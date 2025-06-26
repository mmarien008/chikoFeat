

@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Mes biens</h1>
    <nav>
   
    </nav>
</div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
          <form action="{{route('locataire.save') }}" method="post">
            @csrf
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                  <h5 class="card-title">Ajouter un locataire non reconnu</span></h5>
  
                  <div class="row mt-3">

                      <div class="col d-flex justify-content-center align-items-center">
                          <input type="text" id="inputPassword6" required name="nom"  class="form-control " 
                          aria-describedby="passwordHelpInline" placeholder="Nom du locataire">
                      </div>
                      <div class="col d-flex justify-content-center align-items-center">
                          <input type="text" id="inputPassword6" required name="post_nom" class="form-control " 
                          aria-describedby="passwordHelpInline" placeholder="PostNom du locataire">
                      </div>

                      <div class="col d-flex justify-content-center align-items-center">
                          <input type="text" id="inputPassword6" required name="prenom" class="form-control " 
                          aria-describedby="passwordHelpInline" placeholder="Prenom">
                      </div>


                  </div> 
                  <div class="row mt-3 ">
                      <div class="col-4 d-flex justify-content-center align-items-center">
                          <input type="text" id="inputPassword6" required name="numero" class="form-control " 
                          aria-describedby="passwordHelpInline" placeholder="Numero de téléphone">
                      </div>

                      <div class="col-4 d-flex justify-content-center align-items-center">
                          <button type="submit" class="btn btn-primary">Ajouter un locataire</button>
                      </div>


                  </div>
          </div>


          </form>
           

        </div>



        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Choix de biens</span></h5>
    
                    <div class="row mt-3">

                
                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="select_type" aria-label="Default select example">
                             
                                <option 
                                    value="1" 
                                   
                                >Immeuble</option>

                                <option 
                                    value="2" 
                                   
                                >Galerie</option>
                                
                            </select>
                        </div>
                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="select_bien" aria-label="Default select example">
                                <option >Nom du bien</option>
                              

                            </select>
                        </div>

                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="locataire" aria-label="Default select example">
                               

                                @if (isset($locataires))
                                  @foreach ($locataires as $locataire )
                                  <option value= {{ $locataire->id }}> {{ $locataire->nom }} {{ $locataire->post_nom }}
                                     {{ $locataire->prenom }}</option>
                                  @endforeach
                                @elseif((isset($proprietes)))
                                  @foreach ($proprietes["locataires"] as $locataire )
                                  <option value= {{ $locataire->id }}> {{ $locataire->nom }} {{ $locataire->post_nom }}
                                     {{ $locataire->prenom }}</option>
                                  @endforeach

                                @endif

                
                           
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
                <h5 class="card-title"> </span></h5>

                <div class="row">

                    
                </div>

                <table class="table table-hover " id="mon_tableau">
                  <thead>
                    <tr>
                    
                      <th scope="col">Numero apparts/Nom</th>
                      <th scope="col">Statut </th>
                      <th scope="col">Ajouter un locataire</th>
                    
                    </tr>
                  </thead>

                  <tbody>

                    <tr>
                      @if ( isset($proprietes["appartements"]))

                        @foreach ($proprietes["appartements"] as $apparts )
                        <tr>
                          <td> {{ $apparts->numero}}</td>
                          <td><span class="badge text-bg-success">libre</span></td>
                          <td><div class="form-check valide" >
                            <input type="text" value="{{ $apparts->id}}" style="display: none;">
                            <input class="form-check-input" id="validation" type="checkbox" value="" >
                         
                          </div>
                        </td>

                        </tr>
                          
                        @endforeach
                        @elseif (isset($proprietes["autre_biens"]))
                        @foreach ($proprietes["autre_biens"] as $autre )
                        <tr>
                          <td> {{ $autre->nom}}</td>
                          <td><span class="badge text-bg-success">libre</span></td>
                          <td><div class="form-check valide">
                            <input type="text" value="{{ $autre->id}}" style="display: none;">
                            <input class="form-check-input" type="checkbox" value="" >
                            
                          </div>
                        </td>

                        </tr>
                          
                        @endforeach
                      @endif
                    </tr>
                
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
 

function checbox(valide,select_type,select_bien,locataire) {

 
    if (valide && valide.length > 0) {
        // Boucle sur tous les éléments avec la classe "valide"
        Array.from(valide).forEach((valideElement, index) => {
            valideElement.addEventListener('click', function () {
                const firstChild = valideElement.firstElementChild; // Récupérer le premier enfant de cet élément spécifique

                if (firstChild && locataire) {
                    const valueType = select_type ? select_type.value : null; // Vérifie si select_type est défini
                    const selectedValue = select_bien ? select_bien.value : null; // Vérifie si select_bien est défini

                    if (valueType && selectedValue) {
                        const locataireUrl1 = "{{ route('contrat.create', ['id_type_bien' => ':id', 'nom_bien' => ':nom_propriete', 'bien' => ':bien', 'locataire' => ':locataire']) }}"
                            .replace(':id', valueType)
                            .replace(':nom_propriete', selectedValue)
                            .replace(':bien', firstChild.value)
                            .replace(':locataire', locataire.value);

                        window.location.href = locataireUrl1;
                    } else {
                        alert("Veuillez d'abord sélectionner un type de bien et un bien.");
                    }
                } else {
                    alert("Locataire ou premier enfant manquant pour l'élément à l'index " + index + ".");
                }
            });
        });
    } else {
        console.error("Élément 'valide[0]' introuvable ou invalide.");
    }


  
}
    






$(document).ready(function () {

 

    // Configuration CSRF pour les requêtes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function fetchData(select_type) {

      var a="{{ route('propriete.show', ['id' => ':id']) }}".replace(':id', select_type);
   
        // Requête AJAX
        $.ajax({
            url: a, // URL de la route avec le paramètre
            type: "GET", // Méthode HTTP
            success: function (response) {
                // Cible le deuxième combo
                var secondSelect = $('#select_bien');
           
                secondSelect.empty();
                
                secondSelect.append(new Option('-- Sélectionner --', ''));

                $.each(response.input, function (index, item) {
                    if (response.message == "immeuble") {
                        secondSelect.append(new Option(item.nom_immeuble, item.id));
                    } else if (response.message == "galerie") {
                        secondSelect.append(new Option(item.nom_galerie, item.id));
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Erreur :', error);
            }
        });
    }

    // Fonction pour effectuer la requête AJAX
    function fetchDataNomType(select_type, select_bien) {
    
      var a="{{ route('propriete.show_detaille', ['id' => ':id', 'nom_propriete' => ':nom_propriete']) }}"
            .replace(':id', select_type).replace(':nom_propriete', select_bien);

   
    $.ajax({
        url: a, // URL de la route avec les paramètres
        type: "GET", // Méthode HTTP
        success: function (response) {
          


            var tableBody = $('#mon_tableau tbody');
     
            tableBody.empty();
        

            // Parcours des données reçues
            $.each(response.input, function (index, item) {
              
              
              
              if (response.message == "immeuble") {
                
                var newRow = `
                    <tr>
                     
                        <td> ${item.numero} </td>
                        <td><span class="badge text-bg-success">libre</span></td>
                          <td> 
                              <div class="form-check valide">
                              <input type="text" value="${ item.id}" style="display: none;">
                              <input class="form-check-input" type="checkbox" value="" >
                              </div>
                          </td>
                        
                       
                    </tr>
                `;
                // Ajouter la ligne au tableau
                tableBody.append(newRow);
                        
                    } else if (response.message == "galerie") {

                  
                    

                      var newRow = `
                    <tr>
                        <td>${item.nom} </td>

                        <td><span class="badge text-bg-success">libre</span></td>
                         <td> 
                              <div class="form-check valide">
                              <input type="text" value="${ item.id}" style="display: none;">
                              <input class="form-check-input" type="checkbox" value="" >
                              
                              </div>
                          </td>
                      
                       
                    </tr>
                `;
                // Ajouter la ligne au tableau
                tableBody.append(newRow);
                       
                    }
            });
            const select_type = document.getElementById("select_type");
            const select_bien = document.getElementById("select_bien");
            const locataire = document.getElementById("locataire");
            const valide = document.getElementsByClassName("valide");
            if(valide){
                checbox(valide,select_type,select_bien,locataire);
            }

        

        },
        error: function (xhr, status, error) {
            console.error('Erreur :', error);
        }
    });
}


    // Événement "change" sur le premier sélecteur
    $('#select_type').change(function () {
        var selectedValue = $(this).val();
        fetchData(selectedValue); // Appelle la fonction fetchData avec la valeur sélectionnée
    });



    $('#select_bien').change(function () {
      var selectedValue2 = $('#select_type').val();
        var selectedValue = $(this).val();

        fetchDataNomType(selectedValue2, selectedValue); // Appelle la fonction fetchData avec la valeur sélectionnée
    });


    // Appel initial au chargement de la page
    
    var initialValue = $('#select_type').val(); // Récupère la valeur initiale du sélecteur
    if (initialValue) {
        fetchData(initialValue); // Appelle la fonction fetchData si une valeur est sélectionnée
    }
});



 </script>
@endsection


