#!/bin/bash
# Script para actualizar composer.lock con la configuración de plataforma

echo "Actualizando composer.lock..."
composer update --lock --ignore-platform-reqs

echo "✅ composer.lock actualizado"
echo "Ahora haz: git add composer.lock && git commit -m 'Update composer.lock' && git push"
