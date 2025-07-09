<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\VisitorLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $now = now()->setTimezone('Asia/Dhaka');
        // dd($now);

        $announcements = Announcement::where('is_active', true)
            ->where('announcement_for', NULL)
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->with('image') // eager load image if needed
            ->get();

        $todaysVisit = $this->visitorLog();

        return view('welcome', compact('announcements', 'todaysVisit'));
    }

    private function visitorLog()
    {
        $ip = request()->ip();
        $today = Carbon::today();
    
        $exists = VisitorLog::where('ip_address', $ip)->where('visit_date', $today)->exists();
    
        // dd($exists);
        
        if (!$exists) {
            $country = null;
            $city = null;
            $userAgent = request()->userAgent();
            $visitFrom = request()->query('from', 'direct'); // default value
            $device = $userAgent; // fallback
    
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}");
                if ($response->ok()) {
                    $country = $response['country'];
                    $city = $response['city'];
                }
            } catch (\Exception $e) {}
    
            if (class_exists(\Jenssegers\Agent\Agent::class)) {
                $agent = new \Jenssegers\Agent\Agent();
                $device = $agent->device() . ' - ' . $agent->platform() . ' - ' . $agent->browser();
            }
    
            VisitorLog::create([
                'ip_address' => $ip,
                'visit_date' => $today,
                'country' => ($city && $country) ? "{$city}, {$country}" : ($city ?? $country),
                'browser' => $userAgent,
                'visit_from' => $visitFrom,
                'device' => $device,
            ]);

        }
    
        $todayVisits = VisitorLog::where('visit_date', $today)->count();

        return $todayVisits;
    }
    
}
