# División por Usuarios - Implementación

## Resumen

Se ha implementado un sistema completo de división por usuarios para asegurar que cada usuario solo pueda ver y gestionar sus propios datos (proyectos, tareas y eventos).

## Cambios Realizados

### 1. Políticas de Acceso (Policies)

Se crearon políticas para controlar el acceso a los recursos:

- **`app/Policies/TaskPolicy.php`**: Controla el acceso a las tareas
- **`app/Policies/ProjectPolicy.php`**: Controla el acceso a los proyectos
- **`app/Policies/EventPolicy.php`**: Controla el acceso a los eventos

Cada política verifica que el `user_id` del recurso coincida con el ID del usuario autenticado antes de permitir acciones como ver, editar o eliminar.

### 2. Global Scopes en Modelos

Se agregaron Global Scopes a los modelos para filtrar automáticamente los datos por usuario:

- **`app/Models/Task.php`**: Filtra tareas por `user_id`
- **`app/Models/Project.php`**: Filtra proyectos por `user_id`
- **`app/Models/Event.php`**: Filtra eventos por `user_id`

El Global Scope se aplica automáticamente en todas las consultas cuando hay un usuario autenticado.

```php
protected static function booted(): void
{
    static::addGlobalScope('user', function ($query) {
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }
    });
}
```

### 3. Factories

Se crearon factories para facilitar el testing:

- **`database/factories/TaskFactory.php`**: Genera datos de prueba para tareas
- **`database/factories/ProjectFactory.php`**: Genera datos de prueba para proyectos
- **`database/factories/EventFactory.php`**: Genera datos de prueba para eventos

Cada factory incluye:
- Asignación automática de `user_id`
- Datos realistas usando Faker
- Estados adicionales (por ejemplo, `completed()` para tareas)

### 4. Actualización de Formularios

Se verificó y actualizó el formulario de tareas para asegurar que cuando se crea un proyecto desde el selector, también se asigne el `user_id` correctamente:

- **`app/Filament/Resources/Tasks/Schemas/TaskForm.php`**: Agregado `user_id` oculto en el formulario de creación de proyectos

### 5. Tests

Se crearon tests completos para verificar la funcionalidad:

#### Tests de Políticas (`tests/Feature/TaskPolicyTest.php`)
- ✅ Los usuarios pueden ver sus propias tareas
- ✅ Los usuarios NO pueden ver tareas de otros usuarios
- ✅ Los usuarios pueden actualizar sus propias tareas
- ✅ Los usuarios NO pueden actualizar tareas de otros usuarios
- ✅ Los usuarios pueden eliminar sus propias tareas
- ✅ Los usuarios NO pueden eliminar tareas de otros usuarios

#### Tests de Global Scopes (`tests/Feature/TaskScopeTest.php`)
- ✅ Los usuarios autenticados solo ven sus propias tareas
- ✅ Los usuarios autenticados solo ven sus propios proyectos
- ✅ Los usuarios autenticados solo ven sus propios eventos
- ✅ Los usuarios no ven tareas de otros usuarios en las consultas

## Funcionamiento

### Al Listar Recursos
Cuando un usuario autenticado accede a la lista de tareas, proyectos o eventos:
1. El Global Scope se aplica automáticamente
2. Solo se muestran los recursos donde `user_id` coincide con el usuario autenticado

### Al Ver un Recurso Individual
Cuando un usuario intenta ver un recurso específico:
1. El Global Scope verifica que el recurso pertenezca al usuario
2. La Policy verifica los permisos adicionales
3. Si no es el propietario, se bloquea el acceso

### Al Crear un Recurso
Cuando un usuario crea un recurso:
1. El formulario incluye un campo oculto `user_id` con el ID del usuario autenticado
2. El recurso se guarda automáticamente asociado al usuario

### Al Editar o Eliminar
Cuando un usuario intenta editar o eliminar:
1. El Global Scope asegura que solo pueda acceder a sus propios recursos
2. La Policy verifica los permisos antes de permitir la acción

## Subtareas

- **Subtareas**: No tienen `user_id` directo porque pertenecen a una Task. El acceso se controla automáticamente a través de la relación con Task.

## Ejecución de Tests

Para verificar que todo funciona correctamente:

```bash
# Tests de políticas
php artisan test --filter=TaskPolicyTest

# Tests de scopes
php artisan test --filter=TaskScopeTest

# Todos los tests
php artisan test
```

## Notas Importantes

1. **Sin autenticación**: Si no hay un usuario autenticado, el Global Scope no filtra nada (devuelve todos los registros). Esto es intencional para evitar problemas en comandos de consola o jobs.

2. **Filament**: Las políticas se aplican automáticamente en Filament, por lo que el panel de administración respeta estas restricciones.

3. **Relaciones**: Cuando se cargan relaciones (como `project` en Task), también se respetan los Global Scopes de los modelos relacionados.

4. **Performance**: Los Global Scopes se aplican a nivel de base de datos, por lo que son muy eficientes.

## Seguridad

Este sistema proporciona múltiples capas de seguridad:

1. **Base de datos**: Los Global Scopes filtran a nivel de consulta
2. **Autorización**: Las Policies verifican permisos antes de acciones
3. **Formularios**: El `user_id` se asigna automáticamente y no puede ser modificado por el usuario

Esto asegura que cada usuario tenga privacidad total sobre sus datos y no pueda acceder a información de otros usuarios.
