<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $announcementCollection = Payment::latest();
        $payments = $announcementCollection->paginate(10);
        return view('backend.payments.index', compact('payments'));
    }

    public function create()
    {
        $wings = Wing::get();
        return view('backend.payments.create', compact('wings'));
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

            $payment = Payment::create([
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

                $payment->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.payments.index')->with('success', 'Payment created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function show($payment)
    {
        $payment = Payment::where('uuid', $payment)->first();
        return view('backend.payments.show', compact('payment'));
    }

    public function edit($payment)
    {
        $payment = Payment::where('uuid', $payment)->first();
        $wings = Wing::get();
        return view('backend.payments.edit', compact('payment', 'wings'));
    }

    public function update(Request $request, Payment $payment)
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
            $payment->update([
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
                if ($payment->image) {
                    Storage::disk('public')->delete($payment->image->url);
                    $payment->image()->delete();
                }

                // Store new image
                $path = $request->file('image')->store('images', 'public');
                $payment->image()->create([
                    'uuid' => (string) \Str::uuid(),
                    'url' => $path,
                ]);
            }

            return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $payment = Payment::where('uuid', $uuid)->firstOrFail();
        $payment->delete(); // soft delete
    
        return response()->json([
            'success' => true,
            'message' => 'Payment moved to trash.'
        ]);
    }

    public function trash()
    {
        $trashedCollection = Payment::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.payments.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $payment = Payment::onlyTrashed()->where('uuid', $uuid);
        $payment->restore();

        return redirect()->route('admin.payments.trash')->with('success', 'Payment restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $payment = Payment::onlyTrashed()->where('uuid', $uuid);
        $payment->forceDelete();

        return redirect()->route('admin.payments.trash')->with('success', 'Payment permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Payment::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($payments);
    }

    public function downloadPdf(Request $request)
    {
        $search = $request->get('search');

        $query = Payment::with('user');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $payments = $query->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader("<div style='text-align:center'>Payment List!</div>");
        $mpdf->SetFooter("This is a system generated document(s). So no need to show external signature or seal!");
        $view = view('backend.payments.pdf', compact('payments'));
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
}
