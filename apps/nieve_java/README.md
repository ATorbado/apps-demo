# Nieve Java — manual de uso

Aplicación de escritorio Java para crear una vista previa ficticia de un aviso de vialidad invernal. Funciona localmente y tiene la red desactivada en esta edición.

## Requisitos

- JDK 17 o posterior.
- El Maven Wrapper incluido; no hace falta instalar Maven aparte.

## Compilar y ejecutar

```powershell
.\mvnw.cmd clean verify
java -jar target\vialidad-invernal-demo.jar
```

## Recorrido de trabajo

1. Comprueba la carpeta de trabajo que aparece en la ventana.
2. Pulsa **Crear vista previa ficticia**.
3. La app genera un archivo local con asunto y contenido de demostración.
4. El cuadro final muestra la ruta del archivo creado.

No se envían mensajes ni se realizan conexiones externas.

## Verificar el artefacto

Después de compilar, escanea el JAR en busca de indicadores sensibles:

```powershell
.\scripts\verify-artifact.ps1 `
  -JarPath .\target\vialidad-invernal-demo.jar
```

El resultado esperado es `ARTEFACTO_SIN_INDICADORES_SENSIBLES`.

## Datos y solución de problemas

- Todos los textos y documentos generados son ficticios.
- Los archivos se crean dentro de la carpeta de trabajo mostrada por la app.
- Si Java no arranca, comprueba `java -version` y que sea 17 o posterior.
- Si falla la compilación, ejecuta de nuevo `mvnw.cmd clean verify` desde esta carpeta.
