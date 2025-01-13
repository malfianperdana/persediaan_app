<?php

namespace App\Http\Controllers;

use App\Models\StockLog;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class StockLogController extends Controller
{
    public function index()
    {
        $stockLogs = StockLog::with('item', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stock_logs.index', compact('stockLogs'));
    }

    public function create()
    {
        $items = Item::all();
        return view('stock_logs.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer',
        ]);

        StockLog::create([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'logged_by' => auth()->id(),
        ]);

        return redirect()->route('stock_logs.index')->with('success', 'Log barang masuk berhasil direkam.');
    }

    public function edit($id)
    {
        $stockLog = StockLog::findOrFail($id);
        $items = Item::all();
        return view('stock_logs.edit', compact('stockLog', 'items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $stockLog = StockLog::findOrFail($id);

        $stockLog->update([
            'quantity' => $request->quantity,
            'logged_by' => auth()->id(),
        ]);

        return redirect()->route('stock_logs.index')->with('success', 'Log barang masuk berhasil diubah.');
    }

    public function destroy(StockLog $stock_log)
    {
        $stock_log->delete();
        return redirect()->route('stock_logs.index')->with('success', 'Log barang masuk berhasil dihapus.');
    }
}
