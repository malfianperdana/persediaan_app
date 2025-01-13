<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\RequestDetail;
use App\Models\StockLog;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function index()
    {
        $userRole = session('user_role'); // Ambil peran pengguna dari session
        $userId = auth()->id(); // Ambil ID pengguna yang sedang login

        if ($userRole === 'pengguna') {
            // Pengguna hanya bisa melihat permintaannya sendiri
            $requests = Request::where('user_id', $userId)
                ->with('user', 'details.item')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($userRole === 'supervisor') {
            // Supervisor melihat semua permintaan kecuali dengan status 'rekam'
            $requests = Request::whereNotIn('status', ['rekam'])
                ->with('user', 'details.item')
                ->orderByRaw("FIELD(status, 'pending') DESC") // Prioritaskan status 'pending'
                ->orderBy('request_number', 'asc') // Urutkan berdasarkan nomor permintaan
                ->get();
        } else {
            // Peran lainnya tidak diizinkan
            abort(403, 'Unauthorized access');
        }

        // Kirim data permintaan ke view
        return view('permintaan.index', compact('requests'));
    }


    public function create()
    {
        $users = User::all();
        
        $latestRequest = Request::latest('id')->first();
        $nextRequestNumber = $latestRequest ? 'REQ' . str_pad((int)substr($latestRequest->request_number, 3) + 1, 4, '0', STR_PAD_LEFT) : 'REQ0001';

        return view('permintaan.create', compact('users', 'nextRequestNumber'));
    }

    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $validated['status'] = 'rekam';

        $newRequest = Request::create($validated);
        $requestNumber = $newRequest->request_number;

        return redirect()->route('permintaan.index')->with('success', 'Nomor ' . $requestNumber . ' berhasil direkam');
    }

    public function edit($id)
    {
        $request = Request::findOrFail($id);

        $users = User::all();

        return view('permintaan.edit', compact('request', 'users'));
    }

    public function update(HttpRequest $request, Request $permintaan)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $permintaan->update($validated);
        $requestNumber = $permintaan->request_number;

        return redirect()->route('permintaan.index')->with('success', 'Nomor ' . $requestNumber . ' berhasil diubah');
    }

    public function destroy($id)
    {
        $request = Request::findOrFail($id);
        $requestNumber = $request->request_number;
        $request->delete();

        return redirect()->route('permintaan.index')->with('success', 'Nomor ' . $requestNumber . ' berhasil dihapus');
    }

    public function sendRequest($id)
    {
        $request = Request::findOrFail($id);

        if ($request->status === 'rekam') {
            $request->status = 'pending';
            $request->save();
            return redirect()->route('permintaan.index')->with('success', 'Permintaan dengan nomor ' . $request->request_number . ' berhasil dikirim.');
        }

        return redirect()->route('permintaan.index')->with('info', 'Permintaan sudah dalam status pending.');
    }

    public function approve(Request $request, $id)
    {
        $request = Request::findOrFail($id);
        if ($request->status !== 'pending') {
            return redirect()->route('permintaan.index')->with('info', 'Hanya permintaan dengan status Pending yang dapat disetujui.');
        }

        $requestDetails = $request->details()->with('item')->get();

        $stockQuantities = StockLog::selectRaw('item_id, SUM(quantity) as total_quantity')
            ->groupBy('item_id')
            ->get()
            ->keyBy('item_id');
        
        $approvedQuantities = RequestDetail::selectRaw('request_details.item_id, SUM(request_details.requested_quantity) as approved_quantity')
            ->join('requests', 'requests.id', '=', 'request_details.request_id')
            ->where('requests.status', 'approved')
            ->groupBy('request_details.item_id')
            ->get()
            ->keyBy('item_id');

        $requestDetails->each(function ($detail) use ($stockQuantities, $approvedQuantities) {
            $stockIn = $stockQuantities[$detail->item->id]->total_quantity ?? 0;
            $approved = $approvedQuantities[$detail->item->id]->approved_quantity ?? 0;
            $detail->remaining_stock = $stockIn - $approved;
        });

        $isValid = true;
        $insufficientItems = [];

        foreach ($requestDetails as $detail) {
            if ($detail->requested_quantity > $detail->remaining_stock) {
                $insufficientItems[] = $detail->item->name;
                $isValid = false;
            }
        }

        if ($isValid) {
            $request->update(['status' => 'approved']);
            return redirect()->back()->with('success', 'Permintaan berhasil disetujui.');
        } else {
            $itemNames = implode(', ', $insufficientItems);
            $errorMessage = 'Approval gagal karena ada item yang stoknya tidak mencukupi, yaitu: ' . $itemNames . '.';

            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function reject(Request $request, $id)
    {
        $request = Request::findOrFail($id);

        if ($request->status !== 'pending') {
            return redirect()->route('permintaan.index')->with('info', 'Hanya permintaan dengan status Pending yang dapat ditolak.');
        }

        $request->update(['status' => 'rejected']);

        return redirect()->route('permintaan.index')->with('success', 'Permintaan ditolak.');
    }
}
