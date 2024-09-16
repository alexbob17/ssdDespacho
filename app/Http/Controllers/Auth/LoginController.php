<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Donde redirigir a los usuarios después de iniciar sesión.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crear una nueva instancia del controlador de autenticación.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Mostrar el formulario de inicio de sesión.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Manejar una solicitud de inicio de sesión del usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    // Intentar autenticar al usuario
    if (Auth::attempt($credentials)) {
        // Redirigir a la página deseada después del login
        return redirect()->intended($this->redirectTo);
    }

    // Si las credenciales son incorrectas, redirigir de vuelta con un mensaje de error
    return redirect()->back()
        ->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])
        ->withInput($request->only('email'));
}


    /**
     * Cerrar la sesión del usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}