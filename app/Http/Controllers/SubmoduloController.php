<?php

namespace App\Http\Controllers;

//////////////////////////////////
//MODELOS
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Log;

//////////////////////////////////
use Illuminate\Http\Request;

//////////////////////////////////
use Illuminate\Support\Facades\DB;

/////////////////////////////////
use App\Http\Requests\AlmacenarModeloRequest;

////////////////////////////////
//UTILIDADES
use Route;
use Session;
use Validator;
use Auth;

class SubmoduloController extends Controller
{
    /**
     * Permite listar todos los elementos en la tabla
     * submódulos
     */
    public function index(){
        return view(Route::currentRouteName(), ['submodulos' => Submodulo::paginate()]);
    }

    /**
     * Permite crear un núevo submódulo
     */
    public function crear(){
        return view(Route::currentRouteName(), ['ruta' => 'submodulos.almacenar']);
    }

    /**
     * Permite almacenar un núevo submódulo
     */
    public function almacenar(Request $request){
        
        $rules = [
            'nombre'   => 'required|string|max:20',
            'descripcion'  => 'required|string',
            'icono'    => 'required|string|max:20',
            'modulo_id'    => 'required|integer',
            'visibilidad'     => 'required|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del submodulo es obligatorio.',
            'string'   => 'El :attribute del submodulo debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'La :attribute del modulo al que pertenece el submodulo es un campo obligatorio.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'El submódulo no ha podido ser creado')->showConfirmButton();
            Session::flash('error_message', 'Algunos camposson obligatorios');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        if(Modulo::find($request->modulo_id) == null){
            $errors = array('modulo_id' => 'El módulo ingresado no es válido.');
            alert()->warning('Advertencia', 'El módulo ingresado no es válido.')->showConfirmButton();
            Session::flash('error_message', 'El submódulo no ha podido ser editado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        $submodulo = new Submodulo([
            'nombre'   => $request->nombre,
            'descripcion'  => $request->descripcion,
            'estado'=> 1, 
            'icono'    => $request->icono,
            'visible'     => $request->visibilidad,
            'modulo_id'    => $request->modulo_id,            
        ]);
        $submodulo->save();

        $log = new Log([
            "registro_id"    => $submodulo->id,
            "nombre_tabla"   => 'submodulos',
            "accion"         => 'crear',
            "responsable_id" => Auth::user()->id, 
        ]);
        $log->save();

        alert()->success('Éxito', 'Submódulo creado exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Submódulo creado exitosamente');
        return back();
    }

    /**
     * Permite editar un submódulo existente
     */
    public function editar(Submodulo $submodulo){
        return view(Route::currentRouteName(),[
            'submodulo' => $submodulo,
            'ruta' => 'submodulos.actualizar'
        ]);
    }

    /**
     * Permite actualizar un submódulo existente
     */
    public function actualizar(Request $request, $id){
        
        $rules = [
            'nombre'   => 'required|string|max:20',
            'descripcion'  => 'required|string',
            'icono'    => 'required|string|max:20',
            'modulo_id'    => 'required|integer',
            'visibilidad'     => 'required|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del submodulo es obligatorio.',
            'string'   => 'El :attribute del submodulo debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'La :attribute del modulo al que pertenece el submodulo es obligatorio.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'Algunos campos son obligatorios')->showConfirmButton();
            Session::flash('error_message', 'El submódulo no ha podido ser editado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        if(Modulo::find($request->modulo_id) == null){
            $errors = array('modulo_id' => 'El módulo ingresado no se encuentra registrado.');
            alert()->warning('Advertencia', 'El módulo ingresado no se encuentra registrado.')->showConfirmButton();
            Session::flash('error_message', 'El submódulo no ha podido ser editado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        //Si el valor es diferente a los establecidos, por defecto se vuelve 1 (visible)
        if($request->visibilidad != 0 || $request->visibilidad != 1){
            $request->visibilidad = 1;
        }
       
        $submodulo = Submodulo::findOrFail($id);
        $sub = new Submodulo;
        $sub->nombre = $request->input('nombre');    
        $sub->descripcion = $request->input('descripcion');
        if($request->input('estado')){
            $sub->estado = $request->input('estado');
        }
        else{
            $sub->estado ="0";
        }
        $sub->icono = $request->input('icono');
        if(($request->input('nombre'))=='Permiso'){
            $sub->visible = "0";
        }
        else{
            $sub->visible = $request->input('visibilidad');
        }        
        $sub->modulo_id = $request->input('modulo_id');
        
        
        $datos=([
            'nombre' => $sub->nombre,
            'descripcion' => $sub->descripcion,
            'estado'  => $sub->estado,
            'icono'  => $sub->icono,
            'visible'  => $sub->visible,
            'modulo_id' => $sub->modulo_id,
        ]);
        
        $submodulo->update($datos);
        $submodulo->save();

        $log = new Log([
            "registro_id"    => $submodulo->id,
            "nombre_tabla"   => 'submodulos',
            "accion"         => 'editar',
            "responsable_id" => Auth::user()->id, 
        ]);
        $log->save();

        alert()->success('Éxito', 'Submódulo editado exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Submódulo editado exitosamente');
        return back();
    }

    /**
     * Permite mostrar un submódulo existente
     */
    public function mostrar(Submodulo $submodulo){
        return view(Route::currentRouteName(), ['submodulo' => $submodulo]);
    }

    /**
     * Permite buscar un entre los submódulos existentes
     */
    public function buscar(){
        Session::forget('success_message');
        Session::forget('info_message');
        Session::forget('error_message');

        $caracteristica = null;
        if(isset($_GET["caracteristica"])){
            if($this->existeCaracteristica($_GET["caracteristica"])){
                $caracteristica = $_GET["caracteristica"];
            }
        }

        $valor = null;
        if(isset($_GET["valor"])){
            $valor = $_GET["valor"];
        }

        $submodulos = Submodulo::paginate();
        if($caracteristica != null && $valor != null){
            $submodulos = Submodulo::where([
                [
                    $caracteristica, 'like', '%' . $valor . '%'
                ]
            ])->paginate();

            if(count($submodulos)){
                alert()->success('Éxito', 'Búsqueda realizada correctamente')->showConfirmButton();
                Session::flash('success_message', 'Búsqueda realizada correctamente');
            }else{
                alert()->info('Información', 'No ha habido resultado en la búsqueda.')->showConfirmButton();
                Session::flash('info_message', 'No ha habido resultado en la búsqueda.');
            }
        }

        return view('submodulos.index', [
            'submodulos' => $submodulos,
            'caracteristica' => $caracteristica,
            'valor' => $valor
            ]);
    }

    /**
     * Permite eliminar un submódulo existente
     */
    public function eliminar($id){
        $submodulo = Submodulo::findOrFail($id);
        //Si no posee accesos relacionados
        if(count($submodulo->accesos)==0){

            $log = new Log([
                "registro_id"    => $submodulo->id,
                "nombre_tabla"   => 'submodulos',
                "accion"         => 'eliminar',
                "responsable_id" => Auth::user()->id,
            ]);
            $log->save();

            $submodulo->delete();
            alert()->success('Éxito', 'Submódulo eliminado exitosamente')->showConfirmButton();
            Session::flash('success_message', 'Submódulo eliminado exitosamente');
            return back();
        }
        alert()->error('Error', 'El submódulo no fue eliminado, existen uno o varios accesos que se relacionan a él. Por favor, intentálalo de nuevo.')->showConfirmButton();
        Session::flash('error_message', 'El submódulo no fue eliminado, existen uno o varios accesos que se relacionan a él. Por favor, intentálalo de nuevo.');
        return back()
            ->withInput();        
    }

    /**
     * Funcion que permite verificar que la caracteristica exista en la tabla
     */
    public function existeCaracteristica($caracteristica){
        foreach(\Schema::getColumnListing("submodulos") as $columna){
            if($columna == $caracteristica)
                return true;
        }
        return false;
    }
}
