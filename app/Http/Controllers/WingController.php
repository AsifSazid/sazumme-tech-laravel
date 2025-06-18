<?php

namespace App\Http\Controllers;

use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WingController extends Controller
{
    public function index()
    {
        $announcementCollection = Wing::latest();
        $wings = $announcementCollection->paginate(10);
        return view('backend.wings.index', compact('wings'));
    }

    public function create()
    {
        return view('backend.wings.create');
    }

    public function store(Request $request)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'icon_code' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $wing = Wing::create([
                'uuid' => (string) \Str::uuid(),
                'title' => $request->title,
                'icon_code' => $request->icon_code,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
                'created_by_uuid' => Auth::user()->uuid,
                'is_active' => $request->has('is_active'),
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');

                $wing->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.wings.index')->with('success', 'Wing created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($wing)
    {
        $wing = Wing::where('uuid', $wing)->first();
        return view('backend.wings.show', compact('wing'));
    }

    public function edit($wing)
    {
        $wing = Wing::where('uuid', $wing)->first();
        return view('backend.wings.edit', compact('wing'));
    }

    public function update(Request $request, Wing $wing)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'icon_code' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $wing->update([
                'title' => $request->title,
                'icon_code' => $request->icon_code,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'created_by' => auth()->id(),
                'is_active' => $request->has('is_active'),
            ]);

            if ($request->hasFile('image')) {
                // Delete previous image if exists
                if ($wing->image) {
                    Storage::disk('public')->delete($wing->image->url);
                    $wing->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $wing->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.wings.index')->with('success', 'Wing updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $wing = Wing::where('uuid', $uuid);
        $wing->delete(); // this is soft delete

        return redirect()->route('admin.wings.index')->with('success', 'Wing moved to trash.');
    }

    public function trash()
    {
        $trashedCollection = Wing::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.wings.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $wing = Wing::onlyTrashed()->where('uuid', $uuid);
        $wing->restore();

        return redirect()->route('admin.wings.trash')->with('success', 'Wing restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $wing = Wing::onlyTrashed()->where('uuid', $uuid);
        $wing->forceDelete();

        return redirect()->route('admin.wings.trash')->with('success', 'Wing permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Wing::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $wings = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($wings);
    }

    public function downloadPdf(Request $request)
    {
        $header = "Approved Wing List(s)";

        $search = $request->get('search');

        $query = Wing::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
            $header = "Approved Wing List(s) - Filtered";
        }

        $wings = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>{$header}</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.wings.pdf', compact('wings'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
