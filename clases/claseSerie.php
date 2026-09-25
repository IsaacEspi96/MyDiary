<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiSerie.php';

class Serie
{
    public $idSerie;
    public $idApi;
    public $nombreSerie;
    public $creadorSerie;
    public $directorSerie;
    public $actorSerie;
    public $guionistaSerie;
    public $companiaSerie;
    public $generoSerie;
    public $anoSerie;
    public $temporadasSerie;
    public $episodiosSerie;
    public $ratingAvgSerie;
    public $paisSerie;
    public $idiomaSerie;
    public $posterSerie;
    public $sinopsisSerie;

    function __construct($idSerie = null, $idApi = null, $nombreSerie = null, $creadorSerie = null, $directorSerie = null, $actorSerie = null, $guionistaSerie = null, $companiaSerie = null, $generoSerie = null, $anoSerie = null, $temporadasSerie = null, $episodiosSerie = null, $ratingAvgSerie = null, $paisSerie = null, $idiomaSerie = null, $posterSerie = null, $sinopsisSerie = null)
    {
        $this->idSerie = $idSerie;
        $this->idApi = $idApi;
        $this->nombreSerie = $nombreSerie;
        $this->creadorSerie = $creadorSerie;
        $this->directorSerie = $directorSerie;
        $this->actorSerie = $actorSerie;
        $this->guionistaSerie = $guionistaSerie;
        $this->companiaSerie = $companiaSerie;
        $this->generoSerie = $generoSerie;
        $this->anoSerie = $anoSerie;
        $this->temporadasSerie = $temporadasSerie;
        $this->episodiosSerie = $episodiosSerie;
        $this->ratingAvgSerie = $ratingAvgSerie;
        $this->paisSerie = $paisSerie;
        $this->idiomaSerie = $idiomaSerie;
        $this->posterSerie = $posterSerie;
        $this->sinopsisSerie = $sinopsisSerie;
    } // Fin __construct

    public function existe()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT idSerie FROM series WHERE idApi=:idApi");

                $consulta->bindParam(':idApi', $this->idApi);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    return $resultado['idSerie'];
                } else {
                    return false;
                }
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al comprobar si existe la serie en la Base de Datos.',
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
        $idSerie = $this->existe($this->idApi);

        // Si no existe la creamos, y devolvemos el último idSerie insertado
        // Si existe devolvemos el idSerie correspondiente
        if (!$idSerie) {

            $conexion = conexionBD();

            if (is_array($conexion)) {
                return $conexion;
            } else {
                try {

                    $consulta = $conexion->prepare("INSERT INTO series (idApi, nombreSerie, creadorSerie, directorSerie, actorSerie, guionistaSerie, companiaSerie, generoSerie, anoSerie, temporadasSerie, episodiosSerie, ratingAvgSerie, paisSerie, idiomaSerie, posterSerie, sinopsisSerie) VALUES (:idApi,:nombre,:creador,:director,:actor,:guionista,:compania,:genero,:ano,:temporadas,:episodios,:ratingAvg,:pais,:idioma,:poster,:sinopsis)");

                    $consulta->bindParam(':idApi', $this->idApi);
                    $consulta->bindParam(':nombre', $this->nombreSerie);
                    $consulta->bindParam(':creador', $this->creadorSerie);
                    $consulta->bindParam(':director', $this->directorSerie);
                    $consulta->bindParam(':actor', $this->actorSerie);
                    $consulta->bindParam(':guionista', $this->guionistaSerie);
                    $consulta->bindParam(':compania', $this->companiaSerie);
                    $consulta->bindParam(':genero', $this->generoSerie);
                    $consulta->bindParam(':ano', $this->anoSerie);
                    $consulta->bindParam(':temporadas', $this->temporadasSerie);
                    $consulta->bindParam(':episodios', $this->episodiosSerie);
                    $consulta->bindParam(':ratingAvg', $this->ratingAvgSerie);
                    $consulta->bindParam(':pais', $this->paisSerie);
                    $consulta->bindParam(':idioma', $this->idiomaSerie);
                    $consulta->bindParam(':poster', $this->posterSerie);
                    $consulta->bindParam(':sinopsis', $this->sinopsisSerie);

                    $consulta->execute();

                    return $conexion->lastInsertId();
                } catch (PDOException $error) {
                    $respuesta = [
                        'error' => 'Ocurrió un error al agregar la serie.',
                        'error_tecnico' => $error
                    ];

                    $conexion = null;
                    return $respuesta;
                }
            } // Fin else
        } else {
            return $idSerie;
        }
    } // Fin agregar()

    public function comprobar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT * FROM series WHERE idSerie= :idSerie");

                $consulta->bindParam(':idSerie', $this->idSerie);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al recoger los datos de la serie seleccionada.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin comprobar()

} // Fin clase Serie
