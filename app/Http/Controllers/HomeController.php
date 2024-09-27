<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Ichtrojan\Otp\Otp;

use App\Models\CptClient;
use App\Models\Compte;
use Session;
use App\Models\Connexion;
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
        $connexion = Connexion::where(['identifier'=>Auth::user()->email])->first();

        if($connexion->validity==1){
            $mail=Auth::user()->email;
            $racine=Auth::user()->racine;
            $cptClient=CptClient::where('racine',$racine)->first();
            $comptes=Compte::where('racine',$cptClient->racine)->get();
            return view('home')->with('cptClients',$comptes);
        }else{
            Auth::logout();
            return redirect('/login');
        }
        
    }
    public function otp()
    {
        
        return view('auth.otp')->with('email',Session::get('email'))->with('emailc',Session::get('emailc'));
    }
    public function validationOtp(Request $request){
       // dd($request->otp);
        $result=(new Otp)->validate($request->email, $request->otp);
       
        if($result->status==true){
            $connexion = Connexion::where(['identifier'=>Auth::user()->email])->first();
            $connexion->validity=1;
                $connexion->save();
             return redirect("/");
        }
           
        elseif(trim($result->status)==false)  {
           // $errors = new MessageBag; 
            //$errors = new MessageBag(['password' => ['Code Invalide ou expiré.']]);
            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Code Invalide ou expiré. Veuillez vous reconnecter!'])->with( ['message' => 'test code'] );
        }
      
    }
    public function creation(){
        return view('creation');
    }
}
