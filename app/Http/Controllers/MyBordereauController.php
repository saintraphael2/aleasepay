<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\CptClient;
use App\Models\Compte;
use App\Models\Connexion;
use Dotenv\Dotenv;
use App\DataTables\Type_bordereauDataTable;
use App\Http\Requests\CreateType_bordereauRequest;
use App\Http\Requests\UpdateType_bordereauRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Type_bordereauRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Flash;

class MyBordereauController extends AppBaseController
 {

    private $typeBordereauRepository;

    public function __construct( Type_bordereauRepository $typeBordereauRepo )
 {
        $this->typeBordereauRepository = $typeBordereauRepo;
    }

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

    private function getTypeBordereaux() {
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();

        $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
        $typeBordereauEndPoint = env( 'BORDEREAU_API_GET_TYPE_BORDEREAU', 'api_get_typebordereau' );

        $urlTypeBordereau = $baseUrl . $typeBordereauEndPoint ;
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
        try {
            if ( $token != null ) {
                $responseTypeBordereau = Http::withHeaders( [
                    'Authorization' => "Bearer {$token}",
                ] )->get( $urlTypeBordereau );
            } else {
                return redirect()->back()->withErrors( 'Serveur indisponible.' );
            }
            // Vérification de la réponse
            if ( $responseTypeBordereau->successful() ) {
                $data = $responseTypeBordereau->json();
                ##dd( $data );
                if ( isset( $data[ 'body' ] ) ) {
                    $typebordereaux = $data[ 'body' ];
                    // Récupération des types bordereaux
                    return $typebordereaux;
                }
            }
        } catch ( \Exception $e ) {
            if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            } else {
                $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
            }
            return redirect()->back()->withErrors( $message );
        }
        return null;
    }

    /**
    * Display a listing of the Type_bordereau.
    */

    public function index() {
        if ( Auth::user() != null ) {
            $mail = Auth::user()->email;
            $racine = Auth::user()->racine;
            $cptClient = CptClient::where( 'racine', $racine )->first();
            $comptes = Compte::where( 'racine', $cptClient->racine )->get();
            #dd( $comptes );
            $bordereaux = [];
            try {
                $types = $this->getTypeBordereaux();
                return view( 'commandeBordereau.index', compact( 'comptes', 'bordereaux', 'types' ) ) ;
            } catch ( \Exception $e ) {
                if ( $e->getCode() === 0 || explode( ':', $e->getMessage() )[ 0 ] === 'cURL error 7' ) {
                    $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
                } else {
                    $message = 'Serveur temporairement indisponible. Veuillez réessayer plus tard.';
                }
                return redirect()->back()->withErrors( $message );
            }
            #return view( 'home' )->with( 'cptClients', $comptes );

        } else {
            Auth::logout();
            return redirect( '/login' );
        }
    }

    /**
    * Show the form for creating a new Type_bordereau.
    */

    public function command()
 {
        if ( Auth::user() != null ) {
            $mail = Auth::user()->email;
            $racine = Auth::user()->racine;
            $cptClient = CptClient::where( 'racine', $racine )->first();
            $comptes = Compte::where( 'racine', $cptClient->racine )->get();
            $types = $this->getTypeBordereaux();
            $dateCommande =  Carbon::now()->format( 'Y-m-d' );

            #$dateCommande =  '13/03/2025';

            #dd( $datecomande );
            #return view( 'home' )->with( 'cptClients', $comptes );
            return view( 'commandeBordereau.form' )->with( [ 'dateCommande'=> $dateCommande, 'comptes'=>$comptes, 'types'=>$types ] );
        } else {
            Auth::logout();
            return redirect( '/login' );
        }
    }

    public function docommand( Request $request ) {
        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();

        $validated = $request->validate( [
            'dateCommande' => 'required|string',
            'code' => 'required|string',
            'quantite' => 'required|integer|min:1',
            'compte' => 'required|string'
        ] );
        $datec = Carbon::parse( $validated[ 'dateCommande' ] )->format( 'd/m/Y' );

        session( [
            'dateCommande' => $datec,
        ] );
        $data = [
            'dateCommande' => $datec,
            'code' =>$validated[ 'code' ],
            'quantite' => $validated[ 'quantite' ],
            'compte' => $validated[ 'compte' ]
        ];

        $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
        $commandEndpoint = env( 'BORDEREAU_API_POST_BORDEREAU', 'api_post_commandeBordereau' );
        $urlCommand = $baseUrl . $commandEndpoint;

        // Authentification pour récupérer le token
        $tokenEndpoint = env( 'API_GET_TOKEN', 'token_api' );
        $urlAuthenticate = $baseUrl . $tokenEndpoint;
        $username = env( 'API_USERNAME', 'default_user' );
        $password = env( 'API_PASSWORD', 'default_password' );

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

        if ( $token != null ) {
            $responseCommand = Http::withHeaders( [
                'Authorization' => "Bearer {$token}",
            ] )->post( $urlCommand, $data );
        } else {
            return redirect()->back()->withErrors( 'Serveur indisponible.' );
        }
        #dd( $data );
        if ( $responseCommand->successful() ) {
            $responseBody = $responseCommand->json();

            #if ( isset( $responseBody ) ) {
                #    if ( isset( $responseBody[ 'code' ] ) ) {
                    #      $code = Str::before( $responseBody[ 'code' ], ' ' );
                    #     #dd( $code );
                    #    if ( $code == 500 ) {
                        #        $msg = html_entity_decode( $responseBody[ 'message' ] );
                        #        return redirect()->back()->withErrors( $msg );
                        #    }
                        # }

                        # }

                        #dd( $responseBody );

                        if ( isset( $responseBody ) ) {
                            if (isset( $responseBody[ 'code' ] )) {
                                
                                $code = Str::before( $responseBody[ 'code' ], ' ' );
                                #dd($code);
                                if ( $code == 500 ) {
                                    $msg = html_entity_decode( $responseBody[ 'message' ] );
                                    return redirect()->back()->withErrors( $msg );
                                }
                            } else {

                                #dd( $responseBody );
                                $response = $responseBody[ 'body' ];

                                if ( $response[ 'id' ] != null ) {
                                    Flash::success( 'Votre commande a été enregistrée avec succès.' );
                                    #dd( $response[ 'numeroOrdre' ] );
                                    $this->checkBordereauEtat( $response[ 'numeroOrdre' ] );
                                    $date_Commande = session( 'dateCommande', $datec );
                                    $datafilter = [
                                        'comptealt' => $data[ 'compte' ],
                                        'typebordereau' =>$data[ 'code' ],
                                        'dateDebut' => $date_Commande,
                                        'dateFin' =>$date_Commande
                                    ];

                                    #dd( $datafilter );
                                    $bord = $this->getBordereaux( $datafilter );
                                    #dd( $bord );
                                    if ( Auth::user() != null ) {
                                        $mail = Auth::user()->email;
                                        $racine = Auth::user()->racine;
                                        $cptClient = CptClient::where( 'racine', $racine )->first();
                                        $comptes = Compte::where( 'racine', $cptClient->racine )->get();
                                        #dd( $comptes );

                                        $bordereaux =  $bord;
                                        $types = $this->getTypeBordereaux();
                                        #dd( $types );
                                        #return view( 'home' )->with( 'cptClients', $comptes );
                                        return view( 'commandeBordereau.index', compact( 'comptes', 'bordereaux', 'types' ) ) ;
                                    }
                                }
                            }
                        }
                    }
                }
                /**
                *  String comptealt;
                *  String typebordereau;
                *   String dateDebut;
                *  String dateFin;
                *
                */

                public function filter( Request $request ) {
                    $dotenv = Dotenv::createImmutable( base_path() );
                    $dotenv->load();

                    $compte = $request->input( 'compte' );
                    $typeBordereau = $request->input( 'typebordereau' );
                    $dateDebut = $request->input( 'date_debut' );
                    $dateFin = $request->input( 'date_fin' );

                    if ( $dateDebut == null ) {
                        return redirect()->back()->withErrors( 'Date de début est obligatoire' );
                    }
                    if ( $dateFin == null ) {
                        return redirect()->back()->withErrors( 'Date de fin est obligatoire' );
                    }
                    $data = [
                        'comptealt' =>$compte,
                        'typebordereau' =>$typeBordereau,
                        'dateDebut' =>  Carbon::parse( $dateDebut )->format( 'd/m/Y' ),
                        'dateFin' => Carbon::parse( $dateFin )->format( 'd/m/Y' )
                    ];
                    #dd( $data );
                    $bord = $this->getBordereaux( $data );
                    #dd( $bordereaux );
                    if ( Auth::user() != null ) {
                        $mail = Auth::user()->email;
                        $racine = Auth::user()->racine;
                        $cptClient = CptClient::where( 'racine', $racine )->first();
                        $comptes = Compte::where( 'racine', $cptClient->racine )->get();
                        #dd( $comptes );

                        $bordereaux =  $bord;
                        $types = $this->getTypeBordereaux();
                        #dd( $types );
                        #return view( 'home' )->with( 'cptClients', $comptes );
                        return view( 'commandeBordereau.index', compact( 'comptes', 'bordereaux', 'types' ) ) ;
                    }
                }

                public function checkBordereauEtat( $numeroOrdre ) {
                    $dotenv = Dotenv::createImmutable( base_path() );
                    $dotenv->load();
                    $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
                    $checkBordereauEndPoint = env( 'BORDEREAU_API_CHECK_BORDEREAU', 'api_check_bordereau_etat' );

                    $urlCheckBordereau = $baseUrl . $checkBordereauEndPoint . "{$numeroOrdre}";

                    #dd( $urlCheckBordereau );
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

                    // Consommation du Web Service pour les opérations
                    if ( $token != null ) {
                        $responseEtatBordereau = Http::withHeaders( [
                            'Authorization' => "Bearer {$token}",
                        ] )->get( $urlCheckBordereau );
                    } else {
                        return redirect()->back()->withErrors( 'Serveur indisponible.' );
                    }
                    if ( $responseEtatBordereau->successful() ) {
                        $responseBody = $responseEtatBordereau->json();
                        #dd( $responseBody[ 'body' ][ 'etat' ] );
                        return $responseBody[ 'body' ][ 'etat' ] ;
                    }
                    return null;
                }

                public function getBordereaux( $data ) {
                    $baseUrl = env( 'API_TAX_BASE_URL', 'base_url' );
                    $filterEndpoint = env( 'FILTER_API_POST_BORDEREAU', 'api_post_filterBordereau' );
                    $urlFilter = $baseUrl . $filterEndpoint;

                    // Authentification pour récupérer le token
                    $tokenEndpoint = env( 'API_GET_TOKEN', 'token_api' );
                    $urlAuthenticate = $baseUrl . $tokenEndpoint;
                    $username = env( 'API_USERNAME', 'default_user' );
                    $password = env( 'API_PASSWORD', 'default_password' );

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

                    if ( $token != null ) {
                        $responseCommand = Http::withHeaders( [
                            'Authorization' => "Bearer {$token}",
                        ] )->post( $urlFilter, $data );
                    } else {
                        return redirect()->back()->withErrors( 'Serveur indisponible.' );
                    }

                    if ( $responseCommand->successful() ) {
                        $responseBody = $responseCommand->json();
                        #dd( $responseBody );
                        if ( isset( $responseBody ) ) {
                            $response = $responseBody;
                            foreach ( $response as &$bordereau ) {
                                $etat = $this->checkBordereauEtat( $bordereau[ 'numeroOrdre' ] );
                                $bordereau[ 'etat' ] = $etat;
                            }
                            return $response;
                        }
                    }
                }

                /**
                * Store a newly created Type_bordereau in storage.
                */

                public function store( CreateType_bordereauRequest $request )
 {
                    $input = $request->all();

                    $typeBordereau = $this->typeBordereauRepository->create( $input );

                    Flash::success( 'Type Bordereau saved successfully.' );

                    return redirect( route( 'typeBordereaus.index' ) );
                }

                /**
                * Display the specified Type_bordereau.
                */

                public function show( $id )
 {
                    $typeBordereau = $this->typeBordereauRepository->find( $id );

                    if ( empty( $typeBordereau ) ) {
                        Flash::error( 'Type Bordereau not found' );

                        return redirect( route( 'typeBordereaus.index' ) );
                    }

                    return view( 'type_bordereaus.show' )->with( 'typeBordereau', $typeBordereau );
                }

                /**
                * Show the form for editing the specified Type_bordereau.
                */

                public function edit( $id )
 {
                    $typeBordereau = $this->typeBordereauRepository->find( $id );

                    if ( empty( $typeBordereau ) ) {
                        Flash::error( 'Type Bordereau not found' );

                        return redirect( route( 'typeBordereaus.index' ) );
                    }

                    return view( 'type_bordereaus.edit' )->with( 'typeBordereau', $typeBordereau );
                }

                /**
                * Update the specified Type_bordereau in storage.
                */

                public function update( $id, UpdateType_bordereauRequest $request )
 {
                    $typeBordereau = $this->typeBordereauRepository->find( $id );

                    if ( empty( $typeBordereau ) ) {
                        Flash::error( 'Type Bordereau not found' );

                        return redirect( route( 'typeBordereaus.index' ) );
                    }

                    $typeBordereau = $this->typeBordereauRepository->update( $request->all(), $id );

                    Flash::success( 'Type Bordereau updated successfully.' );

                    return redirect( route( 'typeBordereaus.index' ) );
                }

                /**
                * Remove the specified Type_bordereau from storage.
                *
                * @throws \Exception
                */

                public function destroy( $id )
 {
                    $typeBordereau = $this->typeBordereauRepository->find( $id );

                    if ( empty( $typeBordereau ) ) {
                        Flash::error( 'Type Bordereau not found' );

                        return redirect( route( 'typeBordereaus.index' ) );
                    }

                    $this->typeBordereauRepository->delete( $id );

                    Flash::success( 'Type Bordereau deleted successfully.' );

                    return redirect( route( 'typeBordereaus.index' ) );
                }

            }
