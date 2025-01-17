@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transactions</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')
    <div class="clearfix"></div>
    <div class="card" style="padding: 15px;">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif
        <form method="GET" action="{{route('transactions.filter')}}" class="mb-4">
            <div class="row input-daterange">

                <div class="form-group col-sm-2">
                    {!! Form::label('compte', 'Comptes :') !!}
                    <select name="compte" id="compte" class='form-control'>
                        @foreach($comptes as $compte)
                        <option value="{{$compte->compte}}">{{$compte->compte}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger font-size-xsmall error_date_debut"></span>
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::label('type', 'Types :') !!}
                    <select name="type" id="type" class='form-control'>
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->type}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Date Signature Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('date_debut', 'Date début (jj-mm-aaaa) :') !!}
                    {!! Form::text('date_debut', null, ['class' => 'form-control','id'=>'date_debut']) !!}
                    <span class="text-danger font-size-xsmall error_date_debut"></span>
                </div>
                <!-- Date Debut Field -->
                <div class="form-group col-sm-3">
                    {!! Form::label('date_fin', 'Date fin (jj-mm-aaaa) :') !!}
                    {!! Form::text('date_fin', null, ['class' => 'form-control','id'=>'date_fin']) !!}
                    <span class="text-danger font-size-xsmall error_date_fin"></span>
                </div>
                <div class="form-group col-sm-2" style="margin-top: 2rem;">
                    <button type="submit"  id="filter" class="btn btn-primary btnSubmit">Filtrer</button>
                </div>
            </div>
        </form>
        @include('transactions.table')
    </div>

</div>
<script>
</script>
@endsection
@push('page_scripts')
<script>
$('#date_debut').datepicker({
    minDate: -90,
    maxDate: -1
})
$('#date_fin').datepicker({
    minDate: -89,
    maxDate: '0'
})


$('#filter').click(function() {
    let fromDate = $('#date_debut').val()
    let toDate = $('#date_fin').val()
    let redirect_url = "transactions/search?comptealt=" + $('#compte option:selected').text() + "&typeTransaction=" + $('#type option:selected').text()

    if (fromDate != '' && toDate != '') {

        redirect_url += "&dateDebut=" + fromDate + "&dateFin=" + toDate
    }

    /*
    //alert('Both Date is required')
    let erreur = {
        responseJSON : {message : "Les deux dates sont obligatoires"}
    }
    showError(erreur, "")*/

    console.log("redirect Url : ", redirect_url)
    window.location.href = redirect_url
});
</script>
@endpush