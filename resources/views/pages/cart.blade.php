@extends('layouts.main')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container mt-5">
    <h2>Carrito de Compras</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tour</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cartItems">
            <!-- Los elementos del carrito se cargarán aquí dinámicamente -->
        </tbody>
    </table>
    <div class="text-end">
        <button class="btn btn-success" id="checkoutButton">Finalizar Compra</button>
    </div>
</div>

<script>
    import { addToCart } from '/js/services.js';

    // Simulación de datos del carrito
    const cart = [
        { id: 1, name: 'Tour a la playa', quantity: 2, price: 50 },
        { id: 2, name: 'Caminata en la montaña', quantity: 1, price: 30 }
    ];

    function renderCart() {
        const cartItems = document.getElementById('cartItems');
        cartItems.innerHTML = '';

        cart.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.quantity}</td>
                <td>$${item.price}</td>
                <td>$${item.quantity * item.price}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Eliminar</button>
                </td>
            `;
            cartItems.appendChild(row);
        });
    }

    function removeFromCart(id) {
        const index = cart.findIndex(item => item.id === id);
        if (index !== -1) {
            cart.splice(index, 1);
            renderCart();
        }
    }

    document.getElementById('checkoutButton').addEventListener('click', () => {
        alert('Compra finalizada');
    });

    renderCart();
</script>
@endsection