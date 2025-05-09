<?php

namespace App\Http\Controllers;

use App\DataTables\BordereauDataTable;
use App\Http\Requests\CreateBordereauRequest;
use App\Http\Requests\UpdateBordereauRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\BordereauRepository;
use Illuminate\Http\Request;
use App\Models\CptClient;
use App\Models\Compte;
use App\Models\Type_bordereau;
use Flash;
use Auth;

class BordereauController extends AppBaseController
{
    /** @var BordereauRepository $bordereauRepository*/
    private $bordereauRepository;

    public function __construct(BordereauRepository $bordereauRepo)
    {
        $this->bordereauRepository = $bordereauRepo;
    }

    /**
     * Display a listing of the Bordereau.
     */
    public function index(BordereauDataTable $bordereauDataTable)
    {
        $cptClient=CptClient::where('racine',Auth::user()->racine)->first();
        $bordereauDataTable->client=$cptClient->id;
    return $bordereauDataTable->render('bordereaus.index');
    }


    /**
     * Show the form for creating a new Bordereau.
     */
    public function create()
    {
        $cptClient=CptClient::where('racine',Auth::user()->racine)->first();
        $comptes=Compte::where('racine',Auth::user()->racine)->pluck('compte','compte');
        $type_bordereaux=Type_bordereau::pluck('libelle','id');
        return view('bordereaus.create')->with(['client'=>$cptClient->id,'comptes'=>$comptes,'type_bordereaux'=>$type_bordereaux]);
    }

    /**
     * Store a newly created Bordereau in storage.
     */
    public function store(CreateBordereauRequest $request){
        $input = $request->all();

        $bordereau = $this->bordereauRepository->create($input);

        Flash::success('Votre nouvelle commande est enregistrée avec succès.');

        return redirect(route('bordereaux.index'));
    }

    /**
     * Display the specified Bordereau.
     */
    public function show($id)
    {
        $bordereau = $this->bordereauRepository->find($id);

        if (empty($bordereau)) {
            Flash::error('Bordereau not found');

            return redirect(route('bordereaus.index'));
        }

        return view('bordereaus.show')->with('bordereau', $bordereau);
    }

    /**
     * Show the form for editing the specified Bordereau.
     */
    public function edit($id)
    {
        $bordereau = $this->bordereauRepository->find($id);

        if (empty($bordereau)) {
            Flash::error('Bordereau not found');

            return redirect(route('bordereaux.index'));
        }
        $comptes=Compte::where('racine',Auth::user()->racine)->pluck('compte','compte');
        $type_bordereaux=Type_bordereau::pluck('libelle','id');
        return view('bordereaux.edit')->with(['bordereau'=> $bordereau,'client'=> $bordereau->client,'comptes'=>$comptes,'type_bordereaux'=>$type_bordereaux]);
    }

    /**
     * Update the specified Bordereau in storage.
     */
    public function update($id, UpdateBordereauRequest $request)
    {
        $bordereau = $this->bordereauRepository->find($id);

        if (empty($bordereau)) {
            Flash::error('Bordereau not found');

            return redirect(route('bordereaus.index'));
        }

        $bordereau = $this->bordereauRepository->update($request->all(), $id);

        Flash::success('La commande est mise à jour avec succès.');

        return redirect(route('bordereaux.index'));
    }

    /**
     * Remove the specified Bordereau from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $bordereau = $this->bordereauRepository->find($id);

        if (empty($bordereau)) {
            Flash::error('Bordereau not found');

            return redirect(route('bordereaux.index'));
        }

        $this->bordereauRepository->delete($id);

        Flash::success('La commande est supprimée avec succès.');

        return redirect(route('bordereaux.index'));
    }
}
