# 🚀 Deployment en Render con Docker

## Archivos Creados

- `Dockerfile` - Imagen Docker optimizada para producción
- `docker-entrypoint.sh` - Script de inicio de la aplicación
- `.dockerignore` - Optimización de la build
- `render.yaml` - Configuración automática para Render
- `.env.production.example` - Ejemplo de variables de entorno

## 📋 Pasos para Deployment en Render

### Opción 1: Deployment Automático (Recomendado)

1. **Commitea los archivos al repositorio**
   ```bash
   git add Dockerfile docker-entrypoint.sh .dockerignore render.yaml
   git commit -m "Add Docker configuration for Render deployment"
   git push origin main
   ```

2. **Ve a [Render Dashboard](https://dashboard.render.com/)**

3. **Click en "New +" → "Web Service"**

4. **Conecta tu repositorio GitHub** (alexisrocca/DBA-Laravel)

5. **Render detectará automáticamente el `render.yaml`** y pre-configurará todo

6. **Configura las siguientes variables de entorno adicionales:**
   - `APP_KEY`: Click en "Generate" (Render lo generará automáticamente)
   - `APP_URL`: Tu URL de Render (ej: `https://tu-app.onrender.com`)

7. **Click en "Create Web Service"**

8. **Espera a que complete el deployment** (5-10 minutos la primera vez)

### Opción 2: Deployment Manual

1. **Ve a [Render Dashboard](https://dashboard.render.com/)**

2. **Click en "New +" → "Web Service"**

3. **Conecta tu repositorio**

4. **Configura:**
   - **Name**: `dba-laravel`
   - **Region**: Oregon (o el más cercano)
   - **Branch**: `main`
   - **Runtime**: Docker
   - **Dockerfile Path**: `./Dockerfile`
   - **Docker Command**: (dejar vacío, usa el CMD del Dockerfile)

5. **Variables de Entorno:**
   ```
   APP_NAME=DBA Laravel
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:XXXXXXXXXXX  (generar con: php artisan key:generate --show)
   APP_URL=https://tu-app.onrender.com
   DB_CONNECTION=sqlite
   DB_DATABASE=/var/www/database/database.sqlite
   ```

6. **Plan**: Free (o el que prefieras)

7. **Auto-Deploy**: Enabled

8. **Click en "Create Web Service"**

## 🔑 Generar APP_KEY

Si necesitas generar manualmente el APP_KEY:

```bash
# En tu máquina local
php artisan key:generate --show

# Copia el resultado (ejemplo: base64:xxxxxxxxxxxx)
# Pégalo en la variable APP_KEY en Render
```

## 📊 Base de Datos SQLite

La base de datos SQLite se creará automáticamente en `/var/www/database/database.sqlite` en el contenedor.

⚠️ **IMPORTANTE**: En el plan Free de Render, el contenedor se reinicia cuando hay inactividad, **lo que borrará la base de datos**. 

### Soluciones:

1. **Usar plan Starter ($7/mes)** - Tiene disco persistente
2. **Usar PostgreSQL de Render** (gratuito con limitaciones)
3. **Aceptar que es solo para demos/pruebas**

## 🔄 Re-deployments

Cada vez que hagas push a `main`, Render automáticamente:
1. Construirá la nueva imagen Docker
2. Ejecutará las migraciones
3. Reemplazará el servicio antiguo con el nuevo

## 🧪 Probar Localmente con Docker

```bash
# Construir imagen
docker build -t dba-laravel .

# Ejecutar contenedor
docker run -p 8080:8080 \
  -e APP_KEY=base64:xxxxxxxx \
  -e APP_ENV=production \
  dba-laravel

# Visitar: http://localhost:8080
```

## 📝 Notas Importantes

1. **Primera ejecución**: Los seeders se ejecutarán automáticamente la primera vez
2. **Logs**: Ver logs en Render Dashboard → tu servicio → Logs
3. **Health checks**: Render hace ping automático cada 5 minutos en el plan Free
4. **SSL**: Render proporciona SSL/HTTPS automáticamente

## 🐛 Troubleshooting

### Error: "Permission denied" en database.sqlite
- El script `docker-entrypoint.sh` debería manejarlo automáticamente
- Verifica que el archivo tiene permisos de ejecución

### Error: "APP_KEY not set"
- Genera una key: `php artisan key:generate --show`
- Agrégala a las variables de entorno en Render

### Build muy lenta
- Es normal en la primera build (10-15 min)
- Las siguientes serán más rápidas gracias al cache de Docker

### La app no inicia
- Revisa los logs en Render Dashboard
- Verifica que todas las variables de entorno estén configuradas

## 🎯 URLs de Acceso

Después del deployment exitoso:

- **URL pública**: `https://tu-app.onrender.com`
- **Panel Filament**: `https://tu-app.onrender.com/app`
- **Usuario**: `pepe@dba.com`
- **Contraseña**: `password`

## 💾 Persistencia de Datos (Plan Starter)

Si actualizas al plan Starter ($7/mes), puedes usar un disco persistente:

1. En Render Dashboard → tu servicio → Settings
2. Click "Add Disk"
3. **Mount Path**: `/var/www/database`
4. **Size**: 1GB (suficiente)
5. Actualizar `DB_DATABASE` en env vars: `/var/www/database/database.sqlite`

Esto preservará tu base de datos entre deployments y reinicios.
