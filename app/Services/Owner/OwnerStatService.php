<?php

namespace App\Services\Owner;

use App\Models\Member;
use App\Models\MemberStreamStat;
use App\Models\Owner;
use App\Models\StreamStat;
use Illuminate\Support\Facades\DB;

class OwnerStatService
{

    protected OwnerApiClient $apiClient;

    public function __construct(OwnerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function syncStreamStat(Owner $owner)
    {
        if ($owner->isError) {
            return null;
        }

        $path = "/api/front/models/username/" . $owner->username . "/members";

        try {
            $response = $this->apiClient->get($path, [
                'enable_proxy' => false,
            ]);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), "not found")) {
                Owner::where('id', $owner->id)->update([
                    'isError' => true,
                ]);
            }
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

    public function syncMembers(array $members, StreamStat $streamStat): void {
        DB::transaction(function () use ($members, $streamStat) {
            $memberRows = [];
            $pivotRows = [];
            $memberIds = [];
            $now = now();

            foreach ($members as $member) {
                $memberId = data_get($member, 'user.id');

                if (!$memberId) {
                    continue;
                }

                $memberIds[] = $memberId;

                $memberRows[] = [
                    'id' => $memberId,
                    // Ranking
                    'ranking_league' => data_get($member, 'user.userRanking.league'),
                    'ranking_level' => data_get($member, 'user.userRanking.level'),
                    'ranking_isEx' => data_get($member, 'user.userRanking.isEx'),

                    // Status
                    'isDeleted' => data_get($member, 'user.isDeleted'),
                    'username' => data_get($member, 'user.username'),
                    'isOnline' => data_get($member, 'user.isOnline'),
                    'isBlocked' => data_get($member, 'user.isBlocked'),
                    'isRegular' => data_get($member, 'user.isRegular'),
                    'isExGreen' => data_get($member, 'user.isExGreen'),
                    'isUltimate' => data_get($member, 'user.isUltimate'),
                    'isGreen' => data_get($member, 'user.isGreen'),
                    'hasVrDevice' => data_get($member, 'user.hasVrDevice'),
                    'isModel' => data_get($member, 'user.isModel'),
                    'isStudio' => data_get($member, 'user.isStudio'),
                    'isAdmin' => data_get($member, 'user.isAdmin'),
                    'isSupport' => data_get($member, 'user.isSupport'),
                    'hasAdminBadge' => data_get($member, 'user.hasAdminBadge'),
                    'isPermanentlyBlocked' => data_get($member, 'user.isPermanentlyBlocked'),

                    'updated_at' => $now,
                    'created_at' => $now,
                ];

                $pivotRows[] = [
                    'member_id' => $memberId,
                    'stream_stat_id' => $streamStat->id,
                ];
            }

            Member::upsert(
                $memberRows,
                ['id'],
                [
                    'ranking_league',
                    'ranking_level',
                    'ranking_isEx',
                    'isDeleted',
                    'username',
                    'isOnline',
                    'isBlocked',
                    'isRegular',
                    'isExGreen',
                    'isUltimate',
                    'isGreen',
                    'hasVrDevice',
                    'isModel',
                    'isStudio',
                    'isAdmin',
                    'isSupport',
                    'hasAdminBadge',
                    'isPermanentlyBlocked',
                    'updated_at',
                ]
            );

            MemberStreamStat::where('stream_stat_id', $streamStat->id)
                // ->whereNotIn('member_id', $memberIds)
                ->delete();

            MemberStreamStat::upsert(
                $pivotRows,
                ['member_id', 'stream_stat_id'],
                []
            );
        });
    }
}
