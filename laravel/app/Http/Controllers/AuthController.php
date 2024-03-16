<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller 
{
    /**
     * Update the status of the specified user to "Banned".
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'user_type' => 'required|string|in:Listener,Artist',
        ]);

        $verificationToken = Str::random(40);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verification_token' => $verificationToken,
            'user_type' => $request->user_type,
            'artist_status' => 'Pending'
        ]);

        $verificationLink = route('verification.verify', ['user' => $user->id, 'token' => $verificationToken]);

        Mail::to($user->email)->send(new \App\Mail\RegistrationConfirmation($user, $verificationLink));

        return response()->json(['user' => $user, 'message' => 'User registered successfully. Please check your email for verification.'], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => "Invalid Credentials"
            ], status: Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        if (!$user->verified) {
            // User is not verified, notify and redirect
            return redirect('/');
        }

        $token = $request->user()->createToken('Access Token')->plainTextToken;

        return response([
            'token' => $token
        ])->withCookie("jwt_token", $token, 60 * 24);
    }

    public function user()
    {
        return Auth::user();
    }
    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }
    public function index(Request $request)
    {
        // Fetch artists based on user_type
        $artists = User::where('user_type', 'artist')->get();

        return response()->json($artists);
    }
    
    public function banUser(Request $request)
    {
        $userId = $request->input('userId');

        $user = User::findOrFail($userId);
        $user->status = 'Banned';
        $user->save();

        return response()->json(['message' => 'User banned successfully']);
    }

    public function all(Request $request)
    {
        // Fetch all users with selected attributes
        $users = User::all(['name', 'status', 'created_at', 'user_type']);

        // Return the users data
        return response()->json(['users' => $users]);
    }

    public function approveArtist(Request $request, $artistId)
    {
        // Update the artist status to 'approved' in the database
        $artist = User::findOrFail($artistId);
        $artist->update(['user_status' => 'Approved']);

        // Trigger email notification to the artist
        Mail::to($artist->email)->send(new \App\Mail\ArtistApprovalNotification($artist));

        return response()->json(['message' => 'Artist approved successfully']);
    }

    public function declineArtist($artistId)
    {
        // Update the artist status to 'declined' in the database
        $artist = User::findOrFail($artistId);
        $artist->update(['user_status' => 'Declined']);

        // Trigger email notification to the artist
        Mail::to($artist->email)->send(new \App\Mail\ArtistApprovalNotification($artist));

        return response()->json(['message' => 'Artist declined successfully']);
    }
}
