<?php

namespace App\Http\Controllers;

use Dotenv\Dotenv;
use App\Models\CptClient;
use App\Models\Compte;
use App\Models\PendingTransaction;
use App\Models\Users;
use App\Models\Connexion;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Flash;
use PDF;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Profil;
use App\Repositories\ProfilRepository;

class TransactionPendingController extends Controller {

    private $profilRepository;

    public function __construct( ProfilRepository $profilRepo )
    {
        $this->profilRepository = $profilRepo;
    }
    public function index() {
        if ( Auth::user() != null ) {

            $profilId = Auth::user()->profil;

            $profilEntitie = Profil::where('id',$profilId)->first();
            //dd( $profil->libelle);
            $profil = $profilEntitie->libelle;
            dd($profil);
            $initiateur="INITATEUR";
            $validateur="VALIDATEUR";
            $autonome="AUTONOME";
            return view( 'transactions_pending.index', compact('profil','initiateur','autonome'));
        } else {
            Auth::logout();
            return redirect( '/login' );
        }
    }

    public function getPendingTransactionsByDate(Request $request) {
        $date_debut = Carbon::createFromFormat('d-m-Y', $request->input('date_debut'))->startOfDay()->format('Y-m-d H:i:s');
        $date_fin = Carbon::createFromFormat('d-m-Y', $request->input('date_fin'))->endOfDay()->format('Y-m-d H:i:s');
        $compte = $request->input('compte');
        $type = $request->input('type');
        $tabpane = $request->input('tabpane');
        $transactions = PendingTransaction::with('user')
        ->whereBetween('date_transaction', [$date_debut, $date_fin])
        ->when($tabpane === "tab_pai_step1" || $tabpane === "tab_pai_step2", function ($query) use ($compte, $type) {
            $query->where(function ($q) {
                $q->where('etat', 'en_attente')
                  ->orWhere('etat', 'annulé');
            });
            
            if ($compte) {
                $query->where('compte', $compte);
            }
            if ($type) {
                $query->where('type', $type);
            }
            return $query;
        })
        ->when($tabpane === "tab_pai_step3", function ($query) use ($compte, $type) {
            if ($compte) {
                $query->where('compte', $compte);
            }
            if ($type) {
                $query->where('type', $type);
            }
            return $query;
        })
        ->get();
        return response()->json($transactions);
    }


    public function cancelTransactionPending(Request $request){
        $idTransac = $request->input('idTransac');

        $pendingTransac = PendingTransaction::find($idTransac);
        try{
           
                $pendingTransac->etat = 'annulé';
                $pendingTransac->save();
    
                $initiated_name= Auth::user()->name;
                $email=  Auth::user()->email;
                $data=[
                    'comptealt' =>  $pendingTransac->compte,
                    'montant'=> $pendingTransac->montant_ttc,
                    'reference'=> $pendingTransac->reference,
                    'etat'=> $pendingTransac->etat,
                    'date'=> $pendingTransac->date_transaction,
                    'initiated_name'=> $initiated_name,
                ];
                $validateursEmails=$this->getValidateurEmails();
                $msg="Un paiement a été annulé.";
                Mail::send('transactions_pending.email_cancel', ['msge' => $msg, 'data' => $data], function ($message) use ($email, $msg, $data, $validateursEmails) {
                    $message->to($email)
                            ->subject('Notification');
                
                    if (!empty($validateursEmails) && is_array($validateursEmails)) {
                        $message->cc($validateursEmails);
                    }
                });
    
           return response()->json(['success' => "La transaction a été annulée avec succès. un mail d'annulation vous a été envoyé."], 200);
         }catch ( \Exception $e ) {
            Log::error('UPDAT : ' . $e->getMessage());
            return response()->json(['error' => 'Transaction introuvable.'], 404);
         }

        
    }

    function getValidateurEmails(){
        $racine =   Auth::user()->racine;
        $utilisateurs = Users::where('racine', $racine)
        ->whereHas('profil', function ($query) {
            $query->where('libelle', 'VALIDATEUR');
        })
        ->pluck('email')->toArray();
        return $utilisateurs;
    }

    public function saveTransactionPending( Request $request ) {
        $reference = $request->input('reference');
        $compte = $request->input('compte');
        $montant= $request->input('montant');
        $montant_ttc= $request->input('montant_ttc');
        $etat= $request->input('etat');
        $date= $request->input('date');
        $numeroEmployeur= $request->input('numeroemployeur');
        $contribuable= $request->input('contribuable');
      //  $contribuable= $request->input('contribuable');

        $date_transaction = Carbon::parse($date)->format('Y-m-d H:i:s');
        $description = $request->input('description');
        $type="OCN";
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();
        try{   
        if (PendingTransaction::where('reference', $reference)
        ->where('etat', 'en_attente') ->exists()) {
            return response()->json(['error' => 'Ce paiement est déjà en cours de traitement, en attente de validation.'], 400);
        }

        $initiated_by=  Auth::user()->id;
        $montant=  number_format($montant, 0, '.', ' ');
        $amount= str_replace(' ', '', $montant);

       
        $montant_ttc= (float) str_replace(' ', '', preg_replace('/[^0-9.]/', '', $montant_ttc)); 
        // number_format($montant_ttc, 0, '.', ' ');
        $amount_ttc= number_format($montant_ttc, 0, ',', ' '); 
        //str_replace(' ', '', $montant_ttc);
          
        $pendingTransaction = new PendingTransaction();
        $pendingTransaction->reference = $reference;
        $pendingTransaction->type = $type;
        $pendingTransaction->compte = $compte;
        $pendingTransaction->etat = $etat;
        $pendingTransaction->montant= $amount;
        $pendingTransaction->montant_ttc= $amount_ttc;
        $pendingTransaction->date_transaction = $date_transaction;
        $pendingTransaction->description=$description;
        $pendingTransaction->initiated_by = $initiated_by;
        $pendingTransaction->numero_employeur=$numeroEmployeur;
        $pendingTransaction->contribuable=$contribuable;
        
        $pendingTransaction->save();
        $initiated_name= Auth::user()->name;
        $email=  Auth::user()->email;
        $data=[
            'comptealt' =>  $compte,
            'montant'=> $amount_ttc,
            'reference'=> $reference,
            'etat'=> $etat,
            'date'=> $date,
            'initiated_name'=> $initiated_name,
        ];
        $validateursEmails=$this->getValidateurEmails();
        $titre="Enregistrée";
        $msg="Un paiement a été enregistré et est en attente de validation.";
        Mail::send( 'transactions_pending.email', ['titre'=>$titre, 'msge' => $msg,'data'=>$data ], function ( $message ) use ( $email, $msg,$data,$titre,$validateursEmails ) {
                $message->to( $email );
                $message->subject( 'Notification' );
                if (!empty($validateursEmails) && is_array($validateursEmails)) {
                    $message->cc($validateursEmails);
                }
        });
        return response()->json(['success' => 'Votre paiement a été soumis avec succès. Un e-mail vous a été envoyé.'], 200);
        }catch ( \Exception $e ) {
            Log::error('Erreur lors de l’enregistrement du paiement : ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de l’enregistrement du paiement :'], 500); 
        }
    }


    
    public function saveTransactionPendingOTR( Request $request ) {

        $reference = $request->input('reference');
        $referenceTransaction = $request->input('reference_transaction');
        $compte = $request->input('compte');
        $montant= $request->input('montant');
        $montant_ttc= $request->input('montant_ttc');
        $etat= $request->input('etat');
        $date= $request->input('date');
        $numeroEmployeur= $request->input('numero_employeur');
        $contribuable= $request->input('contribuable');
      //  $contribuable= $request->input('contribuable');
      if(     $compte == null ) {
        return response()->json( [ 'error' => 'Le compte est obligatoire' ], 400 );
      }

        $date_transaction = Carbon::parse($date)->format('Y-m-d H:i:s');
      
        $type="OOT";
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();
        try{   
        if (PendingTransaction::where('reference', $reference)
        ->where('etat', 'en_attente') ->exists()) {
            return response()->json(['error' => 'Ce paiement est déjà en cours de traitement, en attente de validation.'], 400);
        }

        $initiated_by=  Auth::user()->id;
        $montant=  number_format($montant, 0, '.', ' ');
        $amount= str_replace(' ', '', $montant);

        $montant_ttc= (float) str_replace(' ', '', preg_replace('/[^0-9.]/', '', $montant_ttc)); 
        // number_format($montant_ttc, 0, '.', ' ');
        $amount_ttc= number_format($montant_ttc, 0, ',', ' '); 
        //str_replace(' ', '', $montant_ttc);

        
          
        $pendingTransaction = new PendingTransaction();
        $pendingTransaction->reference = $reference;
        $pendingTransaction->reference_transac = $referenceTransaction;
        $pendingTransaction->type = $type;
        $pendingTransaction->compte = $compte;
        $pendingTransaction->etat = $etat;
        $pendingTransaction->montant= $amount;
        $pendingTransaction->montant_ttc= $amount_ttc;
        $pendingTransaction->date_transaction = $date_transaction;
        $pendingTransaction->initiated_by = $initiated_by;
        $pendingTransaction->numero_employeur=$numeroEmployeur;
        $pendingTransaction->contribuable=$contribuable;
        
        $pendingTransaction->save();
        $initiated_name= Auth::user()->name;
        $email=  Auth::user()->email;
        $data=[
            'comptealt' =>  $compte,
            'montant'=> $amount_ttc,
            'reference'=> $reference,
            'etat'=> $etat,
            'date'=> $date,
            'initiated_name'=> $initiated_name,
        ];
        $validateursEmails=$this->getValidateurEmails();
        $titre="Enregistrée";
        $msg="Un paiement a été enregistré et est en attente de validation.";
        Mail::send( 'transactions_pending.email', ['titre'=>$titre, 'msge' => $msg,'data'=>$data ], function ( $message ) use ( $email, $msg,$data,$titre,$validateursEmails ) {
                $message->to( $email );
                $message->subject( 'Notification' );
                if (!empty($validateursEmails) && is_array($validateursEmails)) {
                    $message->cc($validateursEmails);
                }
        });
        return response()->json(['success' => 'Votre paiement a été soumis avec succès. Un e-mail vous a été envoyé.'], 200);
        }catch ( \Exception $e ) {
            Log::error('Erreur lors de l’enregistrement du paiement : ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de l’enregistrement du paiement :'], 500); 
        }
    }

    /**
    *
    */
    public function search( Request $request ) {
        $numero_employeur = $request->input('numero_employeur');
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();

        $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
        $CotisationsEndPoint = env( 'CNSS_API_GET_COTISIATIONS', 'api_get_cotisations' );

        $urlCotisations = $baseUrl . $CotisationsEndPoint . "{$numero_employeur}";

        // Récupération du token
        try {
            $token = $this->getToken();
        } catch ( \Exception $e ) {
            if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            } else {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            }
            return redirect()->back()->withErrors( $message );
        }

        // Consommation du Web Service pour les cotisations
        if ( $token != null ) {
            $responseCotisations = Http::withHeaders( [
                'Authorization' => "Bearer {$token}",
            ] )->get( $urlCotisations );
        } else {
            return redirect()->back()->withErrors( 'Serveur indisponible.' );
        }

        // Vérification de la réponse
        if ( $responseCotisations->successful() ) {
            $data = $responseCotisations->json();
            if ( isset( $data[ 'body' ] ) ) {
                $cotisations = $data[ 'body' ];
                // Récupération des cotisations
            } else {
                $cotisations = [];
            }
        } else {
            $cotisations = [];
        }
        return $cotisations;
    }


    public function getMontantTTC(Request $request){
        
        $operation = $request->input('operation');
        $montant = $request->input('montant');

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
    public function searchByReferenceTaxe(Request $request){
        $reference_taxe = $request->input('numero_employeur');
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
  
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
           #return response()->json(['error' =>   $message], 500);
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
             $racine=Auth::user()->racine;
             $comptes=Compte::where('racine',$racine)->get();
  
             $cptClientsOriginal = $comptes->map(function ($cpt) {
              return $cpt->getOriginal();
          });
         }
        return  $etax ;
        //view('otr.etax', compact('etax','comptes','reference_taxe','cptClientsOriginal'));
     }

    /**
    *
    */

    public function showForm( $reference, $numero_employeur ) {
        // Recherche des informations basées sur la référence
        try {
            $cotisation = $this->getCotisationByReference( $reference );
        } catch ( \Exception $e ) {
            // Méthode fictive à implémenter
            if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            } else {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            }
            return redirect()->back()->withErrors( $message );
        }
        if ( !$cotisation ) {
            return redirect()->back()->withErrors( 'Cotisation introuvable.' );
        }
        ##dd( $cotisation );
        // Exemple de comptes disponibles pour le paiement ( remplace par une vraie source de données )
        $connexion = Connexion::where( [ 'identifier' => Auth::user()->email ] )->first();
        $comptes = [];
        if ( $connexion != null && $connexion->validity == 1 ) {
            $mail = Auth::user()->email;
            $racine = Auth::user()->racine;
            $cptClient = CptClient::where( 'racine', $racine )->first();
            $comptes = Compte::where( 'racine', $racine )->get();
            #$comptes = Compte::where( 'racine', $cptClient->racine )->get();

            #dd( $comptes );

            $cptClientsOriginal = $comptes->map( function ( $cpt ) {
                return $cpt->getOriginal();
            }
        );
        #return view( 'home' )->with( 'cptClients', $comptes );
    } else {
        return redirect()->back()->withErrors( 'Cotisation introuvable.' );
    }
    return view( 'cnss.form', compact( 'cotisation', 'comptes', 'numero_employeur', 'cptClientsOriginal' ) );
}

/**
*
*/

private function getToken() {
    $dotenv = Dotenv::createImmutable( base_path() );
    $dotenv->load();
    $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
    $tokenEndPoint = env( 'API_GET_TOKEN', 'token_api' );
    $urlAuthenticate = $baseUrl . $tokenEndPoint;
    $username = env( 'API_USERNAME', 'default_user' );
    $password = env( 'API_PASSWORD', 'default_password' );

    $responseAuth = Http::post( $urlAuthenticate, [
        'username' => $username,
        'password' => $password,
    ] );

    if ( $responseAuth->failed() ) {
        return null;
    }
    // Récupération du token
    $token = $responseAuth->json( 'token' );
    return $token;
}

/**
*
*/

private function getCotisationByReference( $reference ) {
    $dotenv = Dotenv::createImmutable( base_path() );
    $dotenv->load();

    $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
    $CotisationEndPoint = env( 'CNSS_API_GET_COTISIATION', 'api_get_cotisation' );

    $urlCotisation = $baseUrl . $CotisationEndPoint . "{$reference}";
    // Authentification pour récupérer le token
    try {
        $token = $this->getToken();
    } catch ( \Exception $e ) {
        if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
            $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
        } else {
            $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
        }
        return redirect()->back()->withErrors( $message );
    }

    // Consommation du Web Service pour les cotisations
    if ( $token != null ) {
        $responseCotisation = Http::withHeaders( [
            'Authorization' => "Bearer {$token}",
        ] )->get( $urlCotisation );
    } else {
        return redirect()->back()->withErrors( 'Serveur indisponible.' );
    }
    // Vérification de la réponse
    if ( $responseCotisation->successful() ) {
        $data = $responseCotisation->json();
        //dd( $data );
        if ( isset( $data[ 'data' ][ 'body' ] ) && is_array( $data[ 'data' ][ 'body' ] ) ) {
            $cotisation = $data[ 'data' ][ 'body' ];
            // Récupération des cotisations
            return $cotisation;
        }
    }
    return null;
}

/**
*
*/

private function rappelSearch( $numero_employeur ) {
    return redirect()->route( 'cnss.cotisations.search', [ 'numero_employeur' => $numero_employeur ] );
}

/**
*
*/
public function paiement( Request $request ) {
    $dotenv = Dotenv::createImmutable( base_path() );
    $dotenv->load();


    $idTransac = $request->input('idTransac');

    $pendingTransac = PendingTransaction::find($idTransac);

    // Nettoyer le champ 'amount' pour extraire uniquement le montant numérique
    $amount = ( float ) str_replace( ' ', '', preg_replace( '/[^0-9]/', '', $pendingTransac->montant) );
    $transactionDate = now()->format( 'Y-m-d H:i:s' );
    if ( Auth::user() != null ) {
        $mail = Auth::user()->email;
    }
    // Construire l'objet $data
        $data = [
            'cNSSpaytax' => [
                'referenceID' => $pendingTransac->reference,
                'transactionID' => null, // Champ laissé vide ou par défaut
                'amount' => $pendingTransac->montant,
                'transactionDate' => $transactionDate, // Par exemple, date actuelle
                'currency' => 'XOF', // Valeur fixe
                'status' => 1, // Valeur fixe
            ],
            'designation' => "PAIEMENT CNSS",
            'requester' => $pendingTransac->contribuable,
            'numeroEmployeur' => $pendingTransac->numero_employeur,
            'comptealt' =>  $pendingTransac->compte,
            'email' => $mail,
        ];
        $numEmp = $pendingTransac->numero_employeur;

        
        $comptealt = $pendingTransac->compte;
        $compte = Compte::where('compte', $comptealt)->get();
        $solde = $compte[0]->getOriginal()['solde'];
       //  if ($solde < $amount) {
         //    return redirect()->back()->withErrors('Erreur lors du paiement : Le solde compte ' . $comptealt . ' est insufisant');
        // }
        #return view('home')->with('cptClients',$comptes);
        #dd( $data );
        // Construire l'URL du service de paiement
    $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
    $paymentEndpoint = env('CNSS_API_POST_PAYMENT', 'api_post_payment');
    $urlPayment = $baseUrl . $paymentEndpoint;

    // Authentification pour récupérer le token
    $tokenEndpoint = env( 'API_GET_TOKEN', 'token_api');
    $urlAuthenticate = $baseUrl . $tokenEndpoint;
    $username = env( 'API_USERNAME', 'default_user' );
    $password = env( 'API_PASSWORD', 'default_password');
    #dd( $urlAuthenticate );
    try {
        $token = $this->getToken();
    } catch ( \Exception $e ) {
        if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
            $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
        } else {
            $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
        }
        return response()->json(['error' =>  $message], 500);
       // return redirect()->back()->withErrors( $message );
    }
    try {
    // Consommation du Web Service
    if ( $token != null ) {
        $responsePayment = Http::withHeaders( [
            'Authorization' => "Bearer {$token}",
        ] )->post( $urlPayment, $data );
    } else {
        return response()->json(['error' => 'Serveur indisponible.'], 500);
       // return redirect()->back()->withErrors( 'Serveur indisponible.' );
    }

    // Vérification de la réponse
    if ( $responsePayment->successful() ) {
        $responseBody = $responsePayment->json();
        #dd( $responseBody );
        if ( isset( $responseBody ) ) {
            $code = Str::before( $responseBody['code'], ' ' );
            #dd( $code );
            if ( $code == 500 ) {
                $msg = html_entity_decode( $responseBody['message'] );
                if ( $mail != null ) {
                    Mail::send( 'notifications.index', [ 'msge' => $msg ], function ( $message ) use ( $mail, $msg ) {
                        $message->to( $mail );
                        $message->subject('Notification');
                    }
                );
                #Flash::success( $response[ 'body' ][ 'message' ] . ' . Un email de notification vous sera envoyé.' );
            }
            return response()->json(['error' => $msg], 500);
            //return redirect()->back()->withErrors( $msg );
        }
    }
    $response = $responseBody[ 'Response' ][ 'data' ];
    $othersInfos = $responseBody[ 'Others' ];

    #dd( $mail );

    if ( $response[ 'success' ] ?? false ) {
        if ( $mail != null ) {
            $data = [ 'others' => $othersInfos ];
            $pdf = PDF::loadView( 'cnss.quittance', $data );
            $pdfContent = $pdf->output();
            Mail::send( 'cnss.email', [ 'others' => $othersInfos ], function ( $message ) use ( $mail, $othersInfos, $pdfContent ) {
                $message->to( $mail );
                $message->subject( 'Reçu Paiement Cotisation CNSS: ' . $othersInfos[ 'refDecla' ] );
                $message->attachData( $pdfContent, 'quittance_paiement_cnss.pdf', [
                    'mime' => 'application/pdf',
                ] );
                // Joindre le PDF sans l'enregistrer sur le disque
                });
                    //return response()->json(['success' => $response['body']['message'] . ' . Un email de notification vous sera envoyé.'], 200);
                    Flash::success('Opération réussie' . ' . Un email de notification vous sera envoyé.');
                } else {
                    Flash::success("Opération réussie");
                }
                $referenceTransaction = $othersInfos['referenceTransaction'];
                $pendingTransac->etat = 'validé';
                $pendingTransac->save();
    
              //  $initiated_name= Auth::user()->name;

                $user= Users::where('id',$pendingTransac->initiated_by)->first();
                $initiatedEmail =$user->email;
                $data=[
                    'comptealt' =>  $pendingTransac->compte,
                    'montant'=> $pendingTransac->montant_ttc,
                    'reference'=> $pendingTransac->reference,
                    'etat'=> $pendingTransac->etat,
                    'date'=> $pendingTransac->date_transaction,
                    'initiated_name'=> $user->name,
                ];
                $titre="Validée";
                $msg="Votre paiement a été validé.";
                Mail::send( 'transactions_pending.email', ['titre'=>$titre, 'msge' => $msg,'data'=>$data ], function ( $message ) use ( $initiatedEmail, $msg,$data, $titre, $pdfContent ) {
                        $message->to( $initiatedEmail );
                        $message->subject( 'Notification' );
                        $message->attachData( $pdfContent, 'quittance_paiement_cnss.pdf', [
                            'mime' => 'application/pdf',
                        ] );
                });

                return response()->json(['success' => $response['body']['message'] . ' . Un email de notification vous sera envoyé.'], 200);
                //return $this->rappelSearch($numEmp);
            } else {
                #Flash::errors($responseBody['message']);

                return response()->json(['error' => 'Erreur lors du paiement : ' . $responseBody['message']], 500);
               // return redirect()->back()->withErrors('Erreur lors du paiement : ' . $responseBody['message']);
            }
        } else {
            Flash::error('Erreur lors de la connexion au service de paiement.');
            return response()->json(['error' => 'Erreur lors de la connexion au service de paiement.'], 500);
            //return redirect()->back()->withErrors('Erreur lors de la connexion au service de paiement.' );
        }
    } catch ( \Exception $e ) {
        Log::error('PAIEMENT TREAD: ' . $e->getMessage());
         return response()->json(['error' => "Une erreur est survenue lors de l'opération."], 500);
        }
    }



    public function paiementOTR(Request $request){

    $dotenv = Dotenv::createImmutable(base_path());
    $dotenv->load();

    $idTransac = $request->input('idTransac');

    $pendingTransac = PendingTransaction::find($idTransac);

        $amount = ( float ) str_replace( ' ', '', preg_replace( '/[^0-9]/', '', $pendingTransac->montant) );
        $transactionDate = now()->format( 'Y-m-d H:i:s' );
        if ( Auth::user() != null ) {
            $email = Auth::user()->email;
        }
        // Construire l'objet $data
        $data = [
            'referenceDeclaration' => $pendingTransac->reference,
            'referenceTransaction' =>$pendingTransac->reference_transac,
            'montant' => $amount,
            'contribuable' => $pendingTransac->contribuable,
            'nif' => $pendingTransac->numero_employeur,
            'comptealt' => $pendingTransac->compte,
            'email' =>  $email,
        ];
       
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
         return response()->json(['error' => $message], 500);

     }

      // Consommation du Web Service
      if($token!=null){
        $responsePayment = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->post($urlPayment, $data);
      }else{
        return response()->json(['error' => "Serveur temporairement indisponible. Veuillez réessayer plus tard."], 500);
      }
    try{

  
       #dd($data);
       // Vérification de la réponse
       if ($responsePayment->successful()) {
           $responseBody = $responsePayment->json();
         

            if(isset($responseBody) && isset($responseBody["code"])){
                $code= Str::before($responseBody["code"], " ");
                #dd($code);
                if($code==500){
                    $msg=html_entity_decode($responseBody["message"]);
                    if ($email != null) {
                        Mail::send('notifications.index', ['msge' => $msg], function ($message) use ($email, $msg) {
                            $message->to($email);
                            $message->subject('Notification');
                        });
                        #Flash::success($response['body']['message'] . ' . Un email de notification vous sera envoyé.');
                    }
                    return response()->json(['error' => $msg], 500);
                   // return redirect()->back()->withErrors($msg);
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
                if ($email != null) {
                        Mail::send('otr.email', ['others' => $othersInfos], function ($message) use ($email, $othersInfos,$pdfContent) {
                            $message->to($email);
                            $message->subject('Détails Paiement OTR : ' . $othersInfos['refDecla']);
                            $message->attachData( $pdfContent, 'quittance_paiement_OTR.pdf', [
                                'mime' => 'application/pdf',
                            ] );
                        });
                        Flash::success("Opération Réussie" . ' . Un email de notification vous sera envoyé.');
                }
                $pendingTransac->etat = 'validé';
                $pendingTransac->save();
    
              //  $initiated_name= Auth::user()->name;

                $user= Users::where('id',$pendingTransac->initiated_by)->first();
                $initiatedEmail =$user->email;
                $data=[
                    'comptealt' =>  $pendingTransac->compte,
                    'montant'=> $pendingTransac->montant_ttc,
                    'reference'=> $pendingTransac->reference,
                    'etat'=> $pendingTransac->etat,
                    'date'=> $pendingTransac->date_transaction,
                    'initiated_name'=> $user->name,
                ];
                $titre="Validée";
                $msg="Votre paiement a été validé.";
                Mail::send( 'transactions_pending.email', ['titre'=>$titre, 'msge' => $msg,'data'=>$data ], function ( $message ) use ( $initiatedEmail, $msg,$data, $titre,$pdfContent ) {
                        $message->to( $initiatedEmail );
                        $message->subject( 'Notification' );
                        $message->attachData( $pdfContent, 'quittance_paiement_OTR.pdf', [
                            'mime' => 'application/pdf',
                        ] );
                });

                return response()->json(['success' => 'Opération réussie' . ' . Un email de notification vous sera envoyé.'], 200);
                //return $this->rappelSearch($numEmp);
                }else{
                    return response()->json(['error' => "Votre Opération n'a pas aboutie. Veuillez réessayer ! "], 500);
                    //return redirect()->route('otr.etax')->withErrors("Votre Opération n'a pas aboutie. Veuillez réessayer ! ");
                    #return redirect()->back()->withErrors("Votre Opération n'a pas aboutie. Veuillez réessayer ! ");
                }
               
           } else {
               #Flash::errors($responseBody['message']);
               return response()->json(['error' => 'Erreur lors du paiement ' ]);
           }
       } else {
           Flash::error('Erreur lors de la connexion au service de paiement.');
           return response()->json(['error' => 'Erreur lors de la connexion au service de paiement.']);
       }
    } catch ( \Exception $e ) {
            Log::error('PAIEMENT TREAD: ' . $e->getMessage());
         return response()->json(['error' => "Une erreur est survenue lors de l'opération."], 500);
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
    public function listing() {
        if ( Auth::user() != null ) {
            $mail=Auth::user()->email;
            $racine=Auth::user()->racine;
            $cptClient=CptClient::where('racine',$racine)->first();
            if (!$cptClient) {
                return redirect()->back()->withErrors('Aucun compte client trouvé.');
            }
             $comptes=Compte::where('racine',$cptClient->racine)->orderBy('compte')->get();
            #dd($comptes);
            $transactions=[];
            try {
            $types = $this->getTypeOperation();
            } catch ( \Exception $e ) {
            if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            } else {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            }
            return redirect()->back()->withErrors( $message );
        }
           /* $profilId = Auth::user()->profil;

            $profilEntitie = Profil::where('id',$profilId)->first();
            //dd( $profil->libelle);
            $profil = $profilEntitie->libelle;
          //  dd($profil);
            $initiateur="INITIATEUR";
            $validateur="VALIDATEUR";
            $autonome="AUTONOME";*/
            #return view( 'home' )->with( 'cptClients', $comptes );
            return view('transactions_pending.index',compact('comptes', 'transactions','types')) ;
        } else {
            Auth::logout();
            return redirect( '/login' );
        }
    }


    private function getTypeOperation() {
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();

        $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
        $typeOperationEndPoint = env( 'TYPE_OPERATION_ENDPOINT', 'api_get_typeOperation' );

        $urlTypeOperation = $baseUrl . $typeOperationEndPoint ;
        // Authentification pour récupérer le token
        try {
            $token = $this->getToken();
        } catch ( \Exception $e ) {
            if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            } else {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            }
            return redirect()->back()->withErrors($message);
        }

        // Consommation du Web Service pour les opérations
        if ( $token != null ) {

            try {

            $responseTypeOperation = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ] )->get($urlTypeOperation);
        } catch ( \Exception $e ) {
            if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            } else {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            }
            return redirect()->back()->withErrors($message);
        }
        } else {
            return redirect()->back()->withErrors( 'Serveur indisponible.' );
        }
        // Vérification de la réponse
        if ( $responseTypeOperation->successful() ) {
            $data = $responseTypeOperation->json();
            #dd($data);
            if ( isset( $data ) ) {
                $typeOperations = $data;
                // Récupération des types opérations
                return $typeOperations;
            }
        }
        return null;
    }
/**
 * 
 */
    public function filter(Request $request ) {
        // Exemple : accéder individuellement aux paramètres
        $compte = $request->input( 'compte' );
        $typeOperation = $request->input( 'type' );
        $dateDebut = $request->input( 'date_debut' );
        $dateFin = $request->input( 'date_fin' );

        if ( $dateDebut == null ) {
            return redirect()->back()->withErrors( 'Date de début est obligatoire' );
        }
        if ( $dateFin == null ) {
            return redirect()->back()->withErrors( 'Date de fin est obligatoire' );
        }
        $params = [
            'comptealt' =>  $compte,
            'typeTransaction' => $typeOperation,
            'dateDebut' =>  $dateDebut,
            'dateFin' => $dateFin,
        ];
       
        // Affichage des paramètres (optionnel, pour debug)
       # dd($params);
        #$compte = $request->input( 'compte' );
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();


        $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
        $transactionsEndPoint = env( 'CNSS_API_GET_TRANSACTION', 'api_get_transactions' );

        $urlTransactions = $baseUrl . $transactionsEndPoint;

        // Récupération du token
        try {
            $token = $this->getToken();
        } catch ( \Exception $e ) {
            if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            } else {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            }
            return redirect()->back()->withErrors( $message );
        }

        // Consommation du Web Service pour les cotisations
        if ( $token != null ) {
            $responseTransactions = Http::withHeaders( [
                'Authorization' => "Bearer {$token}",
            ] )->post( $urlTransactions,$params);
        } else {
            return redirect()->back()->withErrors( 'Serveur indisponible.' );
        }

        // Vérification de la réponse
        if ( $responseTransactions->successful() ) {
            $data = $responseTransactions->json();
            
            if ( isset( $data) ) {
             
                $transactions = $data;
                #dd($transactions);
                // Récupération des cotisations
            } else {
                $transactions=[];
            }
        } else {
            $transactions=[];
        }

   

        #========================

        if ( Auth::user() != null ) {
            $mail=Auth::user()->email;
            $racine=Auth::user()->racine;
            $cptClient=CptClient::where('racine',$racine)->first();
             $comptes=Compte::where('racine',$cptClient->racine)->orderBy('compte')->get();
            #dd($comptes);
            $types = $this->getTypeOperation();
            return view( 'transactions.index',compact('comptes', 'transactions','types')) ;
        } else {
            Auth::logout();
            return redirect( '/login' );
            }
        }
/**
 * 
 */
        public function quittance($transaction){
            $dotenv = Dotenv::createImmutable( base_path() );
            $dotenv->load();
    
            $baseUrl = env('API_TAX_BASE_URL', 'base_url');
            $transactionEndPoint = env('GET_TRANSACTION', 'api_get_trans');
    
            $urlTransaction = $baseUrl . $transactionEndPoint . "{$transaction}";
            #dd($urlTransaction);
            // Récupération du token
            try {
                $token = $this->getToken();
            } catch ( \Exception $e ) {
                if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                    $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
                } else {
                    $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
                }
                return redirect()->back()->withErrors( $message );
            }
    
            // Consommation du Web Service pour les cotisations
            if ( $token != null ) {
                $responseTransaction = Http::withHeaders( [
                    'Authorization' => "Bearer {$token}",
                ] )->get($urlTransaction);
            } else {
                return redirect()->back()->withErrors('Serveur indisponible.' );
            }
    
            // Vérification de la réponse
            #dd($responseTransaction);
            if ($responseTransaction->successful()) {
                $data = $responseTransaction->json();
                #dd($data);
                if (isset($data)) {
                    $transaction = $data;
                    #dd($transactions);
                    // Récupération des cotisations
                } 
            }
            #$transaction
            $data=['transaction'=> $transaction];
            #dd($data);
            $pdf= PDF::loadView('transactions.quittance',$data);
            return $pdf->stream('quittance'. $transaction['referenceTransaction'].'.pdf' );
            }
        }