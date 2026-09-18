MyDiary es una aplicación web personal para gestionar y organizar diferentes tipos de contenido multimedia, como películas, series (temporadas y episodios), videojuegos y libros.  
Permite registrar, consultar, valorar, anotar y marcar como favorito o pendiente cada contenido por separado.  
Se puede filtrar por valoración o buscar un contenido concreto, así como editarlos si es necesario.  
Incluye un historial propio de acciones.

Para poder registrarlos se usan API de base de datos públicas, como TMDB para películas y series, IGDB para videojuegos y Open Library para libros. La información proporcionada viene de la petición, pero una vez registrado todo se gestiona desde la base de datos local.  
Debido al funcionamiento de OpenLibrary, se ha decidido que las portadas de los libros se descarguen de forma local en el proyecto una vez que sean registrados.

La página principal tiene registro de usuario e inicio de sesión, siendo el usuario "isaac" y la contraseña "1234" el ejemplo de uso.

## Configuración

1. Instalar un entorno de desarrollo local compatible con PHP que incluya Apache, como Laragon o XAMPP.
2. Importar la base de datos `sql/schema.sql` a phpmyadmin, la cual viene con ejemplos incluidos.
3. Instalar composer en la carpeta raíz privada del entorno (composer require vlucas/phpdotenv)
5. Crear un archivo MyDiary.env en la carpeta raíz privada del entorno local y rellenarlo con los datos sensibles (abajo está la plantilla)
6. Obtener las claves necesarias de cada base de datos pública para usar sus API (token de TMDB, clientId y clientSecret de IGDB, y un correo electrónico personal para Open Library)
6. Acceder a MyDiary desde el entorno local.

## Plantila para MyDiary.env

bDatosServer=""  
bDatos="mydiary"  
bDatosUser=""  
bDatosPass=""  

tokenTMDB=""  
clientIdIGDB=""  
clientSecretIGDB=""  
emailOpenLibrary=""  

## Autor

Isaac Espinosa Acevedo.  
isaacespi96@gmail.com