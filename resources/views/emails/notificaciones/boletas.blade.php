@component('mail::message')

# Hola, {{$boleta->receptor()->NOMBRE}}

@component('mail::panel')
    <span style="text-align: center;">
        Usted ha recibido una nueva boleta de pago de honorarios <strong>({{$boleta->radicado}})</strong> 
    </span>
    <br>
    <span style="text-align: center;">
        Por verifique en la opción "Mis Boletas>listar" en la aplicación de Honorarios.
    </span>
@endcomponent

Gracias, Administrador<br>
{{ config('app.name').'.'}}

<br>
@endcomponent
