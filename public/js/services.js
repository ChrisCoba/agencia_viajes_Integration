// Servicios para consumir las APIs

const API_BASE_URL = '/api/v1';

// Servicio para login
async function login(email, password) {
    const response = await fetch(`${API_BASE_URL}/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });
    return response.json();
}

// Servicio para obtener tours
async function getTours() {
    const response = await fetch(`${API_BASE_URL}/tours`);
    return response.json();
}

// Servicio para gestionar el carrito
async function addToCart(tourId, quantity) {
    const response = await fetch(`${API_BASE_URL}/cart`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tourId, quantity })
    });
    return response.json();
}

// Exportar servicios
export { login, getTours, addToCart };