<!-- Agence Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('agence_code', 'Agence Code:') !!}
    {!! Form::text('agence_code', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Racine Field -->
<div class="form-group col-sm-6">
    {!! Form::label('racine', 'Racine:') !!}
    {!! Form::text('racine', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Compte Field -->
<div class="form-group col-sm-6">
    {!! Form::label('compte', 'Compte:') !!}
    {!! Form::text('compte', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Solde Field -->
<div class="form-group col-sm-6">
    {!! Form::label('solde', 'Solde:') !!}
    {!! Form::text('solde', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Intitule Field -->
<div class="form-group col-sm-6">
    {!! Form::label('intitule', 'Intitule:') !!}
    {!! Form::text('intitule', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Devise Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('devise_code', 'Devise Code:') !!}
    {!! Form::text('devise_code', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Devise Libelle Field -->
<div class="form-group col-sm-6">
    {!! Form::label('devise_libelle', 'Devise Libelle:') !!}
    {!! Form::text('devise_libelle', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>