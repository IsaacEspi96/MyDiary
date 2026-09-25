<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';

class ApiJuego
{
    private $clientId;
    private $clientSecret;
    private $accessToken;

    public function __construct()
    {
        $this->clientId = $_ENV['clientIdIGDB'];
        $this->clientSecret = $_ENV['clientSecretIGDB'];
        $this->accessToken = null;
    } // Fin __construct()

    private function obtenerToken()
    {

        // Comprobamos si tenemos un token guardado en sesión y si todavía no ha caducado.
        if (isset($_SESSION['igdb_access_token']) && isset($_SESSION['igdb_token_expira']) && time() < $_SESSION['igdb_token_expira']) {

            $this->accessToken = $_SESSION['igdb_access_token'];

            return true;
        }

        // No tenemos token o ha caducado. Pedimos uno nuevo a Twitch.

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://id.twitch.tv/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials'
            ]
        );

        $respuesta = curl_exec($curl);

        if (curl_errno($curl)) {

            $error = curl_error($curl);

            curl_close($curl);

            return [
                'error' => 'No se pudo obtener el token de IGDB.',
                'error_tecnico' => $error
            ];
        }

        $codigoHTTP = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $resultado = json_decode(
            $respuesta,
            true
        );

        if ($codigoHTTP < 200 || $codigoHTTP >= 300 || isset($resultado['error'])) {

            return [
                'error' => 'No se pudo obtener el token de IGDB.',
                'error_tecnico' => $resultado
            ];
        }

        // Guardamos el token en la sesión.

        $this->accessToken = $resultado['access_token'];

        $_SESSION['igdb_access_token'] = $resultado['access_token'];

        // Dejamos un margen de 60 segundos antes de considerar que el token ha caducado.

        $_SESSION['igdb_token_expira'] = time() + $resultado['expires_in'] - 60;

        return true;
    } // Fin obtenerToken()

    private function peticion($endpoint, $consulta)
    {

        // Si no tenemos token, lo obtenemos
        if ($this->accessToken === null) {

            $resultado = $this->obtenerToken();

            if (is_array($resultado)) {
                return $resultado;
            }
        }


        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://api.igdb.com/v4/' . $endpoint);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $consulta);

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'Client-ID: ' . $this->clientId,
                'Authorization: Bearer ' . $this->accessToken,
                'Content-Type: text/plain'
            ]
        );

        $respuesta = curl_exec($curl);

        $codigoHTTP = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {

            $error = curl_error($curl);

            curl_close($curl);

            return [
                'error' => $error
            ];
        }

        curl_close($curl);

        // Si el token ha caducado o ha quedado invalidado, obtenemos otro
        if ($codigoHTTP == 401) {

            // Eliminamos el token almacenado.
            unset($_SESSION['igdb_access_token']);
            unset($_SESSION['igdb_token_expira']);

            $this->accessToken = null;

            // Obtenemos uno nuevo.
            $resultado = $this->obtenerToken();

            if (is_array($resultado)) {
                return $resultado;
            }

            // Reintentamos la misma petición.
            return $this->peticion(
                $endpoint,
                $consulta
            );
        }


        $resultado = json_decode($respuesta, true);

        if ($codigoHTTP < 200 || $codigoHTTP >= 300) {

            return [
                'error' => 'IGDB devolvió un error.',
                'error_tecnico' => $resultado
            ];
        }

        return $resultado;
    } // Fin peticion()

    public function buscar($nombre)
    {

        $nombre = addslashes($nombre);

        $consulta = '
            fields id,name,first_release_date,cover.image_id;
            search "' . $nombre . '";
            limit 16;
        ';

        $respuesta = $this->peticion('games', $consulta);

        return $respuesta;
    } // Fin buscar()

    public function detalles($idApi)
    {

        $consulta = '
            fields
                id,
                name,
                summary,
                first_release_date,
                cover.image_id,
                rating,
                genres.name,
                platforms.name,
                franchises.name,
                expansions.name,
                dlcs.name,
                involved_companies.company.name,
                involved_companies.developer,
                involved_companies.publisher;
            where id = ' . $idApi . ';
        ';

        $respuesta = $this->peticion('games', $consulta);

        if (isset($respuesta['error'])) {
            return $respuesta;
        }

        if (empty($respuesta)) {
            return [
                'error' => 'No se encontró el videojuego solicitado.'
            ];
        }

        $juego = $respuesta[0];

        // Duración estimada
        $consultaDuracion = 'fields normally,hastily,completely; where game_id = ' . $idApi . ';';
        $duracion = $this->peticion('game_time_to_beats', $consultaDuracion);

        if (!isset($duracion['error']) && !empty($duracion)) {
            $juego['time_to_beat'] = $duracion[0];
        }

        return $juego;
    } // Fin detalles()

    public function transformarDatos($resultado)
    {

        $juego = [];

        $juego['idApi'] = $resultado['id'];

        $juego['nombreJuego'] = $resultado['name'];

        if (isset($resultado['first_release_date'])) {

            $juego['anoJuego'] = date('Y', $resultado['first_release_date']);
        } else {
            $juego['anoJuego'] = '';
        }

        if (isset($resultado['rating'])) {

            $juego['ratingAvgJuego'] = number_format($resultado['rating'] / 20, 2);
        } else {
            $juego['ratingAvgJuego'] = null;
        }

        $juego['sinopsisJuego'] = $resultado['summary'] ?? '';


        // Poster
        if (
            isset($resultado['cover']['image_id']) && !empty($resultado['cover']['image_id'])
        ) {
            $imageId = $resultado['cover']['image_id'];
            $juego['posterJuego'] = 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/' . $imageId . '.jpg';
        } else {
            $juego['posterJuego'] = '';
        }


        // Géneros
        $generos = [];

        if (isset($resultado['genres'])) {

            foreach ($resultado['genres'] as $genero) {

                if (isset($genero['name'])) {
                    $generos[] = $genero['name'];
                }
            }
        }

        $juego['generoJuego'] = implode(', ', $generos);


        // Plataformas
        $plataformas = [];

        if (isset($resultado['platforms'])) {

            foreach ($resultado['platforms'] as $plataforma) {

                if (isset($plataforma['name'])) {

                    $nombrePlataforma = $plataforma['name'];

                    if ($nombrePlataforma === 'PC (Microsoft Windows)') {
                        $nombrePlataforma = 'PC';
                    }

                    $plataformas[] = $nombrePlataforma;
                }
            }
        }

        $juego['plataformasJuego'] = implode(', ', $plataformas);

        // Metemos las plataformas como array, para usarlas en el select
        $juego['opcionesPlataformasJuego'] = $plataformas;


        // Desarrolladores y editores
        $desarrolladores = [];
        $editores = [];

        if (isset($resultado['involved_companies'])) {

            foreach ($resultado['involved_companies'] as $empresa) {

                if (
                    !isset($empresa['company']) ||
                    !isset($empresa['company']['name'])
                ) {
                    continue;
                }

                $nombreEmpresa = $empresa['company']['name'];

                if (
                    isset($empresa['developer']) &&
                    $empresa['developer'] === true
                ) {
                    $desarrolladores[] = $nombreEmpresa;
                }

                if (
                    isset($empresa['publisher']) &&
                    $empresa['publisher'] === true
                ) {
                    $editores[] = $nombreEmpresa;
                }
            }
        }

        $juego['desarrolladorJuego'] = implode(', ', array_unique($desarrolladores));

        $juego['editorJuego'] = implode(', ', array_unique($editores));


        // Franquicias
        $franquicias = [];

        if (isset($resultado['franchises'])) {

            foreach ($resultado['franchises'] as $franquicia) {

                if (isset($franquicia['name'])) {
                    $franquicias[] = $franquicia['name'];
                }
            }
        }

        $juego['franquiciaJuego'] = implode(', ', array_unique($franquicias));


        // Expansiones
        $expansiones = [];

        if (isset($resultado['expansions'])) {

            foreach ($resultado['expansions'] as $expansion) {

                if (isset($expansion['name'])) {
                    $expansiones[] = $expansion['name'];
                }
            }
        }

        $juego['expansionJuego'] = implode(', ', array_unique($expansiones));


        // DLCs
        $dlcs = [];

        if (isset($resultado['dlcs'])) {

            foreach ($resultado['dlcs'] as $dlc) {

                if (isset($dlc['name'])) {
                    $dlcs[] = $dlc['name'];
                }
            }
        }

        $juego['dlcJuego'] = implode(', ', array_unique($dlcs));

        // Duración estimada
        if (
            isset($resultado['time_to_beat']) &&
            isset($resultado['time_to_beat']['normally'])
        ) {
            $horas = $resultado['time_to_beat']['normally'] / 3600;

            $juego['duracionJuego'] = round($horas, 1) . ' h';
        } else {
            $juego['duracionJuego'] = '';
        }


        return $juego;
    } // Fin transformarDatos()

} // Fin clase ApiJuego
