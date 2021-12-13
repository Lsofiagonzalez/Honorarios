<?php

namespace App\Http\Controllers;

//////////////////////////////////
//MODELOS
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\Acceso;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\Log;
use App\Models\controlUsuarios;
use App\Models\matrizPermisos;

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

class PermisoController extends Controller
{
    /**
     * Permite mostrar la vista para poder administrar los roles
     * y permisos
     */
    public function administrar(Rol $rol){
        return view(Route::currentRouteName(), ['rol' => $rol,
                                                'accesos' => Acceso::select('accesos.*', 'submodulos.modulo_id')->join('submodulos', 'submodulos.id', '=', 'accesos.submodulo_id')->orderBy('modulo_id', 'ASC')->orderBy('submodulo_id', 'ASC')->paginate()]);
    }

    /**
     * Pemrmite actualizar los permisos para cada usuario
     */
    public function actualizar(Request $request, Rol $rol){
        //revisar variable
        $rules = [
            'accesos'   => 'nullable|array'
        ];

        $messages = array(
            'accesos.array' => 'Los accesos deben ser un arreglo.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            $errors = $validator->errors();
            alert()->warning('Advertencia', ($errors->all())[0])->showConfirmButton();
            Session::flash('error_message', 'Ha ocurrido un error en la actualización de permisos.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }

        //Si el arreglo llega vacío significa que no hay permisos para agregar
        //Y que si existen anteriormente se deben eliminar
        if($request->accesos == null){
            foreach($rol->permisos as $permiso){
                $this->eliminar($permiso->id);
            }

            alert()->success('Éxito', 'Permisos editados exitosamente.')->showConfirmButton();
            Session::flash('success_message', 'Permisos editados exitosamente.');
            return back();
        }


        //Si en los accesos no están los permisos anteriores, se eliminan
        foreach($rol->permisos as $permiso){
            if(!in_array($permiso->acceso_id, $request->accesos)){
                $this->eliminar($permiso->id);
            }
        }

        //Si no existe en los permisos actuales, hay que agregarlo
        foreach($request->accesos as $acceso_id){
            if(!count($rol->permisos->where('acceso_id', '=', $acceso_id))){
                //Se verifica que exis  ta el acceso en la DB
                if(Acceso::find($acceso_id) == null){
                    alert()->error('Error', 'Uno de los accesos seleccionados no fue encontrado.')->showConfirmButton();
                    Session::flash('error_message', 'Uno de los accesos seleccionados no fue encontrado. Por favor, intentalo de nuevo.');
                    return back()
                        ->withInput();
                }

                $permiso = new Permiso();
                $permiso->rol_id = $rol->id;
                $permiso->acceso_id = $acceso_id;
                $permiso->save();

                $log = new Log([
                    "registro_id"    => $permiso->id,
                    "nombre_tabla"   => 'permisos',
                    "accion"         => 'actualizar',
                    "responsable_id" => Auth::user()->id, //María Paula
                ]);
                $log->save();
            }
        }

        alert()->success('Éxito', 'Permisos editados exitosamente')->showConfirmButton();
        Session::flash('success_message', 'Permisos editados exitosamente.');
        return back();
    }

    /**
     * Permite buscar un entre los permisos existentes
     */
    public function buscar(Rol $rol){
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

        $accesos = Acceso::orderBy('submodulo_id')->get();
        if($caracteristica != null && $valor != null){
            $accesos = Acceso::where([
                [
                    $caracteristica, 'like', '%' . $valor . '%'
                ]
            ])->orderBy('submodulo_id')->get();

            if(count($accesos)){
                alert()->success('Éxito', 'Búsqueda realizada correctamente')->showConfirmButton();
                Session::flash('success_message', 'Búsqueda realizada correctamente');
            }else{
                alert()->info('Información', 'No ha habido resultado en la búsqueda.')->showConfirmButton();
                Session::flash('info_message', 'No ha habido resultado en la búsqueda.');
            }
        }

        return view('permisos.administrar', [
            'accesos' => $accesos,
            'caracteristica' => $caracteristica,
            'valor' => $valor,
            'rol' => $rol
            ]);
    }

    /**
     * Permite eliminar un permiso existente
     */
    public function eliminar($id){
        $permiso = Permiso::findOrFail($id);

        $log = new Log([
            "registro_id"    => $permiso->id,
            "nombre_tabla"   => 'permisos',
            "accion"         => 'eliminar',
            "responsable_id" => Auth::user()->id, //María Paula
        ]);
        $log->save();

        $permiso->delete();
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

    public function  guardarpermiso(Request $request)
    {
      $permiso = new controlUsuarios($request->all());
      if (!isset($request->accesoGD))
      {
        $permiso->accesoGD=0;
      }
      if(!isset($request->accesoCirugia))
      {
        $permiso->accesoCirugia=0;
      }
      if(!isset($request->accesoIntranet))
      {
        $permiso->accesoIntranet =0;
      }
      if(!isset($request->accesoReportes))
      {
        $permiso->accesoReportes =0;
      }
      if(!isset($request->accesoSIV))
      {
        $permiso->accesoSIV =0;
      }
      if(!isset($request->accesoVehiculos))
      {
        $permiso->accesoVehiculos =0;
      }
      if(!isset($request->accesoMtoSis))
      {
        $permiso->accesoMtoSis =0;
      }
      if(!isset($request->accesoKsar))
      {
        $permiso->accesoKsar = 0;
      }
      if(!isset($request->accesoCenso))
      {
        $permiso->accesoCenso =0;
      }
      if(!isset($request->accesoAccionS))
      {
        $permiso->accesoAccionS = 0;
      }
      $permiso->save();
      return back();
  }

  public function permisosmatriz($id)
  {
    return view('permisos.matriz',compact('id'));
  }

  public function guardarmatriz(Request $request)
  {
    $matriz = new matrizPermisos($request->all());
    $matriz->save();
    return back();
  }

}
