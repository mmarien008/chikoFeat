@extends('leyout.base')

@section('content')
<div class="container">
    <h1>Liste des utilisateurs</h1>
    <a href="{{route('admin.user.create')}}" class="btn btn-primary" >Ajouter un utilisateur</a>


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
                <th>Nom</th>
                <th>E-mail</th>
                <th>Téléphone</th>
                <th>Mot de passe (haché)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ substr($user->password, 0, 10) }}</td> <!-- Afficher le mot de passe haché -->
                    <td>
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                    
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection

