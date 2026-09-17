<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiJuego.php';

class UsuarioxJuego{
    public $idUsuarioJuego;
    public $idUsuario;
    public $idJuego;
    public $ratingJuego;
    public $favJuego;
    public $pendienteJuego;
    public $fechaInicioJuego;
    public $fechaJuego;
    public $plataformaJuego;
    public $notasJuego;

    function __construct($idUsuarioJuego=null, $idUsuario=null, $idJuego=null, $ratingJuego=null, $favJuego=null, $pendienteJuego=null, $fechaInicioJuego=null, $fechaJuego=null, $plataformaJuego=null, $notasJuego=null){
        $this->idUsuarioJuego = $idUsuarioJuego;
        $this->idUsuario = $idUsuario;
        $this->idJuego = $idJuego;
        $this->ratingJuego = $ratingJuego;
        $this->favJuego = $favJuego;
        $this->pendienteJuego = $pendienteJuego;
        $this->fechaInicioJuego = $fechaInicioJuego;
        $this->fechaJuego = $fechaJuego;
        $this->plataformaJuego = $plataformaJuego;
        $this->notasJuego = $notasJuego;
    } // Fin __construct

    public function agregar(){

        $conexion=conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta=$conexion->prepare("INSERT INTO usuariosxjuegos (idUsuario, idJuego, ratingJuego, favJuego, pendienteJuego, fechaJuego, notasJuego, fechaInicioJuego, plataformaJuego) VALUES (:idUsuario,:idJuego, :rating, :fav, :pend, :fecha, :notas, :fechaInicio, :plat)");

                $consulta->bindParam(':idUsuario',$this->idUsuario);
                $consulta->bindParam(':idJuego',$this->idJuego);
                $consulta->bindParam(':rating',$this->ratingJuego);
                $consulta->bindParam(':fav',$this->favJuego);
                $pend=0;
                $consulta->bindParam(':pend',$pend);
                $consulta->bindParam(':fecha',$this->fechaJuego);
                $consulta->bindParam(':notas',$this->notasJuego);
                $consulta->bindParam(':fechaInicio',$this->fechaInicioJuego);
                $consulta->bindParam(':plat',$this->plataformaJuego);

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
    } // Fin agregar()

    public function existe(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT idUsuarioJuego FROM usuariosxjuegos WHERE idJuego=:idJuego AND idUsuario=:idUsuario");

                $consulta->bindParam(':idJuego', $this->idJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if($resultado){
                    $respuesta = [
                        'error' => 'Ya has registrado este videojuego',
                        'error_tecnico' => $this->idJuego
                    ];
                    $conexion = null;
                    return $respuesta;
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

    public function listarTodo(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("SELECT p.idJuego, p.idApi, p.nombreJuego, p.desarrolladorJuego, p.editorJuego, p.anoJuego, p.franquiciaJuego, p.generoJuego, p.plataformasJuego, p.dlcJuego, p.expansionJuego, p.duracionJuego, p.ratingAvgJuego, p.posterJuego, p.sinopsisJuego, up.idUsuarioJuego, up.idUsuario, up.idJuego, up.fechaJuego, up.ratingJuego, up.favJuego, up.pendienteJuego, up.notasJuego, up.plataformaJuego, up.fechaInicioJuego FROM usuariosxjuegos up INNER JOIN juegos p ON up.idJuego = p.idJuego WHERE up.idUsuario = :idUsuario AND up.pendienteJuego = :pend ORDER BY up.fechaJuego DESC, up.idUsuarioJuego DESC");

                $pend=0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de videojuegos.',
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
                $consulta = $conexion->prepare("SELECT p.idJuego, p.idApi, p.nombreJuego, p.desarrolladorJuego, p.editorJuego, p.anoJuego, p.franquiciaJuego, p.generoJuego, p.plataformasJuego, p.dlcJuego, p.expansionJuego, p.duracionJuego, p.ratingAvgJuego, p.posterJuego, p.sinopsisJuego, up.idUsuarioJuego, up.idUsuario, up.idJuego, up.fechaJuego, up.ratingJuego, up.favJuego, up.pendienteJuego, up.notasJuego, up.plataformaJuego, up.fechaInicioJuego FROM usuariosxjuegos up INNER JOIN juegos p ON up.idJuego = p.idJuego WHERE up.ratingJuego = :rating AND up.idUsuario = :idUsuario AND up.pendienteJuego = :pend ORDER BY up.fechaJuego DESC, up.idUsuarioJuego DESC");

                $pend=0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':rating', $this->ratingJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de videojuegos con valoracion '.$this->ratingJuego,
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
                $consulta = $conexion->prepare("SELECT p.idJuego, p.idApi, p.nombreJuego, p.desarrolladorJuego, p.editorJuego, p.anoJuego, p.franquiciaJuego, p.generoJuego, p.plataformasJuego, p.dlcJuego, p.expansionJuego, p.duracionJuego, p.ratingAvgJuego, p.posterJuego, p.sinopsisJuego, up.idUsuarioJuego, up.idUsuario, up.idJuego, up.fechaJuego, up.ratingJuego, up.favJuego, up.pendienteJuego, up.notasJuego, up.plataformaJuego, up.fechaInicioJuego FROM usuariosxjuegos up INNER JOIN juegos p ON up.idJuego = p.idJuego WHERE up.favJuego = :fav AND up.idUsuario = :idUsuario AND up.pendienteJuego = :pend ORDER BY up.fechaJuego DESC, up.idUsuarioJuego DESC");

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
                            'error' => 'Ocurrió un error al obtener el listado de videojuegos favoritos.',
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
                $consulta = $conexion->prepare("SELECT p.idJuego, p.idApi, p.nombreJuego, p.desarrolladorJuego, p.editorJuego, p.anoJuego, p.franquiciaJuego, p.generoJuego, p.plataformasJuego, p.dlcJuego, p.expansionJuego, p.duracionJuego, p.ratingAvgJuego, p.posterJuego, p.sinopsisJuego, up.idUsuarioJuego, up.idUsuario, up.idJuego, up.fechaJuego, up.ratingJuego, up.favJuego, up.pendienteJuego, up.notasJuego, up.plataformaJuego, up.fechaInicioJuego FROM usuariosxjuegos up INNER JOIN juegos p ON up.idJuego = p.idJuego WHERE up.pendienteJuego = :pend AND up.idUsuario = :idUsuario");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de videojuegos pendientes.',
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
                $consulta = $conexion->prepare("INSERT INTO usuariosxjuegos (idUsuario, idJuego, pendienteJuego) VALUES (:idUsuario, :idJuego, :pend)");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idJuego', $this->idJuego);

                $consulta->execute();
                return $conexion->lastInsertId();
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar el videojuego como pendiente.',
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

                    $consulta = $conexion->prepare("SELECT p.idJuego, p.idApi, p.nombreJuego, p.desarrolladorJuego, p.editorJuego, p.anoJuego, p.franquiciaJuego, p.generoJuego, p.plataformasJuego, p.dlcJuego, p.expansionJuego, p.duracionJuego, p.ratingAvgJuego, p.posterJuego, p.sinopsisJuego, up.idUsuarioJuego, up.idUsuario, up.idJuego, up.fechaJuego, up.ratingJuego, up.favJuego, up.pendienteJuego, up.notasJuego, up.plataformaJuego, up.fechaInicioJuego FROM usuariosxjuegos up INNER JOIN juegos p ON up.idJuego = p.idJuego WHERE p.anoJuego=:ano AND up.idUsuario=:idUsuario ORDER BY up.ratingJuego DESC, up.fechaJuego DESC, up.idUsuarioJuego DESC");

                    $consulta->bindParam(':ano', $busqueda);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                    
                }else{
                    $busquedaParcial = "%" . $_POST['busqueda'] . "%";

                    $consulta = $conexion->prepare("SELECT p.idJuego, p.idApi, p.nombreJuego, p.desarrolladorJuego, p.editorJuego, p.anoJuego, p.franquiciaJuego, p.generoJuego, p.plataformasJuego, p.dlcJuego, p.expansionJuego, p.duracionJuego, p.ratingAvgJuego, p.posterJuego, p.sinopsisJuego, up.idUsuarioJuego, up.idUsuario, up.idJuego, up.fechaJuego, up.ratingJuego, up.favJuego, up.pendienteJuego, up.notasJuego, up.plataformaJuego, up.fechaInicioJuego FROM usuariosxjuegos up INNER JOIN juegos p ON up.idJuego = p.idJuego WHERE up.idUsuario=:idUsuario AND (p.nombreJuego LIKE :nombre OR p.desarrolladorJuego LIKE :desarrollador) ORDER BY up.ratingJuego DESC, up.fechaJuego DESC, up.idUsuarioJuego DESC");

                    $consulta->bindParam(':nombre', $busquedaParcial);
                    $consulta->bindParam(':desarrollador', $busquedaParcial);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                }

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al obtener el listado de videojuegos buscados.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxjuegos SET favJuego= :fav WHERE idUsuarioJuego = :idUsuarioJuego AND idUsuario=:idUsuario AND pendienteJuego=:pend");

                $consulta->bindParam(':idUsuarioJuego', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fav', $this->favJuego);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return [
                'exito' => true,
                'idUsuarioJuego' => $this->idUsuarioJuego,
                'favJuego' => $this->favJuego
            ];

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al cambiar el estado favorita del videojuego.',
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
                $consulta = $conexion->prepare("SELECT * FROM usuariosxjuegos WHERE idUsuarioJuego= :idUsuarioJuego AND idUsuario=:idUsuario");
                $consulta->bindParam(':idUsuarioJuego', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
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

    function editarVal(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxjuegos SET ratingJuego=:rating WHERE idUsuarioJuego=:id AND idUsuario=:idUsuario AND pendienteJuego=:pend");

                $consulta->bindParam(':rating', $this->ratingJuego);
                $consulta->bindParam(':id', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();
                
                $respuesta = [
                    'exito' => 'Se editó correctamente la valoración del videojuego.',
                    'exito_tecnico' => $this->ratingJuego
                ];
                return $respuesta;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al editar la valoración del videojuego.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxjuegos SET fechaJuego=:fecha, fechaInicioJuego=:fechaInicio WHERE idUsuarioJuego= :id AND idUsuario=:idUsuario AND pendienteJuego=:pend");

                $consulta->bindParam(':id', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaJuego);
                $consulta->bindParam(':fechaInicio', $this->fechaInicioJuego);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la fecha de visualización del videojuego.',
                    'exito_tecnico' => $this->fechaJuego
                ];
                return $respuesta;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al editar la fecha de visualización del videojuego.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarFecha()

    function editarPlataforma(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxjuegos SET plataformaJuego=:plat WHERE idUsuarioJuego=:id AND idUsuario=:idUsuario AND pendienteJuego=:pend");

                $consulta->bindParam(':plat', $this->plataformaJuego);
                $consulta->bindParam(':id', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();
                
                $respuesta = [
                    'exito' => 'Se editó correctamente la plataforma del videojuego.',
                    'exito_tecnico' => $this->plataformaJuego
                ];
                return $respuesta;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al editar la plataforma del videojuego.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarPlataforma()

    function editarNotas(){
        $conexion = conexionBD();

        if(is_array($conexion)){
            return $conexion;
        }else{
            try{
                $consulta = $conexion->prepare("UPDATE usuariosxjuegos SET notasJuego=:notas WHERE idUsuarioJuego= :id AND idUsuario=:idUsuario AND pendienteJuego=:pend");

                $consulta->bindParam(':id', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':notas', $this->notasJuego);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente las notas del videojuego.',
                    'exito_tecnico' => $this->fechaJuego
                ];
                return $respuesta;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al editar las notas del videojuego.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxjuegos SET pendienteJuego=:pend, fechaJuego=:fecha, fechaInicioJuego=:fechaInicio, ratingJuego=:rating, favJuego=:fav, notasJuego=:notas, plataformaJuego=:plat WHERE idUsuarioJuego= :id AND idUsuario=:idUsuario");

                $consulta->bindParam(':id', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaJuego);
                $consulta->bindParam(':fechaInicio', $this->fechaInicioJuego);
                $consulta->bindParam(':rating', $this->ratingJuego);
                $consulta->bindParam(':fav', $this->favJuego);
                $consulta->bindParam(':notas', $this->notasJuego);
                $consulta->bindParam(':plat', $this->plataformaJuego);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return $this->idUsuarioJuego;
            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al agregar el videojuego pendiente.',
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

                $consulta = $conexion->prepare("DELETE FROM usuariosxjuegos WHERE idUsuarioJuego=:id AND idUsuario=:idUsuario");
                $consulta->bindParam(':id', $this->idUsuarioJuego);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se eliminó correctamente el videojuego.',
                    'exito_tecnico' => $this->idUsuarioJuego,
                ];
                return $respuesta;

            }catch(PDOException $error){
                $respuesta = [
                            'error' => 'Ocurrió un error al eliminar el videojuego.',
                            'error_tecnico' => $error
                            ];
                
                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin eliminar()

} // Fin clase UsuarioxJuego

?>