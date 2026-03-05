<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role_or_permission:dashbord.view|perofile.view'),
        ];
    }

    public function index()
    {
        return view('admin.index');
    }

    public function ProfileView()
    {
        $id   = Auth::user()->id;
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.profile', compact('user', 'roles'));
    }

    /**
     * Real-time live traffic data for the dashboard (polled every 5 s).
     */
    public function liveTraffic()
    {
        // ── Active users (cache-based, 1-min TTL from UpdateLastSeen) ──
        $allUsers = User::select('id', 'name', 'email', 'last_seen', 'last_login_ip', 'last_login_at')
            ->whereNotNull('last_seen')
            ->orderByDesc('last_seen')
            ->get();

        $activeUsers = $allUsers->filter(fn($u) => Cache::has('user-is-online-' . $u->id))->values();

        // ── Login history: logins per hour for last 10 hours ──
        $chart = [];
        for ($i = 9; $i >= 0; $i--) {
            $hour    = Carbon::now()->subHours($i);
            $chart[] = [
                'label' => $hour->format('H:i'),
                'count' => User::whereBetween('last_login_at', [
                    $hour->copy()->startOfHour(),
                    $hour->copy()->endOfHour(),
                ])->count(),
            ];
        }

        // ── OAuth Auth Codes summary ──
        $now = Carbon::now();

        $codesTotal   = DB::table('oauth_auth_codes')->count();
        $codesActive  = DB::table('oauth_auth_codes')
            ->where('revoked', false)
            ->where('expires_at', '>', $now)
            ->count();
        $codesRevoked = DB::table('oauth_auth_codes')->where('revoked', true)->count();
        $codesExpired = DB::table('oauth_auth_codes')
            ->where('revoked', false)
            ->where('expires_at', '<=', $now)
            ->count();

        // Per-client breakdown (join with oauth_clients for name)
        $perClient = DB::table('oauth_auth_codes as c')
            ->join('oauth_clients as cl', 'cl.id', '=', 'c.client_id')
            ->select(
                'cl.name as client_name',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(c.revoked = 0 AND c.expires_at > NOW()) as active'),
                DB::raw('SUM(c.revoked = 1) as revoked'),
                DB::raw('SUM(c.revoked = 0 AND c.expires_at <= NOW()) as expired')
            )
            ->groupBy('c.client_id', 'cl.name')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'active_count' => $activeUsers->count(),
            'active_users' => $activeUsers->map(fn($u) => [
                'name'       => $u->name,
                'email'      => $u->email,
                'ip'         => $u->last_login_ip ?? '—',
                'last_seen'  => $u->last_seen
                    ? Carbon::parse($u->last_seen)->diffForHumans()
                    : '—',
                'last_login' => $u->last_login_at
                    ? Carbon::parse($u->last_login_at)->format('d M Y H:i')
                    : '—',
            ]),
            'chart' => $chart,

            // Auth codes
            'auth_codes' => [
                'total'      => $codesTotal,
                'active'     => $codesActive,
                'revoked'    => $codesRevoked,
                'expired'    => $codesExpired,
                'per_client' => $perClient,
            ],
        ]);
    }
}
