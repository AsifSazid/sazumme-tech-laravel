<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function index()
    {
        $announcementCollection = Purchase::latest();
        $purchases = $announcementCollection->paginate(10);
        return view('backend.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.purchases.create', compact('wings'));
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

            $purchase = Purchase::create([
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

                $purchase->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.purchases.index')->with('success', 'Purchase created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($purchase)
    {
        $purchase = Purchase::where('uuid', $purchase)->first();
        return view('backend.purchases.show', compact('purchase'));
    }

    public function edit($purchase)
    {
        $purchase = Purchase::where('uuid', $purchase)->first();
        $wings = Wing::get();
        return view('backend.purchases.edit', compact('purchase', 'wings'));
    }

    public function update(Request $request, Purchase $purchase)
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
            $purchase->update([
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
                if ($purchase->image) {
                    Storage::disk('public')->delete($purchase->image->url);
                    $purchase->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $purchase->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.purchases.index')->with('success', 'Purchase updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->firstOrFail();
        $purchase->delete(); // soft delete
    
        return response()->json([
            'success' => true,
            'message' => 'Purchase moved to trash.'
        ]);
    }

    public function trash()
    {
        $trashedCollection = Purchase::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.purchases.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $purchase = Purchase::onlyTrashed()->where('uuid', $uuid);
        $purchase->restore();

        return redirect()->route('admin.purchases.trash')->with('success', 'Purchase restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $purchase = Purchase::onlyTrashed()->where('uuid', $uuid);
        $purchase->forceDelete();

        return redirect()->route('admin.purchases.trash')->with('success', 'Purchase permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Purchase::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $purchases = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($purchases);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Purchase::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $purchases = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Purchase List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.purchases.pdf', compact('purchases'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
