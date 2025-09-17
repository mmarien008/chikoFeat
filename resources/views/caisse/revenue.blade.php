
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
    <tr>
      <th scope="row">1</th>
      <td>1500</td>
      <td>Paiement consultation</td>
      <td>2025-09-17</td>
      <td>
        <button class="btn btn-sm btn-warning">Modifier</button>
        <button class="btn btn-sm btn-danger">Supprimer</button>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>2500</td>
      <td>Service externe</td>
      <td>2025-09-16</td>
      <td>
        <button class="btn btn-sm btn-warning">Modifier</button>
        <button class="btn btn-sm btn-danger">Supprimer</button>
      </td>
    </tr>
  </tbody>
</table>





@endsection


