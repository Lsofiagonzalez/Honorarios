<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Boleta;


class BoletaController extends Controller
{
    public function verPDF(Boleta $boleta)
    {

        if (Storage::disk('local')->exists($boleta->ubicacionPDF)) {
            return Storage::disk('local')->response($boleta->ubicacionPDF);
        }
    }

    public function descargarPDF(Boleta $boleta)
    {

        if (Storage::disk('local')->exists($boleta->ubicacionPDF)) {
            return Storage::disk('local')->download($boleta->ubicacionPDF);
        }
    }
}
