<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';

class ApiLibro
{

    private function peticion($url)
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['User-Agent: MyDiary (' . $_ENV['emailOpenLibrary'] . ')', 'Accept: application/json']);

        $respuesta = curl_exec($curl);

        $codigoHTTP = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return [
                'error' => 'No se pudo realizar la petición a Open Library.',
                'error_tecnico' => $error
            ];
        }

        curl_close($curl);

        $resultado = json_decode($respuesta, true);

        if ($codigoHTTP < 200 || $codigoHTTP >= 300) {
            return [
                'error' => 'Open Library devolvió un error.',
                'error_tecnico' => $resultado
            ];
        }

        return $resultado;
    } // Fin peticion()

    public function buscar($nombre)
    {

        $nombre = urlencode($nombre);

        $url = 'https://openlibrary.org/search.json'
            . '?title=' . $nombre
            . '&fields='
            . 'key,'
            . 'title,'
            . 'author_name,'
            . 'first_publish_year,'
            . 'cover_i'
            . '&limit=10';

        $resultado = $this->peticion($url);

        if (isset($resultado['error'])) {
            return $resultado;
        }

        return $resultado['docs'];
    } // Fin buscar()

    public function detalles($idApi)
    {

        if (strpos($idApi, '/works/') !== 0) {
            $idApi = '/works/' . $idApi;
        }


        /// Obtenemos la work
        $urlWork = 'https://openlibrary.org' . $idApi . '.json';
        $resultado = $this->peticion($urlWork);

        if (isset($resultado['error'])) {
            return $resultado;
        }

        // Recuperamos datos básicos que la Work no siempre tiene
        $urlExtra =
            'https://openlibrary.org/search.json'
            . '?q=key:' . urlencode($idApi)
            . '&fields='
            . 'first_publish_year,'
            . 'cover_i,'
            . 'ratings_average,'
            . 'number_of_pages_median,'
            . 'language,'
            . 'edition_count'
            . '&limit=1';


        $extra = $this->peticion($urlExtra);

        if (!isset($extra['error']) && !empty($extra['docs'][0])) {

            $resultado['first_publish_year'] = $extra['docs'][0]['first_publish_year'] ?? null;
            $resultado['cover_i'] = $extra['docs'][0]['cover_i'] ?? null;
            $resultado['ratings_average'] = $extra['docs'][0]['ratings_average'] ?? null;
            $resultado['number_of_pages_median'] = $extra['docs'][0]['number_of_pages_median'] ?? null;
            $resultado['language'] = $extra['docs'][0]['language'] ?? [];
            $resultado['edition_count'] = $extra['docs'][0]['edition_count'] ?? null;
        }

        // Edición representativa
        $urlEdiciones = 'https://openlibrary.org' . $idApi . '/editions.json?limit=1';
        $ediciones = $this->peticion($urlEdiciones);

        if (!isset($ediciones['error']) && !empty($ediciones['entries'])) {

            $resultado['edicionesLibro'] = $ediciones['entries'];
            $resultado['edicionPrincipal'] =  $ediciones['entries'][0];

            foreach ($ediciones['entries'] as $edicion) {
                if (isset($edicion['number_of_pages']) || isset($edicion['publishers']) || isset($edicion['languages'])) {

                    $resultado['edicionPrincipal'] = $edicion;
                    break;
                }
            }
        }


        return $resultado;
    } // Fin detalles()

    public function transformarDatos($resultado)
    {

        $libro = [];

        // Id
        $libro['idApi'] = $resultado['key'] ?? '';

        // Nombre
        $libro['nombreLibro'] = $resultado['title'] ?? '';

        // Autor
        $autorLibro = '';

        if (!empty($resultado['author_name'])) {

            $autorLibro = $resultado['author_name'][0];
        } elseif (isset($resultado['authors'][0]['author']['key'])) {
            $autor = $this->peticion('https://openlibrary.org' . $resultado['authors'][0]['author']['key'] . '.json');

            if (!isset($autor['error']) && isset($autor['name'])) {
                $autorLibro = $autor['name'];
            }
        }

        $libro['autorLibro'] = $autorLibro;

        // Géneros
        $generosPermitidos = [

            'fantasy',
            'fantasy fiction',
            'science fiction',
            'fiction',
            'romance',
            'mystery',
            'thriller',
            'horror',
            'adventure',
            'historical fiction',
            'historical',
            'crime',
            'drama',
            'comedy',
            'poetry',
            'biography',
            'autobiography',
            'memoir',
            'philosophy',
            'psychology',
            'self-help',
            'children',
            'young adult',
            'dystopian',
            'literary fiction',
            'graphic novel',
            'comics',
            'novel',
            'novels',
            'fiction novels',
            'literature',
            'classic literature',
            'classics',
            'modern fiction',
            'contemporary fiction',
            'suspense',
            'detective fiction',
            'police fiction',
            'espionage',
            'spy fiction',
            'war fiction',
            'political fiction',
            'satire',
            'humor',
            'tragedy',
            'romantic fiction',
            'erotic fiction',
            'gothic fiction',
            'dark fantasy',
            'urban fantasy',
            'epic fantasy',
            'high fantasy',
            'magical realism',
            'steampunk',
            'cyberpunk',
            'space opera',
            'alternate history',
            'apocalyptic fiction',
            'post apocalyptic fiction',

            'history',
            'world history',
            'art',
            'music',
            'travel',
            'travel writing',
            'cooking',
            'cookbooks',
            'food',
            'crafts',
            'business',
            'finance',
            'economics',
            'education',
            'textbooks',
            'science',
            'popular science',
            'nature',
            'environment',
            'health',
            'fitness',
            'sports',
            'religion',
            'spirituality',
            'politics',
            'sociology',
            'anthropology',

            'picture books',
            'fairy tales',
            'folk tales',
            'juvenile fiction',
            'juvenile literature',
            'middle grade',
            'school stories',

            'essays',
            'short stories',
            'plays',
            'drama',
            'screenplays'
        ];

        $generos = [];

        if (isset($resultado['subjects'])) {
            foreach ($resultado['subjects'] as $subject) {

                $subjectNormalizado = strtolower(trim($subject));

                if (in_array($subjectNormalizado, $generosPermitidos, true)) {
                    $generos[] = $subject;
                }
            }
        }

        $libro['generoLibro'] = implode(', ', array_unique($generos));

        // Temas
        $temasPermitidos = [

            'marriage',
            'husbands',
            'wives',
            'siblings',
            'children',
            'parent and child',
            'friendship',
            'companionship',
            'rivalry',
            'conflict',
            'betrayal',
            'revenge',
            'love',
            'romance',
            'jealousy',
            'family',
            'community',

            'magic',
            'sorcery',
            'witchcraft',
            'wizardry',
            'dragons',
            'elves',
            'dwarves',
            'vampires',
            'werewolves',
            'ghosts',
            'spirits',
            'monsters',
            'supernatural',
            'mythical creatures',
            'mythology',
            'legends',
            'prophecy',
            'quests',
            'enchanted places',

            'murder',
            'crime',
            'criminals',
            'investigation',
            'mystery',
            'detectives',
            'police',
            'espionage',
            'secrets',
            'conspiracy',
            'kidnapping',

            'racism',
            'prejudice',
            'social issues',
            'poverty',
            'wealth',
            'class differences',
            'political systems',
            'government',
            'revolution',
            'rebellion',
            'colonialism',
            'immigration',

            'journeys',
            'travel',
            'exploration',
            'adventure',
            'survival',
            'wilderness',
            'expeditions',
            'islands',
            'oceans',
            'space',
            'planets',

            'mental health',
            'trauma',
            'anxiety',
            'depression',
            'identity',
            'self discovery',
            'personal growth',
            'dreams',
            'nightmares',
            'memories',

            'artificial intelligence',
            'robots',
            'computers',
            'technology',
            'space exploration',
            'astronomy',
            'genetics',
            'medicine',

            'ancient history',
            'medieval history',
            'world war',
            'warfare',
            'military',
            'historical figures',
            'biographical subjects',

            'storytelling',
            'writers',
            'authors',
            'books',
            'reading',
            'literary criticism',
            'fiction writing'
        ];

        $temas = [];

        if (isset($resultado['subjects'])) {
            foreach ($resultado['subjects'] as $subject) {

                $subjectNormalizado = strtolower(trim($subject));

                if (in_array($subjectNormalizado, $temasPermitidos, true)) {
                    $temas[] = $subject;
                }
            }
        }

        $libro['temaLibro'] = implode(', ', array_unique($temas));

        // Año
        $libro['anoLibro'] = '';

        if (!empty($resultado['first_publish_year'])) {
            $libro['anoLibro'] = $resultado['first_publish_year'];
        } else {
            $edicion = $resultado['edicionPrincipal'] ?? [];

            if (!empty($edicion['publish_date'])) {
                $fecha = date_create($edicion['publish_date']);

                if ($fecha) {
                    $libro['anoLibro'] = $fecha->format('Y');
                }
            }
        }

        // Sinopsis
        $descripcion = $resultado['description'] ?? '';
        $libro['sinopsisLibro'] = $this->limpiarSinopsis($descripcion);

        // Portada
        $coverId = null;

        if (!empty($resultado['covers']) && isset($resultado['covers'][0])) {
            $coverId = $resultado['covers'][0];
        } elseif (!empty($edicion['covers']) && isset($edicion['covers'][0])) {
            $coverId = $edicion['covers'][0];
        } elseif (!empty($resultado['cover_i'])) {
            $coverId = $resultado['cover_i'];
        }

        if ($coverId) {
            $libro['posterLibro'] = 'https://covers.openlibrary.org/b/id/' . $coverId . '-L.jpg';
        } else {
            $libro['posterLibro'] = 'images/noPoster.jpeg';
        }

        // Rating medio
        $libro['ratingAvgLibro'] = isset($resultado['ratings_average']) ? number_format($resultado['ratings_average'], 2) : null;

        // Paginas
        $libro['paginasLibro'] = $resultado['number_of_pages_median'] ?? null;

        // Idioma
        $idiomas = [];

        if (!empty($resultado['language'])) {
            foreach ($resultado['language'] as $idioma) {
                $idiomas[] = basename($idioma);
            }
        }

        $libro['idiomaLibro'] = implode(', ', array_unique($idiomas));

        // Ediciones
        $libro['edicionesLibro'] = $resultado['edition_count'] ?? null;

        return $libro;
    } // Fin transformarDatos()

    private function limpiarSinopsis($descripcion)
    {

        if (is_array($descripcion)) {
            $descripcion = $descripcion['value'] ?? '';
        }

        if (empty($descripcion)) {
            return '';
        }

        // Eliminar definiciones de enlaces:
        // [1]: https://...
        $descripcion = preg_replace('/\n?\s*\[\d+\]:\s*\S+/i', '', $descripcion);

        // Convertir [texto][1] -> texto
        $descripcion = preg_replace(
            '/\[([^\]]+)\]\[\d+\]/',
            '$1',
            $descripcion
        );

        // Eliminar secciones no deseadas:
        $seccionesNoDeseadas = [
            'Key characters',
            'Awards and recognition',
            'Awards & recognition'
        ];

        foreach ($seccionesNoDeseadas as $seccion) {
            $posicion = stripos($descripcion, $seccion);

            if ($posicion !== false) {
                $descripcion = substr($descripcion, 0, $posicion);
            }
        }

        // Eliminar enlaces Markdown restantes:
        // [texto](url) -> texto
        $descripcion = preg_replace('/\[([^\]]+)\]\([^)]+\)/', '$1', $descripcion);

        // Negrita/cursiva:
        // ***texto*** -> texto
        // **texto** -> texto
        // *texto* -> texto
        $descripcion = preg_replace('/\*{1,3}([^*]+)\*{1,3}/', '$1', $descripcion);

        // Limpiar espacios innecesarios
        $descripcion = preg_replace("/[ \t]+/", ' ', $descripcion);
        $descripcion = preg_replace("/\n{3,}/", "\n\n", $descripcion);

        return trim($descripcion);
    } // Fin limpiarSinopsis()

    public function descargarPortada($url)
    {

        if (empty($url)) {
            return '';
        }

        $carpeta = $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/images/libros/';

        // Creamos la carpeta si no existe.
        if (!is_dir($carpeta)) {

            if (!mkdir($carpeta, 0755, true)) {
                return '';
            }
        }

        // Extraemos el id de la portada de Open Library
        if (!preg_match('/\/id\/(\d+)-[SML]\.jpg/i', $url, $coincidencias)) {
            return '';
        }

        $idPortada = $coincidencias[1];

        // Nombre y ruta física del archivo.
        $nombreArchivo = $idPortada . '.jpg';

        $rutaFisica = $carpeta . $nombreArchivo;

        // Ruta que guardaremos en la Base de Datos.
        $rutaBD = 'images/libros/' . $nombreArchivo;

        // Si ya existe, no descargamos nada.
        if (file_exists($rutaFisica)) {
            return $rutaBD;
        }

        // Descargamos la imagen.
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $imagen = curl_exec($ch);

        $codigoHTTP = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Comprobamos que la descarga haya funcionado.
        if ($imagen === false || $codigoHTTP < 200 || $codigoHTTP >= 300 || empty($imagen)) {
            return '';
        }

        // Guardamos la imagen físicamente.
        if (file_put_contents($rutaFisica, $imagen) === false) {
            return '';
        }

        return $rutaBD;
    } // Fin descargarPortada()

} // Fin clase ApiLibro
