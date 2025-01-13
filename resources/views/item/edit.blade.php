<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold mb-4">Edit Item</h1>

                    <form method="POST" action="{{ route('jenis_barang.update', $jenisBarang->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Item -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Item</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $jenisBarang->name) }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring focus:ring-blue-500">
                        </div>

                        <!-- Deskripsi Item -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring focus:ring-blue-500">{{ old('description', $jenisBarang->description) }}</textarea>
                        </div>

                        <!-- Satuan -->
                        <div class="mb-4">
                            <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                            <input type="text" name="unit" id="unit" value="{{ old('unit', $jenisBarang->unit) }}" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring focus:ring-blue-500">
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
