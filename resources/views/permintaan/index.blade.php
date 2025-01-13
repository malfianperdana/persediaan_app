<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permintaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">Daftar Permintaan Barang</h1>

                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="bg-yellow-500 text-white p-4 mb-4 rounded-md">
                            {{ session('info') }}
                        </div>
                    @endif
                    @if(session('user_role')=='pengguna')
                        <div class="mb-4 text-right">
                            <a href="{{ route('permintaan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                + Request
                            </a>
                        </div>
                    @endif

                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">No Permintaan</th>
                                <th class="px-4 py-2 text-left">User Pemohon</th>
                                <th class="px-4 py-2 text-left">Total Item Req</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $request)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $request->request_number }}</td>
                                    <td class="px-4 py-2">{{ $request->user->name }}</td>
                                    <td class="px-4 py-2">
                                        @if($request->details->sum('requested_quantity') == 0)
                                            Belum Ada Data
                                        @else
                                            {{ $request->details->sum('requested_quantity') }} item
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($request->status === 'rekam')
                                            <span class="inline-block px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">Rekam</span>
                                        @elseif($request->status === 'pending')
                                            <span class="inline-block px-3 py-1 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                                        @elseif($request->status === 'approved')
                                            <span class="inline-block px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">Approved</span>
                                        @elseif($request->status === 'rejected')
                                            <span class="inline-block px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">Rejected</span>
                                        @else
                                            <span class="inline-block px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('permintaan.detail.index', $request->id) }}" class="text-blue-500 hover:text-blue-700">Detail</a>
                                    
                                        @if($request->status == 'rekam')
                                            | <a href="{{ route('permintaan.edit', $request->id) }}" class="text-yellow-500 hover:text-yellow-700">Ubah</a>
                                            | <form action="{{ route('permintaan.destroy', $request->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                            </form>
                                        @elseif($request->status == 'pending' && session('user_role') == 'supervisor')
                                            | <button onclick="confirmAction('{{ route('permintaan.approve', $request->id) }}', 'approve')" class="text-green-500 hover:text-green-700">Approve</button>
                                            | <button onclick="confirmAction('{{ route('permintaan.reject', $request->id) }}', 'reject')" class="text-red-500 hover:text-red-700">Reject</button>
                                        @endif
                                    
                                        @if($request->status === 'rekam' && $request->details->sum('requested_quantity') > 0)
                                            | <button class="text-purple-500 hover:text-purple-700" onclick="confirmSendRequest('{{ route('permintaan.sendRequest', $request->id) }}')">Kirim</button>
                                        @endif
                                    </td>                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
        function confirmSendRequest(url) {
            const dialog = document.getElementById('confirmationDialog');
            dialog.classList.remove('hidden');
            document.getElementById('confirmYes').onclick = function() {
                window.location.href = url;
            };
            document.getElementById('confirmNo').onclick = function() {
                dialog.classList.add('hidden');
            };
        }

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
