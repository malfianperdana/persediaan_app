<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Request;
use App\Models\RequestDetail;
use App\Models\StockLog;
use Illuminate\Http\Request as HttpRequest;

class RequestDetailController extends Controller
{
    public function index(Request $request)
    {
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

        return view('permintaan.detail.index', compact('request', 'requestDetails', 'stockQuantities', 'approvedQuantities'));
    }

    public function create(Request $request)
    {
        $items = Item::all();

        return view('permintaan.detail.create', compact('request', 'items'));
    }

    public function store(Request $request, HttpRequest $httpRequest)
    {
        $httpRequest->validate([
            'item_id' => 'required|exists:items,id',
            'requested_quantity' => 'required|integer|min:1',
        ]);

        RequestDetail::create([
            'request_id' => $request->id,
            'item_id' => $httpRequest->item_id,
            'requested_quantity' => $httpRequest->requested_quantity,
        ]);

        return redirect()->route('permintaan.detail.index', $request->id)
                         ->with('success', 'Detail permintaan berhasil direkam.');
    }

    public function edit(Request $request, RequestDetail $detail)
    {
        $items = Item::all();
        
        return view('permintaan.detail.edit', compact('request', 'detail', 'items'));
    }

    public function update(Request $request, HttpRequest $httpRequest, RequestDetail $detail)
    {
        $httpRequest->validate([
            // 'item_id' => 'required|exists:items,id',
            'requested_quantity' => 'required|integer|min:1',
        ]);

        try {
            $detail->update([
                // 'item_id' => $httpRequest->item_id,
                'requested_quantity' => $httpRequest->requested_quantity,
            ]);

            return redirect()->route('permintaan.detail.index', $request->id)
                            ->with('success', 'Detail permintaan berhasil diubah.');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->withErrors('Terjadi kesalahan saat memperbarui detail permintaan. Silakan coba lagi.')
                            ->withInput();  // Menyertakan input lama supaya user tidak perlu mengetik ulang
        }
    }

    public function destroy(Request $request, RequestDetail $detail)
    {
        $detail->delete();

        return redirect()->route('permintaan.detail.index', $request->id)
                         ->with('success', 'Detail permintaan berhasil dihapus.');
    }
}
