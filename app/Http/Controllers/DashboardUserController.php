<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;


class DashboardUserController extends Controller
{
    public function index() {
        $user = auth()->user();
        $query = Schedule::all();

        $stats = [
            'terjadwal' => DB::table('schedules')
            ->where('status', 'terjadwal') 
            ->where('user_id', $user->id)
            ->count(),

            'terlaksana' => DB::table('schedules')
            ->where('status', 'terlaksana')
            ->where('user_id', $user->id)
            ->count(),

        ];

        // $jadwal = $query->orderBy('created_at', 'desc')->get();

        return view('user.dashboard', compact('stats'));
    }

}
