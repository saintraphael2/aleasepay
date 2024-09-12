<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Accueil</p>
    </a>
</li>

<li class="nav-item">
<a href="{{ route('rib') }}" class="nav-link {{ Request::is('rib*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>RIB</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('cptClients.index') }}" class="nav-link {{ Request::is('cptClients*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Relevés</p>
    </a>
</li>