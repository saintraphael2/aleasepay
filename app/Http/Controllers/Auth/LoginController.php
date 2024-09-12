<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
  
         //   auth()->user()->generateCode();
         $otp=(new Otp)->generate($request->email, 'numeric', 6, 15);

         Mail::to($request->email)
            ->send(new Contact([
                'nom' => 'Durand',
                'email' => $request->email,
                'message' => $otp->token
                ]));
            $tab=explode('@',$request->email);
            $deb=substr($tab[0],0,2).'**********@'.$tab[1];
            return view("auth.otp")->with('email',$request->email)->with('emailc',$deb);
            
        }
    
        return redirect("/login")->withErrors(['password' => 'email ou mot de passe erronné. veuillez ressayer!']);
    }
}
