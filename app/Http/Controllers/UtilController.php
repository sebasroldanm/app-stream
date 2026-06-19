<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Feed;
use App\Models\Owner;
use App\Models\Video;
use App\Services\Owner\OwnerSearchService;
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
                    $response->lastUsername = json_decode($response->lastUsername);
                }
                break;
            case 'owner':
                $response = Owner::find($id);
                break;
            case 'similarity':
                $response = Cache::get('owner_similarity_' . $id);
                if ($response) {
                    $response = json_decode($response);
                }
                break;
            case 'related':
                $response = Cache::get('related_' . $id);
                if ($response) {
                    $response = ($response);
                }
                break;
            case 'video':
                $response = Video::find($id);
                break;
            case 'album':
                $response = Album::with('photos')->find($id);
                if ($response) {
                    $response->data = json_decode($response->data);
                    $response->photos = $response->photos->map(function ($photo) {
                        $photo->data = json_decode($photo->data);
                        return $photo;
                    });
                }
                break;
            case 'chat':
                $response = base64_decode($id);
                $response = json_decode($response);
                break;
        }

        return view('utils.json', ['data' => $response]);
    }

    public function searchSuggestion(Request $request, OwnerSearchService $ownerSearchService)
    {
        $request->validate([
            'q' => 'required',
        ]);

        $keyword = $request->q;

        $response = $ownerSearchService->searchSuggestion($keyword);

        return response()->json($response);
    }

    public function searchAll(Request $request, OwnerSearchService $ownerSearchService)
    {
        $request->validate([
            'q' => 'required',
        ]);

        $keyword = $request->q;

        $response = $ownerSearchService->searchAll($keyword);

        return response()->json($response);
    }

    public function dataStream(Request $request, $username)
    {
        $owner = Owner::where('username', $username)->first();
        if ($owner->isLive) {
            if ($owner->show_mode == null) {
                $state = 'live';
            } else {
                $state = $owner->show_mode;
            }
        } else if ($owner->isOnline) {
            $state = 'online';
        } else {
            $state = 'offline';
        }
        if ($owner) {
            return response()->json([
                'state' => $state,
                'streamUrl' => $owner->isLive ? trim(env("URL_HLS") . "/" . $owner->id . "/master/" . $owner->id . ".m3u8") : '',
                'text' => $owner->offlineText,
                'date' => $owner->statusChangedAt?->diffForHumans(),
            ]);
        }

        return response()->json([
            'state' => 'offline',
            'streamUrl' => '',
            'text' => 'Usuario no encontrado',
            'date' => '',
        ]);
    }
}
