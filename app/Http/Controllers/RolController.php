<?php

namespace App\Http\Controllers;

//////////////////////////////////
//MODELOS
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Rol;
use App\Models\Log;
use App\Models\Usuario;

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

use RealRashid\SweetAlert\Facades\Alert;

class RolController extends Controller
{
    /**
     * Permite listar todos los elementos en la tabla
     * roles
     */
    public function index(){
        return view(Route::currentRouteName(), ['roles' => 
                                                Rol::paginate()
                                                ]);

        /*
        Rol::select('roles.*', 'rol_padre.nombre AS rol_padre_nombre')
        ->join('roles AS rol_padre', 'rol_padre.id', '=', 'roles.rol_id')
        ->get()
        */
    }

    /**
     * Permite crear un núevo rol
     */
    public function crear(){
        return view(Route::currentRouteName(), ['ruta' => 'roles.almacenar']);
    }

    /**
     * Permite almacenar un núevo rol
     */
    public function almacenar(Request $request){
        
        $rules = [
            'nombre'   => 'required|string|max:50',
            'descripcion'  => 'required|string',
            'rol_id'    => 'nullable|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del rol es obligatorio.',
            'string'   => 'El :attribute del rol debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'El :attribute del rol que genera la herencia es obligatorio.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'Algunos campos son obligatorios')->showConfirmButton();
            Session::flash('error_message', 'El rol no ha podido ser creado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        if($request->has('rol_id') && $request->input('rol_id') != ""){
            if(Rol::find($request->rol_id) == null){
                $errors = array('rol_id' => 'El rol ingresado no es válido.');
                alert()->warning('Advertencia', 'El rol no ha podido ser creado.')->showConfirmButton();
                Session::flash('error_message', 'El rol no ha podido ser creado.');
                return back()
                    ->withErrors($errors)
                    ->withInput();
            }
        }

        $rol = new Rol($request->all());
        $rol->estado = 1;
        $rol->save();

        $log = new Log([
            "registro_id"    => $rol->id,
            "nombre_tabla"   => 'roles',
            "accion"         => 'crear',
            "responsable_id" => Auth::user()->id, 
        ]);
        $log->save();

        alert()->success('Éxito', 'Rol creado exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Rol creado exitosamente');
        return back();
    }

    /**
     * Permite editar un rol existente
     */
    public function editar(Rol $rol){
        if($rol->rolesNoHeredar() == ""){
            $rolesHeredar = Rol::where("id", "!=", $rol->id)->get();
        }else{
            $arrayNoHeredar = array_filter(array_unique(explode(',', $rol->rolesNoHeredar())));

            $rolesHeredar = Rol::where("id", "!=", $rol->id)
            ->where(function($query) use($arrayNoHeredar){
                foreach($arrayNoHeredar as $rolNoHeredar){
                    $query->where("id", "!=", $rolNoHeredar);
                }
            })->get();
        }
       
        return view(Route::currentRouteName(),[
            'rol' => $rol,
            'ruta' => 'roles.actualizar',
            'rolesHeredar' => $rolesHeredar
        ]);
    }

    /**
     * Permite actualizar un rol existente
     */
    public function actualizar(Request $request, $id){
        $rules = [
            'nombre'   => 'required|string|max:20',
            'descripcion'  => 'required|string',
            'rol_id'    => 'nullable|integer'
        ];

        $messages = array(
            'required' => 'El :attribute del rol es obligatorio.',
            'string'   => 'El :attribute del rol debe ser una cadena de texto.',
            'max'      => 'El :attribute debe contener menos de :max letras.',
            'integer'  => 'La :attribute del rol que genera la herencia es obligatorio.',
        );
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', 'El rol no ha podido ser editado.')->showConfirmButton();
            Session::flash('error_message', 'El rol no ha podido ser editado.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        if(!($request->estado == 0 || $request->estado == 1)){
            $errors = array('estado' => 'El estado ingresado es inválido.');
            alert()->warning('Advertencia', 'El rol no ha podido ser editado.')->showConfirmButton();
            Session::flash('error_message', 'El estado ingresado es inválido.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        if($request->has('rol_id') && $request->input('rol_id') != ""){
            if(Rol::find($request->rol_id) == null){
                $errors = array('rol_id' => 'El rol ingresado no es válido.');
                alert()->warning('Advertencia', 'El rol no ha podido ser editado.')->showConfirmButton();
                Session::flash('error_message', 'El rol ingresado no es válido.');
                return back()
                    ->withErrors($errors)
                    ->withInput();
            }
        }

        $rol = Rol::findOrFail($id);
        $rol->update($request->all());

        if($request->estado == 0 && count($rol->usuarios)>0 ){
            alert()->error('Error', 'El rol no se puede inactivar, existen uno o varios usuarios asociados a él.')->showConfirmButton();
            Session::flash('error_message', 'El rol no se puede inactivar, existen uno o varios usuarios asociados a él.');
            return back()
                ->withInput(); 
        }
        else{
            if($request->has('estado')){
                $rol->estado = 1;
            }else{
                $rol->estado = 0;
            }
            $rol->save();
            $log = new Log([
                "registro_id"    => $rol->id,
                "nombre_tabla"   => 'roles',
                "accion"         => 'editar',
                "responsable_id" => Auth::user()->id, 
            ]);
            $log->save();

            alert()->success('Éxito', 'Rol editado exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Rol editado exitosamente');
        return back();            
        }
    }

    /**
     * Permite mostrar un rol existente
     */
    public function mostrar(Rol $rol){
        return view(Route::currentRouteName(), ['rol' => $rol]);
    }

    /**
     * Permite buscar un rol entre los roles existentes
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

        $roles = Rol::paginate();
        if($caracteristica != null && $valor != null){

            if($valor == "null")
            {
                $roles = Rol::whereNull('rol_id')->get();
            }else{
                $roles = Rol::where([
                    [
                        $caracteristica, 'like', '%' . $valor . '%'
                    ]
                ])->paginate();
            }

            if(count($roles)){
                alert()->success('Éxito', 'Búsqueda realizada correctamente')->showConfirmButton();
                Session::flash('success_message', 'Búsqueda realizada correctamente');
            }else{
                alert()->info('Información', 'No ha habido resultado en la búsqueda.')->showConfirmButton();
                Session::flash('info_message', 'No ha habido resultado en la búsqueda.');
            }
        }

        return view('roles.index', [
            'roles' => $roles,
            'caracteristica' => $caracteristica,
            'valor' => $valor
            ]);
    }

    /**
     * Permite eliminar un rol existente
     */
    public function eliminar($id){
        //Si no se encuentan roles que hereden
        if((Rol::where("rol_id", "=", $id)->first())==null){
            //Si no hay usuarios con el rol
            $rol = Rol::findOrFail($id);
            if(count($rol->usuarios)==0){
                //Se eliminan los permisos relacionados al rol
                foreach($rol->permisos as $permiso){
                    $log = new Log([
                        "registro_id"    => $permiso->id,
                        "nombre_tabla"   => 'permisos',
                        "accion"         => 'eliminar',
                        "responsable_id" => Auth::user()->id, 
                    ]);
                    $log->save();

                    $permiso->delete();
                }

                $log = new Log([
                    "registro_id"    => $rol->id,
                    "nombre_tabla"   => 'roles',
                    "accion"         => 'eliminar',
                    "responsable_id" => Auth::user()->id, 
                ]);
                $log->save(); 
                
                //Se elimina el rol
                $rol->delete();
                alert()->success('Éxito', 'Rol eliminado exitosamente')->showConfirmButton();
                Session::flash('success_message', 'Rol eliminado exitosamente');
                return back();
            }
            alert()->error('Error', 'El rol no ha sido eliminado, existe uno o varios usuarios que tiene asignado el rol. Por favor, intentálalo de nuevo.')->showConfirmButton();
            Session::flash('error_message', 'El rol no ha sido eliminado, existe uno o varios usuarios que tiene asignado el rol');
            return back()
                ->withInput();
        }
        alert()->error('Error', 'El rol no ha sido eliminado, existe otro rol que hereda del mismo. Por favor, intentálalo de nuevo.')->showConfirmButton();
        Session::flash('error_message', 'El rol no ha sido eliminado, existe otro rol que hereda del mismo. Por favor, intentálalo de nuevo.');
        return back()
            ->withInput();
    }

    /**
     * Funcion que permite verificar que la caracteristica exista en la tabla
     */
    public function existeCaracteristica($caracteristica){
        foreach(\Schema::getColumnListing("roles") as $columna){
            if($columna == $caracteristica)
                return true;
        }
        return false;
    }
}
