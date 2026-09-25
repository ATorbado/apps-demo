# Mi Diario — manual de uso

Aplicación Flutter local para escribir entradas, buscar texto, gestionar recordatorios y crear copias JSON.

## Ejecutar

```powershell
flutter pub get
flutter run
```

En un dispositivo compatible, la app se protege por defecto con biometría o PIN del sistema.

## Recorrido de trabajo

1. Pulsa **Desbloquear** y autentícate con el método del dispositivo.
2. En **Escribir día**, selecciona una fecha, escribe la entrada y un recordatorio opcional; pulsa **Guardar**.
3. Usa **Ver diario** para abrir o editar entradas existentes.
4. Usa **Buscar** para filtrar por texto y por intervalo de fechas.
5. En **Recordatorios**, marca como completadas las tareas pendientes.
6. En **Copias**, crea y comparte una copia o importa un archivo JSON.
7. En **Ajustes**, activa o desactiva el bloqueo y reconfigura las notificaciones.

## Dónde se guardan los datos

- Las entradas se almacenan en una base SQLite privada de la app.
- Las copias se guardan como JSON en la carpeta de documentos de la app; se conservan las cinco más recientes.
- La copia automática se intenta los domingos después de las 21:00 y también se programa trabajo en segundo plano cuando la plataforma lo permite.
- Importar una copia añade entradas y evita pisar fechas existentes mediante duplicación controlada.

## Privacidad importante

El repositorio no incluye entradas personales, pero lo que escribas y los JSON que compartas sí pueden contener datos sensibles. Guarda las copias en un lugar seguro y no las adjuntes a incidencias públicas.

## Verificación

```powershell
flutter analyze
flutter test
```

Si no se puede desbloquear, confirma que el dispositivo tiene PIN o biometría configurados. Si el inicio falla, la app se bloquea sin borrar la base local.
