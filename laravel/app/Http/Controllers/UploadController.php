<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \App\Models\Songs;

class UploadController extends Controller
{
    public function upload(Request $request)
{
    $user = Auth::user();
    
    // Validate the request
    $request->validate([
        'file' => 'required',
        'title' => 'required',
        'genre' => 'required',
    ]);

    if ($request->file('file')->isValid()) {
        $file = $request->file('file');
        
        // Store file in a designated folder
        $storedFilePath = $file->store('uploads');
        
        // Store hashed filename in the database
        $song = new Songs();
        $song->music_file_name = $storedFilePath;
        $song->title = $request->input('title');
        $song->artist = 68; // Assign the user's ID as the artist_id
        $song->genre = $request->input('genre');
        $song->save();

        return response()->json(['user' => $song, 'message' => 'File uploaded successfully']);
    } else {
        return response()->json(['error' => 'Invalid file'], 400);
    }
}
}