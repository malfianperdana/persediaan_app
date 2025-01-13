<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Permintaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-4">
                        <a href="{{ route('permintaan.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            < Kembali ke Daftar Permintaan
                        </a>

                        <div class="flex items-center">
                            @if($request->status === 'rekam')
                                <a href="{{ route('permintaan.detail.create', $request->id) }}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    + Item
                                </a>
                            @endif

                            @if($request->status == 'pending' && session('user_role') == 'supervisor')
                                <button onclick="confirmAction('{{ route('permintaan.approve', $request->id) }}', 'approve')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-4">
                                    Approve
                                </button>
                                <button onclick="confirmAction('{{ route('permintaan.reject', $request->id) }}', 'reject')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">
                                    Reject
                                </button>
                            @endif
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 class="text-xl font-semibold mb-4">Detail Permintaan: {{ $request->request_number }}</h2>
    
                    @if($requestDetails->isEmpty())
                        <p>Belum ada detail untuk permintaan ini.</p>
                    @else
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b text-left">Nama Barang</th>
                                    <th class="px-4 py-2 border-b text-left">Jumlah Diminta</th>
                                    @if(session('user_role') == 'supervisor')
                                        <th class="px-4 py-2 border-b text-left">Sisa Stok</th>
                                    @endif
                                    <th class="px-4 py-2 border-b text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requestDetails as $detail)
                                    <tr>
                                        <td class="px-4 py-2 border-b">{{ $detail->item->name }}</td>
                                        <td class="px-4 py-2 border-b">{{ $detail->requested_quantity . ' ' . $detail->item->unit }}</td>
                                        @if(session('user_role') === 'supervisor')
                                            <td class="px-4 py-2 border-b">
                                                {{ $detail->remaining_stock . ' ' . $detail->item->unit }}
                                            </td>
                                        @endif
                                        <td class="px-4 py-2 border-b">
                                            {{-- Kondisi untuk supervisor --}}
                                            @if(session('user_role') === 'supervisor' && $request->status === 'pending')
                                                <a href="{{ route('permintaan.detail.edit', [$request->id, $detail->id]) }}" class="text-yellow-500 hover:text-yellow-700">
                                                    Edit
                                                </a>
                                                <span class="text-gray-500 ml-2">Hapus tidak diizinkan</span>
                                            
                                            {{-- Kondisi untuk pengguna saat status "rekam" --}}
                                            @elseif(session('user_role') === 'pengguna' && $request->status === 'rekam')
                                                <a href="{{ route('permintaan.detail.edit', [$request->id, $detail->id]) }}" class="text-yellow-500 hover:text-yellow-700">
                                                    Edit
                                                </a> |
                                                <form action="{{ route('permintaan.detail.destroy', [$request->id, $detail->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                                </form>
                                            
                                            {{-- Status lainnya --}}
                                            @else
                                                <span class="text-gray-500">Tidak dapat diubah</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="confirmationDialog" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-md shadow-lg">
            <h3 id="confirmationMessage" class="text-lg font-semibold mb-4">Anda yakin?</h3>
            <div class="flex justify-end space-x-4">
                <button id="confirmNo" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">No</button>
                <button id="confirmYes" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Yes</button>
            </div>
        </div>
    </div>

    <script>
        function confirmAction(url, action) {
            const dialog = document.getElementById('confirmationDialog');
            const confirmationMessage = document.getElementById('confirmationMessage');

            if(action === 'approve') {
                confirmationMessage.textContent = 'Anda yakin ingin menyetujui permintaan ini?';
            } else if(action === 'reject') {
                confirmationMessage.textContent = 'Anda yakin ingin menolak permintaan ini?';
            }

            dialog.classList.remove('hidden');

            document.getElementById('confirmYes').onclick = function() {
                window.location.href = url;
            };

            document.getElementById('confirmNo').onclick = function() {
                dialog.classList.add('hidden');
            };
        }
    </script>
</x-app-layout>
