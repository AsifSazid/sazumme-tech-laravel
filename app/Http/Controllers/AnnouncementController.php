<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

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
        return view('backend.announcements.create');
    }

    public function store(Request $request)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'announcement_for' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $announcement = Announcement::create([
                'uuid' => (string) \Str::uuid(),
                'title' => $request->title,
                'announcement_for' => $request->announcement_for,
                'body' => $request->body,
                'created_by' => auth()->id(),
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

            return redirect()->route('announcements.index')->with('success', 'Announcement created successfully!');
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
        return view('backend.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'announcement_for' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $announcement->update([
                'title' => $request->title,
                'announcement_for' => $request->announcement_for,
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

            return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $announcement = Announcement::where('uuid', $uuid);
        $announcement->delete(); // this is soft delete

        return redirect()->route('announcements.index')->with('success', 'Announcement moved to trash.');
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

        return redirect()->route('announcements.trash')->with('success', 'Announcement restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $announcement = Announcement::onlyTrashed()->where('uuid', $uuid);
        $announcement->forceDelete();

        return redirect()->route('announcements.trash')->with('success', 'Announcement permanently deleted.');
    }
}
