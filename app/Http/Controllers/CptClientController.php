<?php

namespace App\Http\Controllers;

use App\DataTables\CptClientDataTable;
use App\Http\Requests\CreateCptClientRequest;
use App\Http\Requests\UpdateCptClientRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CptClientRepository;
use Illuminate\Http\Request;
use Flash;
use Auth;

class CptClientController extends AppBaseController
{
    /** @var CptClientRepository $cptClientRepository*/
    private $cptClientRepository;

    public function __construct(CptClientRepository $cptClientRepo)
    {
        $this->cptClientRepository = $cptClientRepo;
    }

    /**
     * Display a listing of the CptClient.
     */
    public function index(CptClientDataTable $cptClientDataTable)
    {
    return $cptClientDataTable->render('cpt_clients.index');
    }


    /**
     * Show the form for creating a new CptClient.
     */
    public function create()
    {
        return view('cpt_clients.create');
    }

    /**
     * Store a newly created CptClient in storage.
     */
    public function store(CreateCptClientRequest $request)
    {
        $input = $request->all();

        $cptClient = $this->cptClientRepository->create($input);

        Flash::success('Cpt Client saved successfully.');

        return redirect(route('cptClients.index'));
    }

    /**
     * Display the specified CptClient.
     */
    public function show($id)
    {
        $cptClient = $this->cptClientRepository->find($id);

        if (empty($cptClient)) {
            Flash::error('Cpt Client not found');

            return redirect(route('cptClients.index'));
        }

        return view('cpt_clients.show')->with('cptClient', $cptClient);
    }
    public function rib()
    {
        $cptClient = $this->cptClientRepository->find($id);

        if (empty($cptClient)) {
            Flash::error('Cpt Client not found');

            return redirect(route('cptClients.index'));
        }

        return view('cpt_clients.rib')->with('cptClient', $cptClient);
    }
    /**
     * Show the form for editing the specified CptClient.
     */
    public function edit($id)
    {
        $cptClient = $this->cptClientRepository->find($id);

        if (empty($cptClient)) {
            Flash::error('Cpt Client not found');

            return redirect(route('cptClients.index'));
        }

        return view('cpt_clients.edit')->with('cptClient', $cptClient);
    }

    /**
     * Update the specified CptClient in storage.
     */
    public function update($id, UpdateCptClientRequest $request)
    {
        $cptClient = $this->cptClientRepository->find($id);

        if (empty($cptClient)) {
            Flash::error('Cpt Client not found');

            return redirect(route('cptClients.index'));
        }

        $cptClient = $this->cptClientRepository->update($request->all(), $id);

        Flash::success('Cpt Client updated successfully.');

        return redirect(route('cptClients.index'));
    }

    /**
     * Remove the specified CptClient from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cptClient = $this->cptClientRepository->find($id);

        if (empty($cptClient)) {
            Flash::error('Cpt Client not found');

            return redirect(route('cptClients.index'));
        }

        $this->cptClientRepository->delete($id);

        Flash::success('Cpt Client deleted successfully.');

        return redirect(route('cptClients.index'));
    }
}
