<?php

namespace App\Http\Controllers;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorAnalyticsController extends Controller
{
    
    public function summary(Request $request)
    {
        $type = $request->query('type', 'daily'); // daily, weekly, monthly, yearly
    
        $query = VisitorLog::query();
        $rawData = collect();
        $result = [];
    
        switch ($type) {
            case 'daily':
                $start = now()->subDays(6)->startOfDay();
                $end = now()->endOfDay();
    
                $rawData = $query->selectRaw('DATE(created_at) as label, COUNT(*) as count')
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy('label')
                    ->orderBy('label')
                    ->pluck('count', 'label');
    
                for ($i = 0; $i < 7; $i++) {
                    $date = now()->subDays(6 - $i)->format('Y-m-d');
                    $result[] = [
                        'label' => $date,
                        'count' => $rawData[$date] ?? 0
                    ];
                }
                break;
    
            case 'weekly':
                $start = now()->subWeeks(9)->startOfWeek();
                $rawData = $query->selectRaw('YEARWEEK(created_at, 1) as label, COUNT(*) as count')
                    ->where('created_at', '>=', $start)
                    ->groupBy('label')
                    ->orderBy('label')
                    ->pluck('count', 'label');
    
                for ($i = 9; $i >= 0; $i--) {
                    $week = now()->subWeeks($i);
                    $label = $week->format('oW'); // ISO year + week number (e.g., 202529)
                    $result[] = [
                        'label' => $label,
                        'count' => $rawData[$label] ?? 0
                    ];
                }
                break;
    
            case 'monthly':
                $start = now()->subMonths(11)->startOfMonth();
                $rawData = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as label, COUNT(*) as count")
                    ->where('created_at', '>=', $start)
                    ->groupBy('label')
                    ->orderBy('label')
                    ->pluck('count', 'label');
    
                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i)->format('Y-m');
                    $result[] = [
                        'label' => $month,
                        'count' => $rawData[$month] ?? 0
                    ];
                }
                break;
    
            case 'yearly':
                $start = now()->subYears(9)->startOfYear();
                $rawData = $query->selectRaw("YEAR(created_at) as label, COUNT(*) as count")
                    ->where('created_at', '>=', $start)
                    ->groupBy('label')
                    ->orderBy('label')
                    ->pluck('count', 'label');
    
                for ($i = 9; $i >= 0; $i--) {
                    $year = now()->subYears($i)->format('Y');
                    $result[] = [
                        'label' => $year,
                        'count' => $rawData[$year] ?? 0
                    ];
                }
                break;
    
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }
    
        return response()->json($result);
    }
    

    public function sourceChart(Request $request)
    {
        $type = $request->query('type', 'daily');

        $query = VisitorLog::query();

        switch ($type) {
            case 'daily':
                $query->whereDate('created_at', today());
                break;
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month);
                break;
            case 'yearly':
                $query->whereYear('created_at', now()->year);
                break;
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        $data = $query->select('visit_from', DB::raw('count(*) as count'))
            ->groupBy('visit_from')
            ->get();

        return response()->json($data);
    }
}
