
# My Test Degusta Box

**My Test Degusta Box** es una aplicación de seguimiento de tiempo diseñada para que los usuarios puedan registrar y gestionar el tiempo dedicado a distintas tareas. Los usuarios pueden iniciar y detener un temporizador para cada tarea, ingresar nuevos nombres de tareas y visualizar un resumen de tiempo dedicado a cada una, incluyendo el tiempo total trabajado en el día.

## Requisitos

Asegúrate de tener las siguientes herramientas instaladas en tu sistema:

- **Git**: para clonar el repositorio desde GitHub.
- **Docker**: para ejecutar la aplicación en un contenedor.
- **Symfony**: framework usado en el proyecto (configurado dentro de Docker).
- **PHP 8.2.12**: versión utilizada en el proyecto.
- **MySQL**: base de datos para almacenar la información del proyecto.

## Instalación y Configuración

1. **Clonar el repositorio**  
   Clona el repositorio desde GitHub usando el siguiente comando:
   ```bash
   git clone https://github.com/aenunez11/my_test_degusta_box.git
   ```

2. **Navegar al directorio del proyecto**  
   Una vez clonado el repositorio, navega al directorio del proyecto:
   ```bash
   cd my_test_degusta_box
   ```

3. **Iniciar Docker**  
   Asegúrate de que Docker esté en ejecución y luego levanta los contenedores con:
   ```bash
   docker-compose up -d
   ```

4. **Ejecutar las migraciones**  
   Para crear la base de datos y las tablas necesarias, ejecuta las migraciones:
   ```bash
   docker-compose exec php bin/console doctrine:migrations:migrate
   ```

5. **Verificar que la aplicación esté en funcionamiento**  
   Una vez completados los pasos anteriores, abre tu navegador web y dirígete a la siguiente URL para verificar que la aplicación esté corriendo:
   ```
   http://localhost:8000/
   ```

   Si todo está configurado correctamente, deberías ver la página de inicio de la aplicación.

## Uso

Para utilizar la aplicación de seguimiento de tiempo, sigue estos pasos:

1. **Iniciar una tarea**  
   Haz clic en el botón "Iniciar/Detener tarea" y se abrirá un modal donde puedes escribir el nombre de la tarea. Luego, haz clic en el botón "Iniciar". Esto iniciará el temporizador.

   Alternativamente, puedes iniciar una tarea utilizando el comando:
   ```bash
   php bin/console task:action start "nueva tarea"
   ```

2. **Detener una tarea**  
   Cuando desees detener el temporizador, haz clic en el botón "Detener". El temporizador se detendrá y podrás ver el tiempo total transcurrido para esa tarea.

   También puedes detener una tarea usando el comando:
   ```bash
   php bin/console task:action end "nueva tarea"
   ```

3. **Agregar una nueva tarea**  
   Para empezar a rastrear una nueva tarea, escribe un nuevo nombre en el campo de entrada y haz clic en "Iniciar" nuevamente. El temporizador comenzará desde cero para esta nueva tarea o reanudará la tarea si fue registrada ese mismo día, evidenciándose en el temporizador el tiempo acumulado.

   También puedes agregar una nueva tarea utilizando el comando:
   ```bash
   php bin/console task:action start "nueva tarea"
   ```

4. **Ver resumen de tareas**  
   En la página principal, podrás ver el tiempo total que has dedicado a cada tarea y el tiempo total trabajado en el día. Las tareas activas de ese día estarán visibles, y tendrás un resumen global de todas las tareas que se han realizado por días.

   Para ver el resumen de tareas, puedes utilizar el comando:
   ```bash
   php bin/console task:action list
   ```
