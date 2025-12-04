<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;

class UtilController extends Controller
{
    public function viewMetadata($model, $id)
    {
        if ($model == 'feed') {
            $response = Feed::with(['albumFeed.photos', 'videoFeed', 'postFeed.mediaPostFeeds'])->find($id);
            if ($response) {
                $response->data = json_decode($response->data);
            }
        }

        return view('utils.json', ['data' => $response]);
    }
}