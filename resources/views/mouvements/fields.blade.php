<!-- Ecrcpt Numcpte Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ECRCPT_NUMCPTE', 'Ecrcpt Numcpte:') !!}
    {!! Form::text('ECRCPT_NUMCPTE', null, ['class' => 'form-control', 'maxlength' => 40, 'maxlength' => 40]) !!}
</div>

<!-- Lot Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('LOT_DATE', 'Lot Date:') !!}
    {!! Form::text('LOT_DATE', null, ['class' => 'form-control','id'=>'LOT_DATE']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#LOT_DATE').datepicker()
    </script>
@endpush

<!-- Ecrcpt Sens Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ECRCPT_SENS', 'Ecrcpt Sens:') !!}
    {!! Form::text('ECRCPT_SENS', null, ['class' => 'form-control', 'maxlength' => 1, 'maxlength' => 1]) !!}
</div>

<!-- Ecrcpt Montant Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ECRCPT_MONTANT', 'Ecrcpt Montant:') !!}
    {!! Form::number('ECRCPT_MONTANT', null, ['class' => 'form-control']) !!}
</div>

<!-- Ecrcpt Libelle Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ECRCPT_LIBELLE', 'Ecrcpt Libelle:') !!}
    {!! Form::text('ECRCPT_LIBELLE', null, ['class' => 'form-control', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Ecrcpt Libcomp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ECRCPT_LIBCOMP', 'Ecrcpt Libcomp:') !!}
    {!! Form::text('ECRCPT_LIBCOMP', null, ['class' => 'form-control', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Ecrcpt Refer 1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ECRCPT_REFER_1', 'Ecrcpt Refer 1:') !!}
    {!! Form::text('ECRCPT_REFER_1', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>