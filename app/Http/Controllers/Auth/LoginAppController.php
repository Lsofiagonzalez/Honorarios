<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Esalud\UsuarioES;
use App\Models\Usuario_GD;
use App\Models\User;
use App\Models\LogActividad;
use Illuminate\Support\Facades\Auth;


class LoginAppController extends Controller
{

    /**
     * 
     */
    public function authenticate(Request $request)
    {
        $username = $request->nombre_usuario;
        $password = $request->password;

        /**
         * Se intenta autenticar el usuario en Gestión Documental.
         */
        $usuario_GD = Usuario_GD::where('LOGUSU',$username)->first();

        
        if ($usuario_GD) 
        {
            $usuario = $this->verificarUsuarioGD($usuario_GD,$password);
            if($usuario)
            {
                Auth::login($usuario);

                /**
                 * Se crea el log de inicio de sesión.
                 */
                $logActividad = new LogActividad();
                $logActividad->actividad = 'Inicio de sesión en el aplicativo.';
                $logActividad->usuario_id = Auth::user()->id;
                $logActividad->save();
                ////////////////////////////////////////////////////////////////////

                return redirect()->route('dashboard');
            }
        }
        else
        {
            /**
             * Se intenta autenticar el usuario ESALUD.
             */
            $usuarioEsalud = UsuarioES::where('ID_USR',$username)->first();
            if ($usuarioEsalud) 
            {
                $usuario = $this->verificarUsuarioES($usuarioEsalud,$password);
                if($usuario)
                {
                    Auth::login($usuario);
                    
                    /**
                    * Se crea el log de inicio de sesión.
                    */
                    $logActividad = new LogActividad();
                    $logActividad->actividad = 'Inicio de sesión en el aplicativo.';
                    $logActividad->usuario_id = Auth::user()->id;
                    $logActividad->save();
                    ////////////////////////////////////////////////////////////////////
                    
                    
                    return redirect()->route('dashboard');
                }
            }
        }

        return back()->withErrors([
            'nombre_usuario' => 'Las credenciales no coinciden, por favor verifica el usuario y la constraseña.',
        ]);
    }

    /**
     * Autenticar al usuario con el login de Gestión Documental.
     * @param $usuario_GD Es el usuario de Gestión Documental que se desea autenticar.
     * @param $password Es la contraseña digitada por el usuario en el formulario.
     */
    public function verificarUsuarioGD($usuario_GD,$password)
    {
        if ($usuario_GD->PASUSU==md5($password)) 
        {
            $usuario = User::where('nombre_usuario',$usuario_GD->LOGUSU)->first();
            if($usuario)
            {
                /**
                 * Se autentica y se direcciona al dashboard.
                 */
                return $usuario;
                // Auth::login($usuario);
                // return redirect()->route('dashboard');
            }
            else
            {
                /**
                 * Se crea el usuario en el sistema de honorarios.
                 * Se envía el 6 indicando que tendra el rol de usuario genérico.
                 */
                return $this->crearUsuario($usuario_GD->IDUSUA,6,$usuario_GD->LOGUSU,$password);
                
            }
        } 
        else 
        {
            /**
             * Se retorna null en caso de que las credenciales sean incorrectas.
             */
            return null;
        }
        
    }

    /**
     * Autenticar al usuario con el login de ESALUD.
     * @param $usuarioEsalud Es el usuario de esalud que se desea autenticar.
     * @param $password Es la contraseña digitada por el usuario en el formulario.
     */
    public function verificarUsuarioES($usuarioEsalud,$password)
    {
        /**
         * Se validan las credenciales del usuario que se quiere autenticar
         */
        if($usuarioEsalud->PASW_USR==$password)
        {
            /**
             * Se valida si el usuario tiene cuenta en la aplicación de Honorarios. 
             */
            $usuario = User::where('nombre_usuario',$usuarioEsalud->ID_USR)->first();
            if($usuario)
            {
                
                return $usuario;
                // Auth::login($usuario);
                // return redirect()->intended('dashboard');
            }
            else
            {
                /**
                 * Se crea el usuario en el sistema.
                 * Se envía el -1 indicando que el usuario no tiene usuario en Gestión Documental.
                 * Se envía el 3 indicando que el usuario tendrá el rol de médico.
                 */
               return $this->crearUsuario(-1,3,$usuarioEsalud->ID_USR,$password);
              
            }
        }
        else
        {
            /**
             * Se retorna null en caso de que las credenciales sean incorrectas.
             */
            return null; 
        }


    }


    /**
     * Crear usuarios en la tabla usuariosAPP
     * @param $gestion_id
     * @param $rol_id
     * @param $nombre_usuario
     * @param $password
     */
    public function crearUsuario($gestion_id,$rol_id,$nombre_usuario,$password)
    {
        $usuarioNuevo = new User();
        $usuarioNuevo->GD_id = $gestion_id;
        $usuarioNuevo->rol_id = $rol_id;
        $usuarioNuevo->nombre_usuario = $nombre_usuario;
        $usuarioNuevo->password = md5($password);
        $usuarioNuevo->estado = 1;



        /**
         * Se verfica que el usuario creado pertenezca a Gestión Documental.
         */
        if($rol_id!=3)
        {
            $usuarioNuevo->save(); 
        }

        /**
        * Se verifica que el médico trabaje por honorarios.
        */
        if($usuarioNuevo->medicoHonorario())
        {
            /**
             * Se crea el usuario en la base de datos en la tabla usuariosAPP
             */
            $usuarioNuevo->save();  

        }
        return User::where('nombre_usuario',$nombre_usuario)->first();
    }
}
