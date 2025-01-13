<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Models\Request;
use App\Models\RequestDetail;
use App\Models\StockLog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (session('user_role') == 'supervisor') {
            $pendingRequestsCount = Request::where('status', 'pending')->count();

            return view('dashboard', [
                'pendingRequestsCount' => $pendingRequestsCount,
            ]);
        }

        if (session('user_role') == 'admin') {
            $stockLogs = StockLog::select('item_id')
                ->selectRaw('SUM(quantity) as total_quantity')
                ->groupBy('item_id')
                ->with('item')
                ->get();

            $approvedQuantities = RequestDetail::selectRaw('request_details.item_id, SUM(request_details.requested_quantity) as approved_quantity')
                ->join('requests', 'requests.id', '=', 'request_details.request_id')
                ->where('requests.status', 'approved')
                ->groupBy('request_details.item_id')
                ->get()
                ->keyBy('item_id');

            $stockLogs->each(function ($log) use ($approvedQuantities) {
                $approved = $approvedQuantities[$log->item_id]->approved_quantity ?? 0;
                $log->approved_quantity = $approved;  // Tambahkan total permintaan yang disetujui
                $log->remaining_stock = $log->total_quantity - $approved;  // Hitung sisa stok
            });

            $stockLogs = $stockLogs->sortBy('remaining_stock');

            return view('dashboard', [
                'stockLogs' => $stockLogs,
            ]);
        }

        return view('dashboard');
    }
}
