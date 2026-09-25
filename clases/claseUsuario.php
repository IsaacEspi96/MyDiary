<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';

class Usuario
{
    public $idUsuario;
    public $username;
    public $nombreUsuario;
    public $email;
    public $contrasena;
    public $avatar;
    public $fechaRegistro;
    public $identificador;

    function __construct($idUsuario = null, $username = null, $nombreUsuario = null, $email = null, $contrasena = null, $avatar = null, $fechaRegistro = null)
    {
        $this->idUsuario = $idUsuario;
        $this->username = $username;
        $this->nombreUsuario = $nombreUsuario;
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->avatar = $avatar;
        $this->fechaRegistro = $fechaRegistro;
    } // Fin __construct()

    public function insertar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                // Comprobamos que el username esté libre
                $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE username= :username");
                $consulta->bindParam(':username', $this->username);
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                if (count($resultado) > 0) {
                    $respuesta = [
                        'error' => 'Este nombre de usuario ya existe.',
                        'caso' => 'username'
                    ];
                    return $respuesta;
                }

                // Comprobamos que el email esté libre
                $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE email= :email");
                $consulta->bindParam(':email', $this->email);
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                if (count($resultado) > 0) {
                    $respuesta = [
                        'error' => 'Ya existe un usuario con este correo.',
                        'caso' => 'email'
                    ];
                    return $respuesta;
                }

                $consulta = $conexion->prepare("INSERT INTO usuarios (idUsuario, username, nombreUsuario, email, contrasena, avatar, fechaRegistro) VALUES (:idUsuario, :username, :nombreUsuario, :email, :contrasena, :avatar, :fechaRegistro)");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':username', $this->username);
                $consulta->bindParam(':nombreUsuario', $this->nombreUsuario);
                $consulta->bindParam(':email', $this->email);
                $consulta->bindParam(':avatar', $this->avatar);

                $fechaRegistro = date('Y/m/d');
                $consulta->bindParam(':fechaRegistro', $fechaRegistro);

                // Ciframos la contraseña
                $pass = password_hash($this->contrasena, PASSWORD_DEFAULT);
                $consulta->bindParam(':contrasena', $pass);

                $consulta->execute();

                // Inciamos la sesión al registrarse
                $this->idUsuario = $conexion->lastInsertId();

                $_SESSION['idUsuario'] = $this->idUsuario;
                $_SESSION['username'] = $this->username;

                $respuesta = [
                    'exito' => 'El usuario se registró correctamente.',
                    'id' => $conexion->lastInsertId()
                ];

                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al crear al usuario.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin insertar()

    public function validar()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {

                $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE username= :identificador OR email= :identificador");
                $consulta->bindParam(':identificador', $this->identificador);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                // Si el usuario no existe
                if (count($resultado) == 0) {
                    $respuesta = ['error' => 'Usuario o contrasena incorrectos.'];
                    return $respuesta;
                }

                $pass = $resultado[0]['contrasena'];

                if (password_verify($this->contrasena, $pass)) {
                    // La pass es correcta, el usuario está validado

                    // Actualizamos variables y también el objeto actual, para que se sepa qué usuario tiene sesión iniciado en cualquier página del proyecto
                    $_SESSION['idUsuario'] = $resultado[0]['idUsuario'];
                    $_SESSION['username'] = $resultado[0]['username'];
                    $_SESSION['nombreUsuario'] = $resultado[0]['nombreUsuario'];
                    $_SESSION['avatar'] = $resultado[0]['avatar'];

                    $this->idUsuario = $resultado[0]['idUsuario'];
                    $this->username = $resultado[0]['username'];
                    $this->nombreUsuario = $resultado[0]['nombreUsuario'];
                    $this->email = $resultado[0]['email'];
                    $this->avatar = $resultado[0]['avatar'];
                    $this->fechaRegistro = $resultado[0]['fechaRegistro'];

                    // Almacenamos datos que usaremos en la respuesta
                    $respuesta = [
                        'exito' => 'Usuario validado.',
                        'nombreUsuario' => $resultado[0]['nombreUsuario']
                    ];
                    return $respuesta;
                } else {
                    // pass incorrecta
                    // Eliminamos los datos por si hubiera alguna sesión iniciado si alguien ha introducido mal la contraseña
                    unset($_SESSION['idUsuario']);
                    unset($_SESSION['nombreUsuario']);
                    unset($_SESSION['username']);

                    $this->idUsuario = null;
                    $this->username = null;
                    $this->nombreUsuario = null;
                    $this->email = null;
                    $this->avatar = null;
                    $this->fechaRegistro = null;

                    $respuesta = ['error' => 'Usuario o contrasena incorrectos.'];
                    return $respuesta;
                }
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al validar al usuario.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin validar()

    public function editarNombre()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuarios SET nombreUsuario=:nombre WHERE idUsuario=:id");

                $consulta->bindParam(':id', $this->idUsuario);
                $consulta->bindParam(':nombre', $this->nombreUsuario);

                $consulta->execute();

                $_SESSION['nombreUsuario'] = $this->nombreUsuario;

                $respuesta = [
                    'exito' => 'El nombre de usuario se editó correctamente.',
                    'exito_tecnico' => $this->nombreUsuario
                ];

                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar el nombre del usuario.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarNombre()

    public function editarAvatar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        }
        try {
            if (!isset($_FILES['avatar']) || !isset($_FILES['avatar']['error'])) {
                return [
                    'error' => 'No se recibió ninguna imagen.'
                ];
            }

            if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
                return [
                    'error' => 'No se pudo subir la imagen.'
                ];
            }

            if ($_FILES['avatar']['size'] > 5 * 1024 * 1024) {
                return [
                    'error' => 'El avatar no puede superar los 5 MB.'
                ];
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tiposPermitidos = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp'
            ];

            $mime = $finfo->file(
                $_FILES['avatar']['tmp_name']
            );


            if (!isset($tiposPermitidos[$mime])) {
                return [
                    'error' => 'El archivo debe ser una imagen JPG, PNG o WEBP.'
                ];
            }

            if (@getimagesize($_FILES['avatar']['tmp_name']) === false) {
                return [
                    'error' => 'El archivo seleccionado no es una imagen válida.'
                ];
            }

            // Creamos la carpeta física
            $carpeta = $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/images/avatars/';

            if (!is_dir($carpeta)) {
                if (!mkdir($carpeta, 0755, true)) {
                    return [
                        'error' => 'No se pudo crear la carpeta de avatares.'
                    ];
                }
            }

            $extension = $tiposPermitidos[$mime];
            $nombreArchivo = $this->idUsuario . '.' . $extension;
            $rutaFisica = $carpeta . $nombreArchivo;

            // Eliminamos posibles avatares anteriores de este usuario
            $extensiones = ['jpg', 'png', 'webp'];
            foreach ($extensiones as $extensionAnterior) {
                $archivoAnterior = $carpeta . $this->idUsuario . '.' . $extensionAnterior;
                if (file_exists($archivoAnterior) && $archivoAnterior !== $rutaFisica) {
                    unlink($archivoAnterior);
                }
            }

            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaFisica)) {
                return [
                    'error' => 'No se pudo guardar el avatar.'
                ];
            }

            $rutaBD = 'images/avatars/' . $nombreArchivo;


            // Actualizamos el usuario
            $consulta = $conexion->prepare("UPDATE usuarios SET avatar = :avatar WHERE idUsuario = :idUsuario");

            $consulta->bindParam(':avatar', $rutaBD);
            $consulta->bindParam(':idUsuario', $this->idUsuario);

            $consulta->execute();

            // Lo guardamos ya en la sesión actual
            $_SESSION['avatar'] = $rutaBD;

            return [
                'exito' => true,
                'avatar' => $rutaBD
            ];
        } catch (PDOException $error) {
            return [
                'error' => 'Ocurrió un error al actualizar el avatar.',
                'error_tecnico' => $error
            ];
        }
    } // Fin editarAvatar()

    public function cerrarSesion()
    {

        $_SESSION = [];
        session_destroy();

        $respuesta = [
            'exito' => 'La sesión se ha cerrado correctamente'
        ];

        return $respuesta;
    } // Fin cerrarSesion()

} // Fin de la clase Usuario


/*
$usuario = new Usuario();
$usuario->username = 'isaac';
$usuario->nombreUsuario = 'Isaac';
$usuario->email = 'isaac.espi@hotmail.es';
$usuario->contrasena = '1234';

$resultado = $usuario->insertar();
var_dump($resultado);

echo '<br>';

$resultado = $usuario->validar();
var_dump($resultado);
*/
