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
                    placeholder="Entrez la reférence de taxe"  value="{{ old('reference_taxe', $reference_taxe ?? '') }}"  required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
        </form>
    </div>
    <div class="card" style="padding: 15px;">
       
    </div>
</div>

@endsection