<?php

namespace App\Http\Controllers;

use Dotenv\Dotenv;
use App\Models\CptClient;
use App\Models\Compte;
use App\Models\Connexion;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Flash;

class OTREtaxController extends Controller
{
   public function index(){
    if(Auth::user()!=null ){
        return view('otr.etax');
    }else{
        Auth::logout();
        return redirect('/login');
    }
      
   }


    /**
     * 
     */
   public function search(Request $request){
      $reference_taxe = $request->input('reference_taxe');
      $dotenv = Dotenv::createImmutable(base_path());
      $dotenv->load();

      $baseUrl=env('API_TAX_BASE_URL', 'base_url');
      $tokenEndPoint=env('API_GET_TOKEN', 'token_api');
      $etaxgetEndPoint=env('OTR_API_GET_TAX', 'api_get_etax');

      $urlAuthenticate = $baseUrl . $tokenEndPoint;
      $urlCotisations = $baseUrl . $etaxgetEndPoint."{$reference_taxe}";

      try {
        $token = $this->getToken();
     } catch (\Exception $e) {
         if ($e->getCode() === 0 || explode(':',$e->getMessage())[0] === 'cURL error 7') {
             $message = "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
         } else {
             $message = "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
         }
         return redirect()->back()->withErrors($message);
     }

      // Consommation du Web Service pour les cotisations
      if($token!=null){
        $responseCotisations = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
         ])->get($urlCotisations);
      }else{
        return redirect()->back()->withErrors('Erreur Interne.');
      }
     
      // Consommation du Web Service pour les cotisations
      $responseCotisations = Http::withHeaders([
         'Authorization' => "Bearer {$token}",
      ])->get($urlCotisations);

      // Vérification de la réponse
      if ($responseCotisations->successful()) {
         $data = $responseCotisations->json();
        #dd($data);
        if (isset($data)) {
            $etax = $data; // Récupération de la taxe
        } else {
            $etax = [];
        }
      } else {
         $etax = [];
      }
      $connexion = Connexion::where(['identifier'=>Auth::user()->email])->first();
      $comptes=[];
       if($connexion!=null && $connexion->validity==1){
           $mail=Auth::user()->email;
           $racine=Auth::user()->racine;
           $comptes=Compte::where('racine',$racine)->get();

           $cptClientsOriginal = $comptes->map(function ($cpt) {
            return $cpt->getOriginal();
        });
       }
      return view('otr.etax', compact('etax','comptes','reference_taxe','cptClientsOriginal'));
   }
   
    /**
    * 
    */
    private function getToken(){
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
        $baseUrl=env('API_TAX_BASE_URL', 'base_url');
        $tokenEndPoint=env('API_GET_TOKEN', 'token_api');
        $urlAuthenticate = $baseUrl . $tokenEndPoint;
        $username = env('API_USERNAME', 'default_user');
        $password = env('API_PASSWORD', 'default_password');
    
        $responseAuth = Http::post($urlAuthenticate, [
            'username' => $username,
            'password' => $password,
        ]);
         
        if ($responseAuth->failed()) {
            return null;
        }
         // Récupération du token
        $token = $responseAuth->json('token');
        return $token;
       }

   /**
    * 
    */
   public function paiement(Request $request)
   {
    $dotenv = Dotenv::createImmutable(base_path());
    $dotenv->load();

        #dd($request->all());
        $validated = $request->validate([
            'referenceDeclaration' => 'required|string',
            'referenceTransaction' => 'required|string',
            'montant' => 'required|string', 
            'contribuable' => 'required|string',
            'nif' => 'required|string',
            'comptealt' => 'required|string',
        ]);
        $validated['montant'] = (float) str_replace(' ', '', preg_replace('/[^0-9]/', '', $validated['montant']));
        // Construire l'objet $data
        $data = [
            'referenceDeclaration' => $validated['referenceDeclaration'],
            'referenceTransaction' => $validated['referenceTransaction'],
            'montant' => $validated['montant'],
            'contribuable' => $validated['contribuable'],
            'nif' => $validated['nif'],
            'comptealt' => $validated['comptealt'],
        ];
       
        $amount=$validated['montant'];
        $comptealt=$validated['comptealt'];
        $compte=Compte::where('compte',$comptealt)->get();
        
        $solde=$compte[0]->getOriginal()['solde'];
        #dd($amount);
        if ($solde < $amount) {
             return redirect()->back()->withErrors('Erreur lors du paiement : Le solde compte ' . $comptealt .' est insufisant');
        }
        #dd( $data );
       // Construire l'URL du service de paiement
       $baseUrl = env('API_TAX_BASE_URL', 'base_url');
       $paymentOTREndpoint = env('OTR_API_POST_TAX', 'api_post_payment');
       $urlPayment = $baseUrl . $paymentOTREndpoint;
   
       // Authentification pour récupérer le token
       $tokenEndpoint = env('API_GET_TOKEN', 'token_api');
       $urlAuthenticate = $baseUrl . $tokenEndpoint;
       $username = env('API_USERNAME', 'default_user');
       $password = env('API_PASSWORD', 'default_password');
       #dd($urlAuthenticate);
       $responseAuth = Http::post($urlAuthenticate, [
           'username' => $username,
           'password' => $password,
       ]);
   
       if ($responseAuth->failed()) {
           return redirect()->back()->withErrors('Erreur lors de l’authentification.');
       }
   
       // Récupération du token
       $token = $responseAuth->json('token');
   
       // Appeler le web service de paiement avec les données
       $responsePayment = Http::withHeaders([
           'Authorization' => "Bearer {$token}",
       ])->post($urlPayment, $data);
       #dd($data);
       // Vérification de la réponse
       if ($responsePayment->successful()) {
           $responseBody = $responsePayment->json();
           dd($responseBody);
           if ($responseBody['success'] ?? false) {
               Flash::success($responseBody['message']);
               $etax=[];
               $reference_taxe=null;
               return redirect()->route('otr.etax').compact('etax','reference_taxe');
           } else {
               #Flash::errors($responseBody['message']);
               return redirect()->back()->withErrors('Erreur lors du paiement : ' .$responseBody['message'] );
           }
       } else {
           Flash::error('Erreur lors de la connexion au service de paiement.');
           return redirect()->back()->withErrors('Erreur lors de la connexion au service de paiement.');
       }
   }
   

   private function confirmTaxe($reference_taxe){
    $dotenv = Dotenv::createImmutable(base_path());
    $dotenv->load();

    $baseUrl=env('API_TAX_BASE_URL', 'base_url');
    $etaxConfirmationEndPoint=env('OTR_API_CONFIRM_TAX', 'api_get_cotisation');

    $urlConfirmation = $baseUrl . $etaxConfirmationEndPoint."{$reference_taxe}";


    // Authentification pour récupérer le token
    try {
      $responseAuth = Http::post($urlAuthenticate, [
          'username' => $username,
          'password' => $password,
      ]);
   }catch(RequestException $e){
       if ($e->getCode() === 7 || $e->getMessage() === 'cURL error 7') {
           $message = "Impossible de se connecter au serveur. Veuillez vérifier que le service est disponible.";
       } else {
           // Message d'erreur générique
           $message = "Une erreur est survenue lors de la communication avec le serveur.";
       }
       return redirect()->back()->withErrors('Veuillez réessayer plutard' );
   }

    if ($responseAuth->failed()) {
       return redirect()->back()->withErrors('Erreur lors de l’authentification.');
    }

    // Récupération du token
    $token = $responseAuth->json('token');

    // Consommation du Web Service pour les cotisations
    $responseCotisation = Http::withHeaders([
       'Authorization' => "Bearer {$token}",
    ])->get($urlCotisation);
    //dd($urlCotisation);
    //dd($responseCotisation->successful());

    // Vérification de la réponse
    if ($responseCotisation->successful()) {
       $data = $responseCotisation->json();
       //dd($data);
      if (isset($data['data']['body']) && is_array($data['data']['body'])) {
          $cotisation = $data['data']['body']; // Récupération des cotisations
          return $cotisation;
      }
    }
    ##dd("TRACEEEE++++++++++++++++ ");
    return null;
 }
}