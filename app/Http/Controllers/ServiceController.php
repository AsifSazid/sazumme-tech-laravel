<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $announcementCollection = Service::latest();
        $services = $announcementCollection->paginate(10);
        return view('backend.services.index', compact('services'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.services.create', compact('wings'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $wing = $request->announcement_for
                ? Wing::find($request->announcement_for)
                : null;

            $service = Service::create([
                'uuid' => (string) \Str::uuid(),
                'title' => $request->title,
                'announcement_for' => $wing->id ?? null,
                'announcement_for_title' => $wing->title ?? null,
                'announcement_for_uuid' => $wing->uuid ?? null,
                'body' => $request->body,
                'created_by' => Auth::user()->id,
                'created_by_uuid' => Auth::user()->uuid,
                'starts_at' => $request->starts_at,
                'ends_at' => $request->ends_at,
                'is_active' => $request->has('is_active'),
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');

                $service->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($service)
    {
        $service = Service::where('uuid', $service)->first();
        return view('backend.services.show', compact('service'));
    }

    public function edit($service)
    {
        $service = Service::where('uuid', $service)->first();
        $wings = Wing::get();
        return view('backend.services.edit', compact('service', 'wings'));
    }

    public function update(Request $request, Service $service)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $wing = $request->announcement_for
                ? Wing::find($request->announcement_for)
                : null;
            $service->update([
                'title' => $request->title,
                'announcement_for' => $wing->id ?? null,
                'announcement_for_title' => $wing->title ?? null,
                'announcement_for_uuid' => $wing->uuid ?? null,
                'body' => $request->body,
                'starts_at' => $request->starts_at,
                'ends_at' => $request->ends_at,
                'is_active' => $request->is_active,
            ]);

            if ($request->hasFile('image')) {
                // Delete previous image if exists
                if ($service->image) {
                    Storage::disk('public')->delete($service->image->url);
                    $service->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $service->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $service = Service::where('uuid', $uuid)->firstOrFail();
        $service->delete(); // soft delete
    
        return response()->json([
            'success' => true,
            'message' => 'Service moved to trash.'
        ]);
    }

    public function trash()
    {
        $trashedCollection = Service::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.services.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $service = Service::onlyTrashed()->where('uuid', $uuid);
        $service->restore();

        return redirect()->route('admin.services.trash')->with('success', 'Service restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $service = Service::onlyTrashed()->where('uuid', $uuid);
        $service->forceDelete();

        return redirect()->route('admin.services.trash')->with('success', 'Service permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Service::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($services);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Service::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $services = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Service List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.services.pdf', compact('services'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
