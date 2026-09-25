# notALES — manual de uso

Aplicación Android para crear notas locales y mostrarlas en un widget de la pantalla de inicio.

## Compilar y probar

```powershell
.\gradlew.bat testDebugUnitTest assembleDebug
```

El APK de depuración se genera en `app/build/outputs/apk/debug/` y está excluido de Git.

## Recorrido de trabajo

1. Abre la app y crea una nota.
2. Edita o elimina notas desde la lista.
3. Añade el widget `notALES` a la pantalla de inicio.
4. Configura recordatorios y concede permiso de notificaciones cuando Android lo solicite.

## Seguridad y datos

- Las notas se almacenan localmente mediante `SharedPreferences`.
- El repositorio no contiene notas reales, cuentas ni credenciales.
- No introduzcas información sensible en una instalación de demostración ni distribuyas copias de seguridad con contenido personal.
- La compilación y la prueba unitaria de ejemplo se han ejecutado correctamente.
