<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $jenisBarangs = Item::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('unit', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        return view('item.index', compact('jenisBarangs', 'search'));
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'nullable|string|max:100',
        ]);

        Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'unit' => $request->unit,
        ]);

        return redirect()->route('jenis_barang.index')->with('success', 'Jenis Barang berhasil direkam.');
    }

    public function edit($id)
    {
        $jenisBarang = Item::findOrFail($id);
        return view('item.edit', compact('jenisBarang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'nullable|string|max:100',
        ]);

        $item = Item::findOrFail($id);

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'unit' => $request->unit,
        ]);

        return redirect()->route('jenis_barang.index')->with('success', 'Jenis Barang berhasil diubah.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if ($item->requestDetails()->exists() || $item->stockLogs()->exists()) {
            return redirect()->route('jenis_barang.index')->with('error', $item->name . ' tidak dapat dihapus karena sudah memiliki relasi dengan data lain.');
        }

        $item->delete();

        return redirect()->route('jenis_barang.index')->with('success', $item->name . ' berhasil dihapus.');
    }
}
