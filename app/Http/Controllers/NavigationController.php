<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    public function index()
    {
        $navigationCollection = Navigation::latest();
        $navigations = $navigationCollection->paginate(10);
        return view('backend.navigations.index', compact('navigations'));
    }

    public function create()
    {
        $wings = Wing::get();
        $navigations = Navigation::get();
        return view('backend.navigations.create', compact('wings', 'navigations'));
    }

    public function store(Request $request)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'nav_icon' => 'string',
            'url' => 'string',
            'route' => 'string',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $wing = $request->navigation_for
                ? Wing::find($request->navigation_for)
                : null;

            $navigation = Navigation::create([
                'uuid' => (string) \Str::uuid(),
                'title' => $request->title,
                'nav_icon' => $request->nav_icon,
                'url' => $request->url,
                'route' => $request->route,
                'parent_id' => $request->parent_id ?? null,
                'navigation_for' => $wing->id ?? null,
                'navigation_for_title' => $wing->title ?? null,
                'navigation_for_uuid' => $wing->uuid ?? null,
                'subdomain' => $wing->subdomain ?? null,
                'created_by' => Auth::user()->id,
                'created_by_uuid' => Auth::user()->uuid,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.navigations.index')->with('success', 'Navigation created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($navigation)
    {
        $navigation = Navigation::where('uuid', $navigation)->first();
        return view('backend.navigations.show', compact('navigation'));
    }

    public function edit($navigation)
    {
        $navigation = Navigation::where('uuid', $navigation)->first();
        $wings = Wing::get();
        return view('backend.navigations.edit', compact('navigation', 'wings'));
    }

    public function update(Request $request, Navigation $navigation)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $wing = $request->navigation_for
                ? Wing::find($request->navigation_for)
                : null;
            $navigation->update([
                'uuid' => (string) \Str::uuid(),
                'title' => $request->title,
                'navigation_for' => $wing->id ?? null,
                'navigation_for_title' => $wing->title ?? null,
                'navigation_for_uuid' => $wing->uuid ?? null,
                'created_by' => Auth::user()->id,
                'created_by_uuid' => Auth::user()->uuid,
                'url' => strtolower($request->title),
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.navigations.index')->with('success', 'Navigation updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $navigation = Navigation::where('uuid', $uuid);
        $navigation->delete(); // this is soft delete

        return redirect()->route('admin.navigations.index')->with('success', 'Navigation moved to trash.');
    }

    public function trash()
    {
        $trashedCollection = Navigation::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.navigations.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $navigation = Navigation::onlyTrashed()->where('uuid', $uuid);
        $navigation->restore();

        return redirect()->route('admin.navigations.trash')->with('success', 'Navigation restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $navigation = Navigation::onlyTrashed()->where('uuid', $uuid);
        $navigation->forceDelete();

        return redirect()->route('admin.navigations.trash')->with('success', 'Navigation permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Navigation::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $navigations = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($navigations);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Navigation::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $navigations = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Navigation List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.navigations.pdf', compact('navigations'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
