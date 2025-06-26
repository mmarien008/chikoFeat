
@extends("leyout.base")

@section("content")
<div class="pagetitle">
  <div class="row">
    <div class="col">
      <h1>Mes biens</h1>
    </div>
    <div class="col">
      <a href="{{route("loyer.create")}}">
        <div class="btn btn-primary">Ajouter un loyer</div>
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
                            <select class="form-select" id="type_immeuble" aria-label="Default select example">
                     
                                <option

                                value="1">Immeuble</option>
                                <option
                               
                                
                                value="2">Galerie</option>
                            </select>
                        </div>

                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="nom_immeuble"  aria-label="Default select example">
                                <option >Nom de bien</option>
                             
                            </select>
                        </div>

                        <div class="col d-flex justify-content-center align-items-center">
                            <input class="form-control" id="dates" name="dates" type="month">
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
                <h5 class="card-title"> Statistiques</span></h5>

                <div class="row">

                    
                </div>

                <table class="table table-hover" id="mon_tableau">
                  <thead>
                    <tr>
                    
                      <th scope="col">Numero apparts/nom</th>
                      <th scope="col">Occupant</th>
                      <th scope="col">Montant payé</th>
                      <th scope="col">Observation</th>
                      <th scope="col">date de payement</th>
                    
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

      <!-- Right side columns -->
 

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
    function fetchData(type_immeuble) {
        // Requête AJAX
        $.ajax({
            url: "{{ route('loyer.show', ['type' => ':id']) }}".replace(':id', type_immeuble), // URL de la route avec le paramètre
            type: "GET", // Méthode HTTP
            success: function (response) {
                // Cible le deuxième combo
                var secondSelect = $('#nom_immeuble');
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
    function fetchDataNomType(type, id_nom_type,dates) {

      var a="{{ route('loyer.showdetaille', ['type' => ':type', 'nom' => ':nom','date'=> ':date']) }}"
            .replace(':type', type).replace(':nom', id_nom_type).replace(':date', dates);

  


    // Requête AJAX
    $.ajax({
        url: a, // URL de la route avec les paramètres
        type: "GET", // Méthode HTTP
        success: function (response) {
            // Cible le tableau
            var tableBody = $('#mon_tableau tbody');
            // Vider les anciennes lignes
            tableBody.empty();

            // Parcours des données reçues
            $.each(response.input, function (index, item) {
              var status="";
              var date="";
              var montant="";


              if(item.statut_loyer==1){
                status=`<span class="badge text-bg-success"> payé</span> `
              }else if(item.statut_loyer==0){
                status=`<span class="badge text-bg-danger">non payé</span>`
              }
              else if(item.statut_loyer==-1){
                status=`<span class="badge text-bg-warning">une partie</span>`
              }

              if(item.date === null){
                date=` `
              }else {
                date=item.date
              }

              if(item.montant === null){
                montant=` `
              }else {
                montant=item.montant+"$ sur "+item.loyer+"$"
              }

                var newRow = `
                    <tr>
                        <td>${item.numero}</td>
                        <td>${ item.nom} ${ item.post_nom} ${ item.prenom}</td>
                         <td>${montant}  </td>
                        <td>${status} </td>
                        <td>${ date}</td>
                       
                    </tr>
                `;
                // Ajouter la ligne au tableau
                tableBody.append(newRow);
                        
                   

                    
            });
        },
        error: function (xhr, status, error) {
            console.error('Erreur :', error);
        }
    });
}


    // Événement "change" sur le premier sélecteur
    $('#type_immeuble').change(function () {
        var selectedValue = $(this).val();
        fetchData(selectedValue); // Appelle la fonction fetchData avec la valeur sélectionnée
    });

    $('#nom_immeuble').change(function () {
     // Appelle la fonction fetchData avec la valeur sélectionnée
    });

    // Appel initial au chargement de la page
    var initialValue = $('#type_immeuble').val(); // Récupère la valeur initiale du sélecteur
    if (initialValue) {
        fetchData(initialValue); // Appelle la fonction fetchData si une valeur est sélectionnée
    }

    $('#dates').on('change', function () {

      let selectedDate = $(this).val();

      
      var selectedValue2 = $('#type_immeuble').val();
        var selectedValue = $('#nom_immeuble').val();
        fetchDataNomType(selectedValue2, selectedValue,selectedDate); 
    });
});

      </script>
@endsection


