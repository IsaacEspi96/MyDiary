<?php

function limpiaFormulario($respuestas)
{
	foreach ($respuestas as $clave => $valor) {
		$respuestas[$clave] = htmlspecialchars($valor, ENT_QUOTES);
	};

	return $respuestas;
}
