<!-- need to remove -->
<li class="nav-item">
    <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(Request::is('home') ? 'active' : ''); ?>">
        <i class="nav-icon fas fa-home"></i>
        <p>Accueil</p>
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo e(route('rib')); ?>" class="nav-link <?php echo e(Request::is('rib*') ? 'active' : ''); ?>">
        <i class="nav-icon fas fa fa-money-check-alt"></i>
        
        <p>RIB</p>
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo e(route('mouvements.index')); ?>" class="nav-link <?php echo e(Request::is('mouvements*') ? 'active' : ''); ?>">
        <i class="nav-icon fas fa fa-exchange-alt"></i>
        <p>Mouvements</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo e(route('avisTransfert.index')); ?>" class="nav-link <?php echo e(Request::is('avisTransfert*') ? 'active' : ''); ?>">
        <i class="nav-icon fas fa fa-exchange-alt"></i>
        <p>Avis de Débit</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo e(route('commandeBordereau.index')); ?>" class="nav-link <?php echo e(Request::is('bordereau*') ? 'active' : ''); ?>">
    <i class="nav-icon fas fa-solid fa-money-check"></i>
        <p>Bordereaux</p>
    </a>
</li>
<?php if($profil==$autonome ): ?>
<li class="nav-item"> 
    <a href="<?php echo e(route('cnss.cotisations')); ?>" class="nav-link <?php echo e(Request::is('cnss*') ? 'active' : ''); ?> ">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Cotisation CNSS </p>
    </a>
</li>

<li class="nav-item"> 
    <a href="<?php echo e(route('otr.etax')); ?>" class="nav-link <?php echo e(Request::is('otr*') ? 'active' : ''); ?>">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Etax OTR </p>
    </a>
</li>
<?php endif; ?>
<?php if($profil==$initiateur ||  $profil==$validateur): ?>
<li class="nav-item"> 
    <a href="<?php echo e(route('pending.index')); ?>" class="nav-link <?php echo e(Request::is('pending*') ? 'active' : ''); ?>">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Mes Transactions </p>
    </a>
</li>
<?php endif; ?>
<li class="nav-item"> 
    <a href="<?php echo e(route('transactions.index')); ?>" class="nav-link <?php echo e(Request::is('transactions*') ? 'active' : ''); ?>">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Transactions </p>
    </a>
</li>



<?php /**PATH C:\Projet_dev\Laravel\aleasepay\resources\views/layouts/menu.blade.php ENDPATH**/ ?>