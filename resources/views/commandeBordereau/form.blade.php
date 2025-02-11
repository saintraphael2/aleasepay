@extends('layouts.app')

@section('content')
<div class="card" style="padding: 15px;">
    <div class="container">

        <h2>Commande d'un bordereau</h2>

        <form action="{{route('commandeBordereau.docommand')}}" method="POST">
            @csrf
            @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
            @endif
            <div class="mb-3">
                <label for="dateCommande" class="form-label">Date commande</label>
                <input type="date" id="dateCommande" name="dateCommande" class="form-control"/>
            </div>

            <div class="mb-3">
                <label for="reference" class="form-label">Type de bordereau</label>
                <select name="code" id="code" class='form-control'>
                        @foreach($types as $type)
                        <option value="{{$type['code']}}">{{$type['libelle']}}</option>
                        @endforeach
                    </select>
            </div>
            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="int" id="quantite" name="quantite" class="form-control"
                  />
            </div>
            <div class="mb-3">
                <label for="compte" class="form-label">Compte</label>
                <select id="compte" name="compte" class="form-select form-control" required>
                    <option value="">-- Sélectionnez un compte --</option>
                    @foreach($comptes as $compte)
                        <option value="{{$compte->compte}}">{{$compte->compte}}</option>
                     @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success btnSubmit">Commander</button>
            <a class="btn btn-danger btnSubmit">
                Annuler
            </a>
        </form>
    </div>
</div>
@endsection