<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {   
        $user = Auth::user();
        $roleId = isset($user->roles['0']->id);
        if($roleId == 1){
            // dd('Admin');
            $blogCollection = Blog::latest();
        }else{
            // dd('Not Admin');
            $blogCollection = Blog::where('written_by_uuid', $user->uuid)->latest();
        }
        $blogs = $blogCollection->paginate(10);
        return view('backend.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('backend.blogs.create');
    }

    public function store(Request $request)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $blog = Blog::create([
                'uuid' => (string) \Str::uuid(),
                'title' => $request->title,
                'body' => $request->body,
                'written_by' => Auth::user()->id,
                'written_by_uuid' => Auth::user()->uuid,
                'is_active' => $request->has('is_active'),
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');

                $blog->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($blog)
    {
        $blog = Blog::where('uuid', $blog)->first();
        return view('backend.blogs.show', compact('blog'));
    }

    public function edit($blog)
    {
        $blog = Blog::where('uuid', $blog)->first();
        return view('backend.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $blog->update([
                'title' => $request->title,
                'body' => $request->body,
                'written_by' => Auth::user()->id,
                'written_by_uuid' => Auth::user()->uuid,
                'is_active' => $request->has('is_active'),
            ]);

            if ($request->hasFile('image')) {
                // Delete previous image if exists
                if ($blog->image) {
                    Storage::disk('public')->delete($blog->image->url);
                    $blog->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $blog->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $blog = Blog::where('uuid', $uuid);
        $blog->delete(); // this is soft delete

        return redirect()->route('admin.blogs.index')->with('success', 'Blog moved to trash.');
    }

    public function trash()
    {
        $trashedCollection = Blog::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.blogs.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $blog = Blog::onlyTrashed()->where('uuid', $uuid);
        $blog->restore();

        return redirect()->route('admin.blogs.trash')->with('success', 'Blog restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $blog = Blog::onlyTrashed()->where('uuid', $uuid);
        $blog->forceDelete();

        return redirect()->route('admin.blogs.trash')->with('success', 'Blog permanently deleted.');
    }

    public function getData(Request $request)
    {
        $user = Auth::user();
        $roleId = isset($user->roles['0']->id);
        if($roleId == 1){
            // dd('Admin');
            $query = Blog::where('is_active', '1')->with('user');
        }else{
            // dd('Not Admin');
            $query = Blog::where('written_by_uuid', $user->uuid)->with('user');
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($blogs);
    }

    public function downloadPdf(Request $request)
    {
        $header = "Blog List(s)";

        $search = $request->get('search');

        $user = Auth::user();
        $roleId = isset($user->roles['0']->id);
        if($roleId == 1){
            // dd('Admin');
            $query = Blog::where('is_active', '1')->with('user');
        }else{
            // dd('Not Admin');
            $query = Blog::where('written_by_uuid', $user->uuid)->with('user');
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
            $header = "Blog List(s) - Filtered";
        }

        $blogs = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>{$header}</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.blogs.pdf', compact('blogs'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
