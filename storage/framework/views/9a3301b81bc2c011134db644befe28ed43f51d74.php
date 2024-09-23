

<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <h4>Mouvements du compte <?php echo e($compte); ?>  -- <?php echo e($deb->format('d-m-Y')); ?> au <?php echo e($fin->format('d-m-Y')); ?></h4>
                </div>
                <div class="col-sm-3">
                    <a class="btn btn-primary float-right"
                       href="<?php echo e(route('releve',[$compte,$deb->format('Y-m-d'),$fin->format('Y-m-d')])); ?>">
                        Export PDF
                    </a>
                </div>
            </div>
        </div>
    </section>
    <div class="content px-3">
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="clearfix"></div>
     
        <div class="row input-daterange">
            
        <div class="form-group col-sm-3">
                <?php echo Form::label('compte', 'Comptes :'); ?>

                <select name="compte" id="compte" class = 'form-control'>
                    <?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($compte->id); ?>"><?php echo e($compte->compte); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                
                <span class="text-danger font-size-xsmall error_date_debut"></span>
            </div>
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

            <div class="form-group col-sm-3" style="margin-top: 2rem;">
                <button type="submit" name="filter" id="filter" class="btn btn-primary">Filtrer</button>
                
            </div></div>

          
        
        <div class="card">
           <table class="table table-striped table-bordered dataTable no-footer">
            <tr>
            <th>Date</th>
                <th>Désignation</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
            <?php $__currentLoopData = $mouvements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mouvement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                <td><?php echo e($mouvement->LOT_DATE->format('d-m-Y')); ?></td>
                    <td><?php echo e($mouvement->ECRCPT_LIBELLE); ?> <?php echo e($mouvement->ECRCPT_LIBCOMP); ?></td>
                    <td style="text-align:right">
                        <?php if($mouvement->ECRCPT_SENS=='D'): ?>
                            <?php echo e(number_format($mouvement->ECRCPT_MONTANT, 0,"", " ")); ?>

                        <?php endif; ?>
                    </td>
                    <td style="text-align:right">

                    <?php if($mouvement->ECRCPT_SENS=='C'): ?>
                    <?php echo e(number_format($mouvement->ECRCPT_MONTANT, 0,"", " ")); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('page_scripts'); ?>
<script>

    $('#date_debut').datepicker()
    $('#date_fin').datepicker({maxDate: '0'})


        $('#filter').click(function(){
            let fromDate = $('#date_debut').val()
            let toDate = $('#date_fin').val()
            let redirect_url = "mouvements?compte="+$('#compte option:selected').text()
            
            if(fromDate != '' &&  toDate != ''){
                
                redirect_url += "&deb="+fromDate+"&fin="+toDate
            } 
            
            /*
            //alert('Both Date is required')
            let erreur = {
                responseJSON : {message : "Les deux dates sont obligatoires"}
            }
            showError(erreur, "")*/
            
            console.log("redirect Url : ", redirect_url)
            window.location.href =redirect_url
        });

        $('#refresh').click(function(){
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/mouvements/index.blade.php ENDPATH**/ ?>