



<table class="table table-striped">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Montant</th>
      <th scope="col">Motif</th>
      <th scope="col">Date</th>

    </tr>
  </thead>
  <tbody>
    <!-- Exemple de données statiques -->
    
@foreach ($revenu_externes as $revenu_externe)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{$revenu_externe->montant}} $</td>
      <td>{{$revenu_externe->motif}}</td>
      <td>{{ \Carbon\Carbon::parse($revenu_externe->date)->format('d/m/Y') }}</td>
      
    </tr>
         @endforeach
   
  </tbody>
</table>




