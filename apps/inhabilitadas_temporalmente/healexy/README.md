# HEALEXY — manual de uso

Aplicación web PHP heredada para registrar alimentos, peso y estimaciones de macronutrientes.

**Estado: inhabilitada temporalmente como demo.** Falta el esquema MySQL; el registro y los cálculos no se han podido verificar. No es una web ejecutable desde GitHub.

## Requisitos

- PHP con la extensión `mysqli`.
- MySQL o MariaDB con un esquema compatible con las tablas usadas por la aplicación.

El repositorio original no incluye el esquema SQL. La interfaz puede inspeccionarse, pero las funciones de registro y cálculo necesitan una base de datos preparada.

## Configuración local

Define las credenciales fuera del código:

```powershell
$env:HEALEXY_DB_HOST = "127.0.0.1"
$env:HEALEXY_DB_USER = "healexy_demo"
$env:HEALEXY_DB_PASSWORD = "contraseña-local"
$env:HEALEXY_DB_NAME = "healexy_demo"
php -S localhost:8000
```

Abre `http://localhost:8000`. No guardes estos valores en el repositorio.

## Recorrido de trabajo

1. Registra un usuario de prueba.
2. Añade alimentos y cantidades.
3. Consulta el resumen de calorías y macronutrientes.
4. Revisa el historial de peso y alimentación.

## Seguridad y límites

- La copia pública elimina el servidor, usuario y contraseña MySQL incrustados en el proyecto original.
- También elimina la impresión accidental de la contraseña de sesión durante el acceso.
- Es código educativo heredado: construye varias consultas SQL dinámicamente y no debe exponerse a Internet sin una revisión de seguridad y una migración de contraseñas.
- No fue posible ejecutar `php -l` porque PHP no está instalado en este equipo; se realizó revisión estática y escaneo de secretos.
