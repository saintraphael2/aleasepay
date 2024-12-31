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

class CotisationCNSSController extends Controller
{
   public function index(){
      return view('cnss.cotisations');
   }

   public function search(Request $request){

      $numero_employeur = $request->input('numero_employeur');
      $dotenv = Dotenv::createImmutable(base_path());
      $dotenv->load();

      $baseUrl=env('API_TAX_BASE_URL', 'base_url');
      $tokenEndPoint=env('API_GET_TOKEN', 'token_api');
      $CotisationsEndPoint=env('CNSS_API_GET_COTISIATIONS', 'api_get_cotisations');

      $urlAuthenticate = $baseUrl . $tokenEndPoint;
      $urlCotisations = $baseUrl . $CotisationsEndPoint."{$numero_employeur}";

    // Récupération des identifiants depuis .env
      $username = env('API_USERNAME', 'default_user');
      $password = env('API_PASSWORD', 'default_password');

      ##dd($urlAuthenticate);
      // Authentification pour récupérer le token
      $responseAuth = Http::post($urlAuthenticate, [
         'username' => $username,
         'password' => $password,
      ]);

      if ($responseAuth->failed()) {
         return redirect()->back()->withErrors('Erreur lors de l’authentification.');
      }

      // Récupération du token
      $token = $responseAuth->json('token');

      // Consommation du Web Service pour les cotisations
      $responseCotisations = Http::withHeaders([
         'Authorization' => "Bearer {$token}",
      ])->get($urlCotisations);

      // Vérification de la réponse
      if ($responseCotisations->successful()) {
         $data = $responseCotisations->json();

        if (isset($data['body'])) {
            $cotisations = $data['body']; // Récupération des cotisations
        } else {
            $cotisations = [];
        }
      } else {
         $cotisations = [];
      }
      return view('cnss.cotisations', compact('cotisations','numero_employeur'));
   }

   /**
    *
    */
   public function showForm($reference, $numero_employeur)
   {
       // Recherche des informations basées sur la référence
       $cotisation = $this->getCotisationByReference($reference); // Méthode fictive à implémenter

       if (!$cotisation) {
           return redirect()->back()->withErrors('Cotisation introuvable.');
       }
      ##dd($cotisation);
       // Exemple de comptes disponibles pour le paiement (remplace par une vraie source de données)
       $connexion = Connexion::where(['identifier'=>Auth::user()->email])->first();
       $comptes=[];
        if($connexion!=null && $connexion->validity==1){
            $mail=Auth::user()->email;
            $racine=Auth::user()->racine;
            $cptClient=CptClient::where('racine',$racine)->first();
            $comptes=Compte::where('racine',$cptClient->racine)->get();
            #return view('home')->with('cptClients',$comptes);
        }else{
            return redirect()->back()->withErrors('Cotisation introuvable.');
        }
       return view('cnss.form', compact('cotisation', 'comptes'));
   }

   /**
    *
    */
   private function getCotisationByReference($reference){
      $dotenv = Dotenv::createImmutable(base_path());
      $dotenv->load();

      $baseUrl=env('API_TAX_BASE_URL', 'base_url');
      $tokenEndPoint=env('API_GET_TOKEN', 'token_api');
      $CotisationEndPoint=env('CNSS_API_GET_COTISIATION', 'api_get_cotisation');

      $urlAuthenticate = $baseUrl . $tokenEndPoint;
      $urlCotisation = $baseUrl . $CotisationEndPoint."{$reference}";

    // Récupération des identifiants depuis .env
      $username = env('API_USERNAME', 'default_user');
      $password = env('API_PASSWORD', 'default_password');

      ##dd($urlAuthenticate);
      // Authentification pour récupérer le token
      $responseAuth = Http::post($urlAuthenticate, [
         'username' => $username,
         'password' => $password,
      ]);

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
      dd("TRACEEEE++++++++++++++++ ");
      return null;
   }

   /**
    * 
    */
   public function paiement(Request $request)
   {
       // Récupérer les données depuis la requête
       $validated = $request->validate([
         'referenceID' => 'required|string',
         'transactionID' => 'nullable|string',
         'amount' => 'required|numeric',
         'transactionDate' => 'required|date',
         'currency' => 'XOF',
         'status' => 1,
         'designation' => 'required|string',
         'requester' => 'required|string',
         'numeroEmployeur' => 'required|string',
         'comptealt' => 'required|string',
     ]);
 
     // Préparer les données pour l'API
     $data = [
         'cNSSpaytax' => [
             'referenceID' => $validated['referenceID'],
             'transactionID' => $validated['transactionID'],
             'amount' => $validated['amount'],
             'transactionDate' => $validated['transactionDate'],
             'currency' => $validated['currency'],
             'status' => $validated['status'],
         ],
         'designation' => $validated['designation'],
         'requester' => $validated['requester'],
         'numeroEmployeur' => $validated['numeroEmployeur'],
         'comptealt' => $validated['comptealt'],
     ];
   
       // Construire l'URL du service de paiement
       $baseUrl = env('API_TAX_BASE_URL', 'base_url');
       $paymentEndpoint = env('CNSS_API_POST_PAYMENT', 'api_post_payment');
       $urlPayment = $baseUrl . $paymentEndpoint;
   
       // Authentification pour récupérer le token
       $tokenEndpoint = env('API_GET_TOKEN', 'token_api');
       $urlAuthenticate = $baseUrl . $tokenEndpoint;
       $username = env('API_USERNAME', 'default_user');
       $password = env('API_PASSWORD', 'default_password');
   
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
   
       // Vérification de la réponse
       if ($responsePayment->successful()) {
           $responseBody = $responsePayment->json();
   
           if ($responseBody['data']['success'] ?? false) {
               Flash::success('Paiement effectué avec succès.');
               return redirect()->route('cnss.cotisations')->with('success', 'Paiement effectué avec succès.');
           } else {
               Flash::error('Erreur lors du paiement');
               return redirect()->back()->withErrors('Erreur lors du paiement : ' . ($responseBody['data']['body']['message'] ?? 'Inconnue'));
           }
       } else {
           Flash::error('Erreur lors de la connexion au service de paiement.');
           return redirect()->back()->withErrors('Erreur lors de la connexion au service de paiement.');
       }
   }
   
}