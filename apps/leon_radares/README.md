# León Radares — manual de uso

Conjunto de scripts y datos para generar feeds JSON y GeoJSON de radares, controles y cortes de tráfico de León a partir de fuentes públicas.

## Instalar y generar

Requiere Node.js 22 o una versión compatible.

```powershell
npm install
npm run build:feeds
```

Los feeds consolidados se escriben en `radars/latest/` y `radars/today.geojson`.

## Flujo de trabajo

1. Revisa las fuentes públicas configuradas en `scripts/`.
2. Actualiza los archivos mensuales o manuales cuando corresponda.
3. Ejecuta `npm run build:feeds`.
4. Comprueba el JSON generado antes de consumirlo desde otra aplicación.

## Seguridad y datos

- Las coordenadas corresponden a infraestructuras y avisos públicos; no son ubicaciones de usuarios.
- Los workflows del repositorio original no se copiaron porque estaban ligados a su publicación independiente.
- `npm audit --omit=dev` finaliza con cero vulnerabilidades conocidas después de actualizar las dependencias.
