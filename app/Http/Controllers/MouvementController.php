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
        $mouvements=Mouvement::where('ECRCPT_NUMCPTE', $compte)->whereBetween('LOT_DATE', [$deb,$fin])->orderby('LOT_DATE','desc')->get();
       // dd($mouvements);
        return view('mouvements.index')->with(['mouvements'=>$mouvements,'deb'=>$deb,'fin'=>$fin,'comptes'=>$comptes,'compte'=> $compte]);
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
        $mouvements=Mouvement::where('ECRCPT_NUMCPTE', $compte)->whereBetween('LOT_DATE', [$deb,$fin])->orderby('LOT_DATE','desc')->get();
        $data=['mouvements'=>$mouvements,'compte'=>$compte,'deb' => Carbon::parse($deb)->format('d-m-Y'),'fin'=>Carbon::parse($fin)->format('d-m-Y')];
        $pdf= PDF::loadView('mouvements.releve',$data);
        return $pdf->download('releve.pdf');
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
