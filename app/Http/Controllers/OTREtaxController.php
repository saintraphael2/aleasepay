<?php

namespace App\Http\Controllers;

use Dotenv\Dotenv;
use App\Models\CptClient;
use App\Models\Compte;
use App\Models\Connexion;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\PendingTransaction;
use Flash;
use PDF;

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


   public function getMontantTTC(string $operation, string $montant){
    $dotenv = Dotenv::createImmutable(base_path());
    $dotenv->load();

    $baseUrl=env('API_TAX_BASE_URL', 'base_url');
    $etaxgetMontantTTCEndPoint=env('GET_MONTANT_TTC', 'api_get_montant_ttc');

    $urlmontantTTC = $baseUrl . $etaxgetMontantTTCEndPoint."{$operation}" ."/"."{$montant}";

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

     if($token!=null){
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
         ])->get($urlmontantTTC);
      }else{
        return redirect()->back()->withErrors('Erreur Interne.');
      }
      // Vérification de la réponse
      if ($response->successful()) {
         $data = $response->json();
        return $data;
    }
    return null;
}

    /**
     * 
     */
   public function search(Request $request){
      $reference_taxe = $request->input('reference_taxe');
      $dotenv = Dotenv::createImmutable(base_path());
      $dotenv->load();

      if (PendingTransaction::where('reference',  $reference_taxe)
      ->where('etat', 'en_attente') ->exists()) {
        Flash::error('Ce paiement est déjà en cours de traitement, en attente de validation.');
         return view('otr.etax');
        //return redirect()->back()->withErrors( 'Ce paiement est déjà en cours de traitement, en attente de validation.' );
      }

      $baseUrl=env('API_TAX_BASE_URL', 'base_url');
      $etaxgetEndPoint=env('OTR_API_GET_TAX', 'api_get_etax');

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

      // Vérification de la réponse
      if ($responseCotisations->successful()) {
         $data = $responseCotisations->json();
        #dd($data);
        if (isset($data)) {
            $etax = $data; // Récupération de la taxe {referenceDeclaration: 234616000, referenceTransaction: 'TG2153307TG251059142', montant: 4000, contribuable: 'AMIASE', nif: '1001204867', …}
            $etax['montantTTC'] = $this->getMontantTTC("OOT", $etax['montant']);
        } else {
            $etax = [];
        }
      } else {
         $etax = [];
      }
      $connexion = Connexion::where(['identifier'=>Auth::user()->email])->first();
      $comptes=[];
       if($connexion!=null && $connexion->validity==1){
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
        $compted = Compte::where( 'compte', $validated[ 'comptealt' ] )->first();

        if (Auth::user() != null) {
            $mail = Auth::user()->email;
            }
        // Construire l'objet $data
        $data = [
            'referenceDeclaration' => $validated['referenceDeclaration'],
            'referenceTransaction' => $validated['referenceTransaction'],
            'montant' => $validated['montant'],
            'contribuable' => $validated['contribuable'],
            'nif' => $validated['nif'],
            'comptealt' => $validated['comptealt'],
            'comptelabel' => $compted->intitule,
            'email' =>  $mail,
        ];
       
        $amount=$validated['montant'];
        $comptealt=$validated['comptealt'];
        $compte=Compte::where('compte',$comptealt)->get();
        
        $solde=$compte[0]->getOriginal()['solde'];
        #dd($amount);
        #if ($solde < $amount) {
        #     return redirect()->back()->withErrors('Erreur lors du paiement : Le solde compte ' . $comptealt .' est insufisant');
       # }

        #dd( $data );
       // Construire l'URL du service de paiement
       $baseUrl = env('API_TAX_BASE_URL', 'base_url');
       $paymentOTREndpoint = env('OTR_API_POST_TAX', 'api_post_payment');
       $urlPayment = $baseUrl . $paymentOTREndpoint;
   
       // Authentification pour récupérer le token
       #dd($urlAuthenticate);
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

      // Consommation du Web Service
      if($token!=null){
        $responsePayment = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->post($urlPayment, $data);
      }else{
        return redirect()->back()->withErrors('Erreur Interne.');
      }
    
       #dd($data);
       // Vérification de la réponse
       if ($responsePayment->successful()) {
           $responseBody = $responsePayment->json();
         

            if(isset($responseBody) && isset($responseBody["code"])){
                $code= Str::before($responseBody["code"], " ");
                #dd($code);
                if($code==500){
                    $msg=html_entity_decode($responseBody["message"]);
                    if ($mail != null) {
                        Mail::send('notifications.index', ['msge' => $msg], function ($message) use ($mail, $msg) {
                            $message->to($mail);
                            $message->subject('Notification');
                        });
                        #Flash::success($response['body']['message'] . ' . Un email de notification vous sera envoyé.');
                    }
                    return redirect()->back()->withErrors($msg);
                }
            }
           #dd($responseBody['Response']['resultat']);
           if (isset($responseBody['Response']) && $responseBody['Response']['resultat'] !=null) {
               #Flash::success($responseBody['message']);
               $result= $this->confirmTaxe($responseBody['Response']['resultat']);
        
               $othersInfos = $responseBody['Others'];
                if($result==0){
                #$mail = null;
                #dd($mail);
                $data = [ 'others' => $othersInfos ];
                $pdf = PDF::loadView( 'otr.quittance',$data);
                $pdfContent = $pdf->output();
                    #Envoi de mail
                if ($mail != null) {
                        Mail::send('otr.email', ['others' => $othersInfos], function ($message) use ($mail, $othersInfos,$pdfContent) {
                            $message->to($mail);
                            $message->subject('Détails Paiement OTR : ' . $othersInfos['refDecla']);
                            $message->attachData( $pdfContent, 'quittance_paiement_OTR.pdf', [
                                'mime' => 'application/pdf',
                            ] );
                        });
                        Flash::success("Opération Réussie" . ' . Un email de notification vous sera envoyé.');
                }
                #$etax=[];
                #$reference_taxe=null;
                return redirect()->route('otr.etax');
                }else{
                    return redirect()->route('otr.etax')->withErrors("Votre Opération n'a pas aboutie. Veuillez réessayer ! ");
                    #return redirect()->back()->withErrors("Votre Opération n'a pas aboutie. Veuillez réessayer ! ");
                }
               
           } else {
               #Flash::errors($responseBody['message']);
               return redirect()->back()->withErrors('Erreur lors du paiement : ' .$responseBody['message'] );
           }
       } else {
           Flash::error('Erreur lors de la connexion au service de paiement.');
           return redirect()->back()->withErrors('Erreur lors de la connexion au service de paiement.');
       }
   }

   private function getcomptesClient(){
    $connexion = Connexion::where(['identifier'=>Auth::user()->email])->first();
    $comptes=[];
    $cptalts=[];
     if($connexion!=null && $connexion->validity==1){
         $racine=Auth::user()->racine;
         $comptes=Compte::where('racine',$racine)->get();

         $cptClientsOriginal = $comptes->map(function ($cpt) {
            $cptalts= $cpt->getOriginal();
      });
     }
     return $cptalts;
   }
   

   private function confirmTaxe($reference_taxe){
    $dotenv = Dotenv::createImmutable(base_path());
    $dotenv->load();

    $baseUrl=env('API_TAX_BASE_URL', 'base_url');
    $etaxConfirmationEndPoint=env('OTR_API_CONFIRM_TAX', 'api_get_cotisation');

    $urlConfirmation = $baseUrl . $etaxConfirmationEndPoint."{$reference_taxe}";


    // Authentification pour récupérer le token
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

      // Consommation du Web Service
      if($token!=null){
        $confirmEtaxResult = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
         ])->get($urlConfirmation);
      }else{
        return redirect()->back()->withErrors('Erreur Interne.');
      }
   
    // Vérification de la réponse
    if ($confirmEtaxResult->successful()) {
       $data = $confirmEtaxResult->json();
       #dd($data);
      if (isset($data['result']) && $data['result']!=null ) {
        return $data['result']; 
      }
    }
    ##dd("TRACEEEE++++++++++++++++ ");
    return null;
 }
}