<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use App\Models\Adoption;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $totalCats = Cat::count();
        $adoptedCats = Cat::where('is_adopted', true)->count();
        $availableCats = $totalCats - $adoptedCats;
        $pendingAdoptions = Adoption::where('status', 'pending')->count();
        $approvedAdoptions = Adoption::where('status', 'approved')->count();
        $totalUsers = User::count();

        return response()->json([
            'data' => [
                'total_cats' => $totalCats,
                'adopted_cats' => $adoptedCats,
                'available_cats' => $availableCats,
                'pending_adoptions' => $pendingAdoptions,
                'approved_adoptions' => $approvedAdoptions,
                'total_users' => $totalUsers,
            ],
            'message' => 'Dashboard statistics retrieved'
        ]);
    }
}