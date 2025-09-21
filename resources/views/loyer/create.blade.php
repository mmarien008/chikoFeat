
@extends("leyout.base")

@section("content")

@if(session('success'))
    <div class="alert alert-danger">
        {{ session('success') }}
    </div>
@endif
<div class="pagetitle">
    <h1>Payer un loyer</h1>


</div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Nom du locataire</span></h5>
    
                    <div class="row">

                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="locataire" aria-label="Default select example">
                                <option >Nom du locataire</option>
                                @foreach ($mes_biens["locataires"] as $locataire )
                                <option 
                             value="{{$locataire->id}}" >{{$locataire->nom}} {{$locataire->post_nom}} {{$locataire->prenom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>

        </div>

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title">Mes biens</span></h5>

                <div class="row">

                    
                </div>

                <table class="table table-hover">
                  <thead>
                    <tr>
                    
                      <th scope="col">Type de propriété</th>
                      <th scope="col">Déscription</th>
                      <th scope="col">Date d'entrée</th>
                      <th scope="col">Loyer</th>
                      <th scope="col">Garantie</th>
                  
                    
                    </tr>
                  </thead>

                  <tbody>

                
                  @if (isset($mes_biens["pour_immeubles"]) and !empty($mes_biens["pour_immeubles"]))
                  
                  @foreach ( $mes_biens["pour_immeubles"] as $propriete )
                  <tr>  <td><strong> Immeuble</strong>: {{$propriete->nom_immeuble }}</td>
                    <td> <strong>Appartement:</strong> :{{$propriete->numero}}</td>
                    <td> <strong></strong> {{$propriete->date_debut}}</td>

                    <td> <span class="badge text-bg-danger"><a style="text-decoration: none; color:aliceblue" href="{{route("loyer.payer",["nom_locataire"=>$propriete->id_locataire,
                    "type_bien"=>$propriete->id_immeuble,"numero"=>$propriete->id_appartement,"type"=>"1" ])}}">Payer</a></span></td>

                    <td> <span class="badge text-bg-danger"><a style="text-decoration: none; color:aliceblue" href="{{route("garantie.show",["id_locataire"=>$propriete->id_locataire,
                    "id_type_bien"=>$propriete->id_immeuble,"id_bien"=>$propriete->id_appartement,"type"=>"1" ])}}">Ajout ou retrait</a></span></td>
            
                  </tr>
                  @endforeach
                  @endif


                  

                  @if (isset($mes_biens["pour_galerie"]) and !empty($mes_biens["pour_galerie"]))
                  
                  @foreach ( $mes_biens["pour_galerie"] as $propriete )
                  <tr>  <td> <strong> Galerie </strong>: {{$propriete->nom_galerie }}</td>
                    <td> <strong>nom:</strong> {{$propriete->numero}}</td> 
                    <td> <strong></strong> {{$propriete->date_debut}}</td> 
                    <td> <span class="badge "><span class="badge text-bg-danger"><a href="{{route("loyer.payer",["nom_locataire"=>$propriete->id_locataire,
                    "type_bien"=>$propriete->id_galerie,"numero"=>$propriete->id_autre_bien,"type"=>"2" ])}}">Payer</a></span></td>

                    <td> <span class="badge text-bg-danger"><span class="badge text-bg-danger"><a href="{{route("garantie.show",["id_locataire"=>$propriete->id_locataire,
                    "id_type_bien"=>$propriete->id_galerie,"id_bien"=>$propriete->id_autre_bien,"type"=>"2" ])}}">Ajout ou retrait</a></span></td>
                    
                  


                  
                  </tr>
                  @endforeach
                  @endif

                 
    
                  

                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->

          

        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
 

    </div>
  </section>
  <script>

const locataire = document.getElementById("locataire");

    if (locataire) {
        // Événement pour le changement de type
        locataire.addEventListener('change', function () {
            const valueType = locataire.value;
            const locataireUrl = "{{ route('loyer.showLocation', ['id_locataire' => ':id']) }}".replace(':id', valueType);
            window.location.href = locataireUrl;
        });
    }


  </script>
@endsection


