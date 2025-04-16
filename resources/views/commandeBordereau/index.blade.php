@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Bordereaux</h1>
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

        @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif
        <form method="POST" id="bordereauform" class="mb-4">
            @csrf
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
                    <select name="typebordereau" id="type" class='form-control'>
                        @foreach($types as $type)
                        <option value="{{$type['code']}}">{{$type['libelle']}}</option>
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
                    <button type="submit" id="bordereauformSubmit" class="btn btn-primary btnSubmit">Filtrer</button>
                </div>
            </div>
        </form>
        @include('commandeBordereau.table')
    </div>
</div>
<script>
</script>
@endsection
@push('page_scripts')
<script>
let today = new Date();
$('#date_debut').datepicker({
    minDate: -90,
    maxDate: -1,
    dateFormat: 'dd-mm-yy',
    defaultDate: today
}).datepicker("setDate", today);
$('#date_fin').datepicker({
    minDate: -89,
    maxDate: '0',
    dateFormat: 'dd-mm-yy',
    defaultDate: today
}).datepicker("setDate", today);


$(document).ready(function() {
    /* Vérifie si la fonction filter a déjà été exécutée dans cette session
    if (!sessionStorage.getItem('filterExecuted')) {
        sessionStorage.setItem('filterExecuted', 'true'); // Marque comme exécuté
        filter(); // Appel de ta fonction
    }*/
    filter();
    $('#bordereauformSubmit').on('click', function(e) {
        e.preventDefault(); // Empêche un éventuel submit classique

        filter();
        hideLoading();
    })
});

function cancel() {
    $.ajax({
        url: "/bordereau/cancel",
        method: "GET",

        contentType: "application/json",
        data: {},
        success: function(response) {

        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON?.error ||
                "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-messages").html(errorMessage);
            $("#error-alert").removeClass("d-none");
        }
    });
}

function filter() {
    let type = $('#type').val();
    let date_debut = $('#date_debut').val();
    let date_fin = $('#date_fin').val();
    let compte = $('#compte').val();
    showLoading();
    $.ajax({
        url: "/bordereau/checklist",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        contentType: "application/json",
        data: JSON.stringify({
            typebordereau: type,
            compte: compte,
            date_debut: date_debut,
            date_fin: date_fin
        }),
        success: function(response) {

            $("#bordereauxTable tbody").empty();
            console.log("Transaction récupérée :", response);
            //$("#reference_declaration").val(response.refDecla);
            //$("#reference").val(response.referenceTransaction);
            //alert(response.etat);

            response.bordereaux.forEach(bordereau => {
                alert(bordereau.etat);
                let etat = "En attente";
                if (bordereau.etat == "0") {
                    etat = "En attente";
                } else if (bordereau.etat == "1") {
                    etat = "Validé";
                } else if (bordereau.status == "2") {
                    etat = "Commandé";
                }
                let row = `
            <tr class="bordereau-row" >
                <td>${bordereau.compte}</td>
                <td>${bordereau.libelleBordereau}</td>
                <td>${bordereau.dateCommande}</td>
                <td>${bordereau.quantite}</td>
                <td>${bordereau.numeroOrdre}</td>
                 <td>${etat}</td>
            </tr>`;
                $("#bordereauxTable tbody").append(row);
            });

            hideLoading();
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON?.error ||
                "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-messages").html(errorMessage);
            $("#error-alert").removeClass("d-none");
        }
    });
}

$('#filter').click(function() {
    let fromDate = $('#date_debut').val()
    let toDate = $('#date_fin').val()
    let redirect_url = "transactions/search?comptealt=" + $('#compte option:selected').text() +
        "&typeTransaction=" + $('#type option:selected').text()

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