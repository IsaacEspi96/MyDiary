<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';

class ApiPelicula
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
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $this->token, "accept: application/json"]);

        $respuesta = curl_exec($curl);

        if (curl_errno($curl)) {
            return [
                "error" => curl_error($curl)
            ];
        }

        curl_close($curl);

        return $respuesta;
    } // Fin peticion()

    public function buscar($nombre)
    {

        $nombre = urlencode($nombre);

        $url = "https://api.themoviedb.org/3/search/movie?query=" . $nombre;

        $respuesta = $this->peticion($url);

        return json_decode($respuesta, true);
    } // Fin buscar()

    public function detalles($idApi)
    {

        /*
        * Obtenemos los detalles y los créditos
        * en una única petición.
        */
        $url = "https://api.themoviedb.org/3/movie/"
            . $idApi
            . "?append_to_response=credits";

        $datos = $this->peticion($url);

        $respuesta = json_decode($datos, true);

        if (isset($respuesta['status_code'])) {
            return $respuesta;
        }


        /*
        * Directores
        */
        $directores = [];

        if (isset($respuesta['credits']['crew'])) {

            foreach ($respuesta['credits']['crew'] as $persona) {

                if ($persona['job'] == 'Director') {

                    $directores[] = $persona['name'];

                    if (count($directores) >= 2) {
                        break;
                    }
                }
            }
        }

        $respuesta['directores'] =
            implode(', ', $directores);


        /*
        * Actores
        */
        $actores = [];

        if (isset($respuesta['credits']['cast'])) {

            foreach ($respuesta['credits']['cast'] as $actor) {

                if (count($actores) >= 6) {
                    break;
                }

                $actores[] = $actor['name'];
            }
        }

        $respuesta['actores'] =
            implode(', ', $actores);


        /*
        * Guionistas
        */
        $guionistas = [];

        if (isset($respuesta['credits']['crew'])) {

            foreach ($respuesta['credits']['crew'] as $persona) {

                if ($persona['job'] == 'Screenplay') {

                    $guionistas[] = $persona['name'];

                    if (count($guionistas) >= 3) {
                        break;
                    }
                }
            }
        }

        $respuesta['guionistas'] =
            implode(', ', $guionistas);


        /*
        * Eliminamos credits porque ya no necesitamos
        * conservar toda esa información en la respuesta.
        */
        unset($respuesta['credits']);


        return $respuesta;
    } // Fin detalles()

    public function transformarDatos($resultado)
    {

        $pelicula = [];
        $pelicula['idApi'] = $resultado['id'];
        $pelicula['nombrePelicula'] = $resultado['title'];
        $pelicula['anoPelicula'] = substr($resultado['release_date'], 0, 4);
        $pelicula['posterPelicula'] = "https://image.tmdb.org/t/p/w500" . $resultado['poster_path'];
        $pelicula['ratingAvgPelicula'] = number_format($resultado['vote_average'] / 2, 2);
        $pelicula['sinopsisPelicula'] = $resultado['overview'];

        if (isset($resultado['runtime'])) {
            $pelicula['duracionPelicula'] = $resultado['runtime'];
        }
        if (isset($resultado['directores'])) {
            $pelicula['directorPelicula'] = $resultado['directores'];
        }
        if (isset($resultado['actores'])) {
            $pelicula['actorPelicula'] = $resultado['actores'];
        }
        if (isset($resultado['guionistas'])) {
            if ($resultado['guionistas'] == '') {
                $pelicula['guionistaPelicula'] = $resultado['directores'];
            } else {
                $pelicula['guionistaPelicula'] = $resultado['guionistas'];
            }
        }

        // Géneros
        if (isset($resultado['genres'])) {
            $generos = [];

            foreach ($resultado['genres'] as $genero) {
                $generos[] = $genero['name'];
            }

            $pelicula['generoPelicula'] = implode(', ', $generos);
        }

        // Paises
        if (isset($resultado['origin_country'])) {
            $paises = [];

            foreach ($resultado['origin_country'] as $pais) {
                $paises[] = $pais;
            }

            $pelicula['paisPelicula'] = implode(', ', $paises);
        }

        // Compañías
        if (isset($resultado['production_companies'])) {
            $companias = [];

            foreach ($resultado['production_companies'] as $compania) {
                $companias[] = $compania['name'];
            }

            $pelicula['companiaPelicula'] = implode(', ', $companias);
        }

        // Idiomas
        if (isset($resultado['spoken_languages'])) {
            $idiomas = [];

            foreach ($resultado['spoken_languages'] as $idioma) {
                $idiomas[] = $idioma['name'];
            }

            $pelicula['idiomaPelicula'] = implode(', ', $idiomas);
        }

        return $pelicula;
    } // Fin transformarDatos()

} // Fin clase ApiPelicula
