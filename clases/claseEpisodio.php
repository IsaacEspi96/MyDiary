<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiSerie.php';

class Episodio
{
    public $idEpisodio;
    public $idApi;
    public $idTemporada;
    public $nombreEpisodio;
    public $numeroEpisodio;
    public $directorEpisodio;
    public $actorEpisodio;
    public $guionistaEpisodio;
    public $anoEpisodio;
    public $duracionEpisodio;
    public $ratingAvgEpisodio;
    public $posterEpisodio;
    public $sinopsisEpisodio;

    function __construct($idEpisodio = null, $idApi = null, $idTemporada = null, $nombreEpisodio = null, $numeroEpisodio = null, $directorEpisodio = null, $actorEpisodio = null, $guionistaEpisodio = null, $anoEpisodio = null, $duracionEpisodio = null, $ratingAvgEpisodio = null, $posterEpisodio = null, $sinopsisEpisodio = null)
    {
        $this->idEpisodio = $idEpisodio;
        $this->idApi = $idApi;
        $this->idTemporada = $idTemporada;
        $this->nombreEpisodio = $nombreEpisodio;
        $this->directorEpisodio = $directorEpisodio;
        $this->actorEpisodio = $actorEpisodio;
        $this->guionistaEpisodio = $guionistaEpisodio;
        $this->anoEpisodio = $anoEpisodio;
        $this->duracionEpisodio = $duracionEpisodio;
        $this->ratingAvgEpisodio = $ratingAvgEpisodio;
        $this->posterEpisodio = $posterEpisodio;
        $this->sinopsisEpisodio = $sinopsisEpisodio;
    } // Fin __construct

    public function existe()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT idEpisodio FROM seriesepisodios WHERE idApi=:idApi");

                $consulta->bindParam(':idApi', $this->idApi);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    return $resultado['idEpisodio'];
                } else {
                    return false;
                }
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al comprobar si existe el episodio en la Base de Datos.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin existe()

    public function agregar()
    {

        // Miramos si existe
        $idEpisodio = $this->existe($this->idApi);

        // Si no existe la creamos, y devolvemos el último idEpisodio insertado
        // Si existe devolvemos el idEpisodio correspondiente
        if (!$idEpisodio) {

            $conexion = conexionBD();

            if (is_array($conexion)) {
                return $conexion;
            } else {
                try {

                    $consulta = $conexion->prepare("INSERT INTO seriesepisodios (idApi, idTemporada, nombreEpisodio, numeroEpisodio, directorEpisodio, actorEpisodio, guionistaEpisodio, anoEpisodio, duracionEpisodio, ratingAvgEpisodio, posterEpisodio, sinopsisEpisodio) VALUES (:idApi,:idTemporada,:nombre,:numero,:director,:actor,:guionista,:ano,:duracion,:ratingAvg,:poster,:sinopsis)");

                    $consulta->bindParam(':idApi', $this->idApi);
                    $consulta->bindParam(':idTemporada', $this->idTemporada);
                    $consulta->bindParam(':nombre', $this->nombreEpisodio);
                    $consulta->bindParam(':numero', $this->numeroEpisodio);
                    $consulta->bindParam(':director', $this->directorEpisodio);
                    $consulta->bindParam(':actor', $this->actorEpisodio);
                    $consulta->bindParam(':guionista', $this->guionistaEpisodio);
                    $consulta->bindParam(':ano', $this->anoEpisodio);
                    $consulta->bindParam(':duracion', $this->duracionEpisodio);
                    $consulta->bindParam(':ratingAvg', $this->ratingAvgEpisodio);
                    $consulta->bindParam(':poster', $this->posterEpisodio);
                    $consulta->bindParam(':sinopsis', $this->sinopsisEpisodio);

                    $consulta->execute();

                    return $conexion->lastInsertId();
                } catch (PDOException $error) {
                    $respuesta = [
                        'error' => 'Ocurrió un error al agregar el episodio.',
                        'error_tecnico' => $error
                    ];

                    $conexion = null;
                    return $respuesta;
                }
            } // Fin else
        } else {
            return $idEpisodio;
        }
    } // Fin agregar()

    public function comprobar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT * FROM seriesepisodios WHERE idEpisodio= :idEpisodio");

                $consulta->bindParam(':idEpisodio', $this->idEpisodio);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al recoger los datos del episodio seleccionado.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin comprobar()

} // Fin clase Episodio
