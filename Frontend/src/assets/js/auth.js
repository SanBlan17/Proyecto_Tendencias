// ==================== Configuración Base ====================
const API_BASE_URL = '/api';

// ==================== Utilidades de Almacenamiento ====================
const storage = {
    setToken: (token) => localStorage.setItem('authToken', token),
    getToken: () => localStorage.getItem('authToken'),
    clearToken: () => localStorage.removeItem('authToken'),
    setUser: (user) => localStorage.setItem('user', JSON.stringify(user)),
    getUser: () => {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    },
    clearUser: () => localStorage.removeItem('user'),
    isAuthenticated: () => !!localStorage.getItem('authToken')
};

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
            // Token expirado o inválido
            storage.clearToken();
            storage.clearUser();
            window.location.href = 'login.html';
        }

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.message || `HTTP error! status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

// ==================== Manejo del Login ====================
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const remember = document.querySelector('input[name="remember"]').checked;

        try {
            showMessage('Iniciando sesión...', 'info');
            
            const response = await apiRequest('/auth/login', {
                method: 'POST',
                body: { email, password }
            });

            // Guardar token y datos del usuario
            storage.setToken(response.token);
            storage.setUser(response.user);

            if (remember) {
                localStorage.setItem('rememberEmail', email);
            }

            showMessage('¡Bienvenido! Redirigiendo...', 'success');
            
            // Redirigir al dashboard después de 1 segundo
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 1000);

        } catch (error) {
            showMessage(error.message || 'Error al iniciar sesión. Verifica tus datos.', 'error');
        }
    });

    // Cargar email guardado si existe
    const savedEmail = localStorage.getItem('rememberEmail');
    if (savedEmail) {
        document.getElementById('email').value = savedEmail;
        document.querySelector('input[name="remember"]').checked = true;
    }
}

// ==================== Manejo del Registro ====================
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Validaciones básicas
        if (password !== confirmPassword) {
            showMessage('Las contraseñas no coinciden', 'error');
            return;
        }

        if (password.length < 8) {
            showMessage('La contraseña debe tener mínimo 8 caracteres', 'error');
            return;
        }

        try {
            showMessage('Creando cuenta...', 'info');
            
            const response = await apiRequest('/auth/register', {
                method: 'POST',
                body: {
                    first_name: firstName,
                    last_name: lastName,
                    email,
                    phone,
                    password
                }
            });

            // Guardar token y datos del usuario
            storage.setToken(response.token);
            storage.setUser(response.user);

            showMessage('¡Cuenta creada exitosamente! Redirigiendo...', 'success');
            
            // Redirigir al dashboard después de 1 segundo
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 1000);

        } catch (error) {
            showMessage(error.message || 'Error al crear la cuenta. Intenta de nuevo.', 'error');
        }
    });
}

// ==================== Mostrar Mensajes ====================
function showMessage(text, type = 'info') {
    const messageDiv = document.getElementById('message');
    if (!messageDiv) return;

    messageDiv.textContent = text;
    messageDiv.className = `message ${type}`;
    
    if (type !== 'info') {
        setTimeout(() => {
            messageDiv.textContent = '';
            messageDiv.className = 'message';
        }, 5000);
    }
}

// ==================== Cerrar Sesión ====================
function logout() {
    storage.clearToken();
    storage.clearUser();
    window.location.href = 'login.html';
}

// ==================== Exportar funciones ====================
export { apiRequest, storage, logout };
