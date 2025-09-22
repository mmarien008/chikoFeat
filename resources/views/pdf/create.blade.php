
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

                        <div class="col-12 col-md-4 mb-3 d-flex justify-content-center align-items-center">
                            <select class="form-select" id="type_immeuble" aria-label="Default select example">
                               
                                <option value="1">Immeuble</option>
                                <option value="2">Galerie</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-4 mb-3  d-flex justify-content-center align-items-center">
                            <select class="form-select" id="nom_immeuble"  aria-label="Default select example">
                                
                            </select>
                        </div>

                        <div  class="col-12 col-md-4 mb-3  d-flex justify-content-center align-items-center">
                            <input class="form-control" type="month" id="date" name="dates">
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-md-6 mb-3  d-flex justify-content-center align-items-center">
                            <select class="form-select" id="type_rapport"  aria-label="Default select example">
                                <option >Type de rapport</option>
                             
                            </select>
                        </div>

                        <div class="col-12  mb-3   col-md-6">
                          
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
        var secondSelect = $('#nom_immeuble');

        $.ajax({
            url: "{{ route('pdf.show', ['type' => ':id']) }}".replace(':id', type_immeuble),
            type: "GET",
            success: function (response) {
                secondSelect.empty();
                secondSelect.append(new Option('-- Sélectionner --', ''));

                $.each(response.input, function (index, item) {
                    if (response.message == "immeuble") {
                        secondSelect.append(new Option(item.nom_immeuble, item.id));
                    } else if (response.message == "galerie") {
                        secondSelect.append(new Option(item.nom_galerie, item.id));
                    }
                });

                // Sélection automatique du premier élément et afficher le tableau
                if (response.input.length > 0) {
                    secondSelect.val(response.input[0].id);

                    // Date par défaut = mois courant si pas encore choisi
                    let dateDefault = $('#date').val();
                    if (!dateDefault) {
                        const today = new Date();
                        const month = String(today.getMonth() + 1).padStart(2, '0');
                        const year = today.getFullYear();
                        dateDefault = `${year}-${month}`;
                        $('#date').val(dateDefault);
                    }

                    // Mettre à jour le titre
                    const valeur_externe_type = $('#type_immeuble option:selected').text();
                    const valeur_externe_nom = $('#nom_immeuble option:selected').text();
                    $('#titre_loyer').html(`Rapport loyer mois de ${dateDefault} :: ${valeur_externe_type}_ ${valeur_externe_nom}`);

                    fetchDataNomType(type_immeuble, response.input[0].id, dateDefault);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur :', error);
            }
        });
    }

    // Même fetchDataNomType que ton code
    function fetchDataNomType(type, id_nom_type, dates) {
        var url = "{{ route('pdf.genererRapportLoyerMois', ['type' => ':type', 'nom' => ':nom','dates' => ':dates']) }}"
                    .replace(':type', type)
                    .replace(':nom', id_nom_type)
                    .replace(':dates', dates);

        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                var tableBody = $('#mon_tableau tbody');
                tableBody.empty();

                $.each(response.input, function (index, item) {
                    var status = "";
                    var date_fin = item.date_fin ? `<span class="badge text-bg-danger"> a liberé le ${item.date_fin}</span>` : "";
                    var observation = "";
                    if (response.dif[index].length > 0) {
                        observation = "NP " + response.dif[index].join(",") + ",";
                    }

                    if (item.statut_loyer == 1) status = `<span class="badge text-bg-success"> payé</span>`;
                    else if (item.statut_loyer == 0) status = `<span class="badge text-bg-danger">non payé</span>`;
                    else if (item.statut_loyer == -1) {
                        var a = "{{ route('loyer.completerLoyer', ['id_propriete' => ':id_propriete', 'id_bien' => ':id_bien', 'mois' => ':mois']) }}"
                                .replace(':id_propriete', item.id)
                                .replace(':id_bien', type)
                                .replace(':mois', dates);
                        status = `<span class="badge text-bg-warning">Avance</span>
                                  <a href="${a}"><span class="badge text-bg-danger">Completez</span></a>`;
                    }

                    var montant = item.montant ? `${item.montant}$ sur ${item.loyer}$` : "";

                    var newRow = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nom} ${item.post_nom} ${item.prenom}</td>
                            <td>${item.numero}</td>
                            <td>${item.montant_initiale}$</td>
                            <td>${item.montant_ajouter}$</td>
                            <td>${item.montant_retirer}$</td>
                            <td>${item.solde_garantie}$</td>
                            <td>${montant}</td>
                            <td>${status}</td>
                            <td>${observation} ${date_fin}</td>
                            <td>${item.date || ''}</td>
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

    // Changement type immeuble
    $('#type_immeuble').change(function () {
        fetchData($(this).val());
    });

    // Changement date
    $('#date').change(function () {
        let selectedDate = $(this).val();
        const typeVal = $('#type_immeuble').val();
        const nomVal = $('#nom_immeuble').val();
        const valeur_externe_type = $('#type_immeuble option:selected').text();
        const valeur_externe_nom = $('#nom_immeuble option:selected').text();
        $('#titre_loyer').html(`Rapport loyer mois de ${selectedDate} :: ${valeur_externe_type}_ ${valeur_externe_nom}`);
        fetchDataNomType(typeVal, nomVal, selectedDate);
    });

    // Appel initial
    fetchData($('#type_immeuble').val());
});

</script>
@endsection


