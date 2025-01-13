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
                    <h1 class="text-2xl font-semibold mb-4">Rekam Permintaan Barang</h1>

                    <form action="{{ route('permintaan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="request_number" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nomor Permintaan</label>
                            <input type="text" id="request_number" name="request_number" value="{{ $nextRequestNumber }}" class="form-input mt-1 block w-full" readonly />
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">User Pemohon</label>
                            <select id="user_id" name="user_id" class="form-select mt-1 block w-full" required>
                                <option value="{{ auth()->id() }}">{{ auth()->user()->name }}</option>
                            </select>
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('permintaan.index') }}" class="btn btn-secondary px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
