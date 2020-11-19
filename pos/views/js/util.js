$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});

//true es vacio
function esVacio(texto) {
	return (texto == null || texto.length == 0 || /^\s+$/.test(texto));
}

//true selecciono
function seleccionaOpcion(id) {
	var opcion = document.getElementById(id).selectedIndex;
	return !(opcion == null || opcion == 0 || opcion == "");
}

//true es email
function esEmail(email) {
	return ((/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(email)));
}

//true fecha valida
function esFecha(annio, mes, dia) {
	valor = new Date(annio, mes, dia);
	return (isNaN(valor));
}

//true es telefono
function esTelefono(telefono) {
	return ((/^\d{9}$/.test(valor)));
}

//true si a seleccionado al menos un checkbox
function checkboxSeleccionado(idForm) {
	var formulario = document.getElementById(idForm);
	for (var i = 0; i < formulario.elements.length; i++) {
		var elemento = formulario.elements[i];
		if (elemento.type == "checkbox") {
			if (!elemento.checked) {
				return false;
			}
		}
	}
}

//mostrar u ocultar la contraseña
function mostrarContrsena(idinput, idspan) {

	if ($("#" + idinput).prop('type') === "password") {
		$("#" + idinput).prop('type', 'text');
		$("#" + idspan).html('<i class="fa fa-eye" aria-hidden="true"></i>');
	} else {
		$("#" + idinput).prop('type', 'password');
		$("#" + idspan).html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
	}
}

//Comprobar si tiene espacios.
function tieneEspacios(texto) {
	return (texto.trim().length != texto.length);
}

function showAlertExitoso(titulo, mensaje){
	$("#alerta_exitoso").html('<strong>'+ titulo+'</strong> '+ mensaje);
	$("#alerta_exitoso").show();
}

function hideAlertExitoso(){
	$("#alerta_exitoso").hide();
}

function showAlertError(titulo, mensaje){
	$("#alerta_error").html('<strong>'+ titulo+'</strong> '+ mensaje);
	$("#alerta_error").show();
}

function hideAlertError(){
	$("#alerta_error").hide();
}

function showAlertWarning(titulo, mensaje){
	$("#alerta_Warning").html('<strong>'+ titulo+'</strong> '+ mensaje);
	$("#alerta_Warning").show();
}

function hideAlertWarning(){
	$("#alerta_Warning").hide();
}