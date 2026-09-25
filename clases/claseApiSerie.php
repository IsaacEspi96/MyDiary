<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';

class ApiSerie
{
    private $token;

    public function __construct()
    {
        $this->token = $_ENV['tokenTMDB'];
    } // Fin __construct()

    private function peticion($url)
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->token, 'Accept: application/json']);

        $respuesta = curl_exec($curl);

        $codigoHTTP = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            return [
                'error' => 'No se pudo realizar la petición a TMDB.',
                'error_tecnico' => $error
            ];
        }

        curl_close($curl);

        $resultado = json_decode($respuesta, true);

        if ($codigoHTTP < 200 || $codigoHTTP >= 300) {

            return [
                'error' => 'TMDB devolvió un error.',
                'error_tecnico' => $resultado
            ];
        }

        return $resultado;
    } // Fin peticion()

    public function buscar($nombre)
    {

        $nombre = urlencode($nombre);

        $url = 'https://api.themoviedb.org/3/search/tv' . '?query=' . $nombre;

        $resultado = $this->peticion($url);

        if (isset($resultado['error'])) {
            return $resultado;
        }

        return $resultado['results'];
    } // Fin buscar()

    public function detalles($idApi)
    {

        $url = 'https://api.themoviedb.org/3/tv/' . $idApi . '?append_to_response=aggregate_credits,watch/providers';

        $resultado = $this->peticion($url);

        if (isset($resultado['error'])) {
            return $resultado;
        }

        // Directores
        $directores = [];

        if (isset($resultado['aggregate_credits']['crew'])) {
            foreach ($resultado['aggregate_credits']['crew'] as $persona) {

                if (!isset($persona['jobs'])) {
                    continue;
                }

                foreach ($persona['jobs'] as $trabajo) {

                    if ($trabajo['job'] === 'Director' && !in_array($persona['name'], $directores, true)) {

                        $directores[] = $persona['name'];
                        break;
                    }
                }

                if (count($directores) >= 2) {
                    break;
                }
            }
        }

        $resultado['directores'] = implode(', ', $directores);

        // Actores
        $actores = [];

        if (isset($resultado['aggregate_credits']['cast'])) {
            foreach ($resultado['aggregate_credits']['cast'] as $actor) {

                if (count($actores) >= 6) {
                    break;
                }

                $actores[] = $actor['name'];
            }
        }

        $resultado['actores'] = implode(', ', $actores);


        // Guionistas
        $guionistas = [];

        if (isset($resultado['aggregate_credits']['crew'])) {
            foreach ($resultado['aggregate_credits']['crew'] as $persona) {

                if (!isset($persona['jobs'])) {
                    continue;
                }

                foreach ($persona['jobs'] as $trabajo) {

                    if ($trabajo['job'] === 'Writer' || $trabajo['job'] === 'Screenplay' || $trabajo['job'] === 'Teleplay') {

                        if (!in_array($persona['name'], $guionistas, true)) {

                            $guionistas[] = $persona['name'];
                        }

                        break;
                    }
                }

                if (count($guionistas) >= 3) {
                    break;
                }
            }
        }

        $resultado['guionistas'] = implode(', ', $guionistas);


        unset($resultado['aggregate_credits']);

        return $resultado;
    } // Fin detalles()

    public function transformarDatos($resultado)
    {

        $serie = [];

        // Id
        $serie['idApi'] = $resultado['id'] ?? '';

        // Nombre
        $serie['nombreSerie'] = $resultado['name'] ?? '';

        // Creador
        $creadores = [];

        if (!empty($resultado['created_by'])) {
            foreach ($resultado['created_by'] as $creador) {
                if (isset($creador['name'])) {
                    $creadores[] = $creador['name'];
                }
            }
        }

        $serie['creadorSerie'] = implode(', ', array_unique($creadores));

        // Director
        $serie['directorSerie'] = $resultado['directores'] ?? '';

        // Actor
        $serie['actorSerie'] = $resultado['actores'] ?? '';

        // Guionista
        $serie['guionistaSerie'] = $resultado['guionistas'] ?? '';

        // Genero
        $generos = [];

        if (!empty($resultado['genres'])) {
            foreach ($resultado['genres'] as $genero) {
                if (isset($genero['name'])) {
                    $generos[] = $genero['name'];
                }
            }
        }

        $serie['generoSerie'] = implode(', ', array_unique($generos));

        // Año
        $serie['anoSerie'] = !empty($resultado['first_air_date']) ? substr($resultado['first_air_date'], 0, 4) : '';

        // Número temporadas
        $serie['temporadasSerie'] = $resultado['number_of_seasons'] ?? 0;

        // Número episodios
        $serie['episodiosSerie'] = $resultado['number_of_episodes'] ?? 0;

        // Rating medio
        $serie['ratingAvgSerie'] = isset($resultado['vote_average']) ? number_format($resultado['vote_average'] / 2, 2) : null;

        // Compañia
        $companias = [];

        if (!empty($resultado['production_companies'])) {
            foreach ($resultado['production_companies'] as $compania) {
                if (isset($compania['name'])) {
                    $companias[] = $compania['name'];
                }
            }
        }

        $serie['companiaSerie'] = implode(', ', array_unique($companias));

        // País
        $paises = [];

        if (!empty($resultado['production_countries'])) {
            foreach ($resultado['production_countries'] as $pais) {
                if (isset($pais['name'])) {
                    $paises[] = $pais['name'];
                }
            }
        }

        if (empty($paises) && !empty($resultado['origin_country'])) {
            $paises = $resultado['origin_country'];
        }

        $serie['paisSerie'] = implode(', ', array_unique($paises));

        // Idioma
        $idiomas = [];

        if (!empty($resultado['spoken_languages'])) {
            foreach ($resultado['spoken_languages'] as $idioma) {
                if (isset($idioma['name'])) {
                    $idiomas[] = $idioma['name'];
                }
            }
        }

        if (empty($idiomas) && !empty($resultado['original_language'])) {
            $idiomas[] = $resultado['original_language'];
        }

        $serie['idiomaSerie'] = implode(', ', array_unique($idiomas));

        // Sinopsis
        $serie['sinopsisSerie'] = $resultado['overview'] ?? '';

        // Portada
        if (!empty($resultado['poster_path'])) {
            $serie['posterSerie'] = 'https://image.tmdb.org/t/p/w500' . $resultado['poster_path'];
        } else {
            $serie['posterSerie'] = 'images/noPoster.jpeg';
        }

        // Temporadas.
        // Mantenemos la información proporcionada directamente por TMDB para poder utilizarla más adelante.
        $serie['temporadas'] = $resultado['seasons'] ?? [];

        return $serie;
    } // Fin transformarDatos()

    public function temporada($idSerie, $numeroTemporada)
    {

        $url = 'https://api.themoviedb.org/3/tv/' . $idSerie . '/season/' . $numeroTemporada . '?append_to_response=aggregate_credits';

        $datos = $this->peticion($url);

        if (is_array($datos)) {
            return $datos;
        }

        $respuesta = json_decode($datos, true);

        if (isset($respuesta['status_code'])) {

            return [
                'error' => 'TMDB devolvió un error.',
                'error_tecnico' => $respuesta
            ];
        }

        return $respuesta;
    } // Fin temporada()

    public function transformarDatosTemporada($resultado, $nombreSerie)
    {

        $temporada = [];

        // Id
        $temporada['idApi'] = $resultado['id'] ?? '';

        // ID de la serie a la que pertenece
        // Lo dejamos preparado para que el controlador
        // pueda asignarle después tu idSerie de la BD.

        $temporada['idSerie'] = null;

        // Nombre
        $temporada['nombreTemporada'] = $resultado['name'] ? $nombreSerie . ' - ' . $resultado['name'] : '';

        // Numero temporada
        $temporada['numeroTemporada'] = $resultado['season_number'] ?? null;

        // Director
        $directores = [];

        if (isset($resultado['aggregate_credits']['crew']) && is_array($resultado['aggregate_credits']['crew'])) {
            foreach ($resultado['aggregate_credits']['crew'] as $persona) {

                if (empty($persona['jobs'])) {
                    continue;
                }

                foreach ($persona['jobs'] as $trabajo) {
                    if (isset($trabajo['job']) && $trabajo['job'] === 'Director') {
                        if (isset($persona['name']) && !in_array($persona['name'], $directores, true)) {
                            $directores[] = $persona['name'];
                        }
                        break;
                    }
                }
                if (count($directores) >= 2) {
                    break;
                }
            }
        }

        $temporada['directorTemporada'] = implode(', ', $directores);

        // Guionista
        $guionistas = [];

        if (isset($resultado['aggregate_credits']['crew']) && is_array($resultado['aggregate_credits']['crew'])) {
            foreach ($resultado['aggregate_credits']['crew'] as $persona) {
                if (empty($persona['jobs'])) {
                    continue;
                }
                foreach ($persona['jobs'] as $trabajo) {
                    if (isset($trabajo['job']) && ($trabajo['job'] === 'Writer' || $trabajo['job'] === 'Screenplay' || $trabajo['job'] === 'Teleplay')) {
                        if (isset($persona['name']) && !in_array($persona['name'], $guionistas, true)) {
                            $guionistas[] = $persona['name'];
                        }
                        break;
                    }
                }
                if (count($guionistas) >= 3) {
                    break;
                }
            }
        }

        $temporada['guionistaTemporada'] = implode(', ', $guionistas);

        // Actor
        $actores = [];

        if (isset($resultado['aggregate_credits']['cast']) && is_array($resultado['aggregate_credits']['cast'])) {
            foreach ($resultado['aggregate_credits']['cast'] as $actor) {
                if (count($actores) >= 6) {
                    break;
                }
                if (isset($actor['name'])) {
                    $actores[] = $actor['name'];
                }
            }
        }

        $temporada['actorTemporada'] = implode(', ', $actores);

        // Numero episodios
        $temporada['episodiosTemporada'] = count($resultado['episodes']) ?? 0;

        // Año
        $temporada['anoTemporada'] = '';
        if (!empty($resultado['air_date'])) {
            $temporada['anoTemporada'] = substr($resultado['air_date'], 0, 4);
        }

        // Rating medio
        $temporada['ratingAvgTemporada'] = isset($resultado['vote_average']) ? number_format($resultado['vote_average'] / 2, 2) : null;

        // Portada
        if (!empty($resultado['poster_path'])) {
            $temporada['posterTemporada'] = 'https://image.tmdb.org/t/p/w500' . $resultado['poster_path'];
        } else {
            $temporada['posterTemporada'] = 'images/noPoster.jpeg';
        }

        // Sinopsis
        $temporada['sinopsisTemporada'] = $resultado['overview'] ?? '';

        // Episodios
        $episodios = [];

        if (!empty($resultado['episodes'])) {
            foreach ($resultado['episodes'] as $episodio) {

                $episodios[] = [
                    'idApi' => $episodio['id'] ?? '',
                    'nombreEpisodio' => $episodio['name'] ?? '',
                    'numeroEpisodio' => $episodio['episode_number'] ?? null,
                    'ratingAvgEpisodio' => isset($episodio['vote_average']) ? number_format($episodio['vote_average'] / 2, 2) : null,
                    'posterEpisodio' => !empty($episodio['still_path']) ? 'https://image.tmdb.org/t/p/w300' . $episodio['still_path'] : 'images/noPoster.jpeg',
                    'sinopsisEpisodio' => $episodio['overview'] ?? '',
                    'anoEpisodio' => !empty($episodio['air_date']) ? substr($episodio['air_date'], 0, 4) : ''
                ];
            }
        }

        $temporada['episodios'] = $episodios;

        return $temporada;
    } // Fin transformarDatosTemporada()

    public function episodio($idSerie, $numeroTemporada, $numeroEpisodio)
    {

        $url =
            'https://api.themoviedb.org/3/tv/'
            . $idSerie
            . '/season/'
            . $numeroTemporada
            . '/episode/'
            . $numeroEpisodio
            . '?append_to_response=credits';

        $datos = $this->peticion($url);

        if (is_array($datos)) {
            return $datos;
        }

        $respuesta = json_decode($datos, true);

        if (isset($respuesta['status_code'])) {

            return [
                'error' => 'TMDB devolvió un error.',
                'error_tecnico' => $respuesta
            ];
        }

        return $respuesta;
    } // Fin episodio()

    public function transformarDatosEpisodio($resultado, $numeroTemporada, $nombreSerie)
    {

        $episodio = [];


        /*
        * ID de TMDB
        */
        $episodio['idApi'] = $resultado['id'] ?? '';


        /*
        * ID de la temporada
        *
        * Será el ID interno de tu BD cuando lo guardemos.
        */
        $episodio['idTemporada'] = null;


        /*
        * Nombre
        */
        if (strlen((string)$resultado['episode_number']) == 1) {
            $episodio['nombreEpisodio'] = $resultado['name'] ? $nombreSerie . ' - ' . $numeroTemporada . 'x0' . $resultado['episode_number'] . ' (' . $resultado['name'] . ')' : '';
        } else {
            $episodio['nombreEpisodio'] = $resultado['name'] ? $nombreSerie . ' - ' . $numeroTemporada . 'x' . $resultado['episode_number'] . ' (' . $resultado['name'] . ')' : '';
        }


        /*
        * Número de episodio
        */
        $episodio['numeroEpisodio'] = $resultado['episode_number'] ?? null;


        /*
        * Director
        */
        $directores = [];

        if (
            !empty($resultado['credits']['crew']) &&
            is_array($resultado['credits']['crew'])
        ) {

            foreach (
                $resultado['credits']['crew']
                as $persona
            ) {

                if (
                    isset($persona['job']) &&
                    $persona['job'] === 'Director' &&
                    isset($persona['name'])
                ) {

                    if (!in_array(
                        $persona['name'],
                        $directores,
                        true
                    )) {

                        $directores[] =
                            $persona['name'];
                    }

                    if (count($directores) >= 2) {
                        break;
                    }
                }
            }
        }

        $episodio['directorEpisodio'] =
            implode(', ', $directores);


        /*
        * Guionistas
        */
        $guionistas = [];

        if (
            !empty($resultado['credits']['crew']) &&
            is_array($resultado['credits']['crew'])
        ) {

            foreach (
                $resultado['credits']['crew']
                as $persona
            ) {

                if (
                    !isset($persona['job']) ||
                    !isset($persona['name'])
                ) {
                    continue;
                }

                if (
                    $persona['job'] === 'Writer' ||
                    $persona['job'] === 'Screenplay' ||
                    $persona['job'] === 'Teleplay'
                ) {

                    if (!in_array(
                        $persona['name'],
                        $guionistas,
                        true
                    )) {

                        $guionistas[] =
                            $persona['name'];
                    }

                    if (count($guionistas) >= 3) {
                        break;
                    }
                }
            }
        }

        $episodio['guionistaEpisodio'] =
            implode(', ', $guionistas);


        /*
        * Actores
        */
        $actores = [];

        if (
            !empty($resultado['credits']['cast']) &&
            is_array($resultado['credits']['cast'])
        ) {

            foreach (
                $resultado['credits']['cast']
                as $actor
            ) {

                if (count($actores) >= 6) {
                    break;
                }

                if (isset($actor['name'])) {

                    $actores[] =
                        $actor['name'];
                }
            }
        }

        $episodio['actorEpisodio'] =
            implode(', ', array_unique($actores));


        /*
        * Año
        */
        $episodio['anoEpisodio'] = '';

        if (!empty($resultado['air_date'])) {

            $episodio['anoEpisodio'] =
                substr(
                    $resultado['air_date'],
                    0,
                    4
                );
        }


        /*
        * Valoración media
        *
        * TMDB: 0-10
        * Proyecto: 0-5
        */
        $episodio['ratingAvgEpisodio'] =
            isset($resultado['vote_average'])
            ? number_format(
                $resultado['vote_average'] / 2,
                2
            )
            : null;


        /*
        * Portada / imagen
        */
        if (!empty($resultado['still_path'])) {

            $episodio['posterEpisodio'] =
                'https://image.tmdb.org/t/p/w500'
                . $resultado['still_path'];
        } else {

            $episodio['posterEpisodio'] =
                'images/noPoster.jpeg';
        }


        /*
        * Sinopsis
        */
        $episodio['sinopsisEpisodio'] =
            $resultado['overview'] ?? '';


        /*
        * Duración
        *
        * El episodio puede tener runtime aunque no
        * lo hayamos guardado en la temporada.
        */
        $episodio['duracionEpisodio'] = $resultado['runtime'] ? $resultado['runtime'] . ' min' : null;


        return $episodio;
    } // Fin transformarDatosEpisodio()

} // Fin clase ApiSerie
