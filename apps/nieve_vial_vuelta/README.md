# Nieve Vial Vuelta — manual de uso

Demo Flutter para que un perfil supervisor revise partes, ajuste cupos de modulación y consulte o fije stock.

## Ejecutar

```powershell
flutter pub get
flutter run
```

`DEMO_MODE` está activado por defecto. La app parte de un registro ficticio y mantiene los cambios solo en memoria.

## Recorrido de trabajo

### Recoger partes

1. Abre **Recoger partes** y pulsa **Recoger info** para cargar el intervalo mostrado.
2. Selecciona un parte pendiente.
3. Revisa carretera, PK, horas y materiales de cada tramo.
4. Usa **Guardar tramos** para conservar cambios en la sesión.
5. Pulsa **Confirmar parte**. En demo se muestra una ruta de PDF ficticia y no se crea un archivo real.

### Cupos de modulación

1. Abre **Cupos de modulación**.
2. Activa o desactiva la modulación, identifica el cambio con un valor ficticio y ajusta cupos de mina, marina, salmuera y silos.
3. Pulsa **Guardar cupos** o **Recalcular ahora**.

### Stock actual

1. Abre **Fijar stock actual**.
2. Introduce cantidades de prueba por material y silo.
3. Pulsa **Fijar stock actual**. En demo la operación no se envía ni persiste.

## Datos y límites de la demo

- Partes, personas, matrículas y cantidades iniciales son sintéticos.
- Los cambios desaparecen al reiniciar la app.
- No se contacta con ningún servidor y el PDF confirmado es solo una ruta simulada.

## Verificación

```powershell
flutter analyze
flutter test
```

## Integración propia

```powershell
flutter run `
  --dart-define=DEMO_MODE=false `
  --dart-define=NIEVE_VUELTA_BASE_URL=https://servidor.example `
  --dart-define=NIEVE_VUELTA_API_TOKEN=credencial-temporal
```

El servidor debe implementar los recursos `/api/nieve/...` usados por `lib/main.dart`. No distribuyas credenciales permanentes dentro del binario.
