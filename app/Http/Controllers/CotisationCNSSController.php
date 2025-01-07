<?php

namespace App\Http\Controllers;

use Dotenv\Dotenv;
use App\Models\CptClient;
use App\Models\Compte;
use App\Models\Connexion;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Flash;

class CotisationCNSSController extends Controller {
    public function index() {
        if ( Auth::user() != null ) {
            return view( 'cnss.cotisations' );
        } else {
            Auth::logout();
            return redirect( '/login' );
        }
    }

    /**
    *
    */

    public function search( Request $request ) {
        $numero_employeur = $request->input( 'numero_employeur' );
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
        return view( 'cnss.cotisations', compact( 'cotisations', 'numero_employeur' ) );
    }

    /**
    *
    */

    public function showForm( $reference, $numero_employeur ) {
        // Recherche des informations basées sur la référence
        $cotisation = $this->getCotisationByReference( $reference );
        // Méthode fictive à implémenter

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

    #dd( $request->all() );
    $validated = $request->validate( [
        'referenceID' => 'required|string',
        'amount' => 'required|string', // Formaté avec devise et espaces
        'designation' => 'required|string',
        'requester' => 'required|string',
        'numero_employeur' => 'required|string',
        'comptealt' => 'required|string',
    ] );

    // Nettoyer le champ 'amount' pour extraire uniquement le montant numérique
    $validated[ 'amount' ] = ( float ) str_replace( ' ', '', preg_replace( '/[^0-9]/', '', $validated[ 'amount' ] ) );
    $transactionDate = now()->format( 'Y-m-d H:i:s' );
    // Construire l'objet $data
        $data = [
            'cNSSpaytax' => [
                'referenceID' => $validated['referenceID'],
                'transactionID' => null, // Champ laissé vide ou par défaut
                'amount' => $validated['amount'],
                'transactionDate' => $transactionDate, // Par exemple, date actuelle
                'currency' => 'XOF', // Valeur fixe
                'status' => 1, // Valeur fixe
            ],
            'designation' => $validated['designation'],
            'requester' => $validated['requester'],
            'numeroEmployeur' => $validated['numero_employeur'],
            'comptealt' => $validated['comptealt'],
        ];
        $numEmp = $validated['numero_employeur'];

        $amount = $validated['amount'];
        $comptealt = $validated['comptealt'];
        $compte = Compte::where('compte', $comptealt)->get();
        $solde = $compte[0]->getOriginal()['solde'];
        if ($solde < $amount) {
            return redirect()->back()->withErrors('Erreur lors du paiement : Le solde compte ' . $comptealt . ' est insufisant');
        }
        #return view('home')->with('cptClients',$comptes);
        #dd( $data );
        // Construire l'URL du service de paiement
    $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
    $paymentEndpoint = env( 'CNSS_API_POST_PAYMENT', 'api_post_payment' );
    $urlPayment = $baseUrl . $paymentEndpoint;

    // Authentification pour récupérer le token
    $tokenEndpoint = env( 'API_GET_TOKEN', 'token_api' );
    $urlAuthenticate = $baseUrl . $tokenEndpoint;
    $username = env( 'API_USERNAME', 'default_user' );
    $password = env( 'API_PASSWORD', 'default_password' );
    #dd( $urlAuthenticate );
    

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

    // Consommation du Web Service 
    if ( $token != null ) {
        $responsePayment = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->post($urlPayment, $data);
    } else {
        return redirect()->back()->withErrors( 'Serveur indisponible.' );
    }
        // Vérification de la réponse

        if ($responsePayment->successful()) {
            $responseBody = $responsePayment->json();
            #dd($responseBody);
            $response = $responseBody['Response']['data'];
            $othersInfos = $responseBody['Others'];
            $mail = null;
            #dd($mail);

            if (Auth::user() != null) {
                $mail = Auth::user()->email;
            }

            if ($response['success'] ?? false) {
                if ($mail != null) {
                    Mail::send('cnss.email', ['others' => $othersInfos], function ($message) use ($mail) {
                        $message->to($mail);
                        $message->subject('Détails de la cotisation CNSS Reférence : ' . $othersInfos['refDecla']);
                    });
                    Flash::success($response['body']['message'] . ' . Un email de notification vous sera envoyé.');
                } else {
                    Flash::success($response['body']['message']);
                }
                $referenceTransaction = $othersInfos['referenceTransaction'];
                return $this->rappelSearch($numEmp);
            } else {
                #Flash::errors($responseBody['message']);
                return redirect()->back()->withErrors('Erreur lors du paiement : ' . $responseBody['message']);
            }
        } else {
            Flash::error('Erreur lors de la connexion au service de paiement.');
            return redirect()->back()->withErrors('Erreur lors de la connexion au service de paiement.' );
        }
    }
}
