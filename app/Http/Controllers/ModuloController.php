<?php

namespace App\Http\Controllers;

//////////////////////////////////
//MODELOS
use App\Models\Modulo;
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

class ModuloController extends Controller
{
    /**
     * Permite listar todos los elementos en la tabla
     * módulos
     */
    public function index(){
        return view(Route::currentRouteName(), ['modulos' => Modulo::paginate()]);
    }

    /**
     * Permite crear un núevo módulo
     */
    public function crear(){
        return view(Route::currentRouteName(), 
                    ['ruta' => 'modulos.almacenar']);
    }

    /**
     * Permite almacenar un núevo módulo
     */
    public function almacenar(Request $request){
        
        $rules = [
            'nombre'   => 'required|string|max:20',
            'descripcion'  => 'required|string',
            'icono'    => 'required|string|max:20',
            'visibilidad'     => 'required|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del módulo es obligatorio.',
            'string'   => 'El :attribute del módulo debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'La :attribute del módulo al que pertenece el acceso debe ser entero.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'El modulo no ha podido ser creado.')->showConfirmButton();
            Session::flash('error_message', 'Algunos campos son obligatorios.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        //$modulo = new Modulo($request->all());
        $modulo = new Modulo([
            'nombre' => $request->nombre,            
            'descripcion'=> $request->descripcion,
            'estado'=> 1, 
            'icono'=> $request->icono,
            'visible'=> $request->visibilidad,
        ]);
        $modulo->save();

        $log = new Log([
            "registro_id"    => $modulo->id,
            "nombre_tabla"   => 'modulos',
            "accion"         => 'crear',
            "responsable_id" => Auth::user()->id, 
        ]);
        $log->save();

        alert()->success('Éxito', 'Módulo creado exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Módulo creado exitosamente');
        return back();
    }

    /**
     * Permite editar un módulo existente
     */
    public function editar(Modulo $modulo){
        return view(Route::currentRouteName(),[
            'modulo' => $modulo,
            'ruta' => 'modulos.actualizar'
        ]);
    }

    /**
     * Permite actualizar un módulo existente
     */
    public function actualizar(Request $request, $id){
        $rules = [
            'nombre'   => 'required|string|max:20',
            'descripcion'  => 'required|string',
            'icono'    => 'required|string|max:20',
            'visibilidad'     => 'required|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del modulo es obligatorio.',
            'string'   => 'El :attribute del modulo debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'La :attribute del módulo al que pertenece el acceso debe ser entero.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'El módulo no pode ser editado')->showConfirmButton();
            Session::flash('error_message', 'El módulo no ha podido ser editado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        $modulo = Modulo::findOrFail($id);
        $mod = new Modulo;
        $mod->nombre = $request->input('nombre');
        $mod->descripcion = $request->input('descripcion');
        if( $request->input('estado')){
            $mod->estado= $request->input('estado');
        }
        else{
            $mod->estado = "0";
        }
        $mod->icono = $request->input('icono');
        $mod->visible = $request->input('visibilidad');
        
        $datos=(['nombre' => $mod->nombre,
                  'descripcion' => $mod->descripcion,
                  'estado' => $mod->estado,
                  'icono' => $mod->icono,
                  'visible' => $mod->visible
                ]);

        $modulo->update($datos);
        $modulo->save();

        $log = new Log([
            "registro_id"    => $modulo->id,
            "nombre_tabla"   => 'modulos',
            "accion"         => 'editar',
            "responsable_id" => Auth::user()->id, //María Paula
        ]);
        $log->save();

        alert()->success('Éxito', 'Módulo editado exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Módulo editado exitosamente');
        return back();
    }

    /**
     * Permite mostrar un módulo existente y sus submodulos asociados
     */
    public function mostrar(Modulo $modulo){
        return view(Route::currentRouteName(), ['modulo' => $modulo]);
    }

    /**
     * Permite buscar un entre los módulos existentes
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

        $modulos = Modulo::paginate();
        if($caracteristica != null && $valor != null){
            $modulos = Modulo::where([
                [
                    $caracteristica, 'like', '%' . $valor . '%'
                ]
            ])->paginate();

            if(count($modulos)){
                alert()->success('Éxito', 'Búsqueda realizada correctamente')->showConfirmButton();
                Session::flash('success_message', 'Búsqueda realizada correctamente');
            }else{
                alert()->info('Información', 'No ha habido resultado en la búsqueda.')->showConfirmButton();
                Session::flash('info_message', 'No ha habido resultado en la búsqueda.');
            }
        }

        return view('modulos.index', [
            'modulos' => $modulos,
            'caracteristica' => $caracteristica,
            'valor' => $valor
            ]);
    }

    /**
     * Permite eliminar un módulo existente
     */
    public function eliminar($id){
        $modulo = Modulo::findOrFail($id);
        //Si no posee submodulos relacionados
        if(count($modulo->submodulos)==0){
            $log = new Log([
                "registro_id"    => $modulo->id,
                "nombre_tabla"   => 'modulos',
                "accion"         => 'eliminar',
                "responsable_id" => Auth::user()->id, 
            ]);
            $log->save();

            $modulo->delete();

            alert()->success('Éxito', 'Módulo ha sido eliminado exitosamente')->showConfirmButton();
            Session::flash('success_message', 'Módulo ha sido eliminado exitosamente');
            return back();
        }
        //dd(count($modulo->submodulos));
        alert()->error('Error', 'El módulo no fue eliminado, existe uno o varios submódulos que se relacionan a él. Por favor, intentálalo de nuevo.')->showConfirmButton();
        Session::flash('error_message', 'El módulo no fue eliminado, existe uno o varios submódulos que se relacionan a él. Por favor, intentálalo de nuevo.');
        return back()
            ->withInput();  
    }

    /**
     * Funcion que permite verificar que la caracteristica exista en la tabla
     */
    public function existeCaracteristica($caracteristica){
        foreach(\Schema::getColumnListing("modulos") as $columna){
            if($columna == $caracteristica)
                return true;
        }
        return false;
    }    
}
