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
                
                <div class="etu-content">
                    <form action="{{ route('user.logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>

                <div class="footer">
                    <x-footer />
                </div>
            </aside>
        </div>
    </div>

    
@endsection



