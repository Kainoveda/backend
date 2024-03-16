<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use App\Models\User;

class SongController extends Controller
{
    public function getAllMusic()
    {
        // Retrieve all music records from the database
        $music = Songs::all();

        // Loop through each music record and replace the artist ID with the user's name
        foreach ($music as $song) {
            $user = User::find($song->artist_id);
            if ($user) {
                $song->artist_id = $user->name;
            } else {
                // If user is not found, set artist to null or any default value
                $song->artist = null; // You can replace null with any default value
            }
        }

        // Return the modified music data as JSON response
        return response()->json($music, 200);
    }
}

