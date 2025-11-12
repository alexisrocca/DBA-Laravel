# ✅ Checklist de Deployment

Marca cada paso cuando lo completes:

## 📦 Pre-Deployment

- [ ] Todos los archivos Docker están en el repo
  - [ ] `Dockerfile`
  - [ ] `docker-entrypoint.sh`
  - [ ] `.dockerignore`
  - [ ] `render.yaml`

- [ ] Commit y push a GitHub
  ```bash
  git status  # Verifica que están todos
  git add .
  git commit -m "Add Docker deployment for Render"
  git push origin main
  ```

## 🌐 En Render Dashboard

- [ ] Cuenta creada en render.com
- [ ] Repositorio conectado a GitHub
- [ ] Web Service creado

## ⚙️ Configuración

- [ ] `render.yaml` detectado automáticamente
- [ ] Variables de entorno configuradas:
  - [ ] `APP_KEY` generada
  - [ ] `APP_URL` configurada
  - [ ] `APP_ENV=production`
  - [ ] `DB_CONNECTION=sqlite`

## 🚀 Deployment

- [ ] Click "Create Web Service"
- [ ] Build iniciado (esperar 5-10 min)
- [ ] Build completado exitosamente
- [ ] Servicio "Live"

## ✅ Verificación Post-Deployment

- [ ] URL pública funciona
- [ ] Acceso a `/app` funciona
- [ ] Login con `pepe@dba.com` / `password` exitoso
- [ ] Dashboard muestra widgets
- [ ] Drill down funciona
- [ ] Gráficos se visualizan

## 📊 Verificar Datos

- [ ] Ver que hay proyectos en el dashboard
- [ ] Ver que hay tareas
- [ ] Verificar que los seeders corrieron

## 🔍 Troubleshooting (si es necesario)

Si algo falla:

- [ ] Revisar logs en Render Dashboard
- [ ] Verificar que `APP_KEY` está configurada
- [ ] Verificar que la build terminó sin errores
- [ ] Verificar que el puerto es correcto (Render usa variable PORT)

## 📝 Notas Importantes

- ⚠️ Plan Free: Base de datos se borra al reiniciar
- ✅ Para producción real: Actualizar a plan Starter ($7/mes)
- 🔄 Auto-deploy habilitado: Cada push a `main` despliega automáticamente

## 🎓 Para el Profesor

Compartir URL:
- **Aplicación**: `https://[tu-servicio].onrender.com`
- **Panel Admin**: `https://[tu-servicio].onrender.com/app`
- **Usuario**: `pepe@dba.com`
- **Contraseña**: `password`

Características para demostrar:
- ✅ Drill Down 3 niveles (Proyectos → Tareas → Subtareas)
- ✅ Gráfico de torta (distribución de tareas)
- ✅ Semáforo de rendimiento
- ✅ Dashboard interactivo
- ✅ Autenticación segura
