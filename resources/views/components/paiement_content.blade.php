 @props(['paiements' => []])

<div  class="etudiants-container">
        <div class="paiement_title">
            <div class="etudiant-title">
                <h2>Liste des paiements</h2>
                <div class="paiemen">
                    <a href="{{ route('paiements.create')}}" class="etudiant-btn">Ajouter un paiement</a>
                    <a href="{{ route('statistiques.cumul') }}" class="etudiant-btn">Cumul par niveau</a>
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
                        <th>Nom de l'étudiant</th>
                        <th>Montant</th>
                        <th>Date de paiement</th>
                        <th>Mode de paiement</th>
                        <!-- <th>Progression Paiement</th> -->
                        <th>Etat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <ul class="list-group">
                        @foreach($paiements as $paiement)
                        <li  class="list-group-item">
                            <tr>
                                <td>{{ $paiement->etudiant->nom ?? 'inconnu' }}</td>
                                <td>{{ $paiement->montant }}</td>
                                <td>{{ $paiement->date_paiement }}</td>
                                <td>{{ $paiement->mode_paiement }}</td>
                                <td>
                                    @if($paiement->etat)
                                        <p>
                                            @if($paiement->etat === 'solde')
                                                Soldé 
                                            @elseif($paiement->etat === 'partiel')
                                                En attente
                                            @else
                                                {{ $paiement->etat }}
                                            @endif
                                        </p>
                                    @else
                                        <p>Aucun statut de paiement disponible.</p>
                                    @endif
                                </td>
                                <td id="delete-table">
                                    <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form id="delete-form-{{ $paiement->id }}" action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $paiement->id }})"><i class="fa-solid fa-trash"></i></button>
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