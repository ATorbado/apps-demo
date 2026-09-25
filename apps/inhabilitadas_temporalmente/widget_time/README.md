# WidgetTime — manual de uso

Aplicación Android en Kotlin para consultar el tiempo de Gijón y mostrar un widget meteorológico.

**Estado: inhabilitada temporalmente como demo.** La app compila, pero la consulta del tiempo necesita claves nuevas de servicios externos; sin ellas no se cumple el recorrido principal.

## Configurar claves

Las claves ya no están escritas en el código. Defínelas como variables de entorno o propiedades Gradle locales:

```powershell
$env:WEATHER_API_KEY = "tu-clave-weatherapi"
$env:VISUAL_CROSSING_API_KEY = "tu-clave-visual-crossing"
```

No añadas claves reales a `gradle.properties` versionado ni a recursos Android.

## Compilar y probar

```powershell
.\gradlew.bat testDebugUnitTest assembleDebug
```

El APK de depuración se genera en `app/build/outputs/apk/debug/` y está excluido de Git.

## Recorrido de trabajo

1. Concede los permisos solicitados por Android.
2. Abre la pantalla principal para consultar temperatura y otros valores actuales.
3. Añade el widget desde el selector de widgets del dispositivo.
4. Actualiza los datos desde la app o el widget.

## Seguridad y datos

- Las dos claves halladas en el repositorio original fueron retiradas de esta copia.
- Los certificados incluidos son certificados públicos de confianza, no claves privadas.
- La compilación y la prueba unitaria de ejemplo se han ejecutado correctamente.
