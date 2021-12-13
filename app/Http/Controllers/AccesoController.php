<?php

namespace App\Http\Controllers;
//////////////////////////////////
//MODELOS
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Acceso;
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

class AccesoController extends Controller
{
    /**
     * Permite listar todos los elementos en la tabla
     * accesos
     */
    public function index(){
        return view(Route::currentRouteName(), [
            'accesos' => Acceso::paginate()
        ]);
    }

    /**
     * Permite crear un núevo acceso
     */
    public function crear(){
        return view(Route::currentRouteName(), ['ruta' => 'accesos.almacenar']);
    }

    /**
     * Permite almacenar un núevo acceso
     */
    public function almacenar(Request $request){
        //nombre, descripcion, estado, submodulo_id, controlador, ruta
        $rules = [
            'nombre'   => 'required|string|max:30',
            'descripcion'  => 'required|string',
            'controlador'  => array(
                'required',
                'string',
                'max:100', 
                'regex:/^([a-zA-z0-9]+)@([a-zA-z0-9]+)/'
            ),          
            'ruta_nombre'         => 'required|string|max:100',  
            'submodulo_id'    => 'required|integer',
            'visibilidad'     => 'required|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del acceso es obligatorio.',
            'string'   => 'El :attribute del acceso debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'La :attribute del submódulo al que pertenece el acceso es un campo obligatorio.',
            'controlador.regex'  => 'El controlador debe cumplir con la forma: controlador@accion.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'Algunos campos son obligatorios.')->showConfirmButton();
            Session::flash('error_message', 'El acceso no ha podido ser creado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }        

        if(Submodulo::find($request->submodulo_id) == null){
            $errors = array('submodulo_id' => 'El submodulo seleccionado no existe');
            alert()->warning('Advertencia', 'El acceso no ha podido ser creado.')->showConfirmButton();
            Session::flash('error_message', 'El acceso no ha podido ser creado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }
        var_dump($request->all());

        $acceso = new Acceso([
            'nombre' => $request->nombre,
            'descripcion'=> $request->descripcion,
            'estado'=> 1, 
            'submodulo_id'=> $request->submodulo_id,
            'controlador'=> $request->controlador,
            'ruta_nombre' => $request->ruta_nombre,
            'visible'=> $request->visibilidad,
        ]);
        $acceso->save();

        $log = new Log([
            "registro_id"    => $acceso->id,
            "nombre_tabla"   => 'accesos',
            "accion"         => 'crear',
            "responsable_id" => Auth::user()->id, 
        ]);
        $log->save();

        alert()->success('Éxito', 'Acceso creado exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Acceso creado exitosamente');
        return back();
    }

    /**
     * Permite editar un acceso existente
     */
    public function editar(Acceso $acceso){
        return view(Route::currentRouteName(),[
            'acceso' => $acceso,
            'ruta' => 'accesos.actualizar'
        ]);
    }

    /**
     * Permite actualizar un acceso existente
     */
    public function actualizar(Request $request, $id){
        $rules = [
            'nombre'   => 'required|string|max:20',
            'descripcion'  => 'required|string',
            'controlador'  => array(
                'required',
                'string',
                'max:100', 
                'regex:/^([a-zA-z0-9]+)@([a-zA-z0-9]+)/'
            ),          
            'ruta_nombre'         => 'required|string|max:100',  
            'submodulo_id'    => 'required|integer',
            'visibilidad'     => 'required|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del acceso es obligatorio.',
            'string'   => 'El :attribute del acceso debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'La :attribute del submódulo al que pertenece el acceso es obligatorio',
            'controlador.regex'  => 'El controlador debe cumplir con la forma: controlador@accion.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'El acceso no ha podido ser editado.')->showConfirmButton();
            Session::flash('error_message', 'El acceso no ha podido ser editado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        if(Submodulo::find($request->submodulo_id) == null){
            $errors = array('submodulo_id' => 'El submódulo ingresado no se encuentra registrado.');
            alert()->warning('Advertencia', 'El submódulo ingresado no se encuentra registrado.')->showConfirmButton();
            Session::flash('error_message', 'El acceso no ha podido ser editado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        $acceso = Acceso::findOrFail($id);
        $acces= new Acceso;
        $acces ->nombre = $request->input('nombre');
        $acces ->descripcion = $request->input('descripcion');

        if((($request->input('nombre'))=='Almacenar')||(($request->input('nombre'))=='Actualizar')
        || (($request->input('nombre'))=='Listar')||(($request->input('nombre'))=='Administrar')){
            $acces ->estado ="1";
        }
        elseif( $request->input('estado')){
            $acces ->estado = $request->input('estado');
        }
        else{
            $acces ->estado = "0";
        }

        $acces ->submodulo_id = $request->input('submodulo_id');
        $acces ->controlador = $request->input('controlador');
        $acces ->ruta_nombre = $request->input('ruta_nombre');

        if((($request->input('nombre'))=='Almacenar')||(($request->input('nombre'))=='Actualizar')
        ||(($request->input('nombre'))=='Eliminar')||(($request->input('nombre'))=='Mostrar')||
        (($request->input('nombre'))=='Listar')||(($request->input('nombre'))=='Editar')){
            $acces->visible = "0";
        }
        else{
            $acces->visible = $request->input('visibilidad');
        }        

        $datos=([
                  'nombre' => $acces->nombre,
                  'descripcion' => $acces->descripcion,
                  'estado' => $acces->estado,
                  'submodulo_id' => $acces->submodulo_id,
                  'controlador' => $acces->controlador,
                  'ruta_nombre' => $acces->ruta_nombre,
                  'visible' => $acces->visible
        ]);
        $acceso->update($datos);
        $acceso->save();

        $log = new Log([
            "registro_id"    => $acceso->id,
            "nombre_tabla"   => 'accesos',
            "accion"         => 'editar',
            "responsable_id" => Auth::user()->id,
        ]);
        $log->save();
        alert()->success('Bien', 'El acceso ha sido editado exitosamente.')->showConfirmButton();
        Session::flash('success_message', 'El acceso ha sido editado exitosamente');
        return back();
    }

    /**
     * Permite mostrar un acceso existente
     */
    public function mostrar(Acceso $acceso){
        return view(Route::currentRouteName(), ['acceso' => $acceso]);
    }

    /**
     * Permite buscar un entre los accesos existentes
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

        $accesos = Acceso::paginate();
        if($caracteristica != null && $valor != null){
            $accesos = Acceso::where([
                [
                    $caracteristica, 'like', '%' . $valor . '%'
                ]
            ])->paginate();

            if(count($accesos)){
                alert()->success('Éxito', 'Búsqueda realizada correctamente')->showConfirmButton();
                Session::flash('success_message', 'Búsqueda realizada correctamente');
            }else{
                alert()->info('Información', 'No ha habido resultado en la búsqueda.')->showConfirmButton();
                Session::flash('info_message', 'No ha habido resultado en la búsqueda.');
            }
        }

        return view('accesos.index', [
            'accesos' => $accesos,
            'caracteristica' => $caracteristica,
            'valor' => $valor
            ]);
    }

    /**
     * Permite eliminar un acceso existente
     */
    public function eliminar($id){
        $acceso = Acceso::findOrFail($id);
        //Si no se encuentan roles que hereden
        if(!count($acceso->permisos)){
            //Se elimina el acceso
            $acceso->delete();
            alert()->success('Éxito', 'Acceso eliminado exitosamente')->showConfirmButton();
            Session::flash('success_message', 'Acceso eliminado exitosamente');
            return back();
        }

        $log = new Log([
            "registro_id"    => $acceso->id,
            "nombre_tabla"   => 'accesos',
            "accion"         => 'eliminar',
            "responsable_id" => Auth::user()->id, //María Paula
        ]);
        $log->save();

        alert()->error('Error', 'El acceso no ha sido eliminado, uno o varios roles se relacionan a éste acceso. Por favor, intentálalo de nuevo.')->showConfirmButton();
        Session::flash('error_message', 'El acceso no ha sido eliminado, uno o varios roles se relacionan a éste acceso. Por favor, intentálalo de nuevo.');
        return back()
            ->withInput();
    }

    /**
     * Funcion que permite verificar que la caracteristica exista en la tabla
     */
    public function existeCaracteristica($caracteristica){
        foreach(\Schema::getColumnListing("accesos") as $columna){
            if($columna == $caracteristica)
                return true;
        }
        return false;
    }
}

