<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;
class Rol extends Model
{
    /**
     * Tabla a la que referencia el modelo
     */
    protected $table = 'roles';

    /**
     * Los atributos asignables
     *
     * @var array
     */
    protected $fillable = [
        //nombre, descripcion, estado, rol_id
        'nombre', 'descripcion', 'estado', 'rol_id'
    ];

    /**
     * Obtiene el rol del que hereda
     */
    function rolHereda(){
        return $this->hasOne('App\Models\Rol', 'rol_id');
    }

    /**
     * Pertenece al rol del que hereda
     */
    public function rol()
    {
        return $this->belongsTo('App\Models\Rol', 'rol_id');
    }

    /**
     * Se obtienen todos los permisos del rol
     */
    public function permisos()
    {
        return $this->hasMany('App\Models\Permiso');
    }

    /**
     * Permite obtener los roles de los cuales hereda
     */
    public function rolesHereda()
    {
        if($this->rol_id != null){
            return $this->rol->rolesHereda() . $this->rol_id . ",";
        }
        return "";
    }

    /**
     * Permite obtener los permisos de los roles de los cuales hereda
     */
    public function permisosHereda()
    {
        $idRoles = explode(",", $this->rolesHereda());
        
        $permisos = new Collection();
        $index = 0;
        foreach($idRoles as $idRol){
            if($idRol != "")
            {
                $rol = Rol::find($idRol);
                if(true)
                {
                    if(count($rol->permisos))
                    {
                        if($index == 0){
                            $permisos = $rol->permisos;
                            $index++;
                        }else{
                            $permisos = $permisos->merge($rol->permisos);
                        }
                    }            
                }
            }
        }
        return $permisos->unique("acceso_id")->sortBy("acceso_id");
    }

    /**
     * Permite obtener todos los permisos (heredados y propios)
     */
    public function permisosTotal()
    {        
        $permisos = $this->permisosHereda();
        if(count($permisos))
        {
            if(count($this->permisos))
            {
                return $permisos->merge($this->permisos)->unique("acceso_id")->sortBy("acceso_id");
            }
            return $permisos;
        }
        return $this->permisos->unique("acceso_id")->sortBy("acceso_id");
    }

    /**
     * Permite obtener todos los permisos (heredados y propios)
     */
    public function rolesNoHeredar()
    {        
        if(count(Rol::where("rol_id", "=", $this->id)->get())){
            $roles = ""; 
            foreach(Rol::where("rol_id", "=", $this->id)->get() as $rol){
                $roles = $roles . $rol->id . "," . $rol->rolesNoHeredar() . ",";
            }
            return $roles;
        }
        return "";
    }

    /**
     * Se obtienen los usuarios que poseen el rol
     */
    public function usuarios()
    {
        return $this->hasMany('App\Models\Usuario');     
    }

    /**
     * Se obtienen todas las rutas a las que puede accede el rol
     */
    public function accesos()
    {
        $accesos_ids = $this->permisosTotal()->map(function ($item, $key) {
            return [
                'id' => $item->acceso_id
            ];
        });
        return Acceso::whereIn('id', $accesos_ids)->orderBy('nombre')
                    ->get();
    }

    /**
     * Se obtienen todos los submodulos a las que puede acceder el rol
     */
    public function submodulos()
    {
        $submodulos_id = $this->accesos()->map(function ($item, $key) {
            return [
                'id' => $item->submodulo_id
            ];
        });

        return Submodulo::whereIn('id', $submodulos_id)->orderBy('nombre')
                    ->get();
    }

    /**
     * Se obtienen todas los modulos a las que puede accede el rol
     */
    public function modulos()
    {
        $modulos_id = $this->submodulos()->map(function ($item, $key) {
            return [
                'modulo_id' => $item->modulo_id
            ];
        });

        return Modulo::whereIn('id', $modulos_id)->orderBy('nombre')
                    ->get();
    }

    /**
     * Prueba
     */
    public function prueba()
    {
        $submodulos_id = $this->accesos()->map(function ($item, $key) {
            return [
                $item->submodulo_id
            ];
        });

        return $submodulos_id;
        return Submodulo::whereIn('id', $submodulos_id)
                    ->get();
    }
}
