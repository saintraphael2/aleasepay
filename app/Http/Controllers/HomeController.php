<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Ichtrojan\Otp\Otp;

use App\Models\CptClient;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mail=Auth::user()->email;
        $cptClient=CptClient::where('email',$mail)->first();
        return view('home')->with('cptClient',$cptClient);
    }
    public function otp()
    {
        return view('otp');
    }
    public function validationOtp(Request $request){
       // dd($request->otp);
        $result=(new Otp)->validate($request->email, $request->otp);
       
        if($result->status==true)
            return redirect("/");
        elseif(trim($result->status)==false)  {
           // $errors = new MessageBag; 
            //$errors = new MessageBag(['password' => ['Code Invalide ou expiré.']]);
            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Code Invalide ou expiré. Veuillez vous reconnecter!'])->with( ['message' => 'test code'] );
        }
      
    }
}
