@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Etax OTR</h1>
            </div>
            <div class="col-sm-6">
                <!-- <a class="btn btn-primary float-right"
                       href="{{ route('cptClients.create') }}">
                        Add New
                    </a> -->
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" style="padding: 15px;">
        <form method="GET" action="{{route('otr.etax.search')}}" class="mb-4">
            @csrf
            <div class="form-group ">
                <label for="reference_taxe">Référence de taxe</label>
                <input type="text" name="reference_taxe" id="reference_taxe" class="form-control col-sm-3"
                    placeholder="Entrez la reférence de taxe" value="{{ old('reference_taxe', $reference_taxe ?? '') }}"
                    required>
            </div>
            <button type="submit" class="btn btn-primary mt-2 btnSubmit">Rechercher</button>
        </form>
    </div>
    @if(!empty($etax))
    <div class="card" style="padding: 15px;">

        <div class="container">

            <h4>Informations de la taxe</h4>

            <form action="{{route('otr.etax.pay')}}" method="POST">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif
                <div class="mb-3">
                    <label for="referenceDeclaration" class="form-label">Référence Déclaration</label>
                    <input type="text" id="referenceDeclaration" name="referenceDeclaration" class="form-control"
                        value="{{ $etax['referenceDeclaration'] }}" readonly>
                        <input type="hidden" id="referenceTransaction" name="referenceTransaction" class="form-control"
                        value="{{ $etax['referenceTransaction'] }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="contribuable" class="form-label">Contribuable</label>
                    <input type="text" id="contribuable" name="contribuable" class="form-control"
                        value="{{ $etax['contribuable'] }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nif" class="form-label">NIF</label>
                    <input type="text" id="nif" name="nif" class="form-control"
                        value="{{ $etax['nif'] }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="text" id="montant" name="montant" class="form-control"
                        value="{{ number_format($etax['montant'], 0, ',', ' ') }} FCFA" readonly>
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
              
            </form>
        </div>
    </div>
    @endif
</div>
@endsection