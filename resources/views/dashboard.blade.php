<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Selamat Datang, {{ Auth::user()->name }}!

                    @if(session('user_role') == 'supervisor')
                        <p>Terdapat <a href="{{ route('permintaan.index') }}" class="text-blue-500">{{ $pendingRequestsCount }} permintaan</a> yang perlu Anda review.</p>
                    @endif
                </div>

                @if(session('user_role') == 'admin')
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Informasi Stok Per Barang</h3>
                        <table class="table-auto w-full text-left text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nama Barang</th>
                                    <th class="px-4 py-2">Total Barang Masuk</th>
                                    <th class="px-4 py-2">Total Disetujui</th>
                                    <th class="px-4 py-2">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stockLogs as $log)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $log->item->name ?? 'Tidak Diketahui' }}</td>
                                        <td class="border px-4 py-2">{{ $log->total_quantity }}</td>
                                        <td class="border px-4 py-2">{{ $log->approved_quantity ?? 0 }}</td>
                                        <td class="border px-4 py-2">{{ $log->remaining_stock ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
