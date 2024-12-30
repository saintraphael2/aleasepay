<?php

namespace App\Http\Controllers;

use Dotenv\Dotenv;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

         if (isset($data['data']['success']) && $data['data']['success'] === true) {
               $cotisations = $data['data']['body'];
         } else {
               $cotisations = [];
         }
      } else {
         $cotisations = [];
      }
      return view('cnss.cotisations', compact('cotisations'));
   }
}