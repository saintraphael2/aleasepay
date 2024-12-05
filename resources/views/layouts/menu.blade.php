<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Accueil</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('rib') }}" class="nav-link {{ Request::is('rib*') ? 'active' : '' }}">
        <i class="nav-icon fas fa fa-money-check-alt"></i>
        
        <p>RIB</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('mouvements.index') }}" class="nav-link {{ Request::is('mouvements*') ? 'active' : '' }}">
        <i class="nav-icon fas fa fa-exchange-alt"></i>
        <p>Mouvements</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('bordereaux.index') }}" class="nav-link {{ Request::is('bordereaux*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-solid fa-money-check"></i>
        <p>Bordereaux</p>
    </a>
</li>

