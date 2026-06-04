@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Today Sales -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Bugungi Savdo</p>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($todaySales, 0) }} UZS</p>
            </div>
            <i class="fas fa-chart-line text-4xl text-green-500 opacity-20"></i>
        </div>
    </div>

    <!-- Monthly Sales -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Oylik Savdo</p>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($monthlySales, 0) }} UZS</p>
            </div>
            <i class="fas fa-calendar text-4xl text-blue-500 opacity-20"></i>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Jami Mijozlar</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalCustomers }}</p>
            </div>
            <i class="fas fa-users text-4xl text-purple-500 opacity-20"></i>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Jami Mahsulotlar</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>
            <i class="fas fa-box text-4xl text-orange-500 opacity-20"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Sales -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-history mr-2 text-blue-600"></i>So'nggi Sotuvlar
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Chek #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Mijoz</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Summa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Vaqt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <span class="font-semibold text-blue-600">{{ $sale->receipt_number }}</span>
                            </td>
                            <td class="px-6 py-3">{{ $sale->customer?->name ?? 'Noma\'lum' }}</td>
                            <td class="px-6 py-3 font-semibold">{{ number_format($sale->total_amount, 0) }} UZS</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $sale->sale_date->format('H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Sotuvlar yo\'q</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-exclamation-triangle mr-2 text-orange-600"></i>Kam Qoldiqlari
            </h3>
        </div>
        <div class="space-y-3 p-6">
            @forelse($lowStockProducts as $stock)
                <div class="border-l-4 border-orange-500 bg-orange-50 p-3">
                    <p class="font-semibold text-gray-800">{{ $stock->product->name }}</p>
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-cube mr-1"></i>{{ $stock->quantity }} qoldi
                    </p>
                </div>
            @empty
                <p class="text-center text-gray-500 py-4">Hech qanday mahsulot kam emas</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
