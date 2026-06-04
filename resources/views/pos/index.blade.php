@extends('layouts.app')

@section('title', 'POS - Tezkor Sotuv')
@section('header', 'Tezkor Savdo Tizimi (POS)')

@section('content')
<div class="grid grid-cols-4 gap-6">
    <!-- Left Column - Products Search -->
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-search mr-2"></i>Mahsulot Qidirish
            </h3>
            <input type="text" id="productSearch" placeholder="SKU, Barcode yoki Nomi kiriting..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <div id="searchResults" class="mt-4 space-y-2 max-h-64 overflow-y-auto">
            </div>
        </div>

        <!-- Cart Items -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-shopping-cart mr-2"></i>Savdo Aslilari
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full" id="cartTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Mahsulot</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Narxi</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold">Miqdor</th>
                            <th class="px-4 py-2 text-right text-sm font-semibold">Jami</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold">Amal</th>
                        </tr>
                    </thead>
                    <tbody id="cartItems">
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                Mahsulotlar qo'shing
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column - Cart Summary -->
    <div>
        <div class="bg-white rounded-lg shadow p-6 sticky top-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-receipt mr-2"></i>Chek Xulosasi
            </h3>

            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-gray-600">Jami:</span>
                    <span class="font-semibold text-lg" id="subtotal">0 UZS</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Chegirma (%):</span>
                    <input type="number" id="discountPercent" min="0" max="100" step="0.1" value="0"
                           class="w-20 px-2 py-1 border border-gray-300 rounded text-right">
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Chegirma:</span>
                    <span class="font-semibold text-red-600" id="discountAmount">0 UZS</span>
                </div>
                <div class="border-t border-gray-200 pt-3 flex justify-between">
                    <span class="text-gray-600">Soliq (12%):</span>
                    <span class="font-semibold" id="taxAmount">0 UZS</span>
                </div>
                <div class="bg-blue-100 rounded p-3 flex justify-between items-center">
                    <span class="font-bold text-gray-800">To'lov:</span>
                    <span class="font-bold text-2xl text-blue-600" id="totalAmount">0 UZS</span>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-user mr-2"></i>Mijoz
                </label>
                <select id="customerId" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Tanlash (ixtiyoriy)</option>
                    @foreach($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-money-bill mr-2"></i>To'lov Usuli
                </label>
                <select id="paymentMethod" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="cash">Naqd Pul</option>
                    <option value="card">Karta</option>
                    <option value="transfer">O'tkazma</option>
                    <option value="mixed">Aralash</option>
                    <option value="credit">Nasiya</option>
                </select>
            </div>

            <button id="checkoutBtn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition">
                <i class="fas fa-check-circle mr-2"></i>Yakunlash
            </button>

            <button id="cancelBtn" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg mt-2 transition">
                <i class="fas fa-times mr-2"></i>Tozalash
            </button>
        </div>
    </div>
</div>

<script>
let cartItems = [];

document.getElementById('productSearch').addEventListener('input', async (e) => {
    const query = e.target.value;
    if (query.length < 1) {
        document.getElementById('searchResults').innerHTML = '';
        return;
    }

    const response = await fetch(`{{ route('pos.search') }}?q=${query}`);
    const products = await response.json();
    
    let html = '';
    products.forEach(product => {
        html += `
            <div class="border border-gray-200 rounded p-2 hover:bg-blue-50 cursor-pointer" onclick="addToCart(${product.id}, '${product.name}', ${product.selling_price})">
                <div class="font-semibold text-gray-800">${product.name}</div>
                <div class="text-sm text-gray-600">SKU: ${product.sku} | Barcode: ${product.barcode || 'N/A'}</div>
                <div class="text-blue-600 font-bold">${product.selling_price} UZS</div>
            </div>
        `;
    });
    document.getElementById('searchResults').innerHTML = html;
});

function addToCart(productId, productName, price) {
    const existingItem = cartItems.find(item => item.id === productId);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cartItems.push({
            id: productId,
            name: productName,
            price: price,
            quantity: 1
        });
    }
    updateCart();
    document.getElementById('productSearch').value = '';
    document.getElementById('searchResults').innerHTML = '';
}

function removeFromCart(productId) {
    cartItems = cartItems.filter(item => item.id !== productId);
    updateCart();
}

function updateQuantity(productId, quantity) {
    const item = cartItems.find(i => i.id === productId);
    if (item) {
        item.quantity = parseInt(quantity) || 1;
        updateCart();
    }
}

function updateCart() {
    let html = '';
    let subtotal = 0;

    if (cartItems.length === 0) {
        html = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Mahsulotlar qo\'shing</td></tr>';
    } else {
        cartItems.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            html += `
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-3 text-sm">${item.name}</td>
                    <td class="px-4 py-3 text-sm">${item.price} UZS</td>
                    <td class="px-4 py-3 text-center">
                        <input type="number" value="${item.quantity}" min="1" 
                               onchange="updateQuantity(${item.id}, this.value)"
                               class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                    </td>
                    <td class="px-4 py-3 text-right font-semibold">${itemTotal} UZS</td>
                    <td class="px-4 py-3 text-center">
                        <button onclick="removeFromCart(${item.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    document.getElementById('cartItems').innerHTML = html;

    // Calculate totals
    const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
    const discountAmount = (subtotal * discountPercent) / 100;
    const taxAmount = (subtotal - discountAmount) * 0.12;
    const totalAmount = subtotal - discountAmount + taxAmount;

    document.getElementById('subtotal').textContent = subtotal.toLocaleString() + ' UZS';
    document.getElementById('discountAmount').textContent = discountAmount.toLocaleString() + ' UZS';
    document.getElementById('taxAmount').textContent = taxAmount.toLocaleString() + ' UZS';
    document.getElementById('totalAmount').textContent = totalAmount.toLocaleString() + ' UZS';
}

document.getElementById('discountPercent').addEventListener('change', updateCart);

document.getElementById('checkoutBtn').addEventListener('click', async () => {
    if (cartItems.length === 0) {
        alert('Mahsulotlar qo\'shing!');
        return;
    }

    const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
    const customerId = document.getElementById('customerId').value || null;
    const paymentMethod = document.getElementById('paymentMethod').value;

    const response = await fetch('{{ route("pos.checkout") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            customer_id: customerId,
            warehouse_id: document.querySelector('select[name="warehouse"]')?.value || 1,
            items: cartItems,
            discount_percent: discountPercent,
            payment_method: paymentMethod
        })
    });

    const result = await response.json();
    if (result.success) {
        alert('Sotuv muvaffaqiyatli yakunlandi! Chek #: ' + result.receipt_number);
        cartItems = [];
        updateCart();
    } else {
        alert('Xato: ' + result.message);
    }
});

document.getElementById('cancelBtn').addEventListener('click', () => {
    cartItems = [];
    updateCart();
    document.getElementById('discountPercent').value = 0;
});
</script>

@endsection
