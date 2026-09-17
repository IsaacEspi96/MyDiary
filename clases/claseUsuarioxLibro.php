<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiLibro.php';

class UsuarioxLibro{
    public $idUsuarioLibro;
    public $idUsuario;
    public $idLibro;
    public $ratingLibro;
    public $favLibro;
    public $pendienteLibro;
    public $fechaInicioLibro;
    public $fechaLibro;
    public $notasLibro;

    function __construct($idUsuarioLibro=null, $idUsuario=null, $idLibro=null, $ratingLibro=null, $favLibro=null, $pendienteLibro=null, $fechaInicioLibro=null, $fechaLibro=null, $notasLibro=null){
        $this->idUsuarioLibro = $idUsuarioLibro;
        $this->idUsuario = $idUsuario;
        $this->idLibro = $idLibro;
        $this->ratingLibro = $ratingLibro;
        $this->favLibro = $favLibro;
        $this->pendienteLibro = $pendienteLibro;
        $this->fechaInicioLibro = $fechaInicioLibro;
        $this->fechaLibro = $fechaLibro;
        $this->notasLibro = $notasLibro;
    } // Fin __construct

    public function agregar(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO usuariosxlibros (idUsuario, idLibro, ratingLibro, favLibro, pendienteLibro, fechaLibro, notasLibro, fechaInicioLibro) VALUES (:idUsuario, :idLibro, :rating, :fav, :pend, :fecha, :notas, :fechaInicio)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idLibro',$this->idLibro);
                $consulta->bindParam(':rating',$this->ratingLibro);
                $consulta->bindParam(':fav',$this->favLibro);
                $pend=0;
                $consulta->bindParam(':pend',$pend);
                $consulta->bindParam(':fecha',$this->fechaLibro);
                $consulta->bindParam(':notas',$this->notasLibro);
                $consulta->bindParam(':fechaInicio',$this->fechaInicioLibro);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar el libro.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregar()

    public function existe(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT idUsuarioLibro FROM usuariosxlibros WHERE idLibro=:idLibro AND idUsuario=:idUsuario");

                $consulta->bindParam(':idLibro', $this->idLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if($resultado){
                    $respuesta = [
                        'error' => 'Ya has registrado este libro',
                        'error_tecnico' => $this->idLibro
                    ];
                    $conexion = null;
                    return $respuesta;
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

    public function listarTodo(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT p.idLibro, p.idApi, p.nombreLibro, p.autorLibro, p.anoLibro, p.generoLibro, p.temaLibro, p.paginasLibro, p.edicionesLibro, p.idiomaLibro, p.ratingAvgLibro, p.posterLibro, p.sinopsisLibro, up.idUsuarioLibro, up.idUsuario, up.idLibro, up.fechaLibro, up.ratingLibro, up.favLibro, up.pendienteLibro, up.notasLibro, up.fechaInicioLibro FROM usuariosxlibros up INNER JOIN libros p ON up.idLibro = p.idLibro WHERE up.idUsuario = :idUsuario AND up.pendienteLibro = :pend ORDER BY up.fechaLibro DESC, up.idUsuarioLibro DESC");

                $pend=0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de libros.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarTodo()

    public function listarEstrellas(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT p.idLibro, p.idApi, p.nombreLibro, p.autorLibro, p.anoLibro, p.generoLibro, p.temaLibro, p.paginasLibro, p.edicionesLibro, p.idiomaLibro, p.ratingAvgLibro, p.posterLibro, p.sinopsisLibro, up.idUsuarioLibro, up.idUsuario, up.idLibro, up.fechaLibro, up.ratingLibro, up.favLibro, up.pendienteLibro, up.notasLibro, up.fechaInicioLibro FROM usuariosxlibros up INNER JOIN libros p ON up.idLibro = p.idLibro WHERE up.ratingLibro = :rating AND up.idUsuario = :idUsuario AND up.pendienteLibro = :pend ORDER BY up.fechaLibro DESC, up.idUsuarioLibro DESC");

                $pend=0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':rating', $this->ratingLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de libros con valoracion '.$this->ratingLibro,
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarEstrellas()

    public function listarFav(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT p.idLibro, p.idApi, p.nombreLibro, p.autorLibro, p.anoLibro, p.generoLibro, p.temaLibro, p.paginasLibro, p.edicionesLibro, p.idiomaLibro, p.ratingAvgLibro, p.posterLibro, p.sinopsisLibro, up.idUsuarioLibro, up.idUsuario, up.idLibro, up.fechaLibro, up.ratingLibro, up.favLibro, up.pendienteLibro, up.notasLibro, up.fechaInicioLibro FROM usuariosxlibros up INNER JOIN libros p ON up.idLibro = p.idLibro WHERE up.favLibro = :fav AND up.idUsuario = :idUsuario AND up.pendienteLibro = :pend ORDER BY up.fechaLibro DESC, up.idUsuarioLibro DESC");

                $fav = 1;
                $consulta->bindParam(':fav', $fav);
                $pend=0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();
                
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de libros favoritos.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarFav()

    public function listarPendientes(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT p.idLibro, p.idApi, p.nombreLibro, p.autorLibro, p.anoLibro, p.generoLibro, p.temaLibro, p.paginasLibro, p.edicionesLibro, p.idiomaLibro, p.ratingAvgLibro, p.posterLibro, p.sinopsisLibro, up.idUsuarioLibro, up.idUsuario, up.idLibro, up.fechaLibro, up.ratingLibro, up.favLibro, up.pendienteLibro, up.notasLibro, up.fechaInicioLibro FROM usuariosxlibros up INNER JOIN libros p ON up.idLibro = p.idLibro WHERE up.pendienteLibro = :pend AND up.idUsuario = :idUsuario");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de libros pendientes.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarPendientes()

    public function agregarPend(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("INSERT INTO usuariosxlibros (idUsuario, idLibro, pendienteLibro) VALUES (:idUsuario, :idLibro, :pend)");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idLibro', $this->idLibro);

                $consulta->execute();
                return $conexion->lastInsertId();
                
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar el libro como pendiente.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarPend()

    public function buscar(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $busqueda = $_POST['busqueda'];

                if(is_numeric($busqueda)){

                    $consulta = $conexion->prepare("SELECT p.idLibro, p.idApi, p.nombreLibro, p.autorLibro, p.anoLibro, p.generoLibro, p.temaLibro, p.paginasLibro, p.edicionesLibro, p.idiomaLibro, p.ratingAvgLibro, p.posterLibro, p.sinopsisLibro, up.idUsuarioLibro, up.idUsuario, up.idLibro, up.fechaLibro, up.ratingLibro, up.favLibro, up.pendienteLibro, up.notasLibro, up.fechaInicioLibro FROM usuariosxlibros up INNER JOIN libros p ON up.idLibro = p.idLibro WHERE p.anoLibro=:ano AND up.idUsuario=:idUsuario ORDER BY up.ratingLibro DESC, up.fechaLibro DESC, up.idUsuarioLibro DESC");

                    $consulta->bindParam(':ano', $busqueda);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                    
                }else{
                    $busquedaParcial = "%" . $_POST['busqueda'] . "%";

                    $consulta = $conexion->prepare("SELECT p.idLibro, p.idApi, p.nombreLibro, p.autorLibro, p.anoLibro, p.generoLibro, p.temaLibro, p.paginasLibro, p.edicionesLibro, p.idiomaLibro, p.ratingAvgLibro, p.posterLibro, p.sinopsisLibro, up.idUsuarioLibro, up.idUsuario, up.idLibro, up.fechaLibro, up.ratingLibro, up.favLibro, up.pendienteLibro, up.notasLibro, up.fechaInicioLibro FROM usuariosxlibros up INNER JOIN libros p ON up.idLibro = p.idLibro WHERE idUsuario=:idUsuario AND (p.nombreLibro LIKE :nombre OR p.autorLibro LIKE :autor) ORDER BY up.ratingLibro DESC, up.fechaLibro DESC, up.idUsuarioLibro DESC");

                    $consulta->bindParam(':nombre', $busquedaParcial);
                    $consulta->bindParam(':autor', $busquedaParcial);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                }

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de libros buscados.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin buscar()

    public function favorita(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxlibros SET favLibro= :fav WHERE idUsuarioLibro = :idUsuarioLibro AND idUsuario=:idUsuario AND pendienteLibro=:pend");

                $consulta->bindParam(':idUsuarioLibro', $this->idUsuarioLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fav', $this->favLibro);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return [
                'exito' => true,
                'idUsuarioLibro' => $this->idUsuarioLibro,
                'favLibro' => $this->favLibro
            ];

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al cambiar el estado favorita del libro.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin favorita()

    public function comprobar(){

        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT * FROM usuariosxlibros WHERE idUsuarioLibro= :idUsuarioLibro AND idUsuario=:idUsuario");
                $consulta->bindParam(':idUsuarioLibro', $this->idUsuarioLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
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

    function editarVal(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxlibros SET ratingLibro=:rating WHERE idUsuarioLibro=:id AND idUsuario=:idUsuario AND pendienteLibro=:pend");

                $consulta->bindParam(':rating', $this->ratingLibro);
                $consulta->bindParam(':id', $this->idUsuarioLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();
                
                $respuesta = [
                    'exito' => 'Se editó correctamente la valoración del vlibro.',
                    'exito_tecnico' => $this->ratingLibro
                ];
                return $respuesta;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al editar la valoración del libro.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarVal()

    function editarFecha(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxlibros SET fechaLibro=:fecha, fechaInicioLibro=:fechaInicio WHERE idUsuarioLibro= :id AND idUsuario=:idUsuario AND pendienteLibro=:pend");

                $consulta->bindParam(':id', $this->idUsuarioLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaLibro);
                $consulta->bindParam(':fechaInicio', $this->fechaInicioLibro);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la fecha de visualización del libro.',
                    'exito_tecnico' => $this->fechaLibro
                ];
                return $respuesta;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al editar la fecha de visualización del libro.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarFecha()

    function editarNotas(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxlibros SET notasLibro=:notas WHERE idUsuarioLibro= :id AND idUsuario=:idUsuario AND pendienteLibro=:pend");

                $consulta->bindParam(':id', $this->idUsuarioLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':notas', $this->notasLibro);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente las notas del libro.',
                    'exito_tecnico' => $this->fechaLibro
                ];
                return $respuesta;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al editar las notas del libro.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarNotas()

    function agregarPendTabla(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxlibros SET pendienteLibro=:pend, fechaLibro=:fecha, fechaInicioLibro=:fechaInicio, ratingLibro=:rating, favLibro=:fav, notasLibro=:notas WHERE idUsuarioLibro= :id AND idUsuario=:idUsuario");

                $consulta->bindParam(':id', $this->idUsuarioLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaLibro);
                $consulta->bindParam(':fechaInicio', $this->fechaInicioLibro);
                $consulta->bindParam(':rating', $this->ratingLibro);
                $consulta->bindParam(':fav', $this->favLibro);
                $consulta->bindParam(':notas', $this->notasLibro);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return $this->idUsuarioLibro;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar el libro pendiente.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarPendTabla

    function eliminar(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{

                $consulta = $conexion->prepare("DELETE FROM usuariosxlibros WHERE idUsuarioLibro=:id AND idUsuario=:idUsuario");
                $consulta->bindParam(':id', $this->idUsuarioLibro);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se eliminó correctamente el libro.',
                    'exito_tecnico' => $this->idUsuarioLibro,
                ];
                return $respuesta;

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al eliminar el libro.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin eliminar()

} // Fin clase UsuarioxLibro

?>