# Apps demo

Colección pública de nueve aplicaciones de demostración: siete proyectos Flutter, una aplicación Java y una web Next.js. Los datos operativos, identidades, matrículas y registros incluidos son sintéticos.

## Estructura del repositorio

El repositorio contiene nueve aplicaciones en `apps/`, junto con este archivo README, SECURITY.md y LICENSE.

## Aplicaciones y manuales

| Aplicación | Uso principal | Manual |
| --- | --- | --- |
| Agenda Estado | Registrar incidencias y adjuntar fotos | [Abrir manual](apps/agenda_estado/README.md) |
| Animales | Simular un parte de animal en carretera | [Abrir manual](apps/animalesapp/README.md) |
| Inspecciones | Recorrer una inspección de seguridad | [Abrir manual](apps/inspecciones/README.md) |
| Maquinaria M | Consultar vehículos y anotar mantenimientos | [Abrir manual](apps/maquinaria_m/README.md) |
| Mi Diario | Diario personal local con recordatorios y copias | [Abrir manual](apps/mi_diario/README.md) |
| Nieve Java | Crear una vista previa local ficticia | [Abrir manual](apps/nieve_java/README.md) |
| Nieve Vial | Crear, revisar y simular el envío de partes | [Abrir manual](apps/nieve_vial/README.md) |
| Nieve Vial Vuelta | Revisar partes y gestionar cupos y stock | [Abrir manual](apps/nieve_vial_vuelta/README.md) |
| ThreadCare Lab | Consultar cuidados de tejidos y resolver manchas | [Abrir manual](apps/threadcare_lab/README.md) |

## Inicio rápido

### Flutter

```powershell
cd apps\agenda_estado
flutter pub get
flutter run
```

### Java

```powershell
cd apps\nieve_java
.\mvnw.cmd javafx:run
```

### ThreadCare Lab (Next.js)

```powershell
cd apps\threadcare_lab
npm install
npm run dev
```

Las apps que admiten integración remota usan `DEMO_MODE=true` de forma predeterminada. En ese modo no necesitan credenciales ni contactan con la infraestructura privada original. Consulta el manual de cada app antes de introducir datos.

## Seguridad y datos

- No se versionan archivos `.env`, claves de firma, certificados, bases de datos, copias, APK ni credenciales.
- Los valores `DEMO-*`, `Persona de ejemplo`, `Responsable 1/2` y similares son ficticios.
- `Mi Diario` guarda el contenido que escriba el usuario en el dispositivo y sus copias JSON pueden contener información personal.
- `Agenda Estado` puede pedir ubicación y consultar el servicio público CartoCiudad al pulsar **Obtener coordenadas**.
- Para una integración propia, usa un backend HTTPS y autenticación revocable. Un valor incluido mediante `--dart-define` puede extraerse de la app compilada y no debe considerarse un secreto permanente.

Consulta [SECURITY.md](SECURITY.md) para comunicar una vulnerabilidad.

## Licencia

Código publicado bajo la licencia MIT. Consulta [LICENSE](LICENSE).
