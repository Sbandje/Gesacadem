 @props(['etudiants' => []])

<div  class="etudiants-container">
        <div class="etudiant-title">
            <h2>Liste des étudiants</h2>
            <a href="{{ route('etudiants.add')}}" class="etudiant-btn">Ajouter un etudiant</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success')}}</div>
        @endif

        
                    <div class="table-etudiants">
                        
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Email</th>
                                        <th>Date de naissance</th>
                                        <th>Niveau</th>
                                        <th>Module</th>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                        <th>Actions</th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        
                                        @foreach($etudiants as $etudiant)
                                            <tr>
                                                <td>{{ $etudiant->nom }}</td>
                                                <td>{{ $etudiant->prenom }}</td>
                                                <td>{{ $etudiant->email }}</td>
                                                <td>{{ $etudiant->date_naissance }}</td>
                                                <td>{{ $etudiant->niveaux_id }}</td>
                                                <td>{{ $etudiant->modules_id }}</td>
                                                <td>{{ $etudiant->date_debut }}</td>
                                                <td>{{ $etudiant->date_fin }}</td>
                                                <td id="delete-table">
                                                    <a href="{{route('etudiants.edit', $etudiant -> id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <button type="button" class="btn btn-danger" id="btn-delete" onclick="confirmDelete({{$etudiant -> id}})"><i class="fa-solid fa-trash"></i></button>
                                                    <form id="delete-form-{{$etudiant -> id}}" action="{{route('etudiants.destroy', $etudiant)}}" id="delete" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    
                                </tbody>
                            </table>
                        
                    </div>
      
    </div>

<script>
        function confirmDelete(etudiantsId) {
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
                    document.getElementById('delete-form-' + etudiantsId).submit();
                }
            })
        }
    </script>