<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->dataTables); ?>;

use <?php echo e($config->namespaces->model); ?>\<?php echo e($config->modelNames->name); ?>;
<?php if($config->options->localized): ?>
use Yajra\DataTables\Html\Column;
<?php endif; ?>
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class <?php echo e($config->modelNames->name); ?>DataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', '<?php echo e($config->modelNames->snakePlural); ?>.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\<?php echo e($config->modelNames->name); ?> $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(<?php echo e($config->modelNames->name); ?> $model)
    {
        return $model->newQuery();
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
                'buttons'   => [
                    // Enable Buttons as per your need
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
<?php if($config->options->localized): ?>
                'language' => [
                    'url' => url('//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json'),
                ],
<?php endif; ?>
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
            <?php echo $columns; ?>

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return '<?php echo e($config->modelNames->snakePlural); ?>_datatable_' . time();
    }
}
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/vendor/laravel-generator/scaffold/table/datatable.blade.php ENDPATH**/ ?>