/**
 * Seleccionar o desmarcar todos los items en el formulario de consulta
 * ver en views/medicos/formulario.php
 */
function seleccionarTodosHonorarios() {
    var numero = $('#numero').val();
    console.log(numero);
    if ($('#todos').is(':checked')) {
        for (let index = 0; index < (numero); index++) {
            $('#honorario' + index).prop('checked', true);
        }
    } else {
        for (let index = 0; index < numero; index++) {
            $('#honorario' + index).prop('checked', false);
        }

    }
}


function desactivarBoton() {
    $('#bDescargar').prop('disabled', true);
    $('#bEnviar').prop('disabled', true);
    $('#bModificar').prop('disabled', true);
}