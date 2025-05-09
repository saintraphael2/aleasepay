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
                <input type="hidden" id="profil" name="profil" value="<?php echo e($profil); ?>" />
                <input type="hidden" id="initiateur" name="initiateur" value="<?php echo e($initiateur); ?>" />
                <input type="hidden" id="validateur" name="validateur" value="<?php echo e($validateur); ?>" />
                <input type="hidden" id="autonome" name="autonome" value="<?php echo e($autonome); ?>" />
            </div>
        </div>
        <!--/form-->

        <div class="card signincardctz">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php if($profil==$initiateur): ?>
                    <li class="nav-item" role="presentation">

                        <button class=" flex-sm-fill text-sm-center nav-link-tab active" id="tab_pai_step1"
                            data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home"
                            aria-selected="true">Paiement ( Cotisation CNSS )</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class=" flex-sm-fill text-sm-center nav-link-tab" id="tab_pai_step2"
                            data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab"
                            aria-controls="profile" aria-selected="false">Paiement ( Etax OTR ) </button>
                    </li>
                    <?php endif; ?>
                    <?php if($profil==$validateur ): ?>
                    <li class="nav-item" role="presentation">
                        <button class=" flex-sm-fill text-sm-center nav-link-tab" id="tab_pai_step3"
                            data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab"
                            aria-controls="contact" aria-selected="false">Paiement (Cotisation CNSS & Etax OTR)</button>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php if($profil==$initiateur): ?>
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="tab_pai_step1">
                        <?php echo $__env->make('transactions_pending.table_pending_cnss', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="tab_pai_step2">
                        <?php echo $__env->make('transactions_pending.table_pending_otr', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <?php endif; ?>
                    <?php if($profil==$validateur ): ?>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="tab_pai_step3">
                        <?php echo $__env->make('transactions_pending.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <?php endif; ?>
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
                        <?php echo Form::label('numero_employeur', 'Numéro Employeur :', ['class' => 'form-label inputlabel']); ?>

                        <?php echo Form::text('name', null, ['class' => 'form-control','id'=>'numero_employeur',
                        'required', 'maxlength' => 255, 'maxlength' => 255]); ?>

                    </div>
                    <div class="form-group col-sm-4" style="margin-top: 2rem;">
                        <button id="searchForm" class="btn btn-primary btnSubmit">Rechercher</button>
                    </div>
                </div>
                <!--/form-->
                <div id="tableCotisationWrapper">
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
            </div>

            <div id="formPaiementWrapper" class="d-none">
                <div class="card" style="padding: 15px;">

                    <?php echo csrf_field(); ?>
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <?php echo e($errors->first()); ?>

                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="form-group col-sm-6 mb-3">
                            <label for="referenceDeclaration" class="form-label">Référence Déclaration</label>
                            <input type="text" id="referenceDeclaration" name="referenceDeclaration"
                                class="form-control" value="" readonly>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="referenceTransaction" class="form-label">Référence Transaction</label>
                            <input type="text" id="referenceTransaction" name="referenceTransaction"
                                class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-sm-6 mb-3">
                            <label for="taxecontribuable" class="form-label">Contribuable</label>
                            <input type="text" id="taxecontribuable" name="taxecontribuable" class="form-control"
                                value="" readonly>
                        </div>

                        <div class="form-group col-sm-6 mb-3">
                            <label for="nif" class="form-label">NIF</label>
                            <input type="text" id="taxenif" name="taxenif" class="form-control" value="" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 mb-3">
                            <label for="montant" class="form-label">Montant TTC</label>
                            <input type="hidden" id="taxemontant" class="form-control" value="" readonly>
                            <input type="text" id="taxemontant_affiche" name="taxemontant" class="form-control" value=""
                                readonly>

                        </div>

                        <div class="form-group col-sm-6 mb-3">
                            <label for="taxe_comptealt" class="form-label">Compte</label>
                            <select id="taxe_comptealt" name="taxe_comptealt" class="form-select form-control" required>
                                <option value="">-- Sélectionnez un compte --</option>
                                <?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($compte->compte); ?>"><?php echo e($compte->compte); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <button onclick="validationPendingOTR()" class="btn btn-primary btnSubmit">Soumettre</button>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeexampleModal"
                    data-bs-dismiss="modal">Retour</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalForCompte" tabindex="-1" aria-labelledby="modalForCompte" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalForCompte"></h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Reference:</label>
                            <input name="reference_inmodal" id="referenceInModal" class="form-control" readOnly />
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Montant TTC:</label>
                            <input type="hidden" id="montantInModal" class="form-control" readOnly />
                            <input name="montant_inmodal" id="montantInModal_ttc" class="form-control" readOnly />
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
                    <button type="button" class="btn btn-primary" onclick="validationPending()"
                        id="secondBtnValidation">Valider</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
var tabPaneactive = "tab_pai_step1";
document.addEventListener("DOMContentLoaded", function() {
    const tabButtons = document.querySelectorAll('.nav-link-tab');
    let hasActive = false;

    tabButtons.forEach((btn) => {
        if (btn.classList.contains('active')) {
            hasActive = true;
        }
    });

    if (!hasActive && tabButtons.length > 0) {
        const firstVisibleTab = tabButtons[0];
        const targetSelector = firstVisibleTab.getAttribute('data-bs-target'); // ex: "#home"
        const targetElement = document.querySelector(targetSelector);

        if (targetElement) {
            const ariaLabelledBy = targetElement.getAttribute('aria-labelledby');
            console.log("aria-labelledby du tab :", ariaLabelledBy);
            tabPaneactive=ariaLabelledBy;
        }

        // Activer l’onglet
        const tab = new bootstrap.Tab(firstVisibleTab);
        tab.show();
    }
});


//swal("Hello world!");
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
        sweetAlert(
            "Confirmation",
            "Voulez-vous annuler cette transaction ?",
            () => cancelPendingTransac(pendingTransacID),
            "warning"
        );
    }
});

var pendingtransacttype = "";
/*document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-pendingValidate');
    if (btn) {
        pendingTransacID = btn.dataset.pendingtransac;
        pendingtransacttype = btn.dataset.pendingtransacttype;
        console.log('Référence cliquée :', pendingtransacttype);
        sweetAlert(
            "Confirmation",
            "Voulez-vous valider cette transaction ?",
            function() {
                showLoadingOverlay();
                validatePendingTransac(pendingTransacID, pendingtransacttype);
                hideLoadingOverlay();
            },
            "success"
        );
    }
});*/

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-pendingValidate');
    if (!btn) return;

    const pendingTransacID = btn.dataset.pendingtransac;
    const pendingtransacttype = btn.dataset.pendingtransacttype;
    sweetAlert(
        "Confirmation",
        "Voulez-vous valider cette transaction ?",
        () => validatePendingTransac(pendingTransacID, pendingtransacttype),
        "success"
    );
});

/*
function sweetAlert(titre, text, callback, icon) {
    swal({
        title: titre || "Êtes-vous sûr d'annuler cette opération ?",
        text: text || "Souhaitez-vous réellement mettre fin à cette opération ?",
        icon: icon || "warning",
        buttons: true,
        dangerMode: true,
    }).then((willProceed) => {
        if (willProceed) {
            if (typeof callback === "function") {
                showLoading();
                const result = callback();
                // Si callback retourne une promesse (async), on attend qu’elle se termine
                if (result && typeof result.then === "function") {
                    result.then(() => {
                        swal("Opération effectuée avec succès.", {
                            icon: "success",
                        });
                    }).catch(() => {
                        swal("Une erreur est survenue pendant l'opération.", {
                            icon: "error",
                        });
                    });
                } else {
                    // Callback synchrone
                    swal("Opération effectuée avec succès.", {
                        icon: "success",
                    });
                }
            }
        } else {
            swal("Aucune modification n’a été effectuée.");
        }
    });
}*/

function sweetAlert(titre, text, callback, icon) {
    swal({
        title: titre || "Confirmation",
        text: text || "Êtes-vous sûr ?",
        icon: icon || "warning",
        buttons: true,
        dangerMode: true,
    }).then((willProceed) => {
        if (!willProceed) {
            return swal("Aucune modification n’a été effectuée.");
        }

        // 3) À ce stade, l’utilisateur a cliqué sur "OK"
        showLoadingOverlay();

        // On appelle ta fonction, qui retourne une Promise
        const result = callback();

        // Si c’est bien une promesse, on enchaîne dessus
        if (result && typeof result.then === "function") {
            result
                .then(response => {
                    hideLoadingOverlay();
                    swal("Opération effectuée avec succès.", {
                        icon: "success"
                    });
                })
                .catch(err => {
                    hideLoadingOverlay();
                    swal("Une erreur est survenue pendant l'opération.", {
                        icon: "error"
                    });
                });
        } else {
            // Callback synchrone (rare ici)
            hideLoadingOverlay();
            swal("Opération effectuée avec succès.", {
                icon: "success"
            });
        }
    });
}

/**
 * 
 */
function validatePendingTransac(id, type) {
    showLoading();
    if (type == "OCN") {
        // <?php echo e(route('cptClients.create')); ?>

        showLoading();
        return $.ajax({
            url: "<?php echo e(route('pending.paiementcnss')); ?>",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Sécurité CSRF
            },
            contentType: "application/json",
            data: JSON.stringify({
                idTransac: id
            }),
            success: function(response) {
                console.log("Transaction annulée :", response);

                let errorMessage = response.success;
                $("#success-alert").removeClass("d-none").css("z-index", "2000");
                $("#success-messages").html(errorMessage);
                setTimeout(function() {
                    $("#success-alert").addClass("d-none");
                }, 3000);
                hideLoading();
                filter();

            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    let errorMessage = xhr.responseJSON.error ||
                        "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                    $("#error-alert").removeClass("d-none").css("z-index", "2000").html("<p>" +
                        errorMessage +
                        "</p>");
                    setTimeout(function() {
                        $("#error-alert").addClass("d-none");
                    }, 3000);
                    hideLoading();
                }
                hideLoading();
            }
        });


    } else if (type == "OOT") {
        showLoading();
        return $.ajax({
            url: "<?php echo e(route('pending.paiementotr')); ?>",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Sécurité CSRF
            },
            contentType: "application/json",
            data: JSON.stringify({
                idTransac: id
            }),
            success: function(response) {
                console.log("Transaction annulée :", response);

                let errorMessage = response.success;
                $("#success-alert").removeClass("d-none").css("z-index", "2000");
                $("#success-messages").html(errorMessage);
                setTimeout(function() {
                    $("#success-alert").addClass("d-none");
                }, 3000);
                hideLoading();
                filter();
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    let errorMessage = xhr.responseJSON.error ||
                        "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                    $("#error-alert").removeClass("d-none").css("z-index", "2000").html("<p>" +
                        errorMessage +
                        "</p>");
                    setTimeout(function() {
                        $("#error-alert").addClass("d-none");
                    }, 3000);
                    hideLoading();
                }
                hideLoading();
            }
        });
    }
}


function cancelPendingTransac(id) {
    showLoading();
    //<?php echo e(route('cptClients.create')); ?>

    return $.ajax({
        url: "<?php echo e(route('pending.cancel')); ?>",
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
            setTimeout(function() {
                $("#success-alert").addClass("d-none");
            }, 3000);
            hideLoading();
            filter();
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON?.error ||
                "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-messages").html(errorMessage);
            $("#error-alert").removeClass("d-none");
            setTimeout(function() {
                $("#error-alert").addClass("d-none");
            }, 3000);
        }
    });
}
var typeActif = "OCN";

function filter() {
    let type = $('#type').val();
    if (tabPaneactive == 'tab_pai_step1') {
        type = 'OCN';
    } else if (tabPaneactive == 'tab_pai_step2') {
        type = 'OOT';
    }
    if (tabPaneactive == 'tab_pai_step3') {
        type = $('#type').val();
    }
    let date_debut = $('#date_debut').val();
    let date_fin = $('#date_fin').val();
    let compte = $('#compte').val();

    showLoading();
    //<?php echo e(route('cptClients.create')); ?>

    $.ajax({
        url: "<?php echo e(route('pending.filter')); ?>",
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
            } else if (tabPaneactive == 'tab_pai_step3') {
                $("#transactionsTablePay tbody").empty();
            }

            console.log("Transaction récupérée :", response);
            //$("#reference_declaration").val(response.refDecla);
            //$("#reference").val(response.referenceTransaction);
            if (tabPaneactive == 'tab_pai_step1' || tabPaneactive == 'tab_pai_step2') {
                response.forEach(pendingtransac => {
                    let operation = (pendingtransac.type ===
                        "OOT") ? "Paiement OTR" : "Paiement CNSS";
                    let etatClass = {
                        'en_attente': 'status-en_attente',
                        'validé': 'status-validé',
                        'annulé': 'status-annulé'
                    } [pendingtransac.etat] || '';
                    let row = `
            <tr class="pendingtransac-row" data-pendingtransac="${pendingtransac.id}">
                <td>${pendingtransac.reference}</td>
                <td>${operation}</td>
                <td>${pendingtransac.compte}</td>
                <td>${pendingtransac.user?.name}</td>
                <td>${pendingtransac.date_transaction}</td>
                <td>${pendingtransac.montant_ttc} FCFA</td>
                <td><span class="status-badge ${etatClass}">
                    ${pendingtransac.etat.replace('_', ' ')}
                  </span></td>
                <td style="padding: 4px">
                <input type="hidden" id="pendingtransac_${pendingtransac.id}" name="pendingtransac" value="${pendingtransac.id}"/>
                ${pendingtransac.etat !== 'annulé' && pendingtransac.etat !== 'validé' ? `<button type="button" class="btn btn-danger btn-cancel-pendingCnss" 
                    data-pendingtransac="${pendingtransac.id}">
                    Annuler
                </button> ` : ''}
            </td>
            </tr>`;

                    if (tabPaneactive == 'tab_pai_step1') {
                        $("#transactionsTableCnss tbody").append(row);
                    } else if (tabPaneactive == 'tab_pai_step2') {
                        $("#transactionsTableOtr tbody").append(row);
                    }

                });
            } else if (tabPaneactive == 'tab_pai_step3') {
                response.forEach(pendingtransac => {
                    let operation = (pendingtransac.type ===
                        "OOT") ? "Paiement OTR" : "Paiement CNSS";
                    let etatClass = {
                        'en_attente': 'status-en_attente',
                        'validé': 'status-validé',
                        'annulé': 'status-annulé'
                    } [pendingtransac.etat] || '';
                    let rowpay = `
    <tr class="pendingtransac-row" data-pendingtransac="${pendingtransac.id}" data-pendingtransacttype="${pendingtransac.type}">
        <td>${pendingtransac.reference}</td>
        <td>${operation}</td>
        <td>${pendingtransac.compte}</td>
        <td>${pendingtransac.user?.name}</td>
        <td>${pendingtransac.date_transaction}</td>
        <td>${pendingtransac.montant_ttc} FCFA</td>
        <td><span class="status-badge ${etatClass}">
                    ${pendingtransac.etat.replace('_', ' ')}
                  </span></td>
        <td style="padding: 4px">
    <input type="hidden" id="pendingtransac_${pendingtransac.id}" name="pendingtransac" value="${pendingtransac.id}"/>
    ${pendingtransac.etat !== 'annulé' && pendingtransac.etat !== 'validé' ? `
        <button type="button" class="btn btn-danger btn-cancel-pendingCnss" 
            data-pendingtransac="${pendingtransac.id}">
            Annuler
        </button>
        <button type="button" class="btn btn-primary btn-pendingValidate" 
            data-pendingtransac="${pendingtransac.id}"
            data-pendingtransacttype="${pendingtransac.type}">
            Valider
        </button>
    ` : ''}
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
    handleTabPaneDisplay(tabPaneactive);

    if (tabPaneactive == 'tab_pai_step1') {
        showLoading();
        $("#transactionsTableCnss tbody").empty();
        typeActif = 'OCN';
        hideLoading();
    } else if (tabPaneactive == 'tab_pai_step2') {
        showLoading();
        $("#transactionsTableOtr tbody").empty();
        typeActif = 'OOT';
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

async function initSecondModal() {
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

    montantTTC = await getMontantTTC(typeActif, cotisation.amount);

    $("#montantInModal_ttc").val(new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XOF'
    }).format(montantTTC));
}

function validationPending() {
    let compteSelected = $("#compteInModal").val();
    let description = $("#descriptionInModal").val();
    let numero_employeur = $("#numero_employeur").val();
    let montantInModal_ttc = $("#montantInModal_ttc").val();
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
        url: "<?php echo e(route('pending.save')); ?>",
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
            montant_ttc: montantInModal_ttc,
            etat: "en_attente",
            date: new Date(),
            description: description,
            numeroemployeur: numero_employeur,
            contribuable: cotisation.requester
        }),
        success: function(response) {
            console.log("Transactions récupérées :", response);

            let errorMessage = response.success;
            $("#success-alert").removeClass("d-none").css("z-index", "2000");
            $("#success-messages").html(errorMessage);
            setTimeout(function() {
                $("#success-alert").addClass("d-none");
            }, 3000);
            hideLoading();
            document.getElementById("closeForModalCmpte").click();
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON.error ||
                "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-alert").removeClass("d-none").css("z-index", "2000").html("<p>" + errorMessage +
                "</p>");
            setTimeout(function() {
                $("#error-alert").addClass("d-none");
            }, 3000);
            hideLoading();
        }
    });
}

function handleTabPaneDisplay(tabPaneactive) {
    const tableWrapper = document.getElementById("tableCotisationWrapper");
    const formWrapper = document.getElementById("formPaiementWrapper");

    if (tabPaneactive === "tab_pai_step1") {
        tableWrapper.classList.remove("d-none");
        formWrapper.classList.add("d-none");
    } else if (tabPaneactive === "tab_pai_step2") {
        tableWrapper.classList.add("d-none");
        formWrapper.classList.remove("d-none");
    } else {
        // Masquer les deux si ce n’est ni l’un ni l’autre
        tableWrapper.classList.add("d-none");
        formWrapper.classList.add("d-none");
    }
}
var vosCotisations = [];

var etaX = {};

var montantTTC = "";

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


function getMontantTTC(operation, montant) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "<?php echo e(route('pending.getmontantttc')); ?>",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            contentType: "application/json",
            data: JSON.stringify({
                operation,
                montant
            }),
            success: function(response) {
                resolve(response);
            },
            error: function(xhr) {
                reject(xhr.responseJSON?.error || "Erreur inconnue");
            }
        });
    });
}

$("#searchForm").on("click", async function() {
    console.log('ID de l\'onglet cliqué : ' + tabPaneactive);
    let numeroEmployeur = $("#numero_employeur").val();

    showLoadingOverlay();
    handleTabPaneDisplay(tabPaneactive);

    if (tabPaneactive === "tab_pai_step1") {
        // Appel AJAX cotisations classiques
        $.ajax({
            url: "<?php echo e(route('pending.search')); ?>",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            contentType: "application/json",
            data: JSON.stringify({
                numero_employeur: numeroEmployeur
            }),
            success: function(response) {
                vosCotisations = response;
                const transactions = vosCotisations.sort((a, b) => new Date(b.created_at) -
                    new Date(a.created_at));
                $("#voscotisationTable tbody").empty();

                transactions.forEach(transaction => {
                    let row = `
                        <tr class="transaction-row" data-transaction="${transaction.referenceID}">
                            <td>${transaction.referenceID}</td>
                            <td>${transaction.designation}</td>
                            <td>${transaction.requester}</td>
                            <td>${transaction.created_at}</td>
                            <td>${new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(transaction.amount)}</td>
                            <td>
                                <input type="hidden" name="referenceid" value="${transaction.referenceID}" />
                                <button type="button" class="btn btn-primary btn-validation" 
                                    data-bs-target="#modalForCompte" 
                                    data-bs-whatever="@modalForseleectCmpt" 
                                    data-bs-toggle="modal" 
                                    data-transaction="${transaction.referenceID}">
                                    Soumettre
                                </button>
                            </td>
                        </tr>`;
                    $("#voscotisationTable tbody").append(row);
                });

                $("#error-alert").addClass("d-none").html("");
                hideLoadingOverlay();
            },
            error: function(xhr) {
                let message = xhr.responseJSON?.error ||
                    "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                $("#error-messages").html(message);
                $("#error-alert").removeClass("d-none");
                hideLoadingOverlay();
            }
        });

    } else if (tabPaneactive === "tab_pai_step2") {
        // Appel AJAX etax
        $.ajax({
            url: "<?php echo e(route('pending.searchotr')); ?>",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            contentType: "application/json",
            data: JSON.stringify({
                numero_employeur: numeroEmployeur
            }),
            success: async function(response) {
                etaX = response;
                console.log("ETAX", etaX);
                $("#referenceDeclaration").val(etaX.referenceDeclaration);
                $("#referenceTransaction").val(etaX.referenceTransaction);
                $("#taxecontribuable").val(etaX.contribuable);
                $("#taxenif").val(etaX.nif);

                try {
                    montantTTC = await getMontantTTC(typeActif, etaX.montant);
                    $("#taxemontant").val(etaX.montant);

                    $("#taxemontant_affiche").val(new Intl.NumberFormat('fr-FR').format(
                        montantTTC) + ' FCFA');

                    //$("#taxemontant").val(montantTTC); // Valeur brute
                } catch (error) {
                    console.error("Erreur montant TTC :", error);
                }

                $("#error-alert").addClass("d-none").html("");
                hideLoadingOverlay();
            },
            error: function(xhr) {
                let message = xhr.responseJSON?.error ||
                    "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
                $("#error-messages").html(message);
                $("#error-alert").removeClass("d-none");
                hideLoadingOverlay();
            }
        });
    }
});




function validationPendingOTR() {
    let compte = $("#taxe_comptealt").val();
    let montant = $("#taxemontant").val();
    let montant_affiche = $("#taxemontant_affiche").val();
    let montant_ttc = $("#taxemontant_affiche").val().replace(/[\s\u00A0]|FCFA/g, '')
    let referenceDeclaration = $("#referenceDeclaration").val();
    let referenceTransaction = $("#referenceTransaction").val();
    let taxecontribuable = $("#taxecontribuable").val();
    let taxenif = $("#taxenif").val();
    showLoadingOverlay()

    // 👇 Ajoute dynamiquement le z-index
    //loading.style.zIndex = "1100";

    $.ajax({
        url: "<?php echo e(route('pending.otr.save')); ?>",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        contentType: "application/json",
        data: JSON.stringify({
            reference: referenceDeclaration,
            type: "",
            compte: compte,
            montant: montant,
            montant_ttc: montant_ttc,
            etat: "en_attente",
            date: new Date(),
            reference_transaction: referenceTransaction,
            contribuable: taxecontribuable,
            numero_employeur: taxenif
        }),
        success: function(response) {
            //  showLoadingOverlay()         
            console.log("Transactions récupérées :", response);

            let errorMessage = response.success;
            $("#success-alert").removeClass("d-none").css("z-index", "2000");
            $("#success-messages").html(errorMessage);
            setTimeout(function() {
                $("#success-alert").addClass("d-none");
            }, 3000);
            document.getElementById("closeexampleModal").click();
            hideLoadingOverlay();
            filter();
        },
        error: function(xhr) {
            let errorMessage = xhr.responseJSON.error ||
                "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-alert").removeClass("d-none").css("z-index", "2000").html("<p>" + errorMessage +
                "</p>");
            setTimeout(function() {
                $("#error-alert").addClass("d-none");
            }, 3000);
            hideLoadingOverlay();
        }
    });

}

$(document).ready(function() {
    $("#btnAnnuler").on("click", function() {
        updateAnnulerButton();
    });

    $("#btnValider").on("click", function() {
        validerPaiement();
    });


});



document.getElementById("closeexampleModal").addEventListener("click", function() {
    $("#referenceDeclaration").val("");
    $("#referenceTransaction").val("");
    $("#taxecontribuable").val("");
    $("#taxenif").val("");
    $("#taxemontant").val("");
    $("#taxemontant_affiche").val("");

    vosCotisations = [];
    etaX = {};
    montantTTC = "";
    transactionID = "";
    referenceID = "";
    cotisation = {};
    pendingtransacttype = "";

    $("#voscotisationTable tbody").empty();
    $("#numero_employeur").val("");
    filter();
});


var transaction = "";



var exampleModal = document.getElementById('exampleModal');
exampleModal.addEventListener('show.bs.modal', function(event) {
    var modalTitle = exampleModal.querySelector('.modal-title')
    var modalBodyInput = exampleModal.querySelector('.modal-body input')

    var inputTarget = exampleModal.querySelector('.inputlabel');

    var inputLabel = "Numéro Employeur";
    var modalTitre = "Paiement CNSS";
    if (tabPaneactive === "tab_pai_step1") {
        modalTitre = "Paiement CNSS";
        inputLabel = "Numéro Employeur";
    } else if (tabPaneactive === "tab_pai_step2") {
        modalTitre = "Paiement OTR";
        inputLabel = "Reférence Taxe";
    }
    if (tabPaneactive === "tab_pai_step3") {
        modalTitre = "Vos Paiements";
    }
    if (inputTarget) {
        inputTarget.textContent = inputLabel;
    }
    modalTitle.textContent = modalTitre;
    var button = event.relatedTarget; // Bouton qui a déclenché l’ouverture du modal
    var transactionRef = button.getAttribute('data-transaction'); // Récupérer la transaction

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




    });


});

document.getElementById("closeForModalCmpte").addEventListener("click", function() {
    const modalElement = document.getElementById("modalForCompte");

    document.getElementById("referenceInModal").value = "";
    document.getElementById("descriptionInModal").value = "";
    document.getElementById("montantInModal").value = "";
    document.getElementById("montantInModal_ttc").value = "";
    document.getElementById("compteInModal").selectedIndex = 0;
    transactionID = "";
    referenceID = "";
    cotisation = {};
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) {
        modalInstance.hide();
    }
});

function updateAnnulerButton() {
    let transaction = $("#reference").val();
    let motif = encodeURIComponent($("#motif").val());
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/akra4603/public_html/aleasepay/resources/views/transactions_pending/index.blade.php ENDPATH**/ ?>