<?php

namespace App\DataTables;

use App\Models\Bordereau;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class BordereauDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public $client;
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        
        return $dataTable
        ->editColumn('created_at', function ($request) {
            return $request->created_at->format('d-m-Y');
        })
        ->editColumn('date_traitement', function ($request) {
            return ($request->date_traitement)?$request->date_traitement->format('d-m-Y'):'';
        })
        ->editColumn('date_retrait', function ($request) {
            return ($request->date_retrait)?$request->date_retrait->format('d-m-Y'):'';
        })
        ->editColumn('type', function ($request) {
            return $request->types->libelle;
        })->addColumn('action', 'bordereaus.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Bordereau $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bordereau $model)
    {
        $query=$model::where('client',$this->client);
        return $query->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'language' => [
                    'url' => url('vendor/datatables/French.json')
                ],
                'buttons'   => [
                    // Enable Buttons as per your need
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'created_at'=>['title' =>'Date Commande'],
            'compte',
            'type',
            'nombre',
          
            'date_traitement'=>['title' =>'Date de Prise en Charge'],
            
            'date_retrait'=>['title' =>'Date de livraison'],
         
            'feuillet_deb' =>['title' =>'Premier Feuillet'],
            'feuillet_fin' =>['title' =>'Dernier Feuillet']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'bordereaus_datatable_' . time();
    }
}
