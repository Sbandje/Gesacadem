<div class="sidebar">
    <div class="sidebar-header">
        <h3>Tableau de Bord</h3>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
                <a href="{{ route('front.dashboard')}}" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span>Accueil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Modules</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('front.etudiants')}}" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    <span>Etudiants</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('front.inscription')}}" class="nav-link">
                    <i class="fa-solid fa-address-card"></i>
                    <span>Inscription</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('front.paiement')}}" class="nav-link">
                    <i class="fa-solid fa-money-bill"></i>
                    <span>Paiement</span>
                </a>
            </li>
            

            <li class="nav-item">
                <a href="{{ route('besoins.dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-comments"></i>
                    <span>Besoins</span>
                </a>
            </li>
        </ul>
    </nav>
</div>