@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h4>Mouvements du compte {{$compte}} -- {{$deb->format('d-m-Y')}} au {{$fin->format('d-m-Y')}}</h4>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-primary float-right"
                    href="{{ route('releve',[$compte,$deb->format('Y-m-d'),$fin->format('Y-m-d')]) }}" target="_blank">
                    Export PDF
                </a>
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
                {!! Form::label('compte', 'Comptes :') !!}
                <select name="compte" id="compte" class='form-control'>
                    @foreach($comptes as $compte)
                    <option value="{{$compte->id}}">{{$compte->compte}}</option>
                    @endforeach
                </select>

                <span class="text-danger font-size-xsmall error_date_debut"></span>
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

            <div class="form-group col-sm-3" style="margin-top: 2rem;">
                <button type="submit" name="filter" id="filter" class="btn btn-primary">Filtrer</button>

            </div>
        </div>
    </div>



    <div class="card">
        <table class="table table-striped table-bordered dataTable no-footer">
            <tr>
                <th>Date</th>
                <th>Désignation</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
            <tr>
                <td>{{$deb->format('d-m-Y')}}</td>
                <td>Solde initial</td>
                <td style="text-align:right;">
                    @if($soldedeb<=0) {{  number_format($soldedeb, 0,"", " ")   }} @endif </td>
                <td style="text-align:right;"> @if($soldedeb>0)
                    {{  number_format($soldedeb, 0,"", " ")   }}
                    @endif</td>
            </tr>
           <?php 
            $compteur=0;
           // var_dump($mouvements[0]);exit;
           ?>
            @foreach($mouvements as $mouvement)
            <?php
//var_dump($mouvement );exit;
            ?>
            <tr>
                <td>{{\Carbon\Carbon::parse($mouvement["lot_DATE"])->format('d-m-Y')}}</td>
                <td>{{$mouvement["ecrcpt_LIBELLE"] }} {{$mouvement["ecrcpt_LIBCOMP"]}}</td>
                <td style="text-align:right">
                    @if($mouvement["ecrcpt_SENS"]=='D')
                    {{number_format($mouvement["ecrcpt_MONTANT"], 0,"", " ") }}
                    @endif
                </td>
                <td style="text-align:right">

                    @if($mouvement["ecrcpt_SENS"]=='C')
                    {{number_format($mouvement["ecrcpt_MONTANT"], 0,"", " ") }}
                    @endif
                </td>
            </tr>
            <?php
            $compteur++;
            ?>
            @endforeach
            <tr>
                <td>{{$fin->format('d-m-Y')}}</td>
                <td >Solde Final</td>
                <td style="text-align:right;">
                    @if($soldefin<=0) {{  number_format($soldefin, 0,"", " ")   }} @endif </td>
                <td style="text-align:right;"> @if($soldefin>0)
                    {{  number_format($soldefin, 0,"", " ")   }}
                    @endif</td>
            </tr>
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
    let redirect_url = "mouvements?compte=" + $('#compte option:selected').text()

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