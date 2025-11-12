# 🐳 Docker Configuration

Esta aplicación está optimizada para deployment en **Render** usando Docker.

## 📁 Archivos de Configuración

### `Dockerfile`
Imagen optimizada de producción basada en PHP 8.4-FPM con:
- ✅ PHP 8.4 con extensiones necesarias (PDO SQLite, GD, etc.)
- ✅ Node.js 20 para compilar assets
- ✅ Composer optimizado
- ✅ Build multi-stage para reducir tamaño
- ✅ Permisos correctos para Laravel

### `docker-entrypoint.sh`
Script de inicio que:
- 🗄️ Crea y configura base de datos SQLite
- 🔧 Optimiza cache de Laravel
- 📊 Ejecuta migraciones automáticamente
- 🌱 Seed inicial (si la DB está vacía)
- 🚀 Inicia servidor en el puerto correcto

### `.dockerignore`
Optimiza el build excluyendo:
- node_modules
- vendor
- .git
- tests
- archivos de desarrollo

### `render.yaml`
Configuración Infrastructure-as-Code para Render:
- Deployment automático desde `main`
- Variables de entorno pre-configuradas
- Plan Free por defecto
- Region Oregon

## 🚀 Deployment en Render

### Método Automático (Recomendado)

1. Push a GitHub:
   ```bash
   git push origin main
   ```

2. En Render Dashboard:
   - New → Web Service
   - Conectar repo
   - Render detecta `render.yaml`
   - Click "Create Web Service"

¡Listo! Ver **RENDER_QUICKSTART.md** para pasos detallados.

## 🧪 Testing Local con Docker

### Build
```bash
docker build -t dba-laravel .
```

### Run
```bash
docker run -p 8080:8080 \
  -e APP_KEY=base64:xxxxxxxxxxxxx \
  -e APP_ENV=local \
  -e APP_DEBUG=true \
  dba-laravel
```

### Acceder
```
http://localhost:8080
http://localhost:8080/app
```

## 🔧 Configuración de Producción

### Variables de Entorno Requeridas

Ver **RENDER_ENV_VARS.md** para lista completa.

Mínimas necesarias:
```
APP_KEY=base64:xxxxxxxx
APP_URL=https://tu-app.onrender.com
APP_ENV=production
DB_CONNECTION=sqlite
```

### Generar APP_KEY
```bash
php artisan key:generate --show
```

## 📊 Base de Datos

### SQLite en Docker

La aplicación usa SQLite ubicado en:
```
/var/www/database/database.sqlite
```

### ⚠️ Persistencia

**Plan Free de Render:**
- Base de datos se borra al reiniciar el contenedor
- Perfecto para demos/pruebas
- Los seeders se ejecutan automáticamente si está vacía

**Plan Starter ($7/mes):**
- Agregar disco persistente en Render
- Mount path: `/var/www/database`
- La base de datos persiste entre deployments

## 🔄 CI/CD

### Auto-Deploy

Cada push a `main`:
1. ✅ Render detecta el cambio
2. ✅ Construye nueva imagen Docker
3. ✅ Ejecuta migraciones
4. ✅ Reemplaza contenedor antiguo
5. ✅ App actualizada automáticamente

### Logs

Ver en tiempo real:
```
Render Dashboard → Tu Servicio → Logs
```

## 📦 Estructura del Build

1. **Base Image**: PHP 8.4-FPM
2. **Dependencies**: Instala sistema + PHP extensions
3. **Composer**: Instala packages (--no-dev)
4. **NPM**: Instala y compila assets
5. **Permissions**: Configura storage y database
6. **Entrypoint**: Script de inicio

### Optimizaciones

- ✅ Multi-stage para cache de dependencias
- ✅ `composer.json` copiado primero (cache layer)
- ✅ Assets compilados durante build
- ✅ Autoload optimizado
- ✅ Config, route, view cached

## 🐛 Troubleshooting

### Build falla

```bash
# Ver logs detallados en Render
# O probar local:
docker build -t test . --progress=plain
```

### Permisos

El script `docker-entrypoint.sh` maneja permisos automáticamente.

### Port

Render usa variable de entorno `PORT`. El script la detecta automáticamente.

### Database

Si los seeders no corren:
```bash
# En Render Shell (si está disponible)
php artisan db:seed --force
```

## 📖 Documentación Adicional

- **RENDER_QUICKSTART.md** - Deploy en 5 pasos
- **DEPLOYMENT.md** - Guía completa
- **DEPLOYMENT_CHECKLIST.md** - Lista de verificación
- **RENDER_ENV_VARS.md** - Variables de entorno

## 🎯 Quick Links

- [Render Dashboard](https://dashboard.render.com/)
- [Render Docs - Docker](https://render.com/docs/deploy-docker)
- [Laravel Deployment Docs](https://laravel.com/docs/deployment)
