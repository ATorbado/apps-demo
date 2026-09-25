# Animales — manual de uso

Demo Flutter de un parte de animal en carretera. No usa cámara, ubicación, correo, almacenamiento persistente ni servidores.

## Ejecutar

```powershell
flutter pub get
flutter run
```

## Recorrido de trabajo

1. Selecciona **Operario de ejemplo 1** o **Operario de ejemplo 2**. También puedes elegir **Añadir otro Operario** y escribir un nombre ficticio.
2. Pulsa **Animales Atropellados**.
3. Elige el tipo de animal.
4. Rellena la vía, el punto y las observaciones con datos de prueba.
5. Pulsa **Simular envío**.

La confirmación indica que no se ha contactado con ningún servidor ni correo.

## Datos y límites de la demo

- Los campos empiezan con valores ficticios como `VÍA-DEMO` y `1+000`.
- Los datos solo viven en la pantalla actual y se pierden al cerrar o reiniciar la app.
- No introduzcas nombres, ubicaciones ni incidencias reales: esta app sirve para probar el recorrido visual.

## Comprobación rápida

```powershell
flutter analyze
```

Si Flutter no encuentra un dispositivo, ejecuta `flutter devices` y vuelve a iniciar con `flutter run -d <dispositivo>`.
