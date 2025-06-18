<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcementCollection = Announcement::latest();
        $announcements = $announcementCollection->paginate(10);
        return view('backend.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.announcements.create', compact('wings'));
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

            $announcement = Announcement::create([
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

                $announcement->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($announcement)
    {
        $announcement = Announcement::where('uuid', $announcement)->first();
        return view('backend.announcements.show', compact('announcement'));
    }

    public function edit($announcement)
    {
        $announcement = Announcement::where('uuid', $announcement)->first();
        $wings = Wing::get();
        return view('backend.announcements.edit', compact('announcement', 'wings'));
    }

    public function update(Request $request, Announcement $announcement)
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
            $announcement->update([
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
                if ($announcement->image) {
                    Storage::disk('public')->delete($announcement->image->url);
                    $announcement->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $announcement->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $announcement = Announcement::where('uuid', $uuid);
        $announcement->delete(); // this is soft delete

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement moved to trash.');
    }

    public function trash()
    {
        $trashedCollection = Announcement::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.announcements.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $announcement = Announcement::onlyTrashed()->where('uuid', $uuid);
        $announcement->restore();

        return redirect()->route('admin.announcements.trash')->with('success', 'Announcement restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $announcement = Announcement::onlyTrashed()->where('uuid', $uuid);
        $announcement->forceDelete();

        return redirect()->route('admin.announcements.trash')->with('success', 'Announcement permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Announcement::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $announcements = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($announcements);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Announcement::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $announcements = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Announcement List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.announcements.pdf', compact('announcements'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
