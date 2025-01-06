@extends('layouts.app')

@section('content')
<div class="card" style="padding: 15px;">
    <div class="container">
        <h2>Paiement Etax OTR</h2>
        <form action="{{route('cnss.cotisations.pay')}}" method="POST">
            @csrf
            @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
            @endif
            <div class="mb-3">
                <label for="numero_employeur" class="form-label">Numéro Employeur</label>
                <input type="text" id="numero_employeur" name="numero_employeur" class="form-control"
                    value="{{ $numero_employeur }}" readonly>
            </div>

            <div class="mb-3">
                <label for="reference" class="form-label">Référence</label>
                <input type="text" id="reference" name="referenceID" class="form-control"
                    value="{{ $cotisation['referenceID'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="designation" class="form-label">Désignation</label>
                <input type="text" id="designation" name="designation" class="form-control"
                    value="{{ $cotisation['designation'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="requester" class="form-label">Demandeur</label>
                <input type="text" id="requester" name="requester" class="form-control"
                    value="{{ $cotisation['requester'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="created_at" class="form-label">Date de création Cotisation</label>
                <input type="text" id="created_at" name="created_at" class="form-control"
                    value="{{ $cotisation['created_at'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Montant</label>
                <input type="text" id="amount" name="amount" class="form-control"
                    value="{{ number_format($cotisation['amount'], 0, ',', ' ') }} FCFA" readonly>
            </div>

            <div class="mb-3">
                <label for="compte" class="form-label">Compte</label>
                <select id="compte" name="comptealt" class="form-select form-control" required>
                    <option value="">-- Sélectionnez un compte --</option>
                    @foreach ($cptClientsOriginal as $valeur)
                    <option value="{{$valeur['compte']}}">{{$valeur['compte']}}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success btnSubmit">Effectuer le Paiement</button>
            <a href="{{ route('cnss.cotisations.search', ['numero_employeur' => $numero_employeur]) }}" class="btn btn-danger btnSubmit">
                Annuler
            </a>
        </form>
    </div>
</div>
@endsection