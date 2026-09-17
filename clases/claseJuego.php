<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiJuego.php';

class Juego{
    public $idJuego;
    public $idApi;
    public $nombreJuego;
    public $desarrolladorJuego;
    public $editorJuego;
    public $anoJuego;
    public $franquiciaJuego;
    public $generoJuego;
    public $plataformasJuego;
    public $dlcJuego;
    public $expansionJuego;
    public $duracionJuego;
    public $ratingAvgJuego;
    public $posterJuego;
    public $sinopsisJuego;

    function __construct($idJuego=null, $idApi=null, $nombreJuego=null, $desarrolladorJuego=null, $editorJuego=null, $anoJuego=null, $franquiciaJuego=null, $generoJuego=null, $plataformasJuego=null, $dlcJuego=null, $expansionJuego=null, $duracionJuego=null, $ratingAvgJuego=null, $sinopsisJuego=null, $posterJuego=null){
        $this->idJuego = $idJuego;
        $this->idApi = $idApi;
        $this->nombreJuego = $nombreJuego;
        $this->desarrolladorJuego = $desarrolladorJuego;
        $this->editorJuego = $editorJuego;
        $this->anoJuego = $anoJuego;
        $this->franquiciaJuego = $franquiciaJuego;
        $this->generoJuego = $generoJuego;
        $this->plataformasJuego = $plataformasJuego;
        $this->dlcJuego = $dlcJuego;
        $this->expansionJuego = $expansionJuego;
        $this->duracionJuego = $duracionJuego;
        $this->ratingAvgJuego = $ratingAvgJuego;
        $this->posterJuego = $posterJuego;
        $this->sinopsisJuego = $sinopsisJuego;
    } // Fin __construct

    public function existe(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT idJuego FROM juegos WHERE idApi=:idApi");

                $consulta->bindParam(':idApi', $this->idApi);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if($resultado){
                    return $resultado['idJuego'];
                }else{
                    return false;
                }

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al comprobar si existe el videojuego en la Base de Datos.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin existe()

    public function agregar(){

        // Miramos si existe
        $idJuego = $this->existe($this->idApi);

        // Si no existe la creamos, y devolvemos el último idJuego insertado
        // Si existe devolvemos el idJuego correspondiente
        if(!$idJuego){

            $conexion = conexionBD();

            if(is_array($conexion)){
                return $conexion;
            }else{
                try{

                    $consulta=$conexion->prepare("INSERT INTO juegos (idApi, nombreJuego, desarrolladorJuego, editorJuego, anoJuego, franquiciaJuego, generoJuego, plataformasJuego, dlcJuego, expansionJuego, duracionJuego, ratingAvgJuego, posterJuego, sinopsisJuego) VALUES (:idApi,:nombre,:desarrollador,:editor,:ano,:franquicia,:genero,:plat,:dlc,:expansion,:duracion,:ratingAvg,:poster,:sinopsis)");

                    $consulta->bindParam(':idApi',$this->idApi);
                    $consulta->bindParam(':nombre',$this->nombreJuego);
                    $consulta->bindParam(':desarrollador',$this->desarrolladorJuego);
                    $consulta->bindParam(':editor',$this->editorJuego);
                    $consulta->bindParam(':ano',$this->anoJuego);
                    $consulta->bindParam(':franquicia',$this->franquiciaJuego);
                    $consulta->bindParam(':genero',$this->generoJuego);
                    $consulta->bindParam(':plat',$this->plataformasJuego);
                    $consulta->bindParam(':dlc',$this->dlcJuego);
                    $consulta->bindParam(':expansion',$this->expansionJuego);
                    $consulta->bindParam(':duracion',$this->duracionJuego);
                    $consulta->bindParam(':ratingAvg',$this->ratingAvgJuego);
                    $consulta->bindParam(':poster',$this->posterJuego);
                    $consulta->bindParam(':sinopsis',$this->sinopsisJuego);

                    $consulta->execute();

                    return $conexion->lastInsertId();

                }catch(PDOException $error){
                    $respuesta = [
                                'error' => 'Ocurrió un error al agregar el videojuego.',
                                'error_tecnico' => $error
                                ];
                    
                    $conexion = null;
                    return $respuesta;
                }
            } // Fin else
        }else{
            return $idJuego;
        }

    } // Fin agregar()

    public function comprobar(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM juegos WHERE idJuego= :idJuego");

                $consulta->bindParam(':idJuego', $this->idJuego);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al recoger los datos del videojuego seleccionado.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin comprobar()

} // Fin clase Juego


?>