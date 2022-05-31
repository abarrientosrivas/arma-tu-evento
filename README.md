**Edit a file, create a new file, and clone from Bitbucket in under 2 minutes**

When you're done, you can delete the content in this README and update the file with details for others getting started with your repository.

*We recommend that you open this README in another tab as you perform the tasks below. You can [watch our video](https://youtu.be/0ocf7u76WSo) for a full demo of all the steps in this tutorial. Open the video in a new tab to avoid leaving Bitbucket.*

---

# Armá Tu Evento
Para facilitar el trato entre organizadores y proveedores en el armado de eventos.

## Setup del proyecto

(Esta guía quizá se encuentre incompleta, es probable que haya que correr comandos como npm, yarn u otros managers de packetes para instalar las dependencias de AngularJS.)

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

## Create a file

Next, you’ll add a new file to this repository.

1. Click the **New file** button at the top of the **Source** page.
2. Give the file a filename of **contributors.txt**.
3. Enter your name in the empty file space.
4. Click **Commit** and then **Commit** again in the dialog.
5. Go back to the **Source** page.

Before you move on, go ahead and explore the repository. You've already seen the **Source** page, but check out the **Commits**, **Branches**, and **Settings** pages.

---

## Clone a repository

Use these steps to clone from SourceTree, our client for using the repository command-line free. Cloning allows you to work on your files locally. If you don't yet have SourceTree, [download and install first](https://www.sourcetreeapp.com/). If you prefer to clone from the command line, see [Clone a repository](https://confluence.atlassian.com/x/4whODQ).

1. You’ll see the clone button under the **Source** heading. Click that button.
2. Now click **Check out in SourceTree**. You may need to create a SourceTree account or log in.
3. When you see the **Clone New** dialog in SourceTree, update the destination path and name if you’d like to and then click **Clone**.
4. Open the directory you just created to see your repository’s files.

Now that you're more familiar with your Bitbucket repository, go ahead and add a new file locally. You can [push your change back to Bitbucket with SourceTree](https://confluence.atlassian.com/x/iqyBMg), or you can [add, commit,](https://confluence.atlassian.com/x/8QhODQ) and [push from the command line](https://confluence.atlassian.com/x/NQ0zDQ).
