# 📋 Variables de Entorno para Render

Copia y pega estas variables en Render Dashboard → Environment:

```
APP_NAME=DBA Laravel
APP_ENV=production
APP_DEBUG=false
APP_KEY=                    # ← Click "Generate" en Render
APP_URL=                    # ← Tu URL de Render (ej: https://dba-laravel.onrender.com)
APP_TIMEZONE=America/Argentina/Buenos_Aires
APP_LOCALE=es
APP_FALLBACK_LOCALE=es

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

LOG_CHANNEL=stack
LOG_LEVEL=error

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
QUEUE_CONNECTION=sync

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
```

## 🔑 Variables Críticas

### APP_KEY (REQUERIDO)

**Opción 1 - Generar en Render (Recomendado):**
1. En Render, al agregar `APP_KEY`
2. Click en el botón **"Generate"**
3. Render generará una key automáticamente

**Opción 2 - Generar manualmente:**
```bash
php artisan key:generate --show
# Resultado: base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### APP_URL (REQUERIDO)

Después de crear el servicio, Render te dará una URL como:
```
https://dba-laravel.onrender.com
```

Copia esa URL y pégala en `APP_URL`.

## 📝 Notas

- **DB_DATABASE**: Ruta fija, no cambiar
- **SESSION_DRIVER**: `file` es más simple para SQLite
- **CACHE_STORE**: `file` funciona bien en plan Free
- **QUEUE_CONNECTION**: `sync` para plan Free (sin Redis)

## ⚙️ Configuración Manual en Render

Si NO usas `render.yaml`:

1. **Runtime**: Docker
2. **Dockerfile Path**: `./Dockerfile`
3. **Docker Command**: (dejar vacío)
4. **Region**: Oregon (o el más cercano a ti)
5. **Plan**: Free Web Services
6. **Auto-Deploy**: Yes
7. **Environment Variables**: Agregar las de arriba
