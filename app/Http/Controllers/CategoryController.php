<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $announcementCollection = Category::latest();
        $categories = $announcementCollection->paginate(10);
        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.categories.create', compact('wings'));
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

            $category = Category::create([
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

                $category->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($category)
    {
        $category = Category::where('uuid', $category)->first();
        return view('backend.categories.show', compact('category'));
    }

    public function edit($category)
    {
        $category = Category::where('uuid', $category)->first();
        $wings = Wing::get();
        return view('backend.categories.edit', compact('category', 'wings'));
    }

    public function update(Request $request, Category $category)
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
            $category->update([
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
                if ($category->image) {
                    Storage::disk('public')->delete($category->image->url);
                    $category->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $category->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $category = Category::where('uuid', $uuid)->firstOrFail();
        $category->delete(); // soft delete

        return response()->json([
            'success' => true,
            'message' => 'Category moved to trash.'
        ]);
    }

    public function trash()
    {
        $trashedCollection = Category::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.categories.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $category = Category::onlyTrashed()->where('uuid', $uuid);
        $category->restore();

        return redirect()->route('admin.categories.trash')->with('success', 'Category restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $category = Category::onlyTrashed()->where('uuid', $uuid);
        $category->forceDelete();

        return redirect()->route('admin.categories.trash')->with('success', 'Category permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Category::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($categories);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Category::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $categories = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Category List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.categories.pdf', compact('categories'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
