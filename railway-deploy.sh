#!/bin/bash

# ============================================================================
# Script de Deployment para Railway
# ============================================================================
# Este script se puede ejecutar manualmente, pero Railway usa principalmente 
# el Procfile para el deployment automático.
# ============================================================================

set -e  # Detener si hay algún error

echo "🚀 Iniciando deployment en Railway..."
echo "📅 $(date)"
echo ""

# ============================================================================
# 1. MIGRACIONES DE BASE DE DATOS
# ============================================================================
echo "📊 Ejecutando migraciones de base de datos..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo "✅ Migraciones completadas"
else
    echo "❌ Error en migraciones"
    exit 1
fi
echo ""

# ============================================================================
# 2. SEEDERS (Roles, Usuarios y Equipos de prueba)
# ============================================================================
echo "🌱 Ejecutando seeders..."
echo "   → DatabaseSeeder llama a:"
echo "      - RoleSeeder (roles y usuarios de prueba)"
echo "      - EquipmentSeeder (equipos de ejemplo)"

php artisan db:seed --force

if [ $? -eq 0 ]; then
    echo "✅ Seeders completados"
else
    echo "⚠️  Warning: Error en seeders (puede que los datos ya existan)"
fi
echo ""

# ============================================================================
# 3. OPTIMIZACIÓN Y CACHÉS
# ============================================================================
echo "⚡ Optimizando aplicación para producción..."

# Generar cachés optimizados
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Optimización completada"
echo ""

# ============================================================================
# 4. STORAGE LINK
# ============================================================================
echo "🔗 Creando storage link..."
php artisan storage:link 2>/dev/null || echo "   ℹ️  Storage link ya existe"
echo ""

echo "✅ Deployment completado exitosamente!"
echo ""
echo "📍 La aplicación está lista en: ${APP_URL:-https://gestionoficina-production.up.railway.app}"
echo ""
echo "👥 Usuarios de prueba creados:"
echo "   • admin@gestionoficina.com / password123 (Admin)"
echo "   • carlos@gestionoficina.com / password123 (Trabajador)"
echo "   • pedro@gestionoficina.com / password123 (Mantenimiento)"
echo ""
echo "📦 Equipos de ejemplo creados: 11 equipos disponibles"
echo ""
