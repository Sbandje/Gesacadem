@extends('layouts.main')

@section('content')
   <div class="navbar_login">
        <div class="log-nav">
            <h1>Gesacadem</h1>
            <p>Votre académie de langue à proximité</p>
        </div>
    </div>

    <div class="login-container">
        @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        <form method="POST" action="{{route('user.login.post')}}" class="form">
            @csrf
                <h2 class="form-title">Connectez-Vous</h2>
                <div class="form-group">
                    <label for="email">Identifiant / Email</label>
                    <input type="email" id="email" name="email" placeholder="votre@email.com" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Créez un mot de passe" required>
                </div>

                <button type="submit" class="login-btn">Se connecter</button>
        </form>
    </div>

    <div class="footer-login">
      <p>&copy; 2025 Académie de Langues. Tous droits réservés.</p>
    </div>
@endsection
