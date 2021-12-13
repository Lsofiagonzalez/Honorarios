<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::middleware('auth')->group(function ()
{
        Route::get('/','HomeController@index')->name('principal');
        Route::get('/dashboard','DashboardController@index')->name('dashboard');
        Route::post('/modificarAdm','AuxiliarController@modificarAdm')->name('modificarAdm');
        Route::get('/editar-estado/{honorario}','AuxiliarController@editarEstado')->name('editar-estado');
        Route::post('/actualizar','AuxiliarController@update')->name('update');

        Route::prefix('sistema')->group(function () {
        Route::name('sistema.')->group(function () {
          Route::get('/error-permiso','SistemaController@errorPermiso')->name('error-permiso');
          });
        });

        Route::middleware('permisos')->group(function ()
        {
              Route::prefix('modulos')->group(function () {
                  Route::name('modulos.')->group(function () {
                      Route::get('/', 'ModuloController@index')->name('index');
                      Route::get('crear', 'ModuloController@crear')->name('crear');
                      Route::post('/', 'ModuloController@almacenar')->name('almacenar');
                      Route::get('/{modulo}', 'ModuloController@mostrar')->name('mostrar');
                      Route::get('/{modulo}/editar', 'ModuloController@editar')->name('editar');
                      Route::post('/{id}', 'ModuloController@actualizar')->name('actualizar');
                      Route::get('/buscar/caracteristica', 'ModuloController@buscar')->name('buscar');
                      Route::delete('/{id}', 'ModuloController@eliminar')->name('eliminar');
                  });
              });

              Route::prefix('submodulos')->group(function () {
                Route::name('submodulos.')->group(function () {
                  Route::get('/', 'SubmoduloController@index')->name('index');
                  Route::get('crear', 'SubmoduloController@crear')->name('crear');
                  Route::post('/', 'SubmoduloController@almacenar')->name('almacenar');
                  Route::get('/{submodulo}', 'SubmoduloController@mostrar')->name('mostrar');
                  Route::get('/{submodulo}/editar', 'SubmoduloController@editar')->name('editar');
                  Route::post('/{id}', 'SubmoduloController@actualizar')->name('actualizar');
                  Route::get('/buscar/caracteristica', 'SubmoduloController@buscar')->name('buscar');
                  Route::delete('/{id}', 'SubmoduloController@eliminar')->name('eliminar');
                });
              });

              Route::prefix('accesos')->group(function () {
                Route::name('accesos.')->group(function () {
                  Route::get('/', 'AccesoController@index')->name('index');
                  Route::get('crear', 'AccesoController@crear')->name('crear');
                  Route::post('/', 'AccesoController@almacenar')->name('almacenar');
                  Route::get('/{acceso}', 'AccesoController@mostrar')->name('mostrar');
                  Route::get('/{acceso}/editar', 'AccesoController@editar')->name('editar');
                  Route::post('/{id}', 'AccesoController@actualizar')->name('actualizar');
                  Route::get('/buscar/caracteristica', 'AccesoController@buscar')->name('buscar');
                  Route::delete('/{id}','AccesoController@eliminar')->name('eliminar');
                });
              });

              Route::prefix('roles')->group(function () {
                Route::name('roles.')->group(function () {
                  Route::get('/', 'RolController@index')->name('index');
                  Route::get('crear', 'RolController@crear')->name('crear');
                  Route::post('/', 'RolController@almacenar')->name('almacenar');
                  Route::get('/{rol}', 'RolController@mostrar')->name('mostrar');
                  Route::get('/{rol}/editar', 'RolController@editar')->name('editar');
                  Route::post('/{id}', 'RolController@actualizar')->name('actualizar');
                  Route::get('/buscar/caracteristica', 'RolController@buscar')->name('buscar');
                  Route::delete('/{id}', 'RolController@eliminar')->name('eliminar');
                });
              });

              Route::prefix('permisos')->group(function () {
                Route::name('permisos.')->group(function () {
                  Route::get('/rol/{rol}/administrar', 'PermisoController@administrar')->name('administrar');
                  Route::post('/rol/{rol}', 'PermisoController@actualizar')->name('actualizar');
                  Route::post('guardarpermiso', 'PermisoController@guardarpermiso')->name('guardarpermiso');
                  Route::get('/{id?}/permisosmatriz', 'PermisoController@permisosmatriz')->name('permisosmatriz');
                  Route::post('/guardarmatriz', 'PermisoController@guardarmatriz')->name('guardarmatriz');
          
                });
              });

              Route::prefix('logs')->group(function () {
                Route::name('logs.')->group(function () {
                  Route::get('/', 'LogController@index')->name('index');
                  Route::post('/buscar/caracteristica', 'LogController@buscar')->name('buscar');
                  Route::post('/mostrar', 'LogController@mostrar')->name('mostrar');
                });
              });

              Route::prefix('usuarios')->group(function () {
                Route::name('usuarios.')->group(function () {
                  Route::get('/index', 'UsuarioController@index')->name('index');
                  Route::get('ver', 'UsuarioController@ver')->name('ver');
                  Route::post('validar', 'UsuarioController@validar')->name('validar'); 
                  Route::get('crear/usuario', 'UsuarioController@crear')->name('crear');
                  Route::post('/', 'UsuarioController@cargar')->name('cargar');
                  Route::post('registrar/usuario', 'UsuarioController@registrar')->name('registrar');
                  Route::get('/{usuario}/editar', 'UsuarioController@editar')->name('editar');
                  Route::post('/{id}', 'UsuarioController@actualizar')->name('actualizar');
                  Route::post('/actualizar-rol/{usuario}','UsuarioController@actualizarRol')->name('actualizar-rol');
                  // Route::get('editar')
                  Route::post('editar/roles/usuario', 'UsuarioController@editaRol')->name('editaRol');
                  //Route::get('/{cod}', 'UsuarioController@cargar')->name('cargar');
                  //Route::post('/', 'UsuarioController@almacenar')->name('almacenar');
                  Route::get('/{usuario}', 'UsuarioController@mostrar')->name('mostrar');
                  Route::get('/asociar/usuarios/otros/sistemas', 'UsuarioController@otrosUsuarios')->name('otrosUsuarios');
                  Route::post('/asociar/usuarios/otros/sistemas', 'UsuarioController@guardarOtrosUsuarios')->name('guardarOtrosUsuarios');
                  Route::get('/buscar/caracteristica', 'UsuarioController@buscar')->name('buscar');
                  Route::get('/ver/informes/control/usuarios', 'UsuarioController@informes')->name('informes');
                  Route::get('/ver/formato/control/usuarios/enlinea', 'UsuarioController@controlUsuarios')->name('controlUsuarios');
                  Route::get('/ver/formato/control/usuarios/descargar', 'UsuarioController@controlUExcel')->name('controlUExcel');
                  Route::get('/ver/informes/control/usuarios/enlinea', 'UsuarioController@informeControl')->name('informeControl');
                  Route::get('/ver/informes/control/usuarios/descargar', 'UsuarioController@InformeControlExcel')->name('InformeControlExcel');
                  Route::get('/ver/informes/usuario/equipos/enlinea', 'UsuarioController@informeUsuarioEquipo')->name('informeUsuarioEquipo');
                  Route::get('/ver/informes/usuario/equipos/descargar', 'UsuarioController@informeUEPdf')->name('informeUEPdf');
                  Route::delete('/{usuario}', 'UsuarioController@eliminar')->name('eliminar');
                });
              });


              Route::prefix('auditores')->group(function () {
                Route::name('auditores.')->group(function () {
                  Route::get('/','AuditorController@index')->name('index');
                  Route::post('consultar-medico','AuditorController@consultar')->name('consultar');
                });
              });
      
              Route::prefix('auxiliares')->group(function () {
                Route::name('auxiliares.')->group(function () {
                  Route::get('/','AuxiliarController@create')->name('create');
                  Route::get('/listar-boletas-realizadas','AuxiliarController@listarBoletas')->name('listar-boletas-realizadas');
                  Route::get('/ver-pdf/{boleta}','BoletaController@verPDF')->name('boleta-pdf');
                  Route::get('/descargar-pdf/{boleta}','BoletaController@descargarPDF')->name('descargar-boleta-pdf');
                  Route::post('/consultar','AuxiliarController@consultar')->name('consultar');
                  Route::post('/visualizar-boleta','AuxiliarController@visualizarBoleta')->name('visualizar-boleta');
                  Route::post('/modificar-datos','AuxiliarController@modificarBoleta')->name('modificar-datos');
                  Route::post('/descargar','AuxiliarController@generarBoleta')->name('generar-boleta');
                  
                });
              });
      
              Route::prefix('medicos')->group(function () {
                Route::name('medicos.')->group(function () {
                    Route::post('/visualizar-pago','MedicoConsultaController@visualizarSeleccionPago')->name('visualizar-pago');
                    Route::get('/formulario', 'MedicoConsultaController@verFormulario')->name('formulario');
                    Route::get('/mis-boletas', 'MedicoConsultaController@listarBoletas')->name('listar-boletas');
                    Route::get('/mis-soportes', 'MedicoConsultaController@listarSoportes')->name('listar-soportes');
                    Route::get('/ver-pdf/{soporte}','SoportePagoController@verPDF')->name('soporte-pdf');
                    Route::get('/editar-soporte/{soporte}','SoportePagoController@editar')
                          ->name('editar-soporte')
                          ->middleware('openSystem');;
                    Route::post('/modificar-datos','MedicoConsultaController@modificarDatosSoporte')->name('modificar-datos');
                    Route::post('confirmar-actualizacion/{soporte}','SoportePagoController@confirmarActualizacion')->name('confirmar-soporte');
                    Route::post('actualizar-soporte/{soporte}','SoportePagoController@actualizarSoporte')->name('actualizar-soporte');
                    Route::get('/descargar-pdf/{soporte}','SoportePagoController@descargarPDF')->name('descargar-soporte-pdf');
                    Route::post('/consultar','MedicoConsultaController@consultar')
                    ->name('consultar')
                    ->middleware('openSystem');
                    Route::post('/descargar','MedicoConsultaController@generarSoporte')->name('generar-soporte');
                });
            });
      
            Route::prefix('sistema')->group(function () {
              Route::name('sistema.')->group(function () {
                Route::get('/','SistemaController@verConfiguracion')->name('ver');
                Route::post('/definir-mes-anterior','SistemaController@definirMesAnterior')->name('definir-mes-anterior');
                Route::post('/definir-mes-siguiente','SistemaController@definirMesSiguiente')->name('definir-mes-siguiente');
                Route::post('/cerrar-sistema','SistemaController@cerrarSistema')->name('cerrar');
                Route::post('/abrir-sistema','SistemaController@abrirSistema')->name('abrir');
                Route::post('/definir-dias-habiles','SistemaController@definirDiasHabiles')->name('definir-dias-habiles');
              });
            });
      
      
            Route::prefix('ambito')->group(function () {
              Route::name('ambito.')->group(function () {
                Route::get('/','AmbitoController@index')->name('listar');
                Route::post('/cambiar-estado/{ambito}','AmbitoController@cambiarEstado')->name('cambiar-estado');
              });
            });
              
        });

        

      
      
                  // Route::get('editar')

    });


Auth::routes(['register' => false]);

Route::prefix('app')->group(function () {
  Route::name('app.')->group(function () {
  Route::post('login',[App\Http\Controllers\Auth\LoginAppController::class, 'authenticate'])->name('login');
  
  });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
