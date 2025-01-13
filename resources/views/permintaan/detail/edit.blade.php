<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Detail Permintaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-semibold mb-4">Edit Detail Permintaan: {{ $request->request_number }}</h2>

                    @if(session('error'))
                        <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('permintaan.detail.update', [$request->id, $detail->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="item_id" class="block text-sm font-medium text-gray-700">Pilih Barang</label>
                            <select id="item_id" name="item_id" class="mt-1 block w-full select2" @if($detail->item_id) disabled @endif>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $detail->item_id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="requested_quantity" class="block text-sm font-medium text-gray-700">Jumlah Diminta</label>
                            <input type="number" id="requested_quantity" name="requested_quantity" class="mt-1 block w-full" value="{{ old('requested_quantity', $detail->requested_quantity) }}" required>
                        </div>

                        <div class="flex justify-end space-x-4 mt-4">
                            <a href="{{ route('permintaan.detail.index', $request->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>

                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ubah Detail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#item_id').select2({
                placeholder: "Pilih Jenis Barang",
                allowClear: true,
                dropdownAutoWidth: true,
                width: '100%',
            }).on('select2:open', function() {
                $('.select2-search__field').focus();
            });
        });
    </script>
</x-app-layout>
