@component('mail::message')
# Hola, {{$soporte->autor->medicoHonorario()->NOMBRE}}

<span style="text-align: center;">
    Usted ha generado un nuevo soporte de pago de honorarios <strong>({{$soporte->radicado}})</strong> 
</span>
<br>
<span style="text-align: center;">
    Por verifique en la opción "Soporte>listar" en la aplicación de Honorarios.
</span>

Gracias,Administrador<br>
{{ config('app.name') }}
@endcomponent
