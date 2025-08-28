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
    <a href="{{ route('avisTransfert.index') }}" class="nav-link {{ Request::is('avisTransfert*') ? 'active' : '' }}">
        <i class="nav-icon fas fa fa-exchange-alt"></i>
        <p>Avis de Transferts</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('commandeBordereau.index') }}" class="nav-link {{ Request::is('bordereau*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-solid fa-money-check"></i>
        <p>Bordereaux</p>
    </a>
</li>
@if($profil==$autonome )
<li class="nav-item"> 
    <a href="{{ route('cnss.cotisations') }}" class="nav-link {{ Request::is('cnss*') ? 'active' : ''}} ">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Cotisation CNSS </p>
    </a>
</li>

<li class="nav-item"> 
    <a href="{{ route('otr.etax') }}" class="nav-link {{ Request::is('otr*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Etax OTR </p>
    </a>
</li>
@endif
@if($profil==$initiateur ||  $profil==$validateur)
<li class="nav-item"> 
    <a href="{{ route('pending.index') }}" class="nav-link {{ Request::is('pending*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Mes Transactions </p>
    </a>
</li>
@endif
<li class="nav-item"> 
    <a href="{{ route('transactions.index') }}" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-solid fa-wallet" ></i>
        <p>Transactions </p>
    </a>
</li>



