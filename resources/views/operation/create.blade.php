
@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Ajouter une operation </h1>
     
</div><!-- End Page Title -->

<div class="row my-3">
  <a href="{{route("operation.index")}}">

    <div class="col"> <div class="btn btn-primary">Voir les demandes</div></div>
  
  </a>
 

</div>

  <section class="section dashboard">

    <form action="{{route('operation.save')}}" method="post">
    <div class="row " >
      @csrf

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body mt-3">
                  <div class="row">

                    <div class="col-12 mt-3">
                    <select class="form-select" name="type_propriete" id="type_propriete" aria-label="Default select example"> 
                      <option value="-1" >Séléctionner le type de propriété</option>
                        <option value="1">Immeuble</option>
                        <option value="2">Galerie</option>
                    </select>
                    </div>

                    <div class="col-12 mt-3">
                      <div class="col-12 mt-3">
                        <select class="form-select" name="nom_propriete" id="nom_propriete" aria-label="Default select example"> 
                        </select>
                      </div>
                    </div>

                    <div class="col-12 mt-3">
                      <div class="col-12 mt-3">
                        <select class="form-select" name="contenue" id="contenue" aria-label="Default select example"> 
                        </select>
                      </div>
                    </div>

                
                    <div class="col-12 mt-3">
                      <div class="row">
                        <div class="col">
                          <input type="number" class="form-control" required  name="montant" id="exampleFormControlInput1" placeholder="Entrez le montant en dollar">
                        </div>
                        <div class="col">
                          <select class="form-select" name="devise" id="devise" aria-label="Default select example"> 
                            <option value="">CDF</option>
                            <option value="">USD</option>
                          </select>

                        </div>
                    
                      </div>
                      
                    </div>
                  </div>
                   
        
                  <div class="row mt-3">
                    <div class="col">
                      <div class="mb-3">
                        <h5>Justification</h5>
                          <textarea  class="form-control" name="motif" id="exampleFormControlTextarea1" rows="3"> motif</textarea>
                      </div>
                    </div>
                   
                  </div>
                  <div class="row">
                    <div class="col">
                      <button class="btn btn-primary w-100" type="submit"> Envoyer une demande</button>

                    </div>
                  </div>
               
            </div>
        </div>

    </div>
  </section>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script >


  $(document).ready(function () {


function fetchData(select_type) {

  var a="{{ route('propriete.show', ['id' => ':id']) }}".replace(':id', select_type);

    // Requête AJAX
    $.ajax({
        url: a, // URL de la route avec le paramètre
        type: "GET", // Méthode HTTP
        success: function (response) {
         
            // Cible le deuxième combo
            var secondSelect = $('#nom_propriete');
       
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

      var secondSelect = $('#contenue');
       
      secondSelect.empty();
            
     
      $.each(response.input, function (index, item) {
              
              if (response.message == "immeuble") {
                  secondSelect.append(new Option("Appartement_"+item.numero, item.id));
              } else if (response.message == "galerie") {
                  secondSelect.append(new Option(""+item.nom, item.id));
              } 
          });


      

 
      
  

    

    },
    error: function (xhr, status, error) {
        console.error('Erreur :', error);
    }
});
}


// Événement "change" sur le premier sélecteur
$('#type_propriete').change(function () {

 
 

    var selectedValue = $(this).val();
    fetchData(selectedValue); // Appelle la fonction fetchData avec la valeur sélectionnée
});



$('#nom_propriete').change(function () {
  var selectedValue2 = $('#type_propriete').val();
    var selectedValue = $(this).val();

    fetchDataNomType(selectedValue2, selectedValue); // Appelle la fonction fetchData avec la valeur sélectionnée
});


// Appel initial au chargement de la page

var initialValue = $('#type_propriete').val(); // Récupère la valeur initiale du sélecteur
if (initialValue) {
    fetchData(initialValue); // Appelle la fonction fetchData si une valeur est sélectionnée
}
});





</script>
 
@endsection


