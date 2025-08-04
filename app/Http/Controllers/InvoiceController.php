<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index()
    {
        $announcementCollection = Invoice::latest();
        $invoices = $announcementCollection->paginate(10);
        return view('backend.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.invoices.create', compact('wings'));
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

            $announcement = Invoice::create([
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

            return redirect()->route('admin.invoices.index')->with('success', 'Invoice created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($announcement)
    {
        $announcement = Invoice::where('uuid', $announcement)->first();
        return view('backend.invoices.show', compact('announcement'));
    }

    public function edit($announcement)
    {
        $announcement = Invoice::where('uuid', $announcement)->first();
        $wings = Wing::get();
        return view('backend.invoices.edit', compact('announcement', 'wings'));
    }

    public function update(Request $request, Invoice $announcement)
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

            return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $announcement = Invoice::where('uuid', $uuid)->firstOrFail();
        $announcement->delete(); // soft delete
    
        return response()->json([
            'success' => true,
            'message' => 'Invoice moved to trash.'
        ]);
    }

    public function trash()
    {
        $trashedCollection = Invoice::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.invoices.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $announcement = Invoice::onlyTrashed()->where('uuid', $uuid);
        $announcement->restore();

        return redirect()->route('admin.invoices.trash')->with('success', 'Invoice restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $announcement = Invoice::onlyTrashed()->where('uuid', $uuid);
        $announcement->forceDelete();

        return redirect()->route('admin.invoices.trash')->with('success', 'Invoice permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Invoice::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($invoices);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Invoice::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $invoices = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Invoice List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.invoices.pdf', compact('invoices'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
