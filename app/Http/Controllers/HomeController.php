<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Ichtrojan\Otp\Otp;

use App\Models\CptClient;
use App\Models\Compte;
use Session;
use App\Repositories\UserRepository;
use App\Models\Connexion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Dotenv\Dotenv;

class HomeController extends Controller
 {

    protected $userRepository;
    /**
    * Create a new controller instance.
    *
    * @return void
    */

    public function __construct( UserRepository $userRepository )
    {
        $this->middleware( 'auth' );
        $this->userRepository = $userRepository;
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index()
 {
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();
        $connexion = Connexion::where( [ 'identifier'=>Auth::user()->email ] )->first();

        $soldeUrl= env('ALEASEPAY_SOLDE_URL', 'aleasepay_solde');

        if ( $connexion != null && $connexion->validity == 1 ) {
            $mail = Auth::user()->email;
            $racine = Auth::user()->racine;
            $cptClient = CptClient::where( 'racine', $racine )->first();
            $comptes = Compte::where( 'racine', $cptClient->racine )->orderBy( 'compte' )->get();
            try {
                foreach ( $comptes as $compte ) {
                    //dd( $compte );
                    $solde = Http::post($soldeUrl, [
                        'dateSolde' => Carbon::now()->format( 'd/m/Y' ),
                        'compte' => $compte->compte,
                    ] );
                    $compte->solde = json_decode( $solde->getBody(), true )[ 'solde' ];
                }
            } catch ( \Exception $e ) {
                if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                    $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
                } else {
                    $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
                }
                return view( 'maintenance' );
            }
            return view( 'home' )->with( [ 'cptClients'=>$comptes, 'solde'=>$solde ] );
        } else {
            Auth::logout();
            return redirect( '/login' );
        }
    }

    public function otp()
    {

        return view( 'auth.otp' )->with( 'email', Session::get( 'email' ) )->with( 'emailc', Session::get( 'emailc' ) );
    }

    public function validationOtp( Request $request ) {
        // dd( $request->otp );
        $result = ( new Otp )->validate( $request->email, $request->otp );

        if ( $result->status == true ) {
            $connexion = Connexion::where( [ 'identifier'=>Auth::user()->email ] )->first();
            $connexion->validity = 1;
            $connexion->save();
            return redirect( '/' );
        } elseif ( trim( $result->status ) == false ) {
            // $errors = new MessageBag;

            //$errors = new MessageBag( [ 'password' => [ 'Code Invalide ou expiré.' ] ] );
            Auth::logout();
            return redirect( '/login' )->withErrors( [ 'email' => 'Code Invalide ou expiré. Veuillez vous reconnecter!' ] )->with( [ 'message' => 'test code' ] );
        }
    }

    public function creation() {
        return view( 'creation' );
    }

}