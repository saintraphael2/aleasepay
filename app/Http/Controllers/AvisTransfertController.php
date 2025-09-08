<?php

namespace App\Http\Controllers;

use App\DataTables\MouvementDataTable;
use App\Http\Requests\CreateMouvementRequest;
use App\Http\Requests\UpdateMouvementRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MouvementRepository;
use Illuminate\Http\Request;
use Flash;
use Auth;
use App\Models\CptClient;
use App\Models\Mouvement;
use PDF;
use Illuminate\Support\Carbon;
use App\Models\Compte;
use Illuminate\Support\Facades\Http;
use Codedge\Fpdf\Fpdf\Fpdf;
use Dotenv\Dotenv;

class AvisTransfertController extends AppBaseController
{
    /** @var MouvementRepository $mouvementRepository*/
    private $mouvementRepository;

    public function __construct(MouvementRepository $mouvementRepo)
    {
        $this->mouvementRepository = $mouvementRepo;
    }

    /**
     * Display a listing of the Mouvement.
     */
    public function index(Request $request)
    {

        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();

      
        $transfertUrl= env('ALEASEPAY_TRANSFERT_URL', 'aleasepay_transfert');
        if(Auth::user()!=null ){
            $mail=Auth::user()->email;
            $racine=Auth::user()->racine;
            $cptClient=CptClient::where('racine',$racine)->first();
            $comptes=Compte::where('racine',$cptClient->racine)->orderby('compte','asc')->get();
            //dd($comptes);
            if($request->deb == null){
                $fin= Carbon::now();
                $deb=$fin->copy()->startOfMonth();
                $sens='D';
            
            }else{
                $fin= Carbon::parse($request->fin);
                $deb=Carbon::parse($request->deb);
                $sens=$request->sens;
            }
        
           
            //$mouvements=Mouvement::where('ECRCPT_NUMCPTE', $compte)->whereBetween('LOT_DATE', [$deb,$fin])->orderby('LOT_DATE','asc')->get();
        // $mouvements= Http::post('http://localhost:8082/api/myalt_v1/mouvements', [
                $mouvements= Http::post($transfertUrl, [   
                'matricule' => $racine,
                'sens'=>$sens,
                'dateDeb' => $deb->format('d/m/Y'),
                'dateFin' => $fin->format('d/m/Y'),
            ]); 
            
      // dd($mouvements);
        // echo'<pre>';
        #dd($soldedeb);exit;
            return view('avisTransfert.index')->with(['mouvements'=>json_decode($mouvements->getBody(), true),'deb'=>$deb,'fin'=>$fin,'sens'=>$sens]);
        }else{
            Auth::logout();
            return redirect('/login');
        }
    }


    /**
     * Show the form for creating a new Mouvement.
     */
    public function create()
    {
        return view('mouvements.create');
    }
    public function editAvis($reference,$sens){

        $dotenv = Dotenv::createImmutable( base_path() );
        $dotenv->load();

      $avisUrl= env('ALEASEPAY_AVIS_URL', 'aleasepay_avis');
        ini_set('max_execution_time', 500);
      
       
       
        $avis= Http::post($avisUrl, [   
          
            'reference' => $reference,
            'sens' => $sens
            
        ]); 
        $avis=json_decode($avis->getBody(), true);

        $lib=($sens=='D')?'DEBIT':'CREDIT';
         //dd($avis[0]);
         $fpdf= new Fpdf();
    $fpdf->AddPage();
    $fpdf->Image('images/logoalt.png',10,12,100);
	$fpdf->Rect(115,12,80,15);
    $fpdf->SetXY(120,15);
    $fpdf->SetFont('Courier', 'B', 12);
	$fpdf->Cell(70, 5, 'AVIS DE '.$lib,0,0,'C',false);
    $fpdf->SetXY(120,20);
    $fpdf->Cell(70, 5, $lib.' ADVICE',0,0,'C',false);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->SetXY(10,40);
    $fpdf->Cell(70, 5,  $avis[0]['libelle'],0,0,'L',false);
    $fpdf->SetXY(10,45);
    $fpdf->Cell(70, 5,  $avis[0]['cpteauxilAdr1Spec'],0,0,'L',false);
    $fpdf->SetXY(10,50);
    $fpdf->Cell(70, 5,  $avis[0]['cpteauxilAdr2Spec'],0,0,'L',false);
    $fpdf->SetXY(120,70);
    $fpdf->Cell(70, 5, utf8_decode('Date Opération: '. $avis[0]['lotDate']),0,0,'L',false);
    $fpdf->SetXY(10,85);
    $fpdf->Cell(50, 5, 'Agence',0,0,'L',false);
    $fpdf->Cell(70, 5, ': ALT',0,0,'L',false);
    $fpdf->SetXY(10,90);
    $fpdf->Cell(50, 5, utf8_decode('N° Compte'),0,0,'L',false);
    $fpdf->Cell(70, 5, ': '. $avis[0]['compte'],0,0,'L',false);
    $fpdf->SetXY(10,95);
    $fpdf->Cell(50, 5, utf8_decode('Devise'),0,0,'L',false);
    $fpdf->Cell(70, 5, ': '.$avis[0]['devise'],0,0,'L',false);
    $fpdf->SetXY(10,100);
    $fpdf->Cell(50, 5, utf8_decode('Service'),0,0,'L',false);
    $fpdf->Cell(70, 5, ': OPERATIONS',0,0,'L',false);
    $fpdf->SetXY(10,105);
    $fpdf->Cell(50, 5, utf8_decode('Type Opération'),0,0,'L',false);
    $type_operation=(stripos($avis[0]['ecrcptLibcomp'], "VIREMENT") !== false)?"VIREMENT":"TRANSFERT";
    $fpdf->Cell(70, 5, ': '.$type_operation,0,0,'L',false);
    $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->SetXY(10,120);
    $fpdf->Cell(200, 5, utf8_decode('NOUS VOUS INFORMONS AVOIR DEBITE VOTRE COMPTE DE'),0,0,'C',false);
    $fpdf->SetXY(10,125);
    $fpdf->Cell(200, 5, utf8_decode('WE HEREBY INFORM YOU WE DEBITED YOUR ACCOUNT WITH'),0,0,'C',false);
     $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->Rect(10,140,45,10);$fpdf->SetXY(10,143); $fpdf->Cell(45, 5, utf8_decode('MOTIF'),0,0,'C',false);
    $fpdf->Rect(55,140,95,10);$fpdf->SetXY(55,143); $fpdf->Cell(95, 5, utf8_decode('FRAIS'),0,0,'C',false);
    $fpdf->Rect(150,140,45,10);$fpdf->SetXY(150,143); $fpdf->Cell(45, 5, utf8_decode('MONTANT'),0,0,'C',false);
    $motif=$avis[0]['ecrcptLibcomp'];
    if(preg_match('/\breglement fa\b/', $motif)){
        $motif=str_replace('reglement fa','Règlement Facture',$avis[0]['ecrcptLibcomp']);
    }
    $fpdf->Rect(10,150,45,50);$fpdf->SetXY(12,157);$fpdf->MultiCell(40, 10, utf8_decode($motif), 0, 'L');// $fpdf->Cell(45, 10, utf8_decode('FRAIS SUR TRANSFERT'),0,1,'C',false);
    $fpdf->Rect(55,150,95,50);
    $y=157;
    foreach($avis[0]['ligneTransferts'] as $detail){ 
        $fpdf->SetXY(57,$y);
        $libelle=substr(trim(utf8_decode(ucfirst(strtolower($detail['libelle'])))),0,36);
        if(trim($detail['compte'])=="000073010246"){
            $libelle="Montant Virement";
        }
        if(trim($detail['compte'])=="9970290080" || trim($detail['compte'])=="9970290070"){
            $libelle="Frais";
        }
        $fpdf->Cell(20, 5, $libelle,0,0,'L',false);
        $y+=5;
    }
    
    $fpdf->Rect(150,150,45,50);
    $y=157;
    foreach($avis[0]['ligneTransferts'] as $detail){
        $fpdf->SetXY(152,$y);
        $fpdf->Cell(40, 5,  number_format($detail['montant'], 0," ", " ")." ".$detail['devise'] ,0,0,'R');
        $y+=5;
    }
    $fpdf->Rect(55,200,95,20);
    $fpdf->SetXY(55,205); $fpdf->Cell(95, 5, utf8_decode('Total à votre débit XOF'),0,0,'C',false);
    $fpdf->SetXY(150,205); $fpdf->Cell(40, 5, number_format( $avis[0]['ecrcptMontant'], 0," ", " ")." XOF",0,0,'R',false);
    $fpdf->Rect(150,200,45,20);$fpdf->SetXY(55,205); $fpdf->Cell(95, 5, utf8_decode('Total à votre débit XOF'),0,0,'C',false);
    $fpdf->Rect(55,220,95,20);$fpdf->SetXY(55,225); $fpdf->Cell(95, 5, utf8_decode('Date Valeur'),0,0,'C',false);
    $fpdf->Rect(150,220,45,20);
    $fpdf->SetXY(152,225); $fpdf->Cell(40, 5,  $avis[0]['lotDate'],0,0,'C',false);
    $fpdf->Output();//'D'
    exit;
    }
    /**
     * Store a newly created Mouvement in storage.
     */
    public function store(CreateMouvementRequest $request)
    {
        $input = $request->all();

        $mouvement = $this->mouvementRepository->create($input);

        Flash::success('Mouvement saved successfully.');

        return redirect(route('mouvements.index'));
    }

    /**
     * Display the specified Mouvement.
     */
    public function show($id)
    {
        $mouvement = $this->mouvementRepository->find($id);

        if (empty($mouvement)) {
            Flash::error('Mouvement not found');

            return redirect(route('mouvements.index'));
        }

        return view('mouvements.show')->with('mouvement', $mouvement);
    }

    /**
     * Show the form for editing the specified Mouvement.
     */
    public function edit($id)
    {
        $mouvement = $this->mouvementRepository->find($id);

        if (empty($mouvement)) {
            Flash::error('Mouvement not found');

            return redirect(route('mouvements.index'));
        }

        return view('mouvements.edit')->with('mouvement', $mouvement);
    }

    /**
     * Update the specified Mouvement in storage.
     */
    public function update($id, UpdateMouvementRequest $request)
    {
        $mouvement = $this->mouvementRepository->find($id);

        if (empty($mouvement)) {
            Flash::error('Mouvement not found');

            return redirect(route('mouvements.index'));
        }

        $mouvement = $this->mouvementRepository->update($request->all(), $id);

        Flash::success('Mouvement updated successfully.');

        return redirect(route('mouvements.index'));
    }

    /**
     * Remove the specified Mouvement from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mouvement = $this->mouvementRepository->find($id);

        if (empty($mouvement)) {
            Flash::error('Mouvement not found');

            return redirect(route('mouvements.index'));
        }

        $this->mouvementRepository->delete($id);

        Flash::success('Mouvement deleted successfully.');

        return redirect(route('mouvements.index'));
    }
}