
@extends("leyout.base")

@section("content")
<div class="pagetitle">
  <div class="row">
    <div class="col">
      <h1>Imprimer le rapport </h1>
    </div>
    <div class="col">
      <a href="{{route("loyer.create")}}">
        <div class="btn btn-primary">Payer un loyer ou Garantie</div>
      </a>
      
    </div>
   
  </div>
</div><!-- End Page Title -->
<form action="" method="post">

  @csrf

  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Type de biens</span></h5>
    
                    <div class="row">

                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="type_immeuble" aria-label="Default select example">
                               
                                <option value="1">Immeuble</option>
                                <option value="2">Galerie</option>
                            </select>
                        </div>

                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="nom_immeuble"  aria-label="Default select example">
                                
                            </select>
                        </div>

                        <div  class="col d-flex justify-content-center align-items-center">
                            <input class="form-control" type="month" id="date" name="dates">
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col d-flex justify-content-center align-items-center">
                            <select class="form-select" id="type_rapport"  aria-label="Default select example">
                                <option >Type de rapport</option>
                             
                            </select>
                        </div>

                        <div class="col">
                          
                              <a href="{{route("pdf.telecharger")}}" class="btn btn-primary">Imprimer le rapport</a>
                        
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
                <h5 id="titre_loyer" class="card-title"> Rapport loyer </span></h5>

                <div class="row">

                    
                </div>

                <table class="table table-hover" id="mon_tableau">
                    <thead>
                      <tr>
                        <th scope="col">Num</th>

                      
                        <th scope="col">Occupant</th>
                        <th scope="col">Numero apparts/nom</th>
                        <th scope="col">Garantie recu</th>
                       
                        <th scope="col">ajout sur garantie</th>
                        <th scope="col">retait sur garantie</th>

                        <th scope="col">solde garantie</th>
                       
                        <th scope="col">Montant</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Observation</th>
                        <th scope="col">Date</th>
                       
                      
                      </tr>
                    </thead>
  
                    <tbody >
                    

  
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
</form>


      
 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function changeFormat(dateInput) {
   
                // Découper la chaîne en année et mois
                const [year, month] = dateInput.split('-');

                // Reformer la date au format souhaité (exemple : MM/YYYY)
                const formattedDate = `${month}-${year}`;

                // Afficher dans la console ou ailleurs

                return formattedDate
       
        }
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
            url: "{{ route('pdf.show', ['type' => ':id']) }}".replace(':id', type_immeuble), // URL de la route avec le paramètre
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
     

      var a="{{ route('pdf.genererRapportLoyerMois', ['type' => ':type', 'nom' => ':nom','dates' => ':dates']) }}"
            .replace(':type', type).replace(':nom', id_nom_type).replace(':dates', dates);


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
              var observation="";

         

              if(item.date_fin==null){

                
              var date_fin="";

              }else{

                var date_fin=`<span class="badge text-bg-danger"> a liberé le  ${item.date_fin} </span> `;

              }

             
              if (response.dif[index].length > 0) {
                response.dif[index].forEach(element => {
                    observation=observation+element+"," ;
                });

                observation="NP "+observation;
              } else {
                  }

                

              if(item.statut_loyer==1){
                status=`<span class="badge text-bg-success"> payé</span> `
              }else if(item.statut_loyer==0){
                status=`<span class="badge text-bg-danger">non payé</span>`
              }

              else if(item.statut_loyer==-1){
                var a="{{ route('loyer.completerLoyer', ['id_propriete' => ':id_propriete', 'id_bien' => ':id_bien', 'mois' => ':mois']) }}"
            .replace(':id_propriete', item.id).replace(':id_bien', type).replace(':mois', dates)

                status=`<span class="badge text-bg-warning ">Avance</span>
                
               <a href="${a}">   <span class="badge text-bg-danger ">Completez</span></a> 
                
                `
              }

              if(item.date === null){
                date=` `
              }else {
                date=item.date
              }

              if(item.montant === null){
                montant=` `
              }else {
                montant=item.montant+"$ sur "+item.loyer +"$";
              }

                var newRow = `
                    <tr>
                     
                      <td>${ index+1}</td>
                       <td>${ item.nom} ${ item.post_nom} ${ item.prenom}</td>
                        <td>${item.numero}</td>
                        <td>${item.montant_initiale}$ </td>
                         <td>${item.montant_ajouter}$ </td>
                          <td>${item.montant_retirer}$ </td>
                           <td>${item.solde_garantie}$ </td>
                       
                         <td>${montant}  </td>
                        <td>${status} </td>
                         <td> ${observation}${date_fin}    </td>

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

    $('#date').on('change', function () {

     

      let selectedDate = $(this).val();
      var titre_loyer=$('#titre_loyer');
      
      
      var selectedValue2 = $('#type_immeuble').val();
      var selectedValue = $('#nom_immeuble').val();

      var valeur_externe_type = $('#type_immeuble option:selected').text(); 
      var valeur_externe_nom = $('#nom_immeuble option:selected').text(); 

        titre_loyer.html(`Rapport loyer mois de ${selectedDate}  :: ${valeur_externe_type}_ ${valeur_externe_nom}   `);

        fetchDataNomType(selectedValue2, selectedValue,selectedDate); 
    });
});
</script>
@endsection


