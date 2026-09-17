
<div id="cabecera">

    <!-- Header -->
    <header id="header">
        <h1 id="marcaCabecera" class="text-white"> <i class="bi bi-journal-medical"></i> <a href="index.php">MyDiary</a> </h1>
        <nav>
            <a id="botPerfil" class="text-white" data-bs-toggle="modal" data-bs-target="#modalPerfil">Perfil <i class="bi bi-person-fill"></i></a>
            <a href="#menu">Menu</a>
        </nav>
    </header>

    <!-- Menu -->
    <nav id="menu" class="my-2">
        <div class="inner">
            <h2 class="text-white">Menu</h2>
            <ul class="links text-white">
                <li> <a href="index.php"> <i class="bi bi-journal-medical"></i> Inicio</a></li>
                <li> <a href="contenido.php?tipo=pelicula"> <i class="bi bi-film"></i> Peliculas</a></li>
                <li> <a href="contenido.php?tipo=serie"> <i class="bi bi-tv"></i> Series</a></li>
                <li> <a href="contenido.php?tipo=juego"> <i class="bi bi-controller"></i> Videojuegos</a></li>
                <li> <a href="contenido.php?tipo=libro"> <i class="bi bi-book"></i> Libros</a></li>
                <li> <a href="stats.php"> <i class="bi bi-bar-chart-fill"></i> Estadísticas</a></li>
            </ul>
            <a href="#" class="close">Cerrar</a>
        </div>
    </nav>
<div>

<!-- Modal Perfil -->
<div class="modal top fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
    <div class="modal-dialog modal-dialog-centered text-center d-flex justify-content-center">
        <div class="modalContent modal-content w-75">
            <div class="modal-body p-4">

			<div class="position-relative d-inline-block mb-3">
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
                                <li class="m-2">Películas</li>
                                <li class="m-2">Series</li>
                                <li class="m-2">Videojuegos</li>
                                <li class="m-2">Libros</li>
                            </ul>
                            </div>
                            <div class="col-6 text-end">
                            <ul class="list-unstyled mb-0">
                                <li id="totalPeliculas" class="m-2">0</li>
                                <li id="totalSeries" class="m-2">0</li>
                                <li id="totalJuegos" class="m-2">0</li>
                                <li id="totalLibros" class="m-2">0</li>
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


<script>

const controladorUsuario = 'controladores/controladorUsuario.php';

$(document).ready(function(){

	// Funcionalidad de cerrar sesion
	$('#cerrarSesion').click(function(event){
		event.preventDefault();

		$.ajax({
            method: "POST",
            url: controladorUsuario,
            data: {
                "orden": 'cerrarSesion'
            },
        }).done(function(respuesta){
            respuesta=JSON.parse(respuesta);
            if(respuesta.error){
                console.log(respuesta.error);
            }else{
				window.location.href = "index.php";
            }
        }) // Fin done
	}); // Fin click de cerrar sesion

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
			url: controladorUsuario,
			data: {
				"orden": 'numeroTotal'
			},
		}).done(function(respuesta){
			respuesta=JSON.parse(respuesta);
			if(respuesta.error){
				console.log(respuesta.error);
			}else{
				$('#totalPeliculas').text(respuesta.peliculas.length);
                $('#totalJuegos').text(respuesta.juegos.length);
                $('#totalLibros').text(respuesta.libros.length);
                $('#totalSeries').text(respuesta.series.length);
			}
		}) // Fin done
	}); // Fin de números totales en el perfil

}); // Fin document.ready

</script>