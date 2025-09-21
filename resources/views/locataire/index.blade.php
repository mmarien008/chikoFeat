
@extends("leyout.base")

@section("content")
<div class="pagetitle">
  <div class="row">
    <div class="col">
      <h1>Mes biens</h1>
    </div>
    <div class="col">
      <a href="{{route("locataire.create")}}">
        <div class="btn btn-primary">Ajouter un locataire</div>
      </a>
      
    </div>
  </div>
    
 
</div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Type de biens</span></h5>
    
                    <div class="row">

                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="type" aria-label="Default select example">
                                
                                <option  value="1" >Immeuble</option>

                                  <option 
                                value="2" >Galerie</option>
                            </select>
                        </div>

                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="nom_type" aria-label="Default select example">
                                <option >-- Sélectionner --</option>

                              
                            </select>
                        </div>

                       
                        
                    </div>
            </div>

        </div>

      <div class="col-lg-12">
        <div class="row">

          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title"> </span></h5>

                <div class="row">

                    
                </div>

                <table class="table table-hover" id ="mon_tableau">
                  <thead>
                    <tr>
                    
                      <th scope="col">Nom du locataire</th>
                      <th scope="col">Numero ou nom </th>
                      <th scope="col">Loyer fixé à</th>
                      <th scope="col">Garantie fixée à</th>
                      <th scope="col">Date d'entrée</th>
                      <th scope="col"> Date de fin contrat  </th>
                      <th scope="col">  Action  </th>
                      
                    </tr>
                  </thead>

                  <tbody>
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->

          

        </div>
      </div><!-- End Left side columns -->

  
 

    </div>
  </section>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
$(document).ready(function () {
    // Configuration CSRF pour les requêtes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function fetchData(selectedValue) {
    var secondSelect = $('#nom_type');
    $.ajax({
        url: "{{ route('locataire.show', ['type' => ':type']) }}".replace(':type', selectedValue),
        type: "GET",
        success: function (response) {
            // Vider et remplir le deuxième select
            secondSelect.empty();
            secondSelect.append(new Option('-- Sélectionner --', ''));

            // Remplir avec les éléments reçus
            $.each(response.input, function (index, item) {
                if (response.message == "immeuble") {
                    secondSelect.append(new Option(item.nom_immeuble, item.id));
                } else if (response.message == "galerie") {
                    secondSelect.append(new Option(item.nom_galerie, item.id));
                }
            });

            // Sélection automatique du premier élément
            if (response.input.length > 0) {
                secondSelect.val(response.input[0].id).trigger('change'); // prend le premier élément
            }
        },
        error: function (xhr, status, error) {
            console.error('Erreur :', error);
        }
    });
}


    function fetchDataNomType(id_type, id_nom_type) {
        $.ajax({
            url: "{{ route('locataire.showdetaille', ['type' => ':type', 'id_nom' => ':id_nom']) }}"
                .replace(':type', id_type).replace(':id_nom', id_nom_type),
            type: "GET",
            success: function (response) {
                var tableBody = $('#mon_tableau tbody');
                tableBody.empty();
                $.each(response.input, function (index, item) {
                    var date_fin = item.date_fin ?? "en cours";
                    var routeResilier = "";
                    if (!item.date_fin) {
                        routeResilier = `{{ route('contrat.resilier', ['id_locataire' => '__ID_LOCATAIRE__', 'id_bien' => '__ID_BIEN__', 'id_type_bien' => '__ID_TYPE_BIEN__']) }}`
                            .replace('__ID_LOCATAIRE__', item.id_locataire)
                            .replace('__ID_BIEN__', item.id_bien)
                            .replace('__ID_TYPE_BIEN__', id_type);
                        routeResilier = `<a style="color:red" href="${routeResilier}">fin contrat</a>`;
                    }

                    var newRow = `
                        <tr>
                            <td>${item.nom} ${item.post_nom} ${item.prenom}</td>
                            <td>${item.numero}</td>
                            <td>${item.loyer} $</td>
                            <td>${item.garantie} $</td>
                            <td>${item.date_debut}</td>
                            <td>${date_fin}</td>
                            <td>${routeResilier}</td>
                        </tr>
                    `;
                    tableBody.append(newRow);
                });
            },
            error: function (xhr, status, error) {
                console.error('Erreur :', error);
            }
        });
    }

    // Événements change
    $('#type').change(function () {
        var selectedValue = $(this).val();
        fetchData(selectedValue);
    });

    $('#nom_type').change(function () {
        var id_type = $('#type').val();
        var id_nom_type = $(this).val();
        fetchDataNomType(id_type, id_nom_type);
    });

    // Sélection par défaut au chargement
    var initialType = $('#type').val();
    if (initialType) {
        fetchData(initialType); // Cela sélectionne le premier nom_type et affiche le tableau
    }
});



















  
  </script>
@endsection


