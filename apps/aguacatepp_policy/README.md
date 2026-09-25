# AguacatePP Policy — manual de uso

Muestra pública de una política firmada que permite comprobar si una versión de AguacatePP continúa habilitada.

## Archivos

- `policy.json`: configuración legible con versión mínima, caducidad y fecha de emisión.
- `policy.sig`: firma digital separada. Es pública y no es una credencial ni una clave privada.

## Inspección

```powershell
Get-Content policy.json | ConvertFrom-Json | Format-List
```

La autenticidad solo puede verificarse con la clave pública correspondiente de un despliegue autorizado. Esta copia no incluye claves privadas ni afirma que la firma haya sido verificada criptográficamente.

## Límites

No edites `policy.json` esperando conservar una firma válida: cualquier modificación debe producir una firma nueva mediante el sistema autorizado.
