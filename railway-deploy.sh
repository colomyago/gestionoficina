#!/bin/bash

echo "🚀 Iniciando deployment en Railway..."

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders
echo "🌱 Ejecutando seeders..."
php artisan db:seed --force

# Limpiar y optimizar cachés
echo "⚡ Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crear storage link
echo "🔗 Creando storage link..."
php artisan storage:link 2>/dev/null || true

echo "✅ Deployment completado exitosamente!"
