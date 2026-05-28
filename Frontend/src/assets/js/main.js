// ==================== Importar módulos de autenticación ====================
import { storage, logout } from './auth.js';

// ==================== Validar autenticación ====================
function validateAuth() {
    if (!storage.isAuthenticated()) {
        window.location.href = 'login.html';
        return false;
    }
    return true;
}

// ==================== Configuración Base ====================
const API_BASE_URL = '/api';

// ==================== Función para hacer peticiones ====================
async function apiRequest(endpoint, options = {}) {
    const method = options.method || 'GET';
    const headers = {
        'Content-Type': 'application/json',
        ...options.headers
    };

    const token = storage.getToken();
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    try {
        const response = await fetch(`${API_BASE_URL}${endpoint}`, {
            method,
            headers,
            body: options.body ? JSON.stringify(options.body) : null,
            ...options
        });

        if (response.status === 401) {
            storage.clearToken();
            storage.clearUser();
            window.location.href = 'login.html';
        }

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

// ==================== Cargar Citas ====================
async function loadAppointments() {
    try {
        const appointmentsList = document.getElementById('appointments-list');
        appointmentsList.innerHTML = 'Cargando citas...';
        
        // Aquí irá la llamada a la API cuando esté lista
        // const data = await apiRequest('/appointments');
        appointmentsList.innerHTML = '<p>No hay citas disponibles aún.</p>';
    } catch (error) {
        console.error('Error al cargar citas:', error);
        document.getElementById('appointments-list').innerHTML = '<p>Error al cargar citas</p>';
    }
}

// ==================== Cargar Servicios ====================
async function loadServices() {
    try {
        const servicesList = document.getElementById('services-list');
        servicesList.innerHTML = 'Cargando servicios...';
        
        // Aquí irá la llamada a la API cuando esté lista
        // const data = await apiRequest('/services');
        servicesList.innerHTML = '<p>No hay servicios disponibles aún.</p>';
    } catch (error) {
        console.error('Error al cargar servicios:', error);
        document.getElementById('services-list').innerHTML = '<p>Error al cargar servicios</p>';
    }
}

// ==================== Event Listeners ====================
document.addEventListener('DOMContentLoaded', () => {
    // Validar que el usuario esté autenticado
    if (!validateAuth()) return;

    console.log('Frontend cargado');
    
    // Cargar datos del usuario
    const user = storage.getUser();
    if (user) {
        const fullName = `${user.first_name || ''} ${user.last_name || ''}`.trim();
        document.getElementById('userName').textContent = fullName || user.email;
    }

    // Cargar contenido
    loadAppointments();
    loadServices();
});

// ==================== Navegación ====================
document.querySelectorAll('.menu a').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const target = link.getAttribute('href');
        const section = document.querySelector(target);
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// ==================== Botón de logout ====================
const logoutBtn = document.getElementById('logoutBtn');
if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
        if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
            logout();
        }
    });
}
