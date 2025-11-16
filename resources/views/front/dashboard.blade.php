@extends('layouts.main')

 

@section('dash')

   <div class="dash">
        <!-- Faire appelle au user en lui disans bienvenue -->
        <div class="dash-content">
            <main>
                <x-sidebar />
            </main>
            <aside class="dashboard-content">
                <div class="navbar_content">
                    <x-navbar/>
                </div>
                <div>
                    <x-dashboard :totalEtudiants="$totalEtudiants" 
                                    :totalBesoins="$totalBesoins" 
                                    :totalPaiements="$totalPaiements" 
                                    :besoinsEnAttente="$besoinsEnAttente" 
                                    :recentEtudiants="$recentEtudiants" 
                                    :besoinsUrgents="$besoinsUrgents" 
                                    :recentPaiements="$recentPaiements" 
                        />
                </div>
                <div class="footer">
                    <x-footer />
                </div>
                
            </aside>
        </div>
    </div>

@endsection

@section('content')
    <title>Tableau de bord</title>
   
@endsection
