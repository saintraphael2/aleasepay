@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="card-body px-4">
    {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}
</div>

@push('third_party_scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\vendor\infyomlabs\adminlte-templates\src/../views/templates/scaffold/table/datatable/body.blade.php ENDPATH**/ ?>