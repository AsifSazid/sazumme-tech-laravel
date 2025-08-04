<?php

namespace App\Http\Controllers;

use App\Models\SoftwareProduct;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SoftwareProductController extends Controller
{
    public function index()
    {
        $announcementCollection = SoftwareProduct::latest();
        $software_products = $announcementCollection->paginate(10);
        return view('backend.software_products.index', compact('software_products'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.software_products.create', compact('wings'));
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

            $software_product = SoftwareProduct::create([
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

                $software_product->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.software_products.index')->with('success', 'SoftwareProduct created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($software_product)
    {
        $software_product = SoftwareProduct::where('uuid', $software_product)->first();
        return view('backend.software_products.show', compact('software_product'));
    }

    public function edit($software_product)
    {
        $software_product = SoftwareProduct::where('uuid', $software_product)->first();
        $wings = Wing::get();
        return view('backend.software_products.edit', compact('software_product', 'wings'));
    }

    public function update(Request $request, SoftwareProduct $software_product)
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
            $software_product->update([
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
                if ($software_product->image) {
                    Storage::disk('public')->delete($software_product->image->url);
                    $software_product->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $software_product->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.software_products.index')->with('success', 'SoftwareProduct updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $software_product = SoftwareProduct::where('uuid', $uuid)->firstOrFail();
        $software_product->delete(); // soft delete
    
        return response()->json([
            'success' => true,
            'message' => 'SoftwareProduct moved to trash.'
        ]);
    }

    public function trash()
    {
        $trashedCollection = SoftwareProduct::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.software_products.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $software_product = SoftwareProduct::onlyTrashed()->where('uuid', $uuid);
        $software_product->restore();

        return redirect()->route('admin.software_products.trash')->with('success', 'SoftwareProduct restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $software_product = SoftwareProduct::onlyTrashed()->where('uuid', $uuid);
        $software_product->forceDelete();

        return redirect()->route('admin.software_products.trash')->with('success', 'SoftwareProduct permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = SoftwareProduct::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $software_products = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($software_products);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = SoftwareProduct::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $software_products = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>SoftwareProduct List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.software_products.pdf', compact('software_products'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
