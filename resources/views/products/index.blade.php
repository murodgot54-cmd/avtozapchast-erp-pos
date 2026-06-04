@extends('layouts.app')

@section('title', 'Mahsulotlar')
@section('header', 'Mahsulotlar Katalogi')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <form method="GET" action="{{ route('products.index') }}" class="flex gap-2 w-full">
        <div class="flex-1">
            <input type="text" name="search" placeholder="Qidirish..." value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        </div>
        <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Barcha kategoriyalar</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-search mr-2"></i>Qidirish
        </button>
    </form>
    <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg ml-2">
        <i class="fas fa-plus mr-2"></i>Yangi Mahsulot
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nomi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">SKU</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kategoriya</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Xarid Narxi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Sotuv Narxi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Holati</th>
                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-3 font-semibold text-gray-800">{{ $product->name }}</td>
                    <td class="px-6 py-3 text-gray-600">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded">{{ $product->sku }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-600">{{ $product->category->name }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ number_format($product->cost_price, 0) }} UZS</td>
                    <td class="px-6 py-3 font-semibold text-green-600">{{ number_format($product->selling_price, 0) }} UZS</td>
                    <td class="px-6 py-3">
                        @if($product->is_active)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm">
                                <i class="fas fa-check-circle mr-1"></i>Faol
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded text-sm">
                                <i class="fas fa-times-circle mr-1"></i>Nofaol
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center space-x-2">
                        <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Ishonchingiz komilmi?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2 block opacity-50"></i>
                        Mahsulotlar topilmadi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>

@endsection
