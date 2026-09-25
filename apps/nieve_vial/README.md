# Nieve Vial — manual de uso

Demo Flutter para crear partes de vialidad invernal, revisarlos localmente y simular su envío con PDFs.

## Ejecutar

```powershell
flutter pub get
flutter run
```

`DEMO_MODE` está activado por defecto: usa identidades, matrículas y almacenes ficticios, y no contacta con un backend.

## Recorrido de trabajo

### Crear un parte

1. En **Meter**, selecciona de uno a tres operarios ficticios y una matrícula `DEMO-*`.
2. Indica kilómetros y contador iniciales.
3. Añade uno o más tratamientos: actividad, tramo, carretera, PK, horas y materiales cuando correspondan.
4. Pulsa **Finalizar partes** y completa kilómetros finales, horas, combustible, AdBlue y observaciones.
5. Guarda el parte; queda en la base local del dispositivo.

### Revisar o enviar

1. En **Revisar**, elige una fecha, abre un parte local y corrige o elimina sus datos.
2. En **Enviar + PDFs**, selecciona hoy o ayer, revisa los pendientes y completa las horas por operario.
3. Inicia el envío. En demo la petición se simula y no usa la red.

## Datos y límites de la demo

- Los partes se almacenan localmente en SQLite y pueden permanecer tras reiniciar la app.
- Los nombres, matrículas, códigos de actividad y almacenes incluidos son sintéticos.
- No introduzcas datos operativos reales en una instalación de demostración.

## Comprobación rápida

```powershell
flutter analyze
```

## Integración propia

El modo real requiere un servidor HTTPS propio:

```powershell
flutter run `
  --dart-define=DEMO_MODE=false `
  --dart-define=NIEVE_BACKEND_URL=https://servidor.example `
  --dart-define=NIEVE_API_TOKEN=credencial-temporal
```

No uses un token permanente dentro de la app compilada.
