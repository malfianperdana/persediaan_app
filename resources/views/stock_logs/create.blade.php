<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Log Barang Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('stock_logs.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="item_id" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                            <select id="item_id" name="item_id" class="select2 mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="" style="display: none;">Pilih Jenis</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah Barang Masuk</label>
                            <input type="number" id="quantity" name="quantity" class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('stock_logs.index') }}" class="btn btn-secondary px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
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
