 @props(['besoins' => []])

@extends('layouts.main')

@section('content')

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
                    <x-besoin_content :statistiques='$statistiques'/>
                </div>
            </aside>
        </div>
    </div>



@endsection
