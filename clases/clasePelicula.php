<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiPelicula.php';

class Pelicula{
    public $idPelicula;
    public $idApi;
    public $nombrePelicula;
    public $directorPelicula;
    public $actorPelicula;
    public $guionistaPelicula;
    public $generoPelicula;
    public $anoPelicula;
    public $companiaPelicula;
    public $duracionPelicula;
    public $ratingAvgPelicula;
    public $paisPelicula;
    public $idiomaPelicula;
    public $posterPelicula;
    public $sinopsisPelicula;

    function __construct($idPelicula=null, $idApi=null, $nombrePelicula=null, $directorPelicula=null, $actorPelicula=null, $guionistaPelicula=null, $generoPelicula=null, $anoPelicula=null, $companiaPelicula=null, $duracionPelicula=null, $ratingAvgPelicula=null, $paisPelicula=null, $idiomaPelicula=null, $posterPelicula=null, $sinopsisPelicula=null){
        $this->idPelicula = $idPelicula;
        $this->idApi = $idApi;
        $this->nombrePelicula = $nombrePelicula;
        $this->directorPelicula = $directorPelicula;
        $this->actorPelicula = $actorPelicula;
        $this->guionistaPelicula = $guionistaPelicula;
        $this->generoPelicula = $generoPelicula;
        $this->anoPelicula = $anoPelicula;
        $this->companiaPelicula = $companiaPelicula;
        $this->duracionPelicula = $duracionPelicula;
        $this->ratingAvgPelicula = $ratingAvgPelicula;
        $this->paisPelicula = $paisPelicula;
        $this->idiomaPelicula = $idiomaPelicula;
        $this->posterPelicula = $posterPelicula;
        $this->sinopsisPelicula = $sinopsisPelicula;
    } // Fin __construct

    public function existe(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT idPelicula FROM peliculas WHERE idApi=:idApi");

                $consulta->bindParam(':idApi', $this->idApi);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if($resultado){
                    return $resultado['idPelicula'];
                }else{
                    return false;
                }

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al comprobar si existe la película en la Base de Datos.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin existe()

    public function agregar(){

        // Miramos si existe
        $idPelicula = $this->existe($this->idApi);

        // Si no existe la creamos, y devolvemos el último idPelicula insertado
        // Si existe devolvemos el idPelicula correspondiente
        if(!$idPelicula){

            $conexion = conexionBD();

            if(is_array($conexion)){
                return $conexion;
            }else{
                try{

                    $consulta=$conexion->prepare("INSERT INTO peliculas (idApi,nombrePelicula,directorPelicula,actorPelicula,guionistaPelicula,generoPelicula,anoPelicula,companiaPelicula,duracionPelicula,posterPelicula,ratingAvgPelicula,paisPelicula,idiomaPelicula,sinopsisPelicula) VALUES (:idApi,:nombre,:director,:actor,:guionista,:genero,:ano,:compania,:duracion,:poster,:ratingAvg,:pais,:idioma,:sinopsis)");

                    $consulta->bindParam(':idApi',$this->idApi);
                    $consulta->bindParam(':nombre',$this->nombrePelicula);
                    $consulta->bindParam(':director',$this->directorPelicula);
                    $consulta->bindParam(':actor',$this->actorPelicula);
                    $consulta->bindParam(':guionista',$this->guionistaPelicula);
                    $consulta->bindParam(':genero',$this->generoPelicula);
                    $consulta->bindParam(':ano',$this->anoPelicula);
                    $consulta->bindParam(':compania',$this->companiaPelicula);
                    $consulta->bindParam(':duracion',$this->duracionPelicula);
                    $consulta->bindParam(':ratingAvg',$this->ratingAvgPelicula);
                    $consulta->bindParam(':pais',$this->paisPelicula);
                    $consulta->bindParam(':idioma',$this->idiomaPelicula);
                    $consulta->bindParam(':poster',$this->posterPelicula);
                    $consulta->bindParam(':sinopsis',$this->sinopsisPelicula);

                    $consulta->execute();

                    return $conexion->lastInsertId();

                }catch(PDOException $error){
                    $respuesta = [
                                'error' => 'Ocurrió un error al agregar la película.',
                                'error_tecnico' => $error
                                ];
                    
                    $conexion = null;
                    return $respuesta;
                }
            } // Fin else
        }else{
            return $idPelicula;
        }

    } // Fin agregar()

    public function comprobar(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM peliculas WHERE idPelicula= :idPelicula");

                $consulta->bindParam(':idPelicula', $this->idPelicula);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al recoger los datos de la película seleccionada.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin comprobar()

    
    // Métodos para actualizar detalles

    public function listarIdApi(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{

            try{

                $consulta = $conexion->prepare("
                    SELECT idPelicula, idApi
                    FROM peliculas
                    WHERE idApi IS NOT NULL
                    AND idApi <> ''
                ");

                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $error){

                $respuesta = [
                    'error' => 'Ocurrió un error al listar las películas.',
                    'error_tecnico' => $error
                ];

                $conexion = null;

                return $respuesta;
            }
        }

    } // Fin listarIdApi()

    public function actualizarDetalles(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{

            try{

                $consulta = $conexion->prepare("
                    UPDATE peliculas SET
                        actorPelicula = :actor,
                        guionistaPelicula = :guionista,
                        generoPelicula = :genero,
                        duracionPelicula = :duracion,
                        companiaPelicula = :compania,
                        paisPelicula = :pais,
                        idiomaPelicula = :idioma
                    WHERE idPelicula = :idPelicula
                ");

                $consulta->bindParam(':actor', $this->actorPelicula);
                $consulta->bindParam(':guionista', $this->guionistaPelicula);
                $consulta->bindParam(':genero', $this->generoPelicula);
                $consulta->bindParam(':duracion', $this->duracionPelicula);
                $consulta->bindParam(':compania', $this->companiaPelicula);
                $consulta->bindParam(':pais', $this->paisPelicula);
                $consulta->bindParam(':idioma', $this->idiomaPelicula);
                $consulta->bindParam(':idPelicula', $this->idPelicula);

                $consulta->execute();

                return true;

            }catch(PDOException $error){

                $respuesta = [
                    'error' => 'Ocurrió un error al actualizar los detalles de la película.',
                    'error_tecnico' => $error
                ];

                $conexion = null;

                return $respuesta;
            }
        }

    } // Fin actualizarDetalles()

} // Fin clase Pelicula

?>