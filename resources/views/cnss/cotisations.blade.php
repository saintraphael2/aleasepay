@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cotisation CNSS</h1>
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
        <form method="GET" action="{{route('cnss.cotisations.search')}}" class="mb-4">
            @csrf
            @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
            @endif
            <div class="form-group ">
                <label for="numero_employeur">Numéro d'employeur</label>
                <input type="text" name="numero_employeur" id="numero_employeur" class="form-control col-sm-3"
                    placeholder="Entrez le numéro d'employeur"
                    value="{{ old('numero_employeur', $numero_employeur ?? '') }}" required>
            </div>
            <button id="" type="submit" class="btn btn-primary mt-2 btnSubmit">Rechercher</button>
        </form>
    </div>
    <div class="card" style="padding: 15px;">
        @include('cnss.table')
    </div>
</div>

@endsection