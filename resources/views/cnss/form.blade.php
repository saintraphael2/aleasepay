@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Paiement de Cotisation</h2>
        
        <form action="{{route('cnss.cotisations.pay', ['reference' => $cotisation['referenceID']])}}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="numero_employeur" class="form-label">Numéro Employeur</label>
                <input type="text" id="numero_employeur" name="numero_employeur" 
                       class="form-control" value="{{ $numero_employeur }}" readonly>
            </div>

            <div class="mb-3">
                <label for="reference" class="form-label">Référence</label>
                <input type="text" id="reference" name="reference" 
                       class="form-control" value="{{ $cotisation['referenceID'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="designation" class="form-label">Désignation</label>
                <input type="text" id="designation" name="designation" 
                       class="form-control" value="{{ $cotisation['designation'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="requester" class="form-label">Demandeur</label>
                <input type="text" id="requester" name="requester" 
                       class="form-control" value="{{ $cotisation['requester'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="created_at" class="form-label">Date</label>
                <input type="text" id="created_at" name="created_at" 
                       class="form-control" value="{{ $cotisation['created_at'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Montant</label>
                <input type="text" id="amount" name="amount" 
                       class="form-control" value="{{ $cotisation['amount'] }}" readonly>
            </div>

            <div class="mb-3">
                <label for="compte" class="form-label">Compte</label>
                <select id="compte" name="compte" class="form-select" required>
                    <option value="">-- Sélectionnez un compte --</option>
                    @foreach ($comptes as $nom => $valeur)
                        <option value="{{ $valeur }}">{{ $nom }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Effectuer le Paiement</button>
        </form>
    </div>
@endsection
