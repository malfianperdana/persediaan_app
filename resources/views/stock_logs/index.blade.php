<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Log Barang Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4 text-right">
                        <a href="{{ route('stock_logs.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                            + Log Barang Masuk
                        </a>
                    </div>

                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-left">No</th>
                                <th class="px-4 py-2 border-b text-left">Nama Barang</th>
                                <th class="px-4 py-2 border-b text-left">Jumlah Masuk</th>
                                <th class="px-4 py-2 border-b text-left">Tanggal</th>
                                <th class="px-4 py-2 border-b text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockLogs as $log)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border-b">{{ $log->item->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $log->quantity }}</td>
                                    <td class="px-4 py-2 border-b">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('stock_logs.edit', $log->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a> |
                                        <form action="{{ route('stock_logs.destroy', $log->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
