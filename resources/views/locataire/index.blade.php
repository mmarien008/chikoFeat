
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
        // Requête AJAX
        $.ajax({
            url: "{{ route('locataire.show', ['type' => ':type']) }}".replace(':type', selectedValue), // URL de la route avec le paramètre
            type: "GET", // Méthode HTTP
            success: function (response) {
                // Cible le deuxième combo
                var secondSelect = $('#nom_type');

                // Vider les anciennes options
                secondSelect.empty();

                // Ajouter une option par défaut
                secondSelect.append(new Option('-- Sélectionner --', ''));

                // Parcours des données reçues
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
    function fetchDataNomType(id_type, id_nom_type) {

    // Requête AJAX
    $.ajax({
        url: "{{ route('locataire.showdetaille', ['type' => ':type', 'id_nom' => ':id_nom']) }}"
            .replace(':type', id_type).replace(':id_nom', id_nom_type), // URL de la route avec les paramètres
        type: "GET", // Méthode HTTP
        success: function (response) {
          var date_fin="";
          let routeResilier="";


            // Cible le tableau
            var tableBody = $('#mon_tableau tbody');

            // Vider les anciennes lignes
            tableBody.empty();

            // Parcours des données reçues
            $.each(response.input, function (index, item) {

              if(item.date_fin !=null){
                 date_fin=item.date_fin ;
                routeResilier="";

              }else{
                date_fin="en cours" ;
                routeResilier = `{{ route('contrat.resilier', ['id_locataire' => '__ID_LOCATAIRE__',
                'id_bien' => '__ID_BIEN__',  'id_type_bien' => '__ID_TYPE_BIEN__']) }}`;
                    routeResilier = routeResilier.replace('__ID_LOCATAIRE__', item.id_locataire)
                                                 .replace('__ID_BIEN__', item.id_bien)
                                                 .replace('__ID_TYPE_BIEN__',id_type );
                routeResilier=`<a style="color:red" href="${routeResilier}"> fin contrat</a>`;

              }


              if (response.message == "immeuble") {

                var newRow = `
                    <tr>
                        <td>${item.nom} ${item.post_nom} ${item.prenom}</td>
                        <td>${item.numero }</td>
                        <td>${item.loyer} $</td>
                        <td>${item.garantie } $</td>
                        <td>${item.date_debut }</td>
                          <td>${date_fin}</td>


                         <td>${routeResilier}</td>

                    </tr>
                `;
                // Ajouter la ligne au tableau
                tableBody.append(newRow);

                    } else if (response.message == "galerie") {

                      var newRow = `
                    <tr>
                        <td>${item.nom} ${item.post_nom} ${item.prenom}</td>

                        <td>${item.numero }</td>
                        <td>${item.loyer} $</td>
                        <td>${item.garantie } $</td>
                        <td>${item.date_debut }</td>
                         <td>${date_fin}</td>
                         <td><a href="${routeResilier}"> fin contrat</a></td>

                    </tr>
                `;
                // Ajouter la ligne au tableau
                tableBody.append(newRow);

                    }
            });
        },
        error: function (xhr, status, error) {
            console.error('Erreur :', error);
        }
    });
}


    // Événement "change" sur le premier sélecteur
    $('#type').change(function () {
        var selectedValue = $(this).val();
        fetchData(selectedValue); // Appelle la fonction fetchData avec la valeur sélectionnée
    });



    $('#nom_type').change(function () {
      var selectedValue2 = $('#type').val();
        var selectedValue = $(this).val();

        fetchDataNomType(selectedValue2, selectedValue); // Appelle la fonction fetchData avec la valeur sélectionnée
    });

    // Appel initial au chargement de la page
    var initialValue = $('#type').val(); // Récupère la valeur initiale du sélecteur
    if (initialValue) {
        fetchData(initialValue); // Appelle la fonction fetchData si une valeur est sélectionnée
    }
});



















  </script>
@endsection


