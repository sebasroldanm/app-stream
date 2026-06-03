<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Services\Owner\OwnerSyncService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function getTransfer(Request $request)
    {
        $customer_id = $request->customer_id ?? 1;

        $favs = Owner::favoritedByCustomers($customer_id)
            ->select('id', 'username')
            ->whereNotNull('username')
            ->where('username', '!=', '')
            ->orderByDesc('isLive')
            ->orderByDesc('statusChangedAt')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Favoritos obtenidos exitosamente',
            'data' => $favs
        ]);
    }

    public function setTransfer(Request $request, OwnerSyncService $ownerSyncService)
    {
        $request->validate([
            'data.id' => 'required|numeric|max:255',
            'data.username' => 'required|string|max:255',
        ]);

        $created = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($request->data as $item) {
            $owner = Owner::where('username', data_get($item, 'username', ''))->first();
            if ($owner) {
                $skipped++;
                continue;
            }
            
            $ownerId = $ownerSyncService->syncOwnerByUsername(data_get($item, 'username', ''));
            if ($ownerId) {
                $created++;
            } else {
                $failed++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Transferencia completada exitosamente',
            'data' => [
                'created' => $created,
                'skipped' => $skipped,
                'failed' => $failed
            ]
        ]);
    }
}
