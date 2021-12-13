function seleccionarTodosHonorariosMedico() {
    
    var numero = $('#numero1').val();

    console.log(numero);
    if ($('#todos1').is(':checked')) {
        for (let index = 0; index < (numero); index++) {
            $('#honorario' + index).prop('checked', true);
            //$('#honorario21').prop('checked', true);
        }
    } else {
        for (let index = 0; index < numero; index++) {
            $('#honorario' + index).prop('checked', false);
            //$('#honorario21').prop('checked', false);
        }

    }
}