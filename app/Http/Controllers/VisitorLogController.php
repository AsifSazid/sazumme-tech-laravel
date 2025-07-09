<?php

namespace App\Http\Controllers;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorLogController extends Controller
{
    public function index()
    {
        $announcementCollection = VisitorLog::latest();
        $visitorlogs = $announcementCollection->paginate(10);
        return view('backend.visitorlogs.index', compact('visitorlogs'));
    }

    public function show($visitorlog)
    {
        $visitorlog = VisitorLog::where('uuid', $visitorlog)->first();
        return view('backend.visitorlogs.show', compact('visitorlog'));
    }

    public function getData(Request $request)
    {
        $query = VisitorLog::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $visitorlogs = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($visitorlogs);
    }

    public function downloadPdf(Request $request)
    {
        $header = "Approved VisitorLog List(s)";

        $search = $request->get('search');

        $query = VisitorLog::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
            $header = "Approved VisitorLog List(s) - Filtered";
        }

        $visitorlogs = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>{$header}</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.visitorlogs.pdf', compact('visitorlogs'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
