# Maquinaria M — manual de uso

Demo Flutter para consultar vehículos, revisar su historial y añadir registros de mantenimiento.

## Ejecutar

```powershell
flutter pub get
flutter run
```

`DEMO_MODE` está activado por defecto. La app carga dos vehículos ficticios y no realiza peticiones de red.

## Recorrido de trabajo

1. Busca por matrícula o nombre del vehículo.
2. Abre una tarjeta para ver tipos de mantenimiento e historial.
3. Pulsa un tipo, por ejemplo **Cambio de aceite** o **Revisión de neumático**.
4. Completa fecha, posición cuando sea necesaria, kilómetros, marca/modelo y observaciones.
5. Pulsa **Guardar mantenimiento** y comprueba el nuevo registro en el historial.

## Datos y límites de la demo

- Vehículos y matrículas usan valores `DEMO-*`.
- Los registros nuevos solo se guardan en memoria; se pierden al reiniciar la app.
- El botón de recarga restaura la vista desde ese estado temporal.
- No introduzcas matrículas, averías ni detalles de mantenimiento reales.

## Verificación

```powershell
flutter analyze
flutter test
```

## Integración propia

Para conectar tu backend HTTPS:

```powershell
flutter run `
  --dart-define=DEMO_MODE=false `
  --dart-define=MAQUINARIA_BACKEND_URL=https://servidor.example
```

El backend debe implementar los recursos de vehículos, tipos, posiciones e historial esperados por `lib/services/maquinaria_api.dart`.
