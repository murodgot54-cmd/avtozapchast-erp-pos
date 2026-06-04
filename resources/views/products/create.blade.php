@extends('layouts.app')

@section('title', 'Yangi Mahsulot')
@section('header', 'Yangi Mahsulot Qo\'shish')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-8">
    <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-box mr-2"></i>Mahsulot Nomi *
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-barcode mr-2"></i>SKU *
                </label>
                <input type="text" name="sku" value="{{ old('sku') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('sku') border-red-500 @enderror">
                @error('sku') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-qrcode mr-2"></i>Barcode
                </label>
                <input type="text" name="barcode" value="{{ old('barcode') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-key mr-2"></i>OEM Kodi
                </label>
                <input type="text" name="oem_code" value="{{ old('oem_code') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-list mr-2"></i>Kategoriya *
                </label>
                <select name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Kategoriyani tanlang</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-industry mr-2"></i>Ishlab Chiqaruvchi
                </label>
                <select name="manufacturer_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Tanlang</option>
                    @foreach($manufacturers as $mfr)
                        <option value="{{ $mfr->id }}" @selected(old('manufacturer_id') == $mfr->id)>{{ $mfr->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-money-bill mr-2"></i>Xarid Narxi (UZS) *
                </label>
                <input type="number" name="cost_price" value="{{ old('cost_price') }}" step="0.01" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('cost_price') border-red-500 @enderror">
                @error('cost_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-tag mr-2"></i>Sotuv Narxi (UZS) *
                </label>
                <input type="number" name="selling_price" value="{{ old('selling_price') }}" step="0.01" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('selling_price') border-red-500 @enderror">
                @error('selling_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-percent mr-2"></i>Ulgurji Narxi (UZS)
                </label>
                <input type="number" name="wholesale_price" value="{{ old('wholesale_price') }}" step="0.01"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-arrow-down mr-2"></i>Minimal Qoldiq *
                </label>
                <input type="number" name="min_stock" value="{{ old('min_stock', 0) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                @error('min_stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-arrow-up mr-2"></i>Maksimal Qoldiq
                </label>
                <input type="number" name="max_stock" value="{{ old('max_stock') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-align-left mr-2"></i>Tavsifi
            </label>
            <textarea name="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold">
                <i class="fas fa-save mr-2"></i>Saqlash
            </button>
            <a href="{{ route('products.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold">
                <i class="fas fa-times mr-2"></i>Bekor Qilish
            </a>
        </div>
    </form>
</div>

@endsection
