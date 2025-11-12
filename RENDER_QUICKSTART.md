# 🚢 Deploy Rápido en Render - Guía TL;DR

## ✅ Archivos Listos

Ya están creados:
- ✅ `Dockerfile` - Configuración Docker optimizada
- ✅ `docker-entrypoint.sh` - Script de inicio
- ✅ `.dockerignore` - Optimización de build
- ✅ `render.yaml` - Config automática para Render

## 🚀 Deployment en 5 Pasos

### 1️⃣ Commitea los archivos (si no lo has hecho)

```bash
git add Dockerfile docker-entrypoint.sh .dockerignore render.yaml
git commit -m "Add Docker deployment configuration"
git push origin main
```

### 2️⃣ Ve a Render

Abre: https://dashboard.render.com/

### 3️⃣ Crea el Web Service

1. Click **"New +"** → **"Web Service"**
2. Conecta tu repo **alexisrocca/DBA-Laravel**
3. Render detectará `render.yaml` automáticamente
4. Click **"Apply"** para usar la configuración

### 4️⃣ Configura APP_KEY

En la sección **Environment**:
- Busca `APP_KEY`
- Click en **"Generate"** (Render generará una key automática)

O genera manualmente:
```bash
php artisan key:generate --show
# Copia el resultado: base64:xxxxxxxx
```

### 5️⃣ Deploy

Click **"Create Web Service"**

⏱️ **Espera 5-10 minutos** (primera vez)

## 🎯 Acceder a tu App

Una vez deployado:

- **URL**: `https://tu-servicio.onrender.com`
- **Panel Admin**: `https://tu-servicio.onrender.com/app`
- **Usuario**: `pepe@dba.com`
- **Password**: `password`

## ⚠️ Importante: Plan Free

El plan **FREE** de Render:
- ❌ **NO persiste SQLite** (se borra al reiniciar)
- ✅ Perfecto para **demos y pruebas**
- ✅ SSL automático
- ⚠️ Se duerme después de 15 min de inactividad

### Solución: Plan Starter ($7/mes)

Si necesitas persistencia:

1. Actualiza a plan **Starter**
2. Agrega un **Disk** en Settings:
   - **Mount Path**: `/var/www/database`
   - **Size**: 1GB
3. Tu base de datos persistirá entre deployments

## 🔄 Auto-Deploy

Cada `git push` a `main` → Deploy automático ✨

## 📊 Ver Logs

Dashboard → Tu servicio → **Logs** tab

## ⚡ Probar Local

```bash
docker build -t dba-laravel .
docker run -p 8080:8080 -e APP_KEY=base64:xxx dba-laravel
# Abre: http://localhost:8080
```

## 🐛 Si algo falla

1. **Revisa logs** en Render Dashboard
2. **Verifica APP_KEY** esté configurada
3. **Espera** - la primera build tarda más

## 📞 ¿Problemas?

Consulta **DEPLOYMENT.md** para troubleshooting detallado.
