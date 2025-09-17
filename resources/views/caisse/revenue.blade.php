
@extends("leyout.base")

@section("content")
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalrevenue">
  Ajouter une revenue externe
</button>

<table class="table table-striped">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Montant</th>
      <th scope="col">Motif</th>
      <th scope="col">Date</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- Exemple de données statiques -->
    
@foreach ($revenu_externes as $revenu_externe)
    <tr>
      <th scope="row">1</th>
      <td>{{$revenu_externe->montant}}</td>
      <td>{{$revenu_externe->modif}}</td>
      <td>{{ \Carbon\Carbon::parse($revenu_externe->date)->format('d/m/Y') }}</td>

      <td>
        <button class="btn btn-sm btn-warning">Modifier</button>
        <button class="btn btn-sm btn-danger">Supprimer</button>
      </td>
    </tr>
         @endforeach
   
  </tbody>
</table>





@endsection


