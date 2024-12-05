<!-- Client Field -->

   
    {!! Form::hidden('client', $client, ['class' => 'form-control']) !!}


<!-- Compte Field -->
<div class="form-group col-sm-4">
    {!! Form::label('compte', 'Compte:') !!}
    {!! Form::select('compte', $comptes,null, ['class' => 'form-control', 'maxlength' => 12, 'maxlength' => 12]) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-4">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::select('type',$type_bordereaux, null, ['class' => 'form-control']) !!}
</div>

<!-- Nombre Field -->
<div class="form-group col-sm-4">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::number('nombre', null, ['class' => 'form-control']) !!}
</div>
