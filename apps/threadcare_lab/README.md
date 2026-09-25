# ThreadCare Lab — manual de uso

App web Next.js en inglés para consultar instrucciones prudentes de cuidado de tejidos y primeros pasos ante manchas comunes.

## Ejecutar

Requiere Node.js 22.13 o posterior.

```powershell
npm install
npm run dev
```

Abre `http://localhost:3000`.

## Recorrido de trabajo

1. En **Stain solver**, selecciona la mancha y el tejido.
2. Pulsa **Get first steps** para ver la primera acción recomendada y qué evitar.
3. Abre una de las guías rápidas para consultar la secuencia completa.
4. Revisa **Editorial standards** para conocer los criterios y **Privacy** para el tratamiento de datos.

## Datos y límites

- No requiere cuentas, formularios, base de datos ni credenciales.
- El selector funciona íntegramente en el navegador y no guarda un perfil.
- El contenido es orientación general: prevalecen siempre la etiqueta de la prenda y las instrucciones del producto.
- La copia pública no incluye el identificador ni el dominio del hosting original.

## Verificación

```powershell
npm run lint
npm run build
```

Para metadatos absolutos en una publicación propia, define `NEXT_PUBLIC_SITE_URL` con la URL HTTPS del sitio.
