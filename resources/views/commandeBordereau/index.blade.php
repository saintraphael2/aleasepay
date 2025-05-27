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

    <div id="error-alert" class="alert alert-danger d-none">
        <p id="error-messages"> </p>
    </div>
    <div id="success-alert" class="alert alert-success d-none">
        <p id="success-messages"></p>
    </div>
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
                        <!--option value="">Selectionnez votre compte</option-->
                        @foreach($comptes as $compte)
                        <option value="{{$compte->compte}}">{{$compte->compte}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger font-size-xsmall error_date_debut"></span>
                </div>
                    <div class="form-group col-sm-3">
                    {!! Form::label('libelle', 'Libellé du compte :') !!}
                    <input type="text" id="libelleCompte" class="form-control" readonly>
                    </div>      
                @if(is_array($types))
                <div class="form-group col-sm-2">
                    {!! Form::label('type', 'Types :') !!}
                    <select name="typebordereau" id="type" class='form-control'>
                        <!--option value="">Selectionnez</option-->
                        @foreach($types as $type)
                        <option value="{{$type['code']}}">{{$type['libelle']}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <!-- Date Signature Field -->
                <div class="form-group col-sm-2">
                    {!! Form::label('date_debut', 'Date début :') !!}
                    {!! Form::text('date_debut', null, ['class' => 'form-control','id'=>'date_debut']) !!}
                    <span class="text-danger font-size-xsmall error_date_debut"></span>
                </div>
                <!-- Date Debut Field -->
                <div class="form-group col-sm-2">
                    {!! Form::label('date_fin', 'Date fin  :') !!}
                    {!! Form::text('date_fin', null, ['class' => 'form-control','id'=>'date_fin']) !!}
                    <span class="text-danger font-size-xsmall error_date_fin"></span>
                </div>
                <div class="form-group col-sm-1" style="margin-top: 2rem;">
                    <button type="submit" id="bordereauformSubmit" class="btn btn-primary btnSubmit">Filtrer</button>
                </div>
            </div>
        </form>
        @include('commandeBordereau.table')
    </div>
    <div class="modal fade" id="modalForCompte" tabindex="-1" aria-labelledby="modalForCompte" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalForCompte"></h5>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif
                        <div class="mb-3">
                            <label for="dateCommande" class="form-label">Date commande</label>
                            <input type="text" id="dateCommande" name="dateCommande" value="{{$dateCommande}}"
                                class="form-control" readonly />
                        </div>

                        <div class="mb-3">
                        @if(is_array($types))
                            <label for="code" class="form-label">Type de bordereau</label>
                            <select name="code" id="code" class='form-control' required>
                                @foreach($types as $type)
                                <option value="{{$type['code']}}">{{$type['libelle']}}</option>
                                @endforeach
                            </select>
                        @endif
                        </div>
                        <div class="mb-3">
                            <label for="quantite" class="form-label">Quantité</label>
                            <input type="int" id="quantite" name="quantite" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="compte" class="form-label">Compte</label>
                            <select id="compteModal" name="compteModal" class="form-select form-control" required>
                                <option value="">-- Sélectionnez un compte --</option>
                                @foreach($comptes as $compte)
                                <option value="{{$compte->compte}}">{{$compte->compte}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            {!! Form::label('libelle', 'Libellé du compte :') !!}
                            <input type="text" id="libelleCompteModal" class="form-control" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeForModalCmpte">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="commander()"
                        id="secondBtnValidation">Valider</button>
                </div>
            </div>
        </div>
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

$(document).ready(function () {
    $('#compte').on('change', function () {
        var compte = $(this).val();
        initLibelleCompte(compte);
    });
    var compterecup = $('#compte').val();
    initLibelleCompte(compterecup);
});

function initLibelleCompte (compte){
    if (compte) {
            $.ajax({
                url:"{{route('bordereau.getCompteLibelle')}}",
                method: 'GET',
                data: { compte: compte },
                success: function (data) {
                    console.log("DATA " + data);
                    if (data && data.intitule) {
                       // console.log("Transaction récupérée :", response);
                      
                        $('#libelleCompte').val(data.intitule);
                    } else {
                        $('#libelleCompte').val('Libellé non trouvé');
                    }
                },
                error: function () {
                    $('#libelleCompte').val('Erreur serveur');
                }
            });
        } else {
            $('#libelleCompte').val('');
        }
}
function showLoadingOverlay() {
    const loading = document.querySelector('#loading');
    const loadingContent = document.querySelector('#loading-content');
    loading.classList.add('loading');
    loadingContent.classList.add('loading-content');
    loading.style.zIndex = "1100";
}

function hideLoadingOverlay() {
    const loading = document.querySelector('#loading');
    const loadingContent = document.querySelector('#loading-content');
    loading.classList.remove('loading');
    loadingContent.classList.remove('loading-content');
    loading.style.zIndex = "";
}


function commander() {

    let compte = $('#compteModal').val();
    let quantite = $('#quantite').val();
    let code = $('#code').val();
    let dateCommande = $('#dateCommande').val();
    console.log("compte", compte);
    console.log("quantite", quantite);
    console.log("code", code);
    console.log("dateCommande", dateCommande);

    //let concat =compte, " - " , quantite, " - ",code, " - ", dateCommande;
    showLoadingOverlay();
    //{{ route('cptClients.create') }}
    return $.ajax({
        url: "{{ route('commandeBordereau.docommand') }}",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        contentType: "application/json",
        data: JSON.stringify({
            compte: compte,
            quantite: quantite,
            code: code,
            dateCommande: dateCommande
        }),
        success: function(response) {
            let errorMessage = response.success;
            $("#success-alert").removeClass("d-none").css("z-index", "2000");
            $("#success-messages").html(errorMessage);
            setTimeout(function() {
                $("#success-alert").addClass("d-none");
            }, 30000);
            filter();
            hideLoadingOverlay();
            document.getElementById("closeForModalCmpte").click();
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON.error ||
                "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-messages").html(errorMessage);
            $("#error-alert").removeClass("d-none").css("z-index", "2000");
            setTimeout(function() {
                $("#error-alert").addClass("d-none");
            }, 30000);
            hideLoadingOverlay();
        }
    });
}
var modalForCompte = document.getElementById('modalForCompte')
modalForCompte.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = modalForCompte.querySelector('.modal-title')
    var modalBodyInput = modalForCompte.querySelector('.modal-body input')

    //modalTitle.textContent = 'New message to ' + recipient
    //modalBodyInput.value = recipient

    $('#compteModal').on('change', function () {
        var compte = $(this).val();
        if (compte) {
            $.ajax({
                url:"{{route('bordereau.getCompteLibelle')}}",
                method: 'GET',
                data: { compte: compte },
                success: function (data) {
                    console.log("DATA " + data);
                    if (data && data.intitule) {
                       // console.log("Transaction récupérée :", response);
                      
                        $('#libelleCompteModal').val(data.intitule);
                    } else {
                        $('#libelleCompteModal').val('Libellé non trouvé');
                    }
                },
                error: function () {
                    $('#libelleCompteModal').val('Erreur serveur');
                }
            });
        } else {
            $('#libelleCompteModal').val('');
        }
    });


});



document.getElementById("closeForModalCmpte").addEventListener("click", function() {
    const modalElement = document.getElementById("modalForCompte");

    document.getElementById("quantite").value = "";
    document.getElementById("code").value = "";
    document.getElementById("compteModal").value = "";

    document.getElementById("libelleCompteModal").value = "";

    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) {
        modalInstance.hide();
    }
});

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
      if (response != null && Array.isArray(response.bordereaux)) {

            response.bordereaux.forEach(bordereau => {
                //  alert(bordereau.etat);
                let etat = "En attente";
                if (bordereau.etat == "0") {
                    etat = "En attente";
                } else if (bordereau.etat == "1") {
                    etat = "Validé";
                } else if (bordereau.etat == "2") {
                    etat = "Commandé";
                }
                let row = `
            <tr class="bordereau-row">
                <td>${bordereau.compte}</td>
                <td>${bordereau.compteLabel}</td>
                <td>${bordereau.libelleBordereau}</td>
                <td>${bordereau.dateCommande}</td>
                <td>${bordereau.quantite}</td>
                <td>${bordereau.numeroOrdre}</td>
                 <td>${etat}</td>
            </tr>`;
                $("#bordereauxTable tbody").append(row);
            });
}
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