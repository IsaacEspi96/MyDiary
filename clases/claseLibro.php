<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiLibro.php';

class Libro{
    public $idLibro;
    public $idApi;
    public $nombreLibro;
    public $autorLibro;
    public $anoLibro;
    public $generoLibro;
    public $temaLibro;
    public $paginasLibro;
    public $edicionesLibro;
    public $idiomaLibro;
    public $ratingAvgLibro;
    public $posterLibro;
    public $sinopsisLibro;

    function __construct($idLibro=null, $idApi=null, $nombreLibro=null, $autorLibro=null, $anoLibro=null, $generoLibro=null, $temaLibro=null, $paginasLibro=null, $edicionesLibro=null, $idiomaLibro=null, $ratingAvgLibro=null, $posterLibro=null, $sinopsisLibro=null){
        $this->idLibro = $idLibro;
        $this->idApi = $idApi;
        $this->nombreLibro = $nombreLibro;
        $this->autorLibro = $autorLibro;
        $this->anoLibro = $anoLibro;
        $this->generoLibro = $generoLibro;
        $this->temaLibro = $temaLibro;
        $this->paginasLibro = $paginasLibro;
        $this->edicionesLibro = $edicionesLibro;
        $this->idiomaLibro = $idiomaLibro;
        $this->ratingAvgLibro = $ratingAvgLibro;
        $this->posterLibro = $posterLibro;
        $this->sinopsisLibro = $sinopsisLibro;
    } // Fin __construct

    public function existe(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT idLibro FROM libros WHERE idApi=:idApi");

                $consulta->bindParam(':idApi', $this->idApi);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if($resultado){
                    return $resultado['idLibro'];
                }else{
                    return false;
                }

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al comprobar si existe el libro en la Base de Datos.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin existe()

    public function agregar(){

        // Miramos si existe
        $idLibro = $this->existe($this->idApi);

        // Si no existe la creamos, y devolvemos el último idLibro insertado
        // Si existe devolvemos el idLibro correspondiente
        if(!$idLibro){

            $conexion = conexionBD();

            if(is_array($conexion)){
                return $conexion;
            }else{
                try{

                    $consulta=$conexion->prepare("INSERT INTO libros (idApi, nombreLibro, autorLibro, anoLibro, generoLibro, temaLibro, paginasLibro, edicionesLibro, idiomaLibro, ratingAvgLibro, posterLibro, sinopsisLibro) VALUES (:idApi,:nombre,:autor,:ano,:genero,:tema,:paginas,:ediciones,:idioma,:ratingAvg,:poster,:sinopsis)");

                    $consulta->bindParam(':idApi',$this->idApi);
                    $consulta->bindParam(':nombre',$this->nombreLibro);
                    $consulta->bindParam(':autor',$this->autorLibro);
                    $consulta->bindParam(':ano',$this->anoLibro);
                    $consulta->bindParam(':genero',$this->generoLibro);
                    $consulta->bindParam(':tema',$this->temaLibro);
                    $consulta->bindParam(':paginas',$this->paginasLibro);
                    $consulta->bindParam(':ediciones',$this->edicionesLibro);
                    $consulta->bindParam(':idioma',$this->idiomaLibro);
                    $consulta->bindParam(':ratingAvg',$this->ratingAvgLibro);
                    $consulta->bindParam(':poster',$this->posterLibro);
                    $consulta->bindParam(':sinopsis',$this->sinopsisLibro);

                    $consulta->execute();

                    return $conexion->lastInsertId();

                }catch(PDOException $error){
                    $respuesta = [
                                'error' => 'Ocurrió un error al agregar el libro a la tabla libros.',
                                'error_tecnico' => $error
                                ];
                    
                    $conexion = null;
                    return $respuesta;
                }
            } // Fin else
        }else{
            return $idLibro;
        }

    } // Fin agregar()

    public function comprobar(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM libros WHERE idLibro= :idLibro");

                $consulta->bindParam(':idLibro', $this->idLibro);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al recoger los datos del libro seleccionado.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin comprobar()

    public function actualizarPoster(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }

        try{

            $consulta = $conexion->prepare(
                "UPDATE libros
                SET posterLibro = :poster
                WHERE idLibro = :idLibro"
            );

            $consulta->bindParam(
                ':poster',
                $this->posterLibro
            );

            $consulta->bindParam(
                ':idLibro',
                $this->idLibro
            );

            $consulta->execute();

            return $this->posterLibro;

        }catch(PDOException $error){

            $respuesta = [
                'error' => 'La portada se descargó, pero no se pudo actualizar la Base de Datos.',
                'error_tecnico' => $error
            ];

            $conexion = null;
            return $respuesta;
        }
    } // Fin actualizarPoster()

} // Fin clase Libro


?>