<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiSerie.php';

class Temporada{
    public $idTemporada;
    public $idApi;
    public $idSerie;
    public $nombreTemporada;
    public $numeroTemporada;
    public $directorTemporada;
    public $guionistaTemporada;
    public $actorTemporada;
    public $episodiosTemporada;
    public $anoTemporada;
    public $ratingAvgTemporada;
    public $posterTemporada;
    public $sinopsisTemporada;

    function __construct($idTemporada=null, $idApi=null, $idSerie=null, $nombreTemporada=null, $numeroTemporada=null, $directorTemporada=null, $guionistaTemporada=null, $actorTemporada=null, $episodiosTemporada=null, $anoTemporada=null, $ratingAvgTemporada=null, $posterTemporada=null, $sinopsisTemporada=null, ){
        $this->idTemporada = $idTemporada;
        $this->idApi = $idApi;
        $this->idSerie = $idSerie;
        $this->nombreTemporada = $nombreTemporada;
        $this->numeroTemporada = $numeroTemporada;
        $this->directorTemporada = $directorTemporada;
        $this->guionistaTemporada = $guionistaTemporada;
        $this->actorTemporada = $actorTemporada;
        $this->episodiosTemporada = $episodiosTemporada;
        $this->anoTemporada = $anoTemporada;
        $this->ratingAvgTemporada = $ratingAvgTemporada;
        $this->posterTemporada = $posterTemporada;
        $this->sinopsisTemporada = $sinopsisTemporada;
    } // Fin __construct

    public function existe(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT idTemporada FROM seriestemporadas WHERE idApi=:idApi");

                $consulta->bindParam(':idApi', $this->idApi);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if($resultado){
                    return $resultado['idTemporada'];
                }else{
                    return false;
                }

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al comprobar si existe la temporada en la Base de Datos.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin existe()

    public function agregar(){

        // Miramos si existe
        $idTemporada = $this->existe($this->idApi);

        // Si no existe la creamos, y devolvemos el último idTemporada insertado
        // Si existe devolvemos el idTemporada correspondiente
        if(!$idTemporada){

            $conexion = conexionBD();

            if(is_array($conexion)){
                return $conexion;
            }else{
                try{

                    $consulta=$conexion->prepare("INSERT INTO seriestemporadas (idApi, idSerie, nombreTemporada, numeroTemporada, directorTemporada, guionistaTemporada, actorTemporada, episodiosTemporada, anoTemporada, ratingAvgTemporada, posterTemporada, sinopsisTemporada) VALUES (:idApi,:idSerie,:nombre,:numero,:director,:guionista,:actor,:episodios,:ano,:ratingAvg,:poster,:sinopsis)");

                    $consulta->bindParam(':idApi',$this->idApi);
                    $consulta->bindParam(':idSerie',$this->idSerie);
                    $consulta->bindParam(':nombre',$this->nombreTemporada);
                    $consulta->bindParam(':numero',$this->numeroTemporada);
                    $consulta->bindParam(':director',$this->directorTemporada);
                    $consulta->bindParam(':guionista',$this->guionistaTemporada);
                    $consulta->bindParam(':actor',$this->actorTemporada);
                    $consulta->bindParam(':episodios',$this->episodiosTemporada);
                    $consulta->bindParam(':ano',$this->anoTemporada);
                    $consulta->bindParam(':ratingAvg',$this->ratingAvgTemporada);
                    $consulta->bindParam(':poster',$this->posterTemporada);
                    $consulta->bindParam(':sinopsis',$this->sinopsisTemporada);


                    $consulta->execute();

                    return $conexion->lastInsertId();

                }catch(PDOException $error){
                    $respuesta = [
                                'error' => 'Ocurrió un error al agregar la temporada.',
                                'error_tecnico' => $error
                                ];
                    
                    $conexion = null;
                    return $respuesta;
                }
            } // Fin else
        }else{
            return $idTemporada;
        }

    } // Fin agregar()

    public function comprobar(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM seriestemporadas WHERE idTemporada= :idTemporada");

                $consulta->bindParam(':idTemporada', $this->idTemporada);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al recoger los datos de la temporada seleccionada.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin comprobar()

} // Fin clase Temporada

?>