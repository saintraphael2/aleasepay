<?php

namespace App\Http\Controllers;

use App\DataTables\Type_bordereauDataTable;
use App\Http\Requests\CreateType_bordereauRequest;
use App\Http\Requests\UpdateType_bordereauRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Type_bordereauRepository;
use Illuminate\Http\Request;
use Flash;

class Type_bordereauController extends AppBaseController
{
    /** @var Type_bordereauRepository $typeBordereauRepository*/
    private $typeBordereauRepository;

    public function __construct(Type_bordereauRepository $typeBordereauRepo)
    {
        $this->typeBordereauRepository = $typeBordereauRepo;
    }

    /**
     * Display a listing of the Type_bordereau.
     */
    public function index(Type_bordereauDataTable $typeBordereauDataTable)
    {
    return $typeBordereauDataTable->render('type_bordereaus.index');
    }


    /**
     * Show the form for creating a new Type_bordereau.
     */
    public function create()
    {
        return view('type_bordereaus.create');
    }

    /**
     * Store a newly created Type_bordereau in storage.
     */
    public function store(CreateType_bordereauRequest $request)
    {
        $input = $request->all();

        $typeBordereau = $this->typeBordereauRepository->create($input);

        Flash::success('Type Bordereau saved successfully.');

        return redirect(route('typeBordereaus.index'));
    }

    /**
     * Display the specified Type_bordereau.
     */
    public function show($id)
    {
        $typeBordereau = $this->typeBordereauRepository->find($id);

        if (empty($typeBordereau)) {
            Flash::error('Type Bordereau not found');

            return redirect(route('typeBordereaus.index'));
        }

        return view('type_bordereaus.show')->with('typeBordereau', $typeBordereau);
    }

    /**
     * Show the form for editing the specified Type_bordereau.
     */
    public function edit($id)
    {
        $typeBordereau = $this->typeBordereauRepository->find($id);

        if (empty($typeBordereau)) {
            Flash::error('Type Bordereau not found');

            return redirect(route('typeBordereaus.index'));
        }

        return view('type_bordereaus.edit')->with('typeBordereau', $typeBordereau);
    }

    /**
     * Update the specified Type_bordereau in storage.
     */
    public function update($id, UpdateType_bordereauRequest $request)
    {
        $typeBordereau = $this->typeBordereauRepository->find($id);

        if (empty($typeBordereau)) {
            Flash::error('Type Bordereau not found');

            return redirect(route('typeBordereaus.index'));
        }

        $typeBordereau = $this->typeBordereauRepository->update($request->all(), $id);

        Flash::success('Type Bordereau updated successfully.');

        return redirect(route('typeBordereaus.index'));
    }

    /**
     * Remove the specified Type_bordereau from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $typeBordereau = $this->typeBordereauRepository->find($id);

        if (empty($typeBordereau)) {
            Flash::error('Type Bordereau not found');

            return redirect(route('typeBordereaus.index'));
        }

        $this->typeBordereauRepository->delete($id);

        Flash::success('Type Bordereau deleted successfully.');

        return redirect(route('typeBordereaus.index'));
    }
}
