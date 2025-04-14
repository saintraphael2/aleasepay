
<style>
#voscotisationTable {
    width: 100%;
    border-collapse: collapse;
}

#voscotisationTable thead,
#voscotisationTable tbody,
#voscotisationTable th,
#voscotisationTable td {
    display: block;
}

#voscotisationTable thead {
    /* Garde l'en-tête visible */
    width: 100%;
}

#voscotisationTable tbody {
    height: 300px;
    /* Ajuste à ton besoin */
    overflow-y: auto;
    overflow-x: hidden;
    width: 100%;
}

#voscotisationTable tr {
    display: flex;
    width: 100%;
}

#voscotisationTable th,
#voscotisationTable td {
    flex: 1;
    text-align: left;
    padding: 8px;
    border: 1px solid #dee2e6;
}
</style>
<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Historique des transactions enregistrées</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="clearfix"></div>

    <div id="error-alert" class="alert alert-danger d-none">
        <p id="alert_messages"> </p>
    </div>
    <div id="success-alert" class="alert alert-success d-none">
        <p id="success-messages"></p>
    </div>
    <div class="card" style="padding: 15px;">

        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        <!--form method="POST"  class="mb-4"-->
        <?php echo csrf_field(); ?>
        <div class="row input-daterange">

            <div class="form-group col-sm-2">
                <?php echo Form::label('compte', 'Comptes :'); ?>

                <select name="compte" id="compte" class='form-control'>
                    <?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($compte->compte); ?>"><?php echo e($compte->compte); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="text-danger font-size-xsmall error_date_debut"></span>
            </div>

            <?php if(is_array($types)): ?>
            <div class="form-group col-sm-2">
                <?php echo Form::label('type', 'Types :'); ?>

                <select name="type" id="type" class='form-control'>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type['id']); ?>"><?php echo e($type['type']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            <!-- Date Signature Field -->
            <div class="form-group col-sm-3">
                <?php echo Form::label('date_debut', 'Date début (jj-mm-aaaa) :'); ?>

                <?php echo Form::text('date_debut', null, ['class' => 'form-control','id'=>'date_debut']); ?>

                <span class="text-danger font-size-xsmall error_date_debut"></span>
            </div>
            <!-- Date Debut Field -->
            <div class="form-group col-sm-3">
                <?php echo Form::label('date_fin', 'Date fin (jj-mm-aaaa) :'); ?>

                <?php echo Form::text('date_fin', null, ['class' => 'form-control','id'=>'date_fin']); ?>

                <span class="text-danger font-size-xsmall error_date_fin"></span>
            </div>
            <div class="form-group col-sm-2" style="margin-top: 2rem;">
                <button id="pendingFilter" class="btn btn-primary btnSubmit">Filtrer</button>
            </div>
        </div>
        <!--/form-->

        <div class="card signincardctz">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">

                        <button class=" flex-sm-fill text-sm-center nav-link active" id="tab_pai_step1"
                            data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home"
                            aria-selected="true">Paiement ( Cotisation CNSS )</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class=" flex-sm-fill text-sm-center nav-link" id="tab_pai_step2" data-bs-toggle="tab"
                            data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Paiement ( Etax OTR ) </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class=" flex-sm-fill text-sm-center nav-link" id="tab_pai_step3" data-bs-toggle="tab"
                            data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                            aria-selected="false">Paiement (Cotisation CNSS & Etax OTR)</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="tab_pai_step1">
                        <?php echo $__env->make('transactions_pending.table_pending_cnss', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="tab_pai_step2">
                        <?php echo $__env->make('transactions_pending.table_pending_otr', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="tab_pai_step3">
                        <?php echo $__env->make('transactions_pending.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('page_scripts'); ?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details Paiement</h5>
                <button type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal" aria-label="Close">
                    Retour</button>
            </div>
            <div class="modal-body">
                <!--form  class="mb-4"-->
                <?php echo csrf_field(); ?>
                <div class="row input-daterange">

                    <!--div class="form-group col-sm-2">
                            <?php echo Form::label('compte', 'Comptes :'); ?>

                            <select name="compte" id="compte" class='form-control'>
                                <?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($compte->compte); ?>"><?php echo e($compte->compte); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-danger font-size-xsmall error_date_debut"></span>
                        </div-->
                    <div class="form-group col-sm-6">
                        <?php echo Form::label('numero_employeur', 'Numéro Employeur :'); ?>

                        <?php echo Form::text('name', null, ['class' => 'form-control','id'=>'numero_employeur',
                        'required', 'maxlength' => 255, 'maxlength' => 255]); ?>

                    </div>
                    <div class="form-group col-sm-4" style="margin-top: 2rem;">
                        <button id="searchForm" class="btn btn-primary btnSubmit">Rechercher</button>
                    </div>
                </div>
                <!--/form-->
                <table class="table table-bordered table-striped" id="voscotisationTable">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Désignation</th>
                            <th>Demandeur</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" style="" class="btn btn-danger btnSubmit disabled" data-bs-dismiss="modal"
                    id="btnAnnuler">Annuler</button>
                <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal"
                    data-bs-dismiss="modal">Retour</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalForCompte" tabindex="-1" aria-labelledby="modalForCompte" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalForCompte">New message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Reference:</label>
                            <input name="reference_inmodal" id="referenceInModal" class="form-control" readOnly />
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Montant:</label>
                            <input name="montant_inmodal" id="montantInModal" class="form-control" readOnly />
                        </div>
                        <div class="mb-3">
                            <?php echo Form::label('compte', 'Comptes :'); ?>

                            <select name="compte_compte" id="compteInModal" class='form-control'>
                                <?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($compte->compte); ?>"><?php echo e($compte->compte); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Description:</label>
                            <textarea name="description_inmodal" id="descriptionInModal"
                                class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeForModalCmpte">Close</button>
                    <button type="button" class="btn btn-primary" id="secondBtnValidation">Valider</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
swal("Hello world!");
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

    filter();
    $('#pendingFilter').on('click', function(e) {
        e.preventDefault();
        filter();
        hideLoading();
    })
});
var pendingTransacID = "";
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-cancel-pendingCnss');
    if (btn) {
        pendingTransacID = btn.dataset.pendingtransac;
        console.log('Référence cliquée :', pendingTransacID);
        //alert(pendingTransacID);
        cancelPendingTransac(pendingTransacID);
    }
});


function cancelPendingTransac(id) {
    showLoading();
    $.ajax({
        url: "/pending/cancel",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        contentType: "application/json",
        data: JSON.stringify({
            idTransac: id
        }),
        success: function(response) {
            let errorMessage = response.success;
            $("#success-alert").removeClass("d-none").css("z-index", "2000");
            $("#success-messages").html(errorMessage);
            hideLoading();
            filter();
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
    if (tabPaneactive == 'tab_pai_step1') {
        type = 'OCN';
    } else if (tabPaneactive == 'tab_pai_step2') {
        type = 'OOT';
    }if (tabPaneactive == 'tab_pai_step3') {
        alert();
        type = $('#type').val();
    }
    let date_debut = $('#date_debut').val();
    let date_fin = $('#date_fin').val();
    let compte = $('#compte').val();

    showLoading();
    $.ajax({
        url: "/pending/filter",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        contentType: "application/json",
        data: JSON.stringify({
            type: type,
            compte: compte,
            date_debut: date_debut,
            date_fin: date_fin,
            tabpane: tabPaneactive
        }),
        success: function(response) {

            if (tabPaneactive == 'tab_pai_step1') {
                $("#transactionsTableCnss tbody").empty();
            } else if (tabPaneactive == 'tab_pai_step2') {
                $("#transactionsTableOtr tbody").empty();
            } else if (tabPaneactive == 'tab_pai_step3'){
                $("#transactionsTablePay tbody").empty();
            }

            console.log("Transaction récupérée :", response);
            //$("#reference_declaration").val(response.refDecla);
            //$("#reference").val(response.referenceTransaction);
            if (tabPaneactive == 'tab_pai_step1' || tabPaneactive == 'tab_pai_step2' ) {
                response.forEach(pendingtransac => {
                let operation = (pendingtransac.type ===
                    "OOT") ? "Paiement OTR" : "Paiement CNSS";

                let row = `
            <tr class="pendingtransac-row" data-pendingtransac="${pendingtransac.id}">
                <td>${pendingtransac.reference}</td>
                <td>${operation}</td>
                <td>${pendingtransac.compte}</td>
                <td>${pendingtransac.user?.name}</td>
                <td>${pendingtransac.date_transaction}</td>
                <td>${pendingtransac.montant}</td>
                 <td>${pendingtransac.etat}</td>
                 <td>
                <input type="hidden" id="pendingtransac_${pendingtransac.id}" name="pendingtransac" value="${pendingtransac.id}"/>
                <button type="button" class="btn btn-danger btn-cancel-pendingCnss" 
                    data-pendingtransac="${pendingtransac.id}">
                    Annuler
                </button>
            </td>
            </tr>`;

                if (tabPaneactive == 'tab_pai_step1') {
                    $("#transactionsTableCnss tbody").append(row);
                } else if (tabPaneactive == 'tab_pai_step2') {
                    $("#transactionsTableOtr tbody").append(row);
                } 

            });
            } else if(tabPaneactive == 'tab_pai_step3'){
                response.forEach(pendingtransac => {
                let operation = (pendingtransac.type ===
                    "OOT") ? "Paiement OTR" : "Paiement CNSS";

                let rowpay = `
            <tr class="pendingtransac-row" data-pendingtransac="${pendingtransac.id}">
                <td>${pendingtransac.reference}</td>
                <td>${operation}</td>
                <td>${pendingtransac.compte}</td>
                <td>${pendingtransac.user?.name}</td>
                <td>${pendingtransac.date_transaction}</td>
                <td>${pendingtransac.montant}</td>
                 <td>${pendingtransac.etat}</td>
                 <td>
                <input type="hidden" id="pendingtransac_${pendingtransac.id}" name="pendingtransac" value="${pendingtransac.id}"/>
                <button type="button" class="btn btn-danger btn-cancel-pendingCnss" 
                    data-pendingtransac="${pendingtransac.id}">
                    Annuler
                </button>
                <button type="button" class="btn btn-primary btn-cancel-pendingValidate" 
                    data-pendingtransac="${pendingtransac.id}">
                   Valider
                </button>
            </td>
            </tr>`;
                    $("#transactionsTablePay tbody").append(rowpay);
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



var tabPaneactive = "tab_pai_step1";
var comptes = <?php echo json_encode($comptes, 15, 512) ?>;
console.log(comptes);

var modalTitle = "Paiement CNSS";
if ($("#profil_nom").val() === "VALIDATEUR_COMMERCIALE") {
    tabPaneactive = "tab_pai_step1";
} else if ($("#profil_nom").val() === "VALIDATEUR_ENGAGE") {
    tabPaneactive = "tab_pai_step2";
}
document.addEventListener("DOMContentLoaded", function() {
    const tabs = document.querySelectorAll(".nav-link");
    const tabPanes = document.querySelectorAll(".tab-pane");

    tabs.forEach(tab => {
        tab.addEventListener("click", function() {
            // Supprime la classe 'active' de tous les onglets
            tabs.forEach(t => t.classList.remove("active"));

            // Ajoute 'active' à l'onglet cliqué
            this.classList.add("active");

            // Récupère l'ID de la tab cible
            const target = this.getAttribute("data-bs-target");

            // Masque toutes les tab-pane
            tabPanes.forEach(pane => {
                pane.classList.remove("show", "active");
            });

            // Affiche la tab-pane correspondante
            //document.querySelector(target).classList.add("show", "active");
            //const targetElement = document.getElementById('someElement');

            if (target) {
                document.querySelector(target).classList.add("show", "active");
                // targetElement.classList.add('active');
            } else {
                console.warn("#someElement est introuvable !");
            }
        });
    });
});



var afficheStatus = false;
$("#tabpane").val(tabPaneactive);
/*$(document).ready(function () {*/

$('#myTab button').on('click', function() {
    // Récupérer l'ID de l'onglet cliqué
    tabPaneactive = $(this).attr('id');
    console.log('ID de l\'onglet cliqué : ' + tabPaneactive);
    $("#tabpane").val(tabPaneactive);

    if (tabPaneactive == 'tab_pai_step1') {
        showLoading();
        $("#transactionsTableCnss tbody").empty();
        hideLoading();
    } else if (tabPaneactive == 'tab_pai_step2') {
        showLoading();
        $("#transactionsTableOtr tbody").empty();
        hideLoading();
    }
});
var transactionID = "";
var referenceID = "";
var cotisation = {};


document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-validation');
    if (btn) {
        referenceID = btn.dataset.transaction;
        console.log('Référence cliquée :', referenceID);
        initSecondModal();
    }
});

function initSecondModal() {
    let compteId = "";
    vosCotisations.forEach(transaction => {
        if (transaction.referenceID == referenceID) {
            cotisation = transaction;
        }
        /* if (comptes.length == 1) {
             compteId = comptes[0].compte;
         }*/
    });
    $("#referenceInModal").val(cotisation.referenceID);
    $("#montantInModal").val(cotisation.amount);
}

function validationPending() {
    let compteSelected = $("#compteInModal").val();
    let description = $("#descriptionInModal").val();
    console.log("LOG  description", description);
    console.log("LOG compteSelected", compteSelected);

    console.log("LOG cotisation.referenceID", cotisation.referenceID);
    console.log("LOG cotisation.amount", cotisation.amount);

    const loading = document.querySelector('#loading');
    const loadingContent = document.querySelector('#loading-content');
    loading.classList.add('loading');
    loadingContent.classList.add('loading-content');

    // 👇 Ajoute dynamiquement le z-index
    loading.style.zIndex = "1100";

    $.ajax({
        url: "/pending/save",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        contentType: "application/json",
        data: JSON.stringify({
            reference: cotisation.referenceID,
            type: "",
            compte: compteSelected,
            montant: cotisation.amount,
            etat: "en_attente",
            date: new Date(),
            description: description
        }),
        success: function(response) {
            console.log("Transactions récupérées :", response);

            let errorMessage = response.success;
            $("#success-alert").removeClass("d-none").css("z-index", "2000");
            $("#success-messages").html(errorMessage);
            hideLoading();
            document.getElementById("closeForModalCmpte").click();
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON.error ||
                "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-alert").removeClass("d-none").css("z-index", "2000").html("<p>" + errorMessage +
                "</p>");;
            hideLoading();
        }
    });
}
var vosCotisations = [];
$("#searchForm").on("click", function() {
    console.log('ID de l\'onglet cliqué second INPUT : ' + $("#tabpane").val());

    // let dateDebut = $("#dateDebut").val();
    // let dateFin = $("#dateFin").val();
    let numeroEmployeur = $("#numero_employeur").val();

    // alert(numeroEmployeur);
    // let tabpane = $("#tabpane").val();
    // showLoading();

    const loading = document.querySelector('#loading');
    const loadingContent = document.querySelector('#loading-content');
    loading.classList.add('loading');
    loadingContent.classList.add('loading-content');

    // 👇 Ajoute dynamiquement le z-index
    loading.style.zIndex = "1100";

    $.ajax({
        url: "/pending/search",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        contentType: "application/json",
        data: JSON.stringify({
            numero_employeur: numeroEmployeur
        }),
        success: function(response) {
            console.log("Transactions récupérées :", response);
            transactions = response;
            vosCotisations = transactions;
            console.log("Données  transactions : ", response.transactions)
            $("#voscotisationTable tbody").empty();
            transactions.sort((a, b) => new Date(b.created_at) - new Date(a
                .created_at));
            // Ajouter chaque transaction dans le tableau
            transactions.forEach(transaction => {
                let row = `
             <tr class="transaction-row" data-transaction="${transaction.referenceID}">
                <td>${transaction.referenceID}</td>
                <td>${transaction.designation}</td>
                <td>${transaction.requester}</td>
                <td>${transaction.created_at}</td>
                <td>${new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'XOF' }).format(transaction.amount)}</td>
                <td>
                <input type="hidden" id="referenceID_${transaction.referenceID}"  name="referenceid" value="${transaction.referenceID}"
                value="${transaction.referenceID}"/>
                <button type="button" class="btn btn-primary btn-validation"  data-bs-target="#modalForCompte"
                 data-bs-whatever="@modalForseleectCmpt" data-bs-toggle="modal" 
                    data-transaction="${transaction.referenceID}">
                    Soumettre
                </button>
            </td>
            </tr>`;
                $("#voscotisationTable tbody").append(row);
            });
            $("#error-alert").addClass("d-none").html("");
            hideLoading();
        },
        error: function(xhr) {
            //alert(xhr.responseJSON.error);
            if (xhr.responseJSON && xhr.responseJSON.error) {
                let error = xhr.responseJSON.error;
                let errorMessages = "";
                errorMessages += error;
                $("#error-messages").html(errorMessages);
                $("#error-alert").removeClass("d-none");
            } else {
                let errorMessages =
                    "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                $("#error-messages").html(errorMessages);
                $("#error-alert").removeClass("d-none");
            }
            hideLoading();
        }
    });
});


$(document).ready(function() {
    $("#btnAnnuler").on("click", function() {
        updateAnnulerButton();
    });

    $("#btnValider").on("click", function() {
        validerPaiement();
    });


});



document.getElementById("close").addEventListener("click", function() {
    document.getElementById("btnAnnuler").style.display = "block";
    document.getElementById("btnValider").style.display = "block";
    $("#reference_declaration").val("");
    $("#reference").val("");
    $("#contribuable").val("");
    $("#transacDate").val("");
    $("#mount").val("");
    $("#mountttc").val("");
    $("#comptealt").val("");
    $("#operation").val("");
    $("#designation").val("");
    $("#status").val("");
    $("#motif").val("");
});


var transaction = "";
/*
$(document).on("click", ".transaction-row", function() {
    let transactionId = $(this).data("transaction");
    transaction = $(`#transaction_${transactionId}`).val();

    console.log("Transaction sélectionnée :", transaction);
});*/














var exampleModal = document.getElementById('exampleModal');
exampleModal.addEventListener('show.bs.modal', function(event) {
    var modalTitle = exampleModal.querySelector('.modal-title')
    var modalBodyInput = exampleModal.querySelector('.modal-body input')

    var modalTitre = "Paiement CNSS";
    if (tabPaneactive === "tab_pai_step1") {
        modalTitre = "Paiement CNSS";
    } else if (tabPaneactive === "tab_pai_step2") {
        modalTitre = "Paiement OTR";
    }
    if (tabPaneactive === "tab_pai_step3") {
        modalTitre = "Vos Paiements";
    }
    modalTitle.textContent = modalTitre;
    var button = event.relatedTarget; // Bouton qui a déclenché l’ouverture du modal
    var transactionRef = button.getAttribute('data-transaction'); // Récupérer la transaction

    //alert("Transaction sélectionnée : " + transactionRef); // Vérification
    /*
        $.ajax({
            url: "/transactions/gettransaction",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            contentType: "application/json",
            data: JSON.stringify({
                transaction: transactionRef
            }),
            success: function(response) {
                console.log("Transaction récupérée :", response);

                $("#reference_declaration").val(response.refDecla);
                $("#reference").val(response.referenceTransaction);
                $("#contribuable").val(response.contribuable);
                $("#transacDate").val(response.transBankDate);
                $("#mount").val(response.mount);
                $("#mountttc").val(response.mountTTC);
                $("#comptealt").val(response.comptealt);
                if (response.motif != null) {
                    $("#motif").val(decodeURIComponent(response.motif));
                } else {
                    $("#motif").val();
                }

                $("#operation").val(response.type_transaction.operationMonetique);

                let operation = response.type_transaction.operationMonetique;
                $("#designation").val(operation === "OOT" ? "Paiement OTR" : "Paiement CNSS");

                $("#status").val(response.status === "2" ? "Annulé" : response.status === "1" ?
                    "Validé" : "En cours");

                if (response.status == "2") {
                    $("#status").val("Annulé");
                } else if (response.status == "1") {
                    $("#status").val("Validé");
                } else if (response.status == "0.1") {
                    $("#status").val("En cours");
                } else if (response.status == "0") {
                    $("#status").val("En attente");
                }


                let tabpane = $("#tabpane").val();
                if (tabpane === "tab_pai_step3") {
                    document.getElementById("btnAnnuler").style.display = "none";
                    document.getElementById("btnValider").style.display = "none";
                }

                $("#error-alert").addClass("d-none").html("");
                hideLoading();
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON?.error ||
                    "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                $("#error-messages").html(errorMessage);
                $("#error-alert").removeClass("d-none");
            }
        });*/

    let motifField = document.getElementById("motif");
    let toggleMotif = document.getElementById("toggleMotif");
    let btnAnnuler = document.getElementById("btnAnnuler");
    let reference = document.getElementById("reference");

    // Désactiver le bouton Annuler au chargement
    btnAnnuler.classList.add("disabled");

    /* Événement sur la checkbox
    toggleMotif.addEventListener("change", function() {
        if (this.checked || (toggleMotif.checked && motifField.value.trim() !== "")) {
            motifField.removeAttribute("readonly");
            motifField.focus();
            btnAnnuler.classList.remove("disabled");
            btnValider.classList.add("disabled");
        } else {
            motifField.setAttribute("readonly", "true");
            motifField.value = ""; // Efface le texte si décoché
            btnValider.classList.remove("disabled");
            btnAnnuler.classList.add("disabled");
        }

        /*updateAnnulerButton();
    });*/



    var modalForCompte = document.getElementById('modalForCompte')
    exampleModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = exampleModal.querySelector('.modal-title')
        var modalBodyInput = exampleModal.querySelector('.modal-body input')

        //modalTitle.textContent = 'New message to ' + recipient
        //modalBodyInput.value = recipient

        document.getElementById("closeForModalCmpte").addEventListener("click", function() {
            const modalElement = document.getElementById("modalForCompte");

            document.getElementById("referenceInModal").value = "";
            document.getElementById("descriptionInModal").value = "";
            document.getElementById("montantInModal").value = "";
            document.getElementById("compteInModal").selectedIndex = 0;
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        });

        $(document).ready(function() {
            $("#secondBtnValidation").on("click", function() {
                //alert("TRACE");
                validationPending();
            });
        });
    });


});


function updateAnnulerButton() {
    let transaction = $("#reference").val(); // Assurez-vous que l'ID est correct
    let motif = encodeURIComponent($("#motif").val()); // Récupération du motif
    let comptealt = $("#comptealt").val();
    let operation = $("#operation").val();

    console.log("Transaction :", transaction);
    console.log("Motif :", motif);
    console.log("Compte :", comptealt);
    console.log("Opération :", operation);

    // Vérification si le motif est bien rempli
    if (!motif || motif.trim() === "") {
        return;
    }

    $.ajax({
        url: "/transactions/annuler",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Sécurité CSRF
        },
        contentType: "application/json",
        data: JSON.stringify({
            transaction: transaction,
            motif: motif,
            comptealt: comptealt,
            operation: operation
        }),
        success: function(response) {
            console.log("Transaction annulée :", response);
            if (response) {
                hideLoading();
                $("#btnFiltrer").click();
            }
            $("#error-alert").addClass("d-none").html("");
            hideLoading();
        },
        error: function(xhr) {

            if (xhr.responseJSON && xhr.responseJSON.error) {
                let error = xhr.responseJSON.error;
                let errorMessages = "";

                errorMessages += error;

                $("#error-messages").html(errorMessages);
                $("#error-alert").removeClass("d-none");
            } else {
                let errorMessages = "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                $("#error-messages").html(errorMessages);
                $("#error-alert").removeClass("d-none");
            }
            hideLoading();
        }
    });
}


function validerPaiement() {
    let transaction = $("#reference").val(); // Assurez-vous que l'ID est correct
    let motif = encodeURIComponent($("#motif").val()); // Récupération du motif
    let comptealt = $("#comptealt").val();
    let operation = $("#operation").val();
    let tabpane = $("#tabpane").val();

    console.log("Transaction :", transaction);
    console.log("Motif :", motif);
    console.log("Compte :", comptealt);
    console.log("Opération :", operation);
    console.log("tabpane :", tabpane);


    $.ajax({
        url: "/transactions/validate",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Sécurité CSRF
        },
        contentType: "application/json",
        data: JSON.stringify({
            transaction: transaction,
            motif: motif,
            comptealt: comptealt,
            operation: operation,
            tabpane: tabpane
        }),
        success: function(response) {
            console.log("Transaction annulée :", response);
            if (response) {
                //hideLoading();
                $("#btnFiltrer").click();
            }
            $("#error-alert").addClass("d-none").html("");
            hideLoading();
        },
        error: function(xhr) {

            if (xhr.responseJSON && xhr.responseJSON.error) {
                let error = xhr.responseJSON.error;
                let errorMessages = "";

                errorMessages += error;

                $("#error-messages").html(errorMessages);
                $("#error-alert").removeClass("d-none");
            } else {
                let errorMessages = "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                $("#error-messages").html(errorMessages);
                $("#error-alert").removeClass("d-none");
            }
            hideLoading();
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projets\aleasepay\resources\views/transactions_pending/index.blade.php ENDPATH**/ ?>