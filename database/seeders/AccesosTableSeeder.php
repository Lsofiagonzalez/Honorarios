<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class AccesosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //nombre, descripcion, estado, submodulo_id, controlador, ruta_nombre, created_at, updated_at
        //DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Dashboard',    'Permite observar la página principal.', 1, 'HomeController@index', 'dashboard', 1, GETDATE(), GETDATE())");

        //MODULOS
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Crear',        'Permite crear  un nuevo módulo en el sistema.', 1,      'ModuloController@crear',      'modulos.crear', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Mostrar',      'Permite mostrar un nuevo módulo en el sistema.', 1,      'ModuloController@mostrar',    'modulos.mostrar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Almacenar',    'Permite almacenar  un nuevo módulo en el sistema.', 1,  'ModuloController@almacenar',  'modulos.almacenar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Editar',       'Permite editar un módulo en el sistema.', 1,            'ModuloController@editar',     'modulos.editar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Actualizar',   'Permite actualizar un módulo en el sistema.', 1,        'ModuloController@actualizar', 'modulos.actualizar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Buscar',       'Permite buscar módulos en el sistema.', 1,              'ModuloController@buscar',      'modulos.buscar', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Eliminar',     'Permite eliminar un módulo en el sistema.', 1,          'ModuloController@eliminar',   'modulos.eliminar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Listar',       'Permite listar los módulos en el sistema.', 1,          'ModuloController@index',      'modulos.index', 1, GETDATE(), GETDATE())");
        //SUBMODULOS
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Crear',        'Permite crear  un nuevo submódulo en el sistema.', 2,      'SubmoduloController@crear',      'submodulos.crear', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Mostrar',      'Permite mostrar un nuevo submódulo en el sistema.', 2,    'SubmoduloController@mostrar',    'submodulos.mostrar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Almacenar',    'Permite almacenar  un nuevo submódulo en el sistema.', 2,  'SubmoduloController@almacenar',  'submodulos.almacenar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Editar',       'Permite editar un submódulo en el sistema.', 2,            'SubmoduloController@editar',     'submodulos.editar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Actualizar',   'Permite actualizar un submódulo en el sistema.', 2,        'SubmoduloController@actualizar', 'submodulos.actualizar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Buscar',       'Permite buscar submódulos en el sistema.', 2,              'SubmoduloController@buscar',     'submodulos.buscar', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Eliminar',     'Permite eliminar un submódulo en el sistema.', 2,          'SubmoduloController@eliminar',   'submodulos.eliminar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Listar',       'Permite listar los submódulos en el sistema.', 2,          'SubmoduloController@index',      'submodulos.index', 1, GETDATE(), GETDATE())");
        //ACCESO
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Crear',        'Permite crear  un nuevo acceso en el sistema.', 3,      'AccesoController@crear',      'accesos.crear', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Mostrar'  ,    'Permite mostrar  un nuevo acceso en el sistema.', 3,    'AccesoController@mostrar',  'accesos.mostrar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Almacenar',    'Permite almacenar  un nuevo acceso en el sistema.', 3,  'AccesoController@almacenar',  'accesos.almacenar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Editar',       'Permite editar un acceso en el sistema.', 3,            'AccesoController@editar',     'accesos.editar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Actualizar',   'Permite actualizar un acceso en el sistema.', 3,        'AccesoController@actualizar', 'accesos.actualizar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Buscar',       'Permite buscar accesos en el sistema.', 3,              'AccesoController@buscar',      'accesos.buscar', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Eliminar',     'Permite eliminar un acceso en el sistema.', 3,          'AccesoController@eliminar',   'accesos.eliminar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Listar',       'Permite listar los accesos en el sistema.', 3,          'AccesoController@index',      'accesos.index', 1, GETDATE(), GETDATE())");
        //ROLES
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Crear',        'Permite crear un nuevo rol en el sistema.', 4,      'RolController@crear',      'roles.crear', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Mostrar',      'Permite mostrar un nuevo rol en el sistema.', 4,  'RolController@mostrar',    'roles.mostrar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Almacenar',    'Permite almacenar un nuevo rol en el sistema.', 4,  'RolController@almacenar',  'roles.almacenar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Editar',       'Permite editar un rol en el sistema.', 4,            'RolController@editar',    'roles.editar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Actualizar',   'Permite actualizar un rol en el sistema.', 4,        'RolController@actualizar','roles.actualizar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Buscar',       'Permite buscar roles en el sistema.', 4,             'RolController@buscar',     'roles.buscar', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Eliminar',     'Permite eliminar un rol en el sistema.', 4,          'RolController@eliminar',  'roles.eliminar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Listar',       'Permite listar los roles en el sistema.', 4,         'RolController@index',     'roles.index', 1, GETDATE(), GETDATE())");
        //PERMISOS
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Administrar',   'Permite administrar los permisos de un rol determinado en el sistema.', 5, 'PermisoController@administrar', 'permisos.administrar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Actualizar',    'Permite actualizar los permisos de un rol determinado en el sistema.', 5,  'PermisoController@actualizar',  'permisos.actualizar', 0, GETDATE(), GETDATE())");
        //USUARIOS
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Crear',        'Permite crear un nuevo usuario en el sistema.', 6,      'UsuarioController@crear',      'usuarios.crear', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Mostrar',      'Permite mostrar un nuevo usuario en el sistema.',6,      'UsuarioController@mostrar',    'usuarios.mostrar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Almacenar',    'Permite almacenar un nuevo usuario en el sistema.',6,   'UsuarioController@almacenar',  'usuarios.almacenar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Editar',       'Permite editar un usuario en el sistema.', 6,           'UsuarioController@editar',     'usuarios.editar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Actualizar',   'Permite actualizar un usuario en el sistema.', 6,       'UsuarioController@actualizar', 'usuarios.actualizar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Buscar',       'Permite buscar usuarios en el sistema.', 6,             'UsuarioController@buscar',      'usuarios.buscar', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Eliminar',     'Permite eliminar un usuario en el sistema.', 6,         'UsuarioController@eliminar',   'usuarios.eliminar', 0, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Listar',       'Permite listar los usuarios en el sistema.', 6,         'UsuarioController@index',      'usuarios.index', 1, GETDATE(), GETDATE())");
        //LOGS
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Buscar',       'Permite buscar logs en el sistema.', 7,                 'LogController@index',  'logs.buscar', 1, GETDATE(), GETDATE())");
        DB::insert("INSERT INTO accesos (nombre, descripcion, submodulo_id, controlador, ruta_nombre, visible, created_at, updated_at) VALUES ('Listar',       'Permite listar los usuarios en el sistema.', 7,         'LogController@index',  'logs.index', 1, GETDATE(), GETDATE())");
    }
}
