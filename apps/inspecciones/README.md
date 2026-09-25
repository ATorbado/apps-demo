# Inspecciones — manual de uso

Demo Flutter de una inspección de seguridad. Usa responsables y fechas ficticias; el envío final se simula.

## Ejecutar

```powershell
flutter pub get
flutter run
```

## Recorrido de trabajo

1. Escribe un lugar de trabajo y una descripción de actividad de prueba.
2. Elige **Responsable 1** o **Responsable 2** y selecciona la fecha.
3. Pulsa **Guardar y continuar**.
4. Responde cada pregunta con **OK**, **NOK** o **N/A**. **Todas OK** completa el cuestionario rápidamente.
5. Para una respuesta **NOK**, indica gravedad, si está resuelta, observaciones y selecciona exactamente dos imágenes.
6. Pulsa **Enviar** al llegar a la última pregunta.

## Datos y límites de la demo

- Las fechas de **Últimas inspecciones** son sintéticas y no proceden de un servidor.
- Las imágenes seleccionadas solo se muestran en memoria durante la sesión; la app no las copia ni transmite.
- El envío espera brevemente y confirma que no ha contactado con ningún servidor.
- No introduzcas personas, obras, incidencias ni fotos reales.

## Verificación

```powershell
flutter analyze
flutter test
```

Si el selector de imágenes no se abre, comprueba los permisos del dispositivo o emulador y vuelve a intentarlo con imágenes de prueba.
