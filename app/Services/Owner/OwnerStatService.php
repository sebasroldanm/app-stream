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

        try {
            $response = $this->apiClient->get($path, [
                'enable_proxy' => false,
            ]);
        } catch (\Exception $e) {
            return null;
        }
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
            $memberModel = Member::find(data_get($member, 'user.id'));
            if (!$memberModel) {
                $memberModel = new Member();
                $memberModel->id = data_get($member, 'user.id');
            }
            $memberModel->ranking_league = data_get($member, 'user.userRanking.league');
            $memberModel->ranking_level = data_get($member, 'user.userRanking.level');
            $memberModel->ranking_isEx = data_get($member, 'user.userRanking.isEx');
            $memberModel->isDeleted = data_get($member, 'user.isDeleted');
            $memberModel->username = data_get($member, 'user.username');
            $memberModel->isOnline = data_get($member, 'user.isOnline');
            $memberModel->isBlocked = data_get($member, 'user.isBlocked');
            $memberModel->isRegular = data_get($member, 'user.isRegular');
            $memberModel->isExGreen = data_get($member, 'user.isExGreen');
            $memberModel->isUltimate = data_get($member, 'user.isUltimate');
            $memberModel->isGreen = data_get($member, 'user.isGreen');
            $memberModel->hasVrDevice = data_get($member, 'user.hasVrDevice');
            $memberModel->isModel = data_get($member, 'user.isModel');
            $memberModel->isStudio = data_get($member, 'user.isStudio');
            $memberModel->isAdmin = data_get($member, 'user.isAdmin');
            $memberModel->isSupport = data_get($member, 'user.isSupport');
            $memberModel->hasAdminBadge = data_get($member, 'user.hasAdminBadge');
            $memberModel->isPermanentlyBlocked = data_get($member, 'user.isPermanentlyBlocked');
            $memberModel->save();

            MemberStreamStat::create([
                'member_id' => $memberModel->id,
                'stream_stat_id' => $streamStat->id,
            ]);
        }
    }
}
