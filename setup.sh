#!/bin/bash

# Script de Setup para Proyecto Tendencias
# Este script configura y levanta todos los servicios

set -e

echo "🚀 Iniciando Proyecto Tendencias..."

# 1. Verificar Docker
if ! command -v docker &> /dev/null; then
    echo "❌ Docker no está instalado"
    exit 1
fi

echo "✅ Docker encontrado"

# 2. Bajar servicios previos si existen
echo "🛑 Deteniendo servicios previos..."
docker-compose down -v 2>/dev/null || true

# 3. Limpiar imágenes antiguas
echo "🧹 Limpiando imágenes y volúmenes..."
docker system prune -af --volumes 2>/dev/null || true

# 4. Construir e iniciar servicios
echo "🔨 Construyendo y levantando servicios..."
docker-compose build --no-cache
docker-compose up -d

# 5. Esperar a que PostgreSQL esté listo
echo "⏳ Esperando a que PostgreSQL esté listo..."
sleep 10

# 6. Ejecutar migraciones del Gateway
echo "📊 Ejecutando migraciones del Gateway..."
docker-compose exec -T gateway php artisan migrate --force

# 7. Ejecutar seeders del Gateway
echo "🌱 Ejecutando seeders del Gateway..."
docker-compose exec -T gateway php artisan db:seed --force

# 8. Generar JWT Secret si no existe
echo "🔐 Configurando JWT..."
docker-compose exec -T gateway php artisan jwt:secret --force || true

# 9. Verificar que los servicios están corriendo
echo ""
echo "📋 Estado de los servicios:"
docker-compose ps

echo ""
echo "✅ Proyecto Tendencias inicializado correctamente!"
echo ""
echo "📍 URLs de acceso:"
echo "   - Gateway:       http://localhost:8000"
echo "   - Frontend:      http://localhost:5173 (después de npm install && npm run dev)"
echo "   - Mailpit:       http://localhost:8025"
echo "   - PostgreSQL:    localhost:5432"
echo "   - Redis:         localhost:6379"
echo ""
echo "🔑 Usuarios de prueba:"
echo "   - Email: juan@example.com"
echo "   - Email: maria@example.com"
echo "   - Email: carlos@example.com"
echo "   - Email: ana@example.com"
echo "   - Contraseña: password123 (para todos)"
echo ""
echo "📝 Para ver logs:"
echo "   docker-compose logs -f [servicio]"
echo ""
echo "🛑 Para detener:"
echo "   docker-compose down"
echo ""
