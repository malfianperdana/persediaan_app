<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jenis Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">Daftar Jenis Barang</h1>

                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Search Form -->
                    <div class="mb-4 flex justify-between items-center">
                        <form action="{{ route('jenis_barang.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" value="{{ old('search', $search) }}" class="border border-gray-300 p-2 rounded-md" placeholder="Ketik nama jenis...">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ms-2">
                                Cari
                            </button>
                        </form>
                        
                        <a href="{{ route('jenis_barang.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Jenis Barang
                        </a>
                    </div>

                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">No</th>
                                <th class="px-4 py-2 text-left">Nama Jenis</th>
                                <th class="px-4 py-2 text-left">Satuan</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisBarangs as $jenisBarang)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $loop->iteration + ($jenisBarangs->currentPage() - 1) * $jenisBarangs->perPage() }}</td>
                                    <td class="px-4 py-2">{{ $jenisBarang->name }}</td>
                                    <td class="px-4 py-2">{{ $jenisBarang->unit }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('jenis_barang.edit', $jenisBarang->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                        | 
                                        <form action="{{ route('jenis_barang.destroy', $jenisBarang->id) }}" method="POST" style="display:inline;">
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

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $jenisBarangs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
