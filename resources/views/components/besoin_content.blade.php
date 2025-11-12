<div class="besoin-container">
     <div class="all" id="all1">
            <div class="all1-icone">
                <i class="fa-solid fa-border-all"></i>
            </div>
            <div class="all1-text">
                <h4>{{ $statistiques['total'] }}</h4>
                <small>Total Besoins</small>
            </div>
        </div>
    <div class="besoin-all">
       

        <div class="all" id="all2">
            <div class="all-icone">
                <i class="fa-regular fa-light-emergency-on"></i>
            </div>
            <div class="all-text">
                <h4>{{ $statistiques['urgents'] }}</h4>
                <small>Urgents</small>
            </div>
        </div>

        <div class="all" id="all1">
            <div class="all-icone">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="all1-text">
                <h4>{{ $statistiques['en_attente'] }}</h4>
                <small>En attente</small>
            </div>
        </div>

        <div class="all" id="all3">
            <div class="all-icone">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="all-text">
                <h4>{{ $statistiques['resolus'] }}</h4>
                <small>Résolus</small>
            </div>
        </div>

        <div class="all" id="all1">
            <div class="all-icone">
                <i class="fa-solid fa-square-xmark"></i>
            </div>
            <div class="all1-text">
                <h4>{{ $statistiques['rejetes'] }}</h4>
                <small>Rejetés</small>
            </div>
        </div>
    </div>


        


  

<div  class="etudiants-container">
        <div class="paiement_title">
            <div class="etudiant-title">
                <h2>Liste des paiements</h2>
                <div class="paiemen">
                    <a href="{{ route('besoins.create')}}" class="etudiant-btn">Ajouter un paiement</a>
                   
                </div>
            </div>
            
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success')}}</div>
        @endif

        <div class="table-etudiants">
            <table class="table">
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Type</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Priorité</th>
                        <th>Date Limite</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <ul class="list-group">
                        @foreach($besoins as $besoin)
                        <li  class="list-group-item">
                            <tr>
                                <td>{{ $besoin->etudiant->nom ?? 'inconnu' }}</td>
                                <td>{{ $besoin->type }}</td>
                                <td>{{ $besoin->titre }}</td>
                                <td>{{ $besoin->description }}</td>
                                <td>{{ $besoin->priorite }}</td>
                                <td>{{ $besoin->date_limite }}</td>
                                <td id="delete-table">
                                    <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form id="delete-form-{{ $besoin->id }}" action="{{ route('besoins.destroy', $besoin->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $besoin->id }})"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        </li>
                        @endforeach
                    </ul>
                </tbody>
            </table>
    </div>

    

<script>
        function confirmDelete(paiementsId) {
            Swal.fire({
                title: 'Etes-vous sûr',
                text: "Vous ne pouvez pas annulé la suppression !",
                icon: 'warning',

                showCancelButton: true,
                confirmButtonColor: '#027e3a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimé !',
                cancelButtonText: 'Annulé'

            }).then((result) => {
                if(result.isConfirmed) {
                    document.getElementById('delete-form-' + paiementsId).submit();
                }
            })
        }
    </script>
</div>