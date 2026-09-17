<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/conexionBD.php';

class Historial{
    public $idHistorial;
    public $idUsuario;
    public $idUsuarioPelicula;
    public $idUsuarioSerie;
    public $idUsuarioTemporada;
    public $idUsuarioEpisodio;
    public $idUsuarioJuego;
    public $idUsuarioLibro;
    public $nombreHistorial;
    public $accionHistorial;
    public $fechaHistorial;

    function __construct($idHistorial=null, $idUsuario=null, $idUsuarioPelicula=null, $idUsuarioSerie=null, $idUsuarioTemporada=null, $idUsuarioEpisodio=null, $idUsuarioJuego=null, $idUsuarioLibro=null, $nombreHistorial=null, $accionHistorial=null, $fechaHistorial=null){
        $this->idHistorial = $idHistorial;
        $this->idUsuario = $idUsuario;
        $this->idUsuarioPelicula = $idUsuarioPelicula;
        $this->idUsuarioSerie = $idUsuarioSerie;
        $this->idUsuarioTemporada = $idUsuarioTemporada;
        $this->idUsuarioEpisodio = $idUsuarioEpisodio;
        $this->idUsuarioJuego = $idUsuarioJuego;
        $this->idUsuarioLibro = $idUsuarioLibro;
        $this->nombreHistorial = $nombreHistorial;
        $this->accionHistorial = $accionHistorial;
        $this->fechaHistorial = $fechaHistorial;
    } // Fin __construct

    public function agregarPelicula(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO historial (idUsuario, idUsuarioPelicula, nombreHistorial, accionHistorial) VALUES (:idUsuario, :idUsuarioPelicula, :nombre, :accion)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idUsuarioPelicula',$this->idUsuarioPelicula);
                $consulta->bindParam(':nombre',$this->nombreHistorial);
                $consulta->bindParam(':accion',$this->accionHistorial);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar la acción al historial de películas.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarPelicula()

    public function listarPelicula(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM historial WHERE idUsuario = :idUsuario AND idUsuarioPelicula IS NOT NULL ORDER BY fechaHistorial DESC LIMIT 50");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de historial de películas.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarPelicula()

    public function agregarSerie(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO historial (idUsuario, idUsuarioSerie, nombreHistorial, accionHistorial) VALUES (:idUsuario, :idUsuarioSerie, :nombre, :accion)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idUsuarioSerie',$this->idUsuarioSerie);
                $consulta->bindParam(':nombre',$this->nombreHistorial);
                $consulta->bindParam(':accion',$this->accionHistorial);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar la acción al historial de series.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarSerie()

    public function agregarTemporada(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO historial (idUsuario, idUsuarioTemporada, nombreHistorial, accionHistorial) VALUES (:idUsuario, :idUsuarioTemporada, :nombre, :accion)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idUsuarioTemporada',$this->idUsuarioTemporada);
                $consulta->bindParam(':nombre',$this->nombreHistorial);
                $consulta->bindParam(':accion',$this->accionHistorial);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar la acción al historial de series.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarTemporada()

    public function agregarEpisodio(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO historial (idUsuario, idUsuarioEpisodio, nombreHistorial, accionHistorial) VALUES (:idUsuario, :idUsuarioEpisodio, :nombre, :accion)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idUsuarioEpisodio',$this->idUsuarioEpisodio);
                $consulta->bindParam(':nombre',$this->nombreHistorial);
                $consulta->bindParam(':accion',$this->accionHistorial);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar la acción al historial de series.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarEpisodio()

    public function listarSerie(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM historial WHERE idUsuario = :idUsuario AND (idUsuarioSerie IS NOT NULL OR idUsuarioTemporada IS NOT NULL OR idUsuarioEpisodio IS NOT NULL) ORDER BY fechaHistorial DESC LIMIT 50");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de historial para series.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarSerie()

    public function agregarJuego(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO historial (idUsuario, idUsuarioJuego, nombreHistorial, accionHistorial) VALUES (:idUsuario, :idUsuarioJuego, :nombre, :accion)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idUsuarioJuego',$this->idUsuarioJuego);
                $consulta->bindParam(':nombre',$this->nombreHistorial);
                $consulta->bindParam(':accion',$this->accionHistorial);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar la acción al historial de videojuegos.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarJuego()

    public function listarJuego(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM historial WHERE idUsuario = :idUsuario AND idUsuarioJuego IS NOT NULL ORDER BY fechaHistorial DESC LIMIT 50");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de historial para videojuegos.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarJuego()

    public function agregarLibro(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO historial (idUsuario, idUsuarioLibro, nombreHistorial, accionHistorial) VALUES (:idUsuario, :idUsuarioLibro, :nombre, :accion)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idUsuarioLibro',$this->idUsuarioLibro);
                $consulta->bindParam(':nombre',$this->nombreHistorial);
                $consulta->bindParam(':accion',$this->accionHistorial);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar la acción al historial de libros.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarLibro()

    public function listarLibro(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM historial WHERE idUsuario = :idUsuario AND idUsuarioLibro IS NOT NULL ORDER BY fechaHistorial DESC LIMIT 50");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de historial para libros.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarLibro()

} // Fin clase Historial
?>