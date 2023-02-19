# Armá Tu Evento
Para facilitar el trato entre organizadores y proveedores en el armado de eventos.

## Setup del proyecto

(Esta guía quizá se encuentre incompleta, es probable que haya que correr comandos como npm, yarn u otros managers de packetes para instalar las dependencias de AngularJS.)

### Linux 
1. Tener **PHP7.4.33 y MariaDB** instalados.
2. Crear base de datos Homestead con **utf8_general_ci**.
3. Configurar .env con los datos de la db.
4. Seguir los pasos de https://getcomposer.org/download/ para obtener el instalador.
5. Según la distribución que se esté utilizando, tendrá que activar o instalar distintas extensiones de php.
6. Correr composer.phar utilizando **PHP7.4.33** y con el parametro `self-update --1` para forzar composer 1.
7. Levantar la base de datos de **MariaDB**.
8. Utilizando **PHP7.4.33** llamar a los comandos `artisan key:generate`, `artisan migrate`, `artisan db:seed` (para staging de datos de prueba), y `artisan serve`.
    > La librería faker está fuera de soporte y quizá sea necesario hacer correcciones en el source
9. La plataforma debería estar servida en localhost:8000.
10. Para levantar la plataforma a la web utilizar **php7-apache** y asegurese de que utilice **PHP7.4.33**.

### Windows 
1. Instalar **XAMPP**. Reemplazar el php por defecto por **PHP7.4.33**.
    > Se utiliza **XAMPP** únicamente para facilitar la instalación de la base de datos sql y la herramienta **phpMyAdmin**.
    > La versión de php necesaria para el proyecto no es compatible con el apache por default.
2. Crear la base de datos con **phpMyAdmin** y modificar .env con los datos de la misma.
    > Asegurarse de seleccionar el formato **utf8_general_ci**.
3. Seguir los pasos de https://getcomposer.org/download/ para obtener el instalador.
    > Utilice el método manual por linea de comando para obtener el archivo "composer.phar" local
4. Será necesario activar extensiones en el php de **XAMPP**.
5. Correr composer.phar utilizando **PHP7.4.33** y con el parametro `self-update --1` para forzar composer 1.
6. Levantar la base de datos desde **XAMPP**.
7. Utilizando **PHP7.4.33** llamar a los comandos `artisan key:generate`, `artisan migrate`, `artisan db:seed` (para staging de datos de prueba), y `artisan serve`.
    > La librería faker está fuera de soporte y quizá sea necesario hacer correcciones en el source
8. La plataforma debería estar servida en localhost:8000.