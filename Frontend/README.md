# Frontend - Proyecto Tendencias

Frontend simple para Proyecto Tendencias, diseñado para funcionar con Laravel y microservicios.

## 📁 Estructura del Proyecto

```
Frontend/
├── src/
│   ├── assets/
│   │   ├── css/          # Estilos CSS
│   │   ├── js/           # JavaScript
│   │   └── images/       # Imágenes
│   ├── components/       # Componentes reutilizables
│   └── pages/            # Páginas
├── public/               # Archivos HTML públicos
├── dist/                 # Build producción
├── package.json          # Dependencias
├── vite.config.js        # Configuración Vite
└── README.md
```

## 🚀 Inicio Rápido

### Instalación

```bash
cd Frontend
npm install
```

### Desarrollo

```bash
npm run dev
```

El servidor estará disponible en `http://localhost:5173`

### Producción

```bash
npm run build
```

Los archivos compilados estarán en la carpeta `dist/`

## 🔗 Integración con Laravel

El frontend está configurado para hacer peticiones a `http://localhost:8000` mediante proxy en Vite.

Para que funcione correctamente:

1. Asegúrate de que tu servidor Laravel esté corriendo en `http://localhost:8000`
2. Las peticiones a `/api/*` se redirigirán automáticamente al backend

## 📝 Próximos Pasos

- [ ] Configurar componentes Vue/React
- [ ] Implementar autenticación
- [ ] Crear páginas principales
- [ ] Conectar con servicios del backend
- [ ] Implementar formularios
- [ ] Agregar validaciones

## 🛠️ Tecnologías

- HTML5
- CSS3
- Vanilla JavaScript
- Vite (Build tool)
- Axios (HTTP Client)

---

*Proyecto Tendencias - 2026*
