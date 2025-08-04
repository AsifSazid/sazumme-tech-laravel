<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TagController extends Controller
{
    public function index()
    {
        $announcementCollection = Tag::latest();
        $tags = $announcementCollection->paginate(10);
        return view('backend.tags.index', compact('tags'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.tags.create', compact('wings'));
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

            $tag = Tag::create([
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

                $tag->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($tag)
    {
        $tag = Tag::where('uuid', $tag)->first();
        return view('backend.tags.show', compact('tag'));
    }

    public function edit($tag)
    {
        $tag = Tag::where('uuid', $tag)->first();
        $wings = Wing::get();
        return view('backend.tags.edit', compact('tag', 'wings'));
    }

    public function update(Request $request, Tag $tag)
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
            $tag->update([
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
                if ($tag->image) {
                    Storage::disk('public')->delete($tag->image->url);
                    $tag->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $tag->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $tag = Tag::where('uuid', $uuid)->firstOrFail();
        $tag->delete(); // soft delete
    
        return response()->json([
            'success' => true,
            'message' => 'Tag moved to trash.'
        ]);
    }

    public function trash()
    {
        $trashedCollection = Tag::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.tags.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $tag = Tag::onlyTrashed()->where('uuid', $uuid);
        $tag->restore();

        return redirect()->route('admin.tags.trash')->with('success', 'Tag restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $tag = Tag::onlyTrashed()->where('uuid', $uuid);
        $tag->forceDelete();

        return redirect()->route('admin.tags.trash')->with('success', 'Tag permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Tag::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $tags = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($tags);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Tag::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $tags = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Tag List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.tags.pdf', compact('tags'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
