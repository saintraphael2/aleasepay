<!-- need to remove -->
<li class="nav-item">
    <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(Request::is('home') ? 'active' : ''); ?>">
        <i class="nav-icon fas fa-home"></i>
        <p>Accueil</p>
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo e(route('rib')); ?>" class="nav-link <?php echo e(Request::is('rib*') ? 'active' : ''); ?>">
        <i class="nav-icon fas fa-home"></i>
        <p>RIB</p>
    </a>
</li>


<li class="nav-item">
    <a href="<?php echo e(route('mouvements.index')); ?>" class="nav-link <?php echo e(Request::is('mouvements*') ? 'active' : ''); ?>">
        <i class="nav-icon fas fa-home"></i>
        <p>Mouvements</p>
    </a>
</li>
<?php /**PATH C:\Users\kokou.djimissa\Documents\Projets\altprojects\aleasepay\resources\views/layouts/menu.blade.php ENDPATH**/ ?>