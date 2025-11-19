# 📚 GUÍA DE USO DE LA DOCUMENTACIÓN - TFI
## Cómo utilizar todos los documentos generados

---

## 🎯 OBJETIVO

Esta guía te explica cómo usar cada documento generado para armar tu informe del Trabajo Final Integrador (TFI) de forma rápida y profesional.

**Este material sirve para cualquier materia que requiera un TFI con documentación técnica completa.**

---

## 📁 DOCUMENTOS DISPONIBLES

Has recibido **5 documentos principales** en la carpeta `/docs`:

1. **DOCUMENTACION_TFI.md** - Contenido técnico completo (80+ páginas)
2. **DIAGRAMA_BASE_DATOS.md** - Esquema de BD con instrucciones para diagramar
3. **GUIA_CAPTURAS_MANUAL.md** - Guía paso a paso para capturar pantallas
4. **INDICE_INFORME_TFI.md** - Estructura sugerida del informe
5. **RESUMEN_EJECUTIVO_ESTADISTICAS.md** - Datos, métricas y resumen

---

## 🚀 PLAN DE ACCIÓN: 5 PASOS

### PASO 1: Lee el Índice Sugerido (15 min)
📄 **Archivo:** `INDICE_INFORME_TFI.md`

**Qué hacer:**
1. Abre el archivo y revisa la estructura completa
2. Verifica que cubra todos los requisitos de tu institución
3. Ajusta secciones si es necesario (agregar/quitar según tu caso)
4. Toma nota de las extensiones sugeridas por sección

**Resultado:** Entenderás cómo estructurar tu informe final

---

### PASO 2: Captura las Pantallas (2-3 horas)
📄 **Archivo:** `GUIA_CAPTURAS_MANUAL.md`

**Qué hacer:**
1. Accede a la URL de producción: https://gestionoficina-production.up.railway.app/admin
2. Sigue la guía sección por sección:
   - Login como Admin
   - Captura todas las pantallas de Admin
   - Login como Trabajador (carlos@gestionoficina.com)
   - Captura todas las pantallas de Trabajador
   - Login como Mantenimiento (pedro@gestionoficina.com)
   - Captura todas las pantallas de Mantenimiento
3. Nombra los archivos según la guía: `01_login.png`, `02_dashboard_admin.png`, etc.
4. Guarda todo en una carpeta `capturas/` o similar
5. Usa el checklist al final del documento para verificar que tienes todo

**Resultado:** 35-40 capturas de pantalla profesionales

**Tip:** Si necesitas hacer anotaciones (flechas, círculos), usa:
- Windows: Snipping Tool
- Online: Photopea.com (gratis, similar a Photoshop)
- Software: ShareX (gratis), Snagit (pago)

---

### PASO 3: Crea el Diagrama de Base de Datos (1 hora)
📄 **Archivo:** `DIAGRAMA_BASE_DATOS.md`

**Qué hacer:**
1. Abre el documento y ve a la sección "ENTIDADES Y ATRIBUTOS"
2. Abre una herramienta de diagramado:
   - **Recomendado (online gratis):** https://app.diagrams.net/ (Draw.io)
   - **Alternativa 1:** https://dbdiagram.io/
   - **Alternativa 2:** https://www.lucidchart.com/ (requiere registro)
3. Crea cajas para cada tabla usando la información del documento
4. Dibuja las relaciones (flechas) según la sección "RELACIONES"
5. Usa el diagrama ASCII como referencia visual
6. Exporta en PNG o PDF de alta calidad

**Resultado:** Un diagrama ER profesional para incluir en tu informe

**Tip:** En Draw.io:
- Usa plantillas: File → New → Software → Entity Relation
- O busca "ERD" en las formas

---

### PASO 4: Arma el Informe con Word/Google Docs (4-6 horas)
📄 **Archivos:** 
- `INDICE_INFORME_TFI.md` (estructura)
- `DOCUMENTACION_TFI.md` (contenido)
- `RESUMEN_EJECUTIVO_ESTADISTICAS.md` (datos y resumen)

**Qué hacer:**

#### 4.1 Crear el Documento Base
1. Abre Word o Google Docs
2. Configura márgenes según `INDICE_INFORME_TFI.md`:
   - Superior: 3cm, Inferior: 2.5cm
   - Izquierdo: 3cm, Derecho: 2.5cm
3. Configura estilos:
   - Título 1: Arial 16pt (capítulos)
   - Título 2: Arial 14pt (secciones)
   - Título 3: Arial 12pt (subsecciones)
   - Normal: Arial 11pt, interlineado 1.5

#### 4.2 Crear Portada
Incluye:
- Título del proyecto
- Tu nombre completo y legajo
- Nombre de la materia
- Institución
- Fecha
- Logo institucional (si aplica)

#### 4.3 Copiar Contenido por Secciones

**Sección 1: Resumen Ejecutivo**
- Copia desde `RESUMEN_EJECUTIVO_ESTADISTICAS.md`
- Sección: "RESUMEN EJECUTIVO"
- Ajusta redacción a primera persona si es necesario

**Sección 2-5: Introducción, Objetivos, Integrantes, Propuesta**
- Copia desde `DOCUMENTACION_TFI.md`
- Secciones 1, 2, 3
- **IMPORTANTE:** Completa la sección "Integrantes" con tus datos reales

**Sección 6: Análisis de Requisitos**
- Copia desde `DOCUMENTACION_TFI.md` sección 2.3 (Alcance)
- Amplía con requisitos funcionales y no funcionales

**Sección 7: Plan de Trabajo**
- Copia desde `DOCUMENTACION_TFI.md` sección 3
- Ajusta fechas reales de tu proyecto

**Sección 8: Tecnologías**
- Copia desde `DOCUMENTACION_TFI.md` sección 4
- Es la sección más completa, úsala tal cual

**Sección 9: Arquitectura**
- Copia desde `DOCUMENTACION_TFI.md` sección 5
- Incluye los diagramas ASCII o conviértelos a imágenes

**Sección 10: Base de Datos**
- Copia desde `DOCUMENTACION_TFI.md` sección 7
- **IMPORTANTE:** Inserta aquí el diagrama ER que creaste en el Paso 3
- Incluye las tablas detalladas del documento

**Sección 11: Módulos**
- Copia desde `DOCUMENTACION_TFI.md` sección 6
- Esta es la sección más larga (15-20 páginas)
- Incluye todos los 12 módulos documentados

**Sección 15: Manual de Usuario**
- Usa las capturas que hiciste en el Paso 2
- Sigue la estructura de `GUIA_CAPTURAS_MANUAL.md` sección "TIPS PARA EL MANUAL"
- Ejemplo de página:
  ```
  #### 3.2 Aprobar Solicitud de Préstamo
  
  Para aprobar una solicitud pendiente:
  
  1. Ir a "Solicitudes" en el menú
  2. Localizar solicitud con badge amarillo "Pendiente"
  3. Clic en botón "Aprobar"
  4. Completar formulario...
  
  [Insertar captura 09_solicitudes_aprobar.png]
  Figura 9: Modal de aprobación
  ```

**Sección 16: Resultados**
- Copia desde `RESUMEN_EJECUTIVO_ESTADISTICAS.md`
- Sección: "ESTADÍSTICAS DEL PROYECTO"

**Sección 17: Conclusiones**
- Copia desde `DOCUMENTACION_TFI.md` sección 10.1
- Personaliza con tu experiencia

**Sección 18: Trabajo Futuro**
- Copia desde `DOCUMENTACION_TFI.md` sección 10.2

**Sección 19: Referencias**
- Copia desde `DOCUMENTACION_TFI.md` sección 11

**Sección 20: Glosario**
- Copia desde `DOCUMENTACION_TFI.md` sección 12

#### 4.4 Generar Índice Automático
**En Word:**
1. Coloca cursor al inicio del documento (después de portada)
2. Referencias → Tabla de contenido → Automática
3. Actualiza después de terminar: Clic derecho → Actualizar campos

**En Google Docs:**
1. Insertar → Índice → Índice con números de página
2. Se actualiza automáticamente

#### 4.5 Insertar Figuras y Tablas
- Inserta imágenes centradas
- Agrega pie de figura: "Figura X: Descripción"
- Numera secuencialmente
- Crea índice de figuras (Word: Referencias → Insertar tabla de ilustraciones)

---

### PASO 5: Revisión Final (1 hora)
📄 **Archivo:** `INDICE_INFORME_TFI.md` (sección CHECKLIST)

**Qué hacer:**
1. Usa el checklist del documento
2. Revisa ortografía (F7 en Word)
3. Verifica que todas las imágenes estén referenciadas
4. Comprueba que los números de página del índice sean correctos
5. Lee el resumen ejecutivo y conclusiones para verificar coherencia
6. Guarda como PDF final

**Resultado:** Informe completo y profesional listo para entregar

---

## 📊 RESUMEN DE TIEMPOS

| Paso | Descripción | Tiempo Estimado |
|------|-------------|-----------------|
| 1 | Leer índice y planificar | 15 min |
| 2 | Capturar pantallas | 2-3 horas |
| 3 | Crear diagrama ER | 1 hora |
| 4 | Armar informe en Word | 4-6 horas |
| 5 | Revisión final | 1 hora |
| **TOTAL** | | **8-11 horas** |

**Con estos documentos, tienes el 90% del trabajo hecho.** Solo necesitas:
- Completar tus datos personales
- Capturar las pantallas
- Crear el diagrama ER
- Copiar y pegar el contenido en Word
- Revisar y ajustar redacción

---

## 🎨 TIPS DE FORMATO

### Para que se vea más profesional:

1. **Usa colores consistentes:**
   - Títulos en azul oscuro (#004aad)
   - Código en fondo gris (#f5f5f5)
   - Alertas/warnings en amarillo
   - Éxitos en verde

2. **Tablas:**
   - Usa bordes sutiles (gris claro)
   - Alterna color de filas (zebra striping)
   - Negrita en encabezados

3. **Código:**
   - Fuente Consolas o Courier New
   - Tamaño 10pt
   - Fondo gris claro
   - Borde fino

4. **Imágenes:**
   - Siempre centradas
   - Borde fino opcional (1pt gris)
   - Sombra sutil (opcional)

5. **Portada:**
   - Usa logo de tu universidad
   - Título grande y centrado
   - Fecha en formato completo: "18 de noviembre de 2025"

---

## 🆘 SOLUCIÓN DE PROBLEMAS

### "El informe es muy largo"
✅ **Solución:** Puedes:
- Reducir sección de módulos (describe solo los 5 principales)
- Mover código detallado a apéndices
- Resumir arquitectura

### "No sé cómo hacer el diagrama ER"
✅ **Solución:** 
- Usa dbdiagram.io (super simple)
- O simplemente incluye el diagrama ASCII del documento como está
- O pide a un compañero que sepa usar Draw.io

### "Las capturas se ven pixeladas"
✅ **Solución:**
- Usa pantalla completa al capturar
- Guarda en PNG (no JPG)
- En Word, clic derecho → Formato de imagen → No comprimir

### "No entiendo qué escribir en [sección X]"
✅ **Solución:**
- Todo el contenido está en `DOCUMENTACION_TFI.md`
- Solo copia y pega la sección correspondiente
- Ajusta redacción a tu estilo si es necesario

### "¿Qué hago con el código fuente?"
✅ **Solución:**
- No incluyas TODO el código en el informe
- Incluye solo fragmentos relevantes (ejemplos de modelos, policies)
- El código completo está en GitHub (incluye el link)

---

## ✅ CHECKLIST RÁPIDO

Antes de entregar, verifica:

**Contenido Mínimo Requerido (ajusta según tu institución):**
- [ ] Portada con datos completos (nombre, carrera, institución)
- [ ] Índice general con números de página
- [ ] Resumen ejecutivo (1-2 páginas)
- [ ] Introducción y justificación del proyecto
- [ ] Objetivos claros y numerados
- [ ] Descripción de tecnologías usadas
- [ ] Diagrama de base de datos (imagen)
- [ ] Listado de módulos desarrollados
- [ ] Manual de usuario con capturas (mínimo 15)
- [ ] Conclusiones y trabajo futuro
- [ ] Referencias bibliográficas
- [ ] Glosario de términos técnicos

**Formato:**
- [ ] Márgenes correctos (3cm izq, 2.5cm der)
- [ ] Interlineado 1.5
- [ ] Numeración de páginas
- [ ] Todas las figuras numeradas
- [ ] Todas las tablas numeradas
- [ ] Índice de figuras (opcional pero recomendado)

**Calidad:**
- [ ] Sin errores ortográficos
- [ ] Todas las imágenes legibles
- [ ] Enlaces/URLs funcionando
- [ ] PDF final < 50MB

---

## 📞 ESTRUCTURA DE CARPETAS RECOMENDADA

Para organizarte mejor:

```
TFI_GestionOficina/
│
├── docs/                           (Ya tienes esto)
│   ├── DOCUMENTACION_TFI.md
│   ├── DIAGRAMA_BASE_DATOS.md
│   ├── GUIA_CAPTURAS_MANUAL.md
│   ├── INDICE_INFORME_TFI.md
│   └── RESUMEN_EJECUTIVO_ESTADISTICAS.md
│
├── capturas/                       (Crear y guardar aquí)
│   ├── 01_login.png
│   ├── 02_dashboard_admin.png
│   ├── 03_equipos_listado.png
│   └── ... (todas las demás)
│
├── diagramas/                      (Crear y guardar aquí)
│   ├── diagrama_er.png
│   ├── arquitectura.png
│   └── flujo_datos.png (opcional)
│
├── informe/
│   ├── TFI_GestionOficina_v1.docx  (Borrador)
│   ├── TFI_GestionOficina_v2.docx  (Revisión)
│   └── TFI_GestionOficina_FINAL.pdf (Entrega)
│
└── README.md                       (Este archivo)
```

---

## 🎓 CONSEJOS FINALES

### Para la Defensa Oral (si aplica)

Si tienes que presentar/defender tu TFI:

1. **Prepara Demo en Vivo:**
   - Usa la URL de producción
   - Practica el flujo completo de préstamo
   - Ten cuentas de prueba anotadas

2. **Prepara Presentación (PPT/Google Slides):**
   - 15-20 diapositivas máximo
   - Usa capturas del sistema
   - Destaca: problema → solución → resultados

3. **Practica tu Pitch:**
   - 5 minutos: ¿Qué es? ¿Por qué? ¿Cómo?
   - 10 minutos: Demo en vivo
   - 5 minutos: Resultados y conclusiones

### Puntos Fuertes de tu Proyecto

Destaca estos puntos en tu presentación/conclusiones:

✨ **Sistema completamente funcional en producción**  
✨ **41 equipos de demostración con datos realistas**  
✨ **3 roles diferenciados con permisos específicos**  
✨ **Auditoría completa de operaciones**  
✨ **Optimizaciones de rendimiento implementadas**  
✨ **Documentación técnica exhaustiva**  
✨ **Tests con 100% de éxito**  
✨ **Deployment automático desde GitHub**  

### Preguntas Típicas de Evaluadores

**P: ¿Por qué elegiste Laravel y Filament?**  
R: Laravel es el framework PHP más popular con excelente documentación. Filament me permitió crear la interfaz de administración rápidamente sin sacrificar funcionalidad. Ambos son tecnologías modernas y demandadas en el mercado.

**P: ¿Cómo garantizas la seguridad?**  
R: Implementé múltiples capas: autenticación con Sanctum, políticas de autorización en cada operación, validación server-side, HTTPS forzado, protección CSRF, y contraseñas hasheadas.

**P: ¿Es escalable?**  
R: Sí, la arquitectura en capas permite agregar módulos fácilmente. Uso Eloquent ORM que facilita cambios de BD. Los índices optimizan consultas. Railway permite escalar recursos según demanda.

**P: ¿Qué aprendiste?**  
R: Laravel a nivel profesional, trabajo con Docker, deployment en PaaS, optimización de queries, autorización granular, y documentación técnica exhaustiva.

---

## 🎉 ¡ÉXITO!

Con estos documentos tienes todo lo necesario para un TFI completo y profesional. 

**Recuerda:**
- El 90% del contenido ya está escrito
- Solo necesitas organizar, capturar pantallas, y crear el diagrama
- La documentación técnica es muy completa
- Tu sistema funciona y está en producción

**¡Mucha suerte con tu presentación!** 🚀

---

**Última actualización:** Noviembre 2025  
**Autor de la documentación:** GitHub Copilot  
**Sistema:** Gestión de Oficina v1.0
