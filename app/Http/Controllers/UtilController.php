<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UtilController extends Controller
{
    public function viewMetadata($model, $id)
    {
        switch ($model) {
            case 'feed':
                $response = Feed::with(['albumFeed.photos', 'videoFeed', 'postFeed.mediaPostFeeds'])->find($id);
                if ($response) {
                    $response->data = json_decode($response->data);
                    $response->lastUsername = json_decode($response->lastUsername);
                }
                break;
            case 'owner':
                $response = Owner::find($id);
                if ($response) {
                    $response->data = json_decode($response->data);
                }
                break;
            case 'similarity':
                $response = Cache::get('owner_similarity_' . $id);
                if ($response) {
                    $response = json_decode($response);
                }
                break;
        }

        return view('utils.json', ['data' => $response]);
    }
}