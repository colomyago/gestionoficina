#!/bin/bash

echo "🚀 Iniciando deployment en Railway..."

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders (solo la primera vez o si la DB está vacía)
echo "🌱 Verificando seeders..."
if php artisan tinker --execute="echo \App\Models\User::count();" | grep -q "^0$"; then
    echo "🌱 Base de datos vacía, ejecutando seeders..."
    php artisan db:seed --force
else
    echo "✅ Base de datos ya tiene datos, omitiendo seeders"
fi

# Limpiar y optimizar cachés
echo "🧹 Limpiando cachés..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "⚡ Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crear storage link
echo "🔗 Creando storage link..."
php artisan storage:link

echo "✅ Deployment completado exitosamente!"
