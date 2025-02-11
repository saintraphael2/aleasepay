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

class MouvementController extends AppBaseController
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
        if(Auth::user()!=null ){
        $mail=Auth::user()->email;
        $racine=Auth::user()->racine;
        $cptClient=CptClient::where('racine',$racine)->first();
        $comptes=Compte::where('racine',$cptClient->racine)->get();
        //dd($comptes);
        if($request->deb == null){
             $fin= Carbon::now();
             $deb=$fin->copy()->startOfMonth();

           
        }else{
            $fin= Carbon::parse($request->fin);
            $deb=Carbon::parse($request->deb);
        }
      
        $compte=($request->compte !== null)?$request->compte:$comptes[0]->compte;
        $mouvements=Mouvement::where('ECRCPT_NUMCPTE', $compte)->whereBetween('LOT_DATE', [$deb,$fin])->orderby('LOT_DATE','asc')->get();
        $soldedeb = Http::post('http://testwin.aleaseapi.com/api/myalt_v1/soldeDate', [
            'dateSolde' => $deb->format('d/m/Y'),
            'compte' => $compte,
            
        ]); //dd( $soldedeb);

        $soldefin = Http::post('http://testwin.aleaseapi.com/api/myalt_v1/soldeDate', [
            'dateSolde' => $fin->format('d/m/Y'),
            'compte' => $compte,
            
        ]); 
       // echo'<pre>';
    #dd($soldedeb);exit;
        return view('mouvements.index')->with(['mouvements'=>$mouvements,'deb'=>$deb,'fin'=>$fin,'comptes'=>$comptes,
        'compte'=> $compte,'soldedeb'=>($soldedeb!=null)?$soldedeb['solde']:0,'soldefin'=>($soldefin!=null)?$soldefin['solde']:0]);
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
    public function releve($compte,$deb,$fin){
        ini_set('max_execution_time', 500);
        $soldedeb = Http::post('http://testwin.aleaseapi.com/api/myalt_v1/soldeDate', [
            'dateSolde' => Carbon::parse($deb)->addDays(-1)->format('d/m/Y'),
            'compte' => $compte,
            
        ]);//var_dump($soldedeb['solde']);exit;
       // $soldedeb =$soldedeb['solde'];
       $comptes=Compte::where('compte',$compte)->first();
        $mouvements=Mouvement::where('ECRCPT_NUMCPTE', $compte)->whereBetween('LOT_DATE', [$deb,$fin])->orderby('LOT_DATE','asc')->get();
       /* $data=['mouvements'=>$mouvements,'compte'=>$compte,'deb' => Carbon::parse($deb)->format('d-m-Y'),'fin'=>Carbon::parse($fin)->format('d-m-Y')];
        $pdf= PDF::loadView('mouvements.releve',$data);
        return $pdf->download('releve.pdf');*/
         $fpdf= new Fpdf();
         $fpdf->AliasNbPages();
         $fpdf->intitule=$comptes->intitule;
         $fpdf->compte=$compte;
         $fpdf->devise=$comptes->devise_code." ".$comptes->devise_libelle;
         $fpdf->deb=Carbon::parse($deb)->format('d/m/Y');
         $fpdf->fin=Carbon::parse($fin)->format('d/m/Y');
         $fpdf->auteur=Auth::user()->email;
         $fpdf->datedition=Carbon::now()->toDateTimeString();
         $fpdf->rib=$comptes->cle;
         $fpdf->soldeinit=$soldedeb['solde'];
        
        $fpdf->AddPage();
       
    $fpdf->SetFont('Courier', 'B', 8);
    /*$fpdf->SetLineWidth(1);
    $fpdf->Line(10,80,200,80);*/
    $solde=$soldedeb['solde'];
    $y=97;
    $total_debit=0;
    $total_credit=0;
    foreach($mouvements as $mouvement){
        $solde=($mouvement->ECRCPT_SENS=='D')? ($solde-$mouvement->ECRCPT_MONTANT) :($solde+$mouvement->ECRCPT_MONTANT) ;
        $total_debit=($mouvement->ECRCPT_SENS=='D')? ($total_debit+$mouvement->ECRCPT_MONTANT) :($total_debit+0);
        $total_credit=($mouvement->ECRCPT_SENS=='C')? ($total_credit+$mouvement->ECRCPT_MONTANT) :($total_credit+0);;
        $fpdf->SetXY(10,$y);
        $fpdf->Line(10,$y,10,$y+5);
        $fpdf->Line(200,$y,200,$y+5);
        $fpdf->Line(30,$y,30,$y+5);
        $fpdf->Line(100,$y,100,$y+5);
        $fpdf->Line(150,$y,150,$y+5);
        $fpdf->Cell(20, 5, $mouvement->LOT_DATE->format('d-m-Y'),0,0,'C',false);
        $fpdf->Cell(70, 5, utf8_decode($mouvement->ECRCPT_LIBELLE),0,0,'L',false);
        $fpdf->Cell(25, 5, ($mouvement->ECRCPT_SENS=='D')? number_format($mouvement->ECRCPT_MONTANT, 0,"", " ") :'',0,0,'R',false);
        $fpdf->Cell(25, 5, ($mouvement->ECRCPT_SENS=='C')? number_format($mouvement->ECRCPT_MONTANT, 0,"", " ") :'',0,0,'R',false);
        
        $fpdf->Cell(25, 5,( $solde<=0)? number_format($solde, 0,"", " "):'',0,0,'C',false);
        $fpdf->Cell(25, 5, ( $solde>0)? number_format($solde, 0,"", " "):'',0,1,'C',false);
        $y+=5;
        if($y>260 ){
            $fpdf->Line(10,$y,200,$y);
            $y=97;
            $fpdf->AddPage();
        }
    }
    $fpdf->Line(10,$y,200,$y);

    $fpdf->Line(10,$y+10,200,$y+10);

    $fpdf->Line(10,$y,10,$y+10);
    $fpdf->Line(200,$y,200,$y+10);
    //$fpdf->Line(30,$y,30,$y+10);
   // $fpdf->Line(100,$y,100,$y+10);$fpdf->Cell(35, 5, ( $solde<=0)? number_format($solde, 0,"", " "):'',0,0,'C',false);
        
       // $fpdf->Cell(25, 5,( $solde>0)? number_format($solde, 0,"", " "):'',0,0,'C',false);
    //$fpdf->Line(150,$y,150,$y+10);
    if($y==97){
        $fpdf->SetXY(10,$y);
    }

        $fpdf->Cell(70, 5, number_format($soldedeb['solde'], 0,"", " "),0,0,'C',false);
        $fpdf->Cell(30, 5, number_format($total_debit, 0,"", " "),0,0,'C',false);
        $fpdf->Cell(30, 5, number_format($total_credit, 0,"", " "),0,0,'C',false);
        
        $fpdf->Cell(25, 5, ( $solde<=0)? number_format($solde, 0,"", " "):'',0,0,'C',false);
        $fpdf->Cell(25, 5, ( $solde>0)? number_format($solde, 0,"", " "):'',0,1,'C',false);
        $fpdf->Cell(40, 5, utf8_decode('Solde Précédent'),0,0,'C',false);
        $fpdf->Cell(50, 5, utf8_decode('Total Débit'),0,0,'C',false);
        $fpdf->Cell(35, 5, utf8_decode('Total Crédit'),0,0,'C',false);
        $fpdf->Cell(35, 5, utf8_decode('Solde Débit'),0,0,'C',false);
        
        $fpdf->Cell(25, 5, utf8_decode('Solde Crédit'),0,0,'C',false);
        
   
    
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