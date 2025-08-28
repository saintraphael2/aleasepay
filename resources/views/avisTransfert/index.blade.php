@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h4>Liste des transferts (Avis de {{($sens=='D'?'Débit':'Crédit')}}) du {{$deb->format('d-m-Y')}} au {{$fin->format('d-m-Y')}}</h4>
            </div>
            <div class="col-sm-3">
                
            </div>
        </div>
    </div>
</section>
<div class="content px-3">
    @include('flash::message')
    <div class="clearfix"></div>
    <div class="card" style="padding: 15px;">

        <div class="row input-daterange">

            <div class="form-group col-sm-3">
                <input type="hidden" name="avis" id="avis" value="D">
                
                <span class="text-danger font-size-xsmall error_date_debut"></span>
            </div>
            <!-- Date Signature Field -->
            <div class="form-group col-sm-3">
                {!! Form::label('date_debut', 'Date début (jj-mm-aaaa) :') !!}
                {!! Form::text('date_debut', null, ['class' => 'form-control','id'=>'date_debut','required']) !!}
                <span class="text-danger font-size-xsmall error_date_debut"></span>
            </div>

            <!-- Date Debut Field -->
            <div class="form-group col-sm-3">
                {!! Form::label('date_fin', 'Date fin (jj-mm-aaaa) :') !!}
                {!! Form::text('date_fin', null, ['class' => 'form-control','id'=>'date_fin','required']) !!}
                <span class="text-danger font-size-xsmall error_date_fin"></span>
            </div>

            <div class="form-group col-sm-3" style="margin-top: 2rem;">
                <button type="submit" name="filter" id="filter" class="btn btn-primary">Filtrer</button>

            </div>
        </div>
    </div>



    <div class="card">
        <table class="table table-striped table-bordered dataTable no-footer">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Compte</th>
                <th>Désignation</th>
                <th>Montant</th>
                <th>Motif</th>
                <th> </th>
            </tr>
             
           <?php 
            $compteur=1;
           // var_dump($mouvements[0]);exit;
           ?>
            @foreach($mouvements as $mouvement)
            <?php
//var_dump($mouvement );exit;
            ?>
            <tr>
                <th>{{$compteur}}</th>
                <td>{{\Carbon\Carbon::parse($mouvement["dateLot"])->format('d-m-Y')}}</td>
                <td>{{$mouvement["compte"] }}  </td>
                <td>  {{$mouvement["libelle"]}}</td>
                 
                <td style="text-align:right">

                    
                    {{number_format($mouvement["montant"], 0,"", " ") }}
                   
                </td>
                <td>  {{$mouvement["libComp"]}}</td>
                <th>  <a  href="{{ route('editAvis',[$mouvement['reference'],$sens]) }}" target="_blank" class='btn btn-default btn-xs'>
    <i class="fa fa-print"></i></th>
            </tr>
            <?php
            $compteur++;
            ?>
            @endforeach
             
        </table>
    </div>
</div>

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
    let redirect_url = "avisTransfert?sens=" + $('#avis').val()

    if (fromDate != '' && toDate != '') {

        redirect_url += "&deb=" + fromDate + "&fin=" + toDate
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

$('#refresh').click(function() {
    //$('#date_debut').val('')
    //$('#date_fin').val('')


    console.log("redirect Url : ", redirect_url)
    showSuccess(redirect_url, null, null)
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
</script>
@endpush