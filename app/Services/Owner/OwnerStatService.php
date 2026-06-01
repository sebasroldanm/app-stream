<?php

namespace App\Services\Owner;

use App\Models\Member;
use App\Models\MemberStreamStat;
use App\Models\Owner;
use App\Models\StreamStat;

class OwnerStatService
{

    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getStreamStatData(Owner $owner)
    {
        return $this->syncStreamStat($owner);
    }

    public function syncStreamStat(Owner $owner)
    {
        $stat = StreamStat::where("owner_id", $owner->id)->first();

        if ($stat && $stat->updated_at->diffInMinutes(now()) < 2) {
            return $stat;
        }

        $path = "/api/front/models/username/" . $owner->username . "/members";

        $response = $this->apiClient->get($path);
        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            return null;
        }

        $body = json_decode($response->getBody(), true);

        $data = collect($body)->only([
            'guests',
            'spies',
            'invisibles',
            'greens',
            'golds',
            'regulars',
        ])->toArray();

        $stat = StreamStat::updateOrCreate(
            ['owner_id' => $owner->id],
            $data
        );
        $this->syncMembers($body['members'], $stat);

        return $stat->fresh();
    }

    public function syncMembers(array $members, StreamStat $streamStat)
    {
        MemberStreamStat::where('stream_stat_id', $streamStat->id)->delete();
        foreach ($members as $member) {
            $member = Member::updateOrCreate(
                ['id' => data_get($member, 'id')],
                [
                    'ranking_league'        => data_get($member, 'user.userRanking.league'),
                    'ranking_level'         => data_get($member, 'user.userRanking.level'),
                    'ranking_isEx'          => data_get($member, 'user.userRanking.isEx'),
                    'isDeleted'             => data_get($member, 'user.isDeleted'),
                    'username'              => data_get($member, 'user.username'),
                    'isOnline'              => data_get($member, 'user.isOnline'),
                    'isBlocked'             => data_get($member, 'user.isBlocked'),
                    'isRegular'             => data_get($member, 'user.isRegular'),
                    'isExGreen'             => data_get($member, 'user.isExGreen'),
                    'isUltimate'            => data_get($member, 'user.isUltimate'),
                    'isGreen'               => data_get($member, 'user.isGreen'),
                    'hasVrDevice'           => data_get($member, 'user.hasVrDevice'),
                    'isModel'               => data_get($member, 'user.isModel'),
                    'isStudio'              => data_get($member, 'user.isStudio'),
                    'isAdmin'               => data_get($member, 'user.isAdmin'),
                    'isSupport'             => data_get($member, 'user.isSupport'),
                    'hasAdminBadge'         => data_get($member, 'user.hasAdminBadge'),
                    'isPermanentlyBlocked'  => data_get($member, 'user.isPermanentlyBlocked'),
                ]
            );
            MemberStreamStat::create([
                'member_id' => $member->id,
                'stream_stat_id' => $streamStat->id,
            ]);
        }
    }
}