@extends('leyout.base')

@section('content')
<div class="container">
    <h1>Voir les demandes</h1>
   


    <!-- Affichage des messages de succès (si présents) -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tableau des utilisateurs -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Intitulé</th>
                <th>Motif</th>
                <th>Montant</th>
                
                <th>Statut</th>
                <th>Date</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach($val as $va)
                <tr>
                    <td>  </td>
                    <td> {{ $va->numero }} </td>
                    <td>{{ $va->modif }}</td>

                    <td>{{ $va->montant }}$</td>
                    <td>   
                        <span class="badge 
                            {{ $va->status == 0 ? 'text-bg-primary' : ($va->status == 1 ? 'text-bg-success' : 'text-bg-danger') }}">
                            {{ $va->status == 0 ? '' : ($va->status == 1 ? 'Valider' : 'Annuler') }}
                        </span>
                    </td>
                    
                    <td> 
                        {{ $va->date }} 
                    </td>

                    <td>
                         @if ($va->status == 0)
                            <a href="{{ route('admin.operation.valider', ['id' => $va->id]) }}" class="btn btn-primary">Valider</a>
                            <a href="{{ route('admin.operation.annuler', ['id' => $va->id]) }}" class="btn btn-danger">Annuler</a>
                         @endif


                        <span class="badge 
                                {{ $va->status2 == 0 ? 'text-bg-primary' : ($va->status2 == 1 ? 'text-bg-success' : 'text-bg-danger') }}">
                                {{ $va->status2 == 0 ? '' : ($va->status2 == 1 ? 'Terminé' : 'En cours') }}
                        </span>

                  






                       
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection

