<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>MyDiary</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
		<link rel="stylesheet" href="assetsIndex/css/main.css" />
		<noscript><link rel="stylesheet" href="assetsIndex/css/noscript.css" /></noscript>
		<link rel="icon" href="images/favicon.svg" type="image/svg+xml">
	</head>
<body class="is-preload">

<!-- Contenido -->
<div id="wrapper">
	<header id="header">
		<div class="logo">
			<i class="icon bi bi-journal-medical"></i>
		</div>
		<div class="content">
			<div class="inner">
				<h1 id="marca">MyDiary</h1>

				<?php if(!isset($_SESSION['idUsuario'])): ?>
					<p>Diario personal para mantener un registro de todo lo que consumes</p>
					<nav id="navSesion">
						<ul>
							<li>
							<a data-bs-toggle="modal" data-bs-target="#modalSesion">Iniciar Sesión</a>
							</li>
							<li>
							<a data-bs-toggle="modal" data-bs-target="#modalRegistro">Registrarse</a>
							</li>
						</ul>
					</nav>
				<?php else: 
					echo '<p>Bienvenido, '.$_SESSION['nombreUsuario'].'</p>'; ?>
					<nav id="navStats">
						<ul>
							<li>
								<a data-bs-toggle="modal" data-bs-target="#modalPerfil"><i class="bi bi-person-fill"></i> Perfil</a>
							</li>
							<li>
								<a href="stats.php">Estadísticas <i class="bi bi-bar-chart-fill"></i></a>
							</li>
						</ul>
						
					</nav>
				<?php endif; ?>
			</div>
		</div>

		<?php if(isset($_SESSION['idUsuario'])): ?>
			<nav>
				<ul>
					<li><a href="contenido.php?tipo=pelicula"><i class="bi bi-film"></i> Películas</a></li>
					<li><a href="contenido.php?tipo=serie"><i class="bi bi-tv"></i> Series</a></li>
					<li><a href="contenido.php?tipo=juego"><i class="bi bi-controller"></i> Juegos</a></li>
					<li><a href="contenido.php?tipo=libro"><i class="bi bi-book"></i> Libros</a></li>
					<li><a href="contenido.php?tipo=extra"><i class="bi bi-plus-lg"></i> Añadir</a></li>
				</ul>
			</nav>
		<?php endif; ?>
	</header>

	<footer id="footer">
		<p class="copyright">&copy; MyDiary. Diseño: Isaac EA</a>.</p>
	</footer>

</div> <!-- Fin Contenido -->

<!-- Modal Iniciar Sesion -->
<div class="modal fade" id="modalSesion" tabindex="-1" aria-labelledby="sesionModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modalContent modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="sesionModalLabel">Introduzca sus credenciales</h1>
				<button type="button" class="btn shadow-none ms-auto text-warning" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
			</div>
			<div class="modal-body">
				<form id="sesionForm">
					<div class=" my-3">
						<label for="usernameFormSesion">Nombre de usuario o correo electrónico:</label>
						<input class="form-control" id="usernameFormSesion" name="usernameFormSesion" type="text" required />
						<div id="invalidUsernameSesion"class="invalid-feedback" data-sb-feedback="name:required">Introduzca un nombre de usuario válido o correo electrónico asociado por favor.</div>
					</div>
					<div class=" my-3">
						<label for="contraFormSesion">Contraseña:</label>
						<input class="form-control" id="contraFormSesion" name="contraFormSesion" type="password" required/>
						<div id="invalidContraSesion" class="invalid-feedback" data-sb-feedback="name:required">Introduzca una contraseña válida por favor.</div>
					</div>
				</form>
			</div>
			<div class="modal-footer mt-0 pt-0">
				<button type="button" class="mt-4 btn btn-secondary" data-bs-dismiss="modal" id="botFormSesionCerrar">Cerrar</button>
				<button type="button" class="mt-4 btn" id="botFormSesionConfirmar">Confirmar</button>
			</div>
		</div>
	</div>
</div> <!-- Fin Modal Iniciar Sesion -->

<!-- Modal Registro -->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modalContent modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="registroModalLabel">Introduzca sus datos</h1>
				<button type="button" class="btn shadow-none ms-auto text-warning" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
			</div>
			<div class="modal-body">
				<form id="registroForm">
					<div class=" my-3">
						<label for="usernameFormRegistro">Nombre de usuario:</label>
						<input class="form-control" id="usernameFormRegistro" name="usernameFormRegistro" type="text" required />
						<div id="invalidUsernameRegistro" class="invalid-feedback" data-sb-feedback="name:required">Introduzca un nombre de usuario válido por favor.</div>
					</div>
					<div class=" my-3">
						<label for="emailFormRegistro">Correo Electrónico:</label>
						<input class="form-control" id="emailFormRegistro" name="emailFormRegistro" type="text" required/>
						<div id="invalidEmailRegistro" class="invalid-feedback" data-sb-feedback="name:required">Introduzca un correo electrónico válido por favor.</div>
					</div>
					<div class=" my-3">
						<label for="contraFormRegistro">Contraseña:</label>
						<input class="form-control" id="contraFormRegistro" name="contraFormRegistro" type="password" required/>
						<div class="invalid-feedback" data-sb-feedback="name:required">Introduzca una contraseña válida por favor.</div>
					</div>
					<div class=" my-3">
						<label for="confirmarContraFormRegistro">Confirmar Contraseña:</label>
						<input class="form-control" id="confirmarContraFormRegistro" name="confirmarContraFormRegistro" type="password" required/>
						<div class="invalid-feedback" data-sb-feedback="name:required">La contraseña no coincide.</div>
					</div>
				</form>
			</div>
			<div class="modal-footer mt-0 pt-0">
				<button type="button" class="mt-4 btn btn-secondary" data-bs-dismiss="modal" id="botFormRegistroCerrar">Cerrar</button>
				<button type="button" class="mt-4 btn" id="botFormRegistroConfirmar">Confirmar</button>
			</div>
		</div>
	</div>
</div> <!-- Fin Modal Registro -->

<!-- Modal Nombre Usuario -->
<div class="modal fade" id="modalNombre" tabindex="-1" aria-labelledby="nombreModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modalContent modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="nombreModalLabel">Introduzca su nombre de pila</h1>
				<button type="button" class="btn shadow-none ms-auto text-warning" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
			</div>
			<div class="modal-body">
				<form id="nombreForm">
					<div class=" my-3">
						<label for="FormNombre">Nombre de pila:</label>
						<input class="form-control" id="FormNombre" name="FormNombre" type="text" required />
						<div id="invalidNombre"class="invalid-feedback" data-sb-feedback="name:required">Introduzca un nombre válido por favor.</div>
					</div>
					<input type="hidden" id="idFormNombre" name="idFormNombre">
				</form>
			</div>
			<div class="modal-footer mt-0 pt-0">
				<button type="button" class="mt-4 btn btn-secondary" data-bs-dismiss="modal" id="botFormNombreCerrar">Omitir</button>
				<button type="button" class="mt-4 btn" id="botFormNombreConfirmar">Confirmar</button>
			</div>
		</div>
	</div>
</div> <!-- Fin Modal Nombre Usuario -->

<!-- Modal Perfil -->
<div class="modal top fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
    <div class="modal-dialog modal-dialog-centered text-center d-flex justify-content-center">
        <div class="modalContent modal-content w-75">
            <div class="modal-body p-4">

			<div class="position-relative d-inline-block">
                <img id="avatarPerfil" src="<?php echo !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'images/noAvatar.jpg'; ?>" style="width: 180px; height: 180px;" alt="avatar" class="rounded-circle object-fit-cover" />

				<button type="button" id="editarAvatar" class="btn btn-dark rounded-circle position-absolute bottom-0 end-0 me-1 mb-1" title="Editar Avatar"> <i class="bi bi-pencil-fill"></i> </button>

				<input type="file" id="inputAvatar" accept="image/jpeg,image/png,image/webp" class="d-none">
			</div>

                <form>
                    <div>
                        <h2 class="text-warning"><?php echo $_SESSION['nombreUsuario'] ?></h2>
                        <div class="row border border-3 border-warning my-3">
                            <div class="col-6">
                            <ul class="list-unstyled mb-0 text-start">
                                <li>Películas</li>
                                <li>Series</li>
                                <li>Videojuegos</li>
                                <li>Libros</li>
                            </ul>
                            </div>
                            <div class="col-6 text-end">
                            <ul class="list-unstyled mb-0">
                                <li id="totalPeliculas">0</li>
                                <li id="totalSeries">0</li>
                                <li id="totalJuegos">0</li>
                                <li id="totalLibros">0</li>
                            </ul>
                            </div>
                        </div>
                    
                        <button id="cerrarSesion" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger">Cerrar Sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- Fin Modal Perfil -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="assetsIndex/js/jquery.min.js"></script>
<script src="assetsIndex/js/browser.min.js"></script>
<script src="assetsIndex/js/breakpoints.min.js"></script>
<script src="assetsIndex/js/util.js"></script>
<script src="assetsIndex/js/main.js"></script>

<script>

 const controlador = "controladores/controladorUsuario.php";

$(document).ready(function(){

	// Funcionalidad de confirmar en sesion
    $('#botFormSesionConfirmar').click(function(event){
        event.preventDefault();

		$('.form-control').removeClass('is-invalid');

        let identificador = $('#usernameFormSesion').val();
        let pass = $('#contraFormSesion').val();

		let valido = true;
		if(identificador.trim() === ''){
            $('#usernameFormSesion').addClass('is-invalid');
            valido=false;
        }
		if(pass.trim() === ''){
            $('#contraFormSesion').addClass('is-invalid');
            valido=false;
        }
        if(!valido){
            return;
        }

        $.ajax({
            method: "POST",
            url: controlador,
			dataType: "json",
            data: {
                "identificador": identificador,
				"contrasena": pass,
                "orden": 'validar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                console.log(respuesta.error);
				$('#usernameFormSesion').addClass('is-invalid');
				$('#contraFormSesion').addClass('is-invalid');
				$('#invalidUsernameSesion').text(respuesta.error);
				$('#invalidContraSesion').text(respuesta.error);
            }else{
				location.reload();
            } // Fin else
        }) // Fin ajax
    });

	// Funcionalidad de confirmar en registro
    $('#botFormRegistroConfirmar').click(function(event){
        event.preventDefault();

		$('.form-control').removeClass('is-invalid');
		
        let username = $('#usernameFormRegistro').val();
		let email = $('#emailFormRegistro').val();
        let pass = $('#contraFormRegistro').val();
		let pass2 = $('#confirmarContraFormRegistro').val();

		let valido = true;
		if(username.trim() === ''){
            $('#usernameFormRegistro').addClass('is-invalid');
            valido=false;
        }
		if(email.trim() === ''){
            $('#emailFormRegistro').addClass('is-invalid');
            valido=false;
        }
		if(pass.trim() === ''){
            $('#contraFormRegistro').addClass('is-invalid');
            valido=false;
        }
		if(pass !== pass2){
			$('#confirmarContraFormRegistro').addClass('is-invalid');
			valido=false;
		}
        if(!valido){
            return;
        }

        $.ajax({
            method: "POST",
            url: controlador,
			dataType: "json",
            data: {
                "username": username,
				"contrasena": pass,
				"email": email,
				"contrasena2": pass2,
                "orden": 'insertar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                console.log(respuesta.error);
				if(respuesta.caso == 'username'){
					$('#usernameFormRegistro').addClass('is-invalid');
					$('#invalidUsernameRegistro').text(respuesta.error);
				}
				if(respuesta.caso == 'email'){
					$('#emailFormRegistro').addClass('is-invalid');
					$('#invalidEmailRegistro').text(respuesta.error);
				}
            }else{
				$('#idFormNombre').val(respuesta.id);
				let modalRegistro = bootstrap.Modal.getInstance(document.getElementById('modalRegistro'));
    			modalRegistro.hide();

				let modalNombre = new bootstrap.Modal(document.getElementById('modalNombre'));
    			modalNombre.show();
            } // Fin else
        }) // Fin done
    });

	// Funcionalidad de confirmar en nombre
    $('#botFormNombreConfirmar').click(function(event){
        event.preventDefault();

		$('.form-control').removeClass('is-invalid');

        let nombre = $('#FormNombre').val();
		let id = $('#idFormNombre').val();

		let valido = true;
		if(nombre.trim() === ''){
            $('#FormNombre').addClass('is-invalid');
            valido=false;
        }
        if(!valido){
            return;
        }

        $.ajax({
            method: "POST",
            url: controlador,
			dataType: "json",
            data: {
                "nombreUsuario": nombre,
				"idUsuario": id,
                "orden": 'editarNombre'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                console.log(respuesta.error);
            }else{
				location.reload();
            } // Fin else
        }) // Fin ajax
    });

	// Funcionalidad de omitir nombre
	$('#botFormNombreCerrar').click(function(event){
		event.preventDefault();
		location.reload();
	});

	// Funcionalidad de cerrar sesion
	$('#cerrarSesion').click(function(event){
		event.preventDefault();

		$.ajax({
            method: "POST",
            url: controlador,
			dataType: "json",
            data: {
                "orden": 'cerrarSesion'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                console.log(respuesta.error);
            }else{
				window.location.href = "index.php";
            } // Fin else
        }) // Fin ajax
	});

	// Funcionalidad de editar avatar
	$('#editarAvatar').click(function(event){
		event.preventDefault();

    	$('#inputAvatar').click();
	});

	// Funcionalidad de confirmar en editar avatar
	$('#inputAvatar').change(function(){

		const archivo = this.files[0];

		if(!archivo){
			return;
		}
		const avatarAnterior = $('#avatarPerfil').attr('src');
		const imagen = URL.createObjectURL(archivo);
		$('#avatarPerfil').attr('src', imagen);
		const datos = new FormData();
		datos.append('orden','editarAvatar');
		datos.append('avatar',archivo);

		$.ajax({
			method: "POST",
			url: controlador,
			data: datos,
			dataType: "json",
			processData: false,
			contentType: false
		}).done(function(respuesta){
			if(respuesta.error){
				console.log(respuesta.error_tecnico);
				$('#avatarPerfil').attr('src',avatarAnterior);
			}else{
				$('#avatarPerfil').attr('src',respuesta.avatar + '?v=' + Date.now());
				URL.revokeObjectURL(imagen);
			} // Fin else
		}); //Fin ajax
	});

	// Números totales en el perfil
	$('#modalPerfil').on('shown.bs.modal', function(){

		$.ajax({
			method: "POST",
			url: controlador,
			dataType: "json",
			data: {
				"orden": 'numeroTotal'
			},
		}).done(function(respuesta){
			if(respuesta.error){
				console.log(respuesta.error);
			}else{
				$('#totalPeliculas').text(respuesta.peliculas.length);
				$('#totalJuegos').text(respuesta.juegos.length);
				$('#totalLibros').text(respuesta.libros.length);
				$('#totalSeries').text(respuesta.series.length);
				
			} // Fin else
		}) // Fin ajax
	});

	// Cerrar modales
	$('.modal').on('hide.bs.modal', function(){
        document.activeElement.blur();
	});

}); // Fin document.ready

</script>

</body>
</html>
