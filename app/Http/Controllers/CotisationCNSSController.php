<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CotisationCNSSController extends Controller
{
   public function index(){
    // $url = 'http://localhost:8080/api/cnss/getPaiementCotisations/65354';

    // // Consommation du Web Service
    // $response = Http::get($url);

    // if ($response->successful()) {
    //     $data = $response->json();

    //     // Vérifie si les données sont récupérées avec succès
    //     if (isset($data['data']['success']) && $data['data']['success'] === true) {
    //         $cotisations = $data['data']['body'];
    //     } else {
    //         $cotisations = [];
    //     }
    // } else {
    //     $cotisations = [];
    // }
    return view('cnss.cotisations')->with('cotisations');
   }
}
