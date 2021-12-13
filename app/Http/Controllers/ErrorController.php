<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{

    /**
     * Función que permite mostrar la página de error para el código
     * 403
     */
    public function mostrar($codigo = 404){

        switch ($codigo) {
            case 403:
                $mensaje = 'Parece que no posees los permisos suficientes para ver ésta 
                página. Por favor, contacta a tu administrador para resolver el problema.';
                break;

            case 404:
                $mensaje = 'Parece que la página o el documento al que intentas acceder
                no fue encontrado, por favor revisa la dirección ingresada e inténtalo
                de nuevo.';
                break;
            
            default:
                $codigo = 404;
                $mensaje = 'Parece que la página o el documento al que intentas acceder
                no fue encontrado, por favor revisa la dirección ingresada e inténtalo
                de nuevo.';
                break;
        }
        return view('errores.general', ['codigo' => $codigo, 'mensaje' => $mensaje]);
    }
}
