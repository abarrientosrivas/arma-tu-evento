# Armá Tu Evento
Para facilitar el trato entre organizadores y proveedores en el armado de eventos.

## Setup del proyecto

Para levantar el servidor de Laravel/Angular y probar la plataforma
en una nueva PC(Linux), hacer lo siguiente:

1. Tener **PHP7, Python2, NPM y MariaDB** instalados.
2. Crear base de datos Homestead con utf8_general_ci.
3. Configurar .env con los datos de la db.
4. Seguir los pasos de https://getcomposer.org/download/ para obtener el instalador.
5. Se necesitan habilitar las extensiones pdo-mysql y gd en php.ini
6. Correr composer.phar utilizando php7 y con el parametro --1 para forzar composer 1.
7. Levantar la base de datos de MariaDB.
8. Ejecutar el comando 'sudo npm install -g npm@6' para forzar la version 6 de npm.
9. Utilizando **PHP7** llamar a los comandos artisan key:generate, artisan migrate, artisan db:seed (para staging de datos de prueba), y artisan serve.
10. La plataforma debería estar servida en localhost:8000.
11. Para levantar la plataforma a la web utilizar **php7-apache**.

El entorno de desarrollo está pensado para un sistema operativo Linux, pero es posible levantar la plataforma
en Windows, para ello utilizar alguna terminal como GitBash, y la herramienta de servidor apache/sql/php XAMPP.
Es probable que necesite buscar tutoriales equivalentes para los pasos anteriores.

---
