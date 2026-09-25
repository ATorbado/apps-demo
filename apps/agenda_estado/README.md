# Agenda Estado — manual de uso

Demo Flutter para registrar una incidencia de carretera, calcular su posición, adjuntar hasta dos fotografías y simular el envío.

## Ejecutar

Requiere Flutter compatible con el rango de Dart de `pubspec.yaml`.

```powershell
flutter pub get
flutter run
```

`DEMO_MODE` está activado por defecto: no necesitas URL ni credencial y el envío se confirma localmente.

## Recorrido de trabajo

1. Elige la fecha, identificador, carretera, calzada y margen.
2. Selecciona tipo, causa y subelemento; añade comentarios si son necesarios.
3. Completa las fechas y horas de conocimiento y actuación.
4. Pulsa **Obtener coordenadas** para usar la ubicación del dispositivo y calcular el PK.
5. Añade cero, una o dos fotos y pulsa **Enviar**.
6. Revisa el resumen final; en demo no se envía nada a un backend.

El interruptor **Modo grande** aumenta el tamaño de texto y controles.

## Ubicación, fotos y datos pendientes

Al pulsar **Obtener coordenadas**, la app solicita permiso de ubicación y consulta el servicio público CartoCiudad para resolver el punto kilométrico. No uses ubicaciones reales si solo estás probando la demo.

En modo real, si un fallo reintentable impide el envío, los campos y una copia de las fotos quedan cifrados en el almacenamiento privado de la app hasta el siguiente intento. La cola tiene límites y recuperación ante corrupción.

## Verificación

```powershell
flutter analyze
flutter test
```

## Integración propia

Desactiva la demo y configura tu servidor HTTPS:

```powershell
flutter run `
  --dart-define=DEMO_MODE=false `
  --dart-define=AGENDA_BACKEND_URL=https://servidor.example/submit `
  --dart-define=AGENDA_API_TOKEN=credencial-temporal
```

No publiques credenciales duraderas dentro de la app. Cambia también el identificador de paquete y la firma antes de distribuir una versión propia.
