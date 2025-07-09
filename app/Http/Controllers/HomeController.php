<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\VisitorLog;
use Jenssegers\Agent\Agent;
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

        $todaysVisit = $this->visitorLog($now);

        return view('welcome', compact('announcements', 'todaysVisit'));
    }

    private function visitorLog($now)
    {
        $ip = request()->ip();
        $visitDay = $now->toDateString(); // '2025-07-10'
        $userAgent = request()->userAgent();
        $visitFrom = request()->query('from', 'direct');
    
        // Device detection
        $device = $userAgent; // fallback
        if (class_exists(Agent::class)) {
            $agent = new Agent();
            $device = $agent->device() . ' - ' . $agent->platform() . ' - ' . $agent->browser();
        }
    
        // Check for existing visitor with same IP, same day, same browser
        $exists = VisitorLog::where('ip_address', $ip)
            ->where('visit_day', $visitDay)
            ->where('browser', $userAgent)
            ->exists();
    
        if (!$exists) {
            $country = null;
            $city = null;
    
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}");
                if ($response->ok()) {
                    $country = $response['country'];
                    $city = $response['city'];
                }
            } catch (\Exception $e) {
                // Fail silently
            }
    
            VisitorLog::create([
                'ip_address' => $ip,
                'visit_date' => $now,
                'visit_day' => $visitDay,
                'country' => ($city && $country) ? "{$city}, {$country}" : ($city ?? $country),
                'browser' => $userAgent,
                'visit_from' => $visitFrom,
                'device' => $device,
            ]);
        }
    
        $todayVisits = VisitorLog::where('visit_day', $visitDay)->count();

        return $todayVisits;
    }
    
}
