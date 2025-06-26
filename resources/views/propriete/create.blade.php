
@extends("leyout.base")

@section("content")
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="pagetitle">
    <h1 id="teste">Ajouter une propriété</h1>
</div><!-- End Page Title -->


<form action="{{route('propriete.save') }}" method="post">
  @csrf

  <section class="section dashboard">
    

    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Type de biens</span></h5>
                    <div class="row">
                        <div class="col-12 mt-2 col-md-4 d-flex justify-content-center align-items-center">
                            <select class="form-select" id="bien" required name="type_bien" aria-label="Default select example">
                              <option >Choisir la propriété</option>
                              
                                <option value="1">Immeuble</option>
                                <option value="2">Galerie</option>
                              </select>
                        </div>

                        <div class="col-12 mt-2  col-md-4 d-flex justify-content-center align-items-center">
                            <input type="text" id="inputPassword6" required name="nom" class="form-control " 
                            aria-describedby="passwordHelpInline" placeholder="Entrer le nom du bien">
                        </div>

                        <div class="col-12 mt-2  col-md-4 d-flex justify-content-center align-items-center">
                            <input type="text" id="inputPassword6" required name="adresse" class="form-control " 
                            aria-describedby="passwordHelpInline" placeholder="Entrer l'adresse physique">
                        </div>
                        
                    </div>

                    <div class="row ">

                      <div class="col-12 mt-2 col-md-4 d-flex justify-content-center align-items-center">
                          <select class="form-select" required id="ville" name="ville" aria-label="Default select example">
                              <option value="" >Choisir la ville</option>
                                 <option value="Lubumbashi">Lubumbashi</option>
                              <option value="Kinshasa">Kinshasa</option>
                              <option value="Kananga">Mbujimayi</option>
                            </select>
                      </div>
                      <div class="col-12 mt-2 col-md-4 d-flex justify-content-center align-items-center">
                        <select class="form-select" required id="province" name="province" aria-label="Default select example">
                            <option value="" >Choisir la province</option>
                            
                            <option value="Kinshasa">Kinshasa</option>
                            <option value="katanga">katanga</option>
                             <option value="kasai">kasai</option>
                          </select>
                      </div>
                  </div>
            </div>
        </div>
      <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Recent Sales -->
            <div class="col-12" id="insertion" >

              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title" id="titre">Ajouter les appartements</span></h5>
                 
                 
                  <div id="personalisation">
                    
                  
                  </div>
              </div>

            </div><!-- End Recent Sales -->
          </div>
        </div><!-- End Left side columns -->

    </div>
  </section>
</form>

<script>
  function addGalerie(){
    const personnalisationDiv = document.getElementById("personalisation"); 
     const htmlContent = `
      <div class="row">
      <div class="col-12 col-md-4"> <input type="number" name="autre[]" class="form-control" placeholder="Nombre des magasins "></div>
      <div class="col-12 col-md-4"> <input type="number" name="autre[]" class="form-control" placeholder="Nombre des depots"></div>
      <div class="col-12 col-md-4"> <input type="number" name="autre[]" class="form-control" placeholder="Nombre des etalages"></div>
    </div>
     `
     personnalisationDiv.innerHTML = htmlContent;
   
  }
  function addHTMLToPersonalisation() {
    const personnalisationDiv = document.getElementById("personalisation"); // Div cible

    // Contenu HTML à ajouter
    const htmlContent = `
        <div class="row">
            <div class="col-auto">
                <label for="inputPassword6" id="nombreElement" class="col-form-label">Nombre des niveau</label>
            </div>
            <div class="col-auto">
                <input type="number" id="nombreNiveau" class="form-control" aria-describedby="passwordHelpInline">
            </div>
        </div>
        <table class="table table-hover" style="overflow-y: scroll;">
            <thead>
                <tr id="entete">
                    <th scope="col">Numero apparts</th>
                    <th scope="col">Supprimer</th>
                    <th scope="col">Ajouter</th>
                </tr>
            </thead>
            <tbody id="appart">
            </tbody>
        </table>
    `;

    // Ajouter le contenu dans le div avec l'id personnalisation
    personnalisationDiv.innerHTML = htmlContent;
}

function generateLevelsAndRows(nombreNiveau, appart, trbtn, alpha) {
    // Réinitialiser le tableau avant d'ajouter de nouvelles données
    while (appart.firstChild) {
        appart.removeChild(appart.firstChild);
    }

    for (let k = 0; k < nombreNiveau; k++) {
        // Création de la ligne de séparation
        const sep = document.createElement('tr');
        const sepEl = document.createElement('td');
        sepEl.innerHTML = "Niveau " + (k + 1);
        sepEl.classList.add('text-center');
        sepEl.setAttribute('colspan', '3'); // Fusionne les 3 colonnes
        sep.appendChild(sepEl);

        // Ajouter la ligne de séparation au tableau
        appart.appendChild(sep);

        // Boucle pour créer des lignes de données
        for (let i = 0; i < 3; i++) {
            const newRow = document.createElement('tr');

            // Première colonne avec un champ de saisie
            const inputCell = document.createElement('td');
            const inputField = document.createElement('input');
           
            inputField.type = "text";
            inputField.setAttribute('name', 'appart[]');
            inputField.classList.add('form-control'); // Style Bootstrap
            inputField.value = `${alpha[k]}${i + 1}`;
            inputCell.appendChild(inputField);
            newRow.appendChild(inputCell);

            // Deuxième colonne avec une icône Bootstrap
            const iconCell = document.createElement('td');
            const trashIcon = document.createElement('i');
            trashIcon.classList.add('bi', 'bi-trash', 'sup');
            trashIcon.style.color = "green"; // Couleur facultative
            iconCell.appendChild(trashIcon);
            newRow.appendChild(iconCell);

            // Troisième colonne avec une autre icône Bootstrap
            const textCell = document.createElement('td');
            const plusIcon = document.createElement('i');
            plusIcon.classList.add('bi', 'bi-patch-plus', 'modif');
            plusIcon.style.color = "green"; // Couleur facultative
            textCell.appendChild(plusIcon);
            newRow.appendChild(textCell);

            // Ajouter la ligne au tableau
            appart.appendChild(newRow);
        }
    }

    // Ajouter le bouton "Valider" à la fin
    appart.appendChild(trbtn);
}

  function removeRow(clickedIcon) {
    // Supprime la ligne parente de l'icône cliquée
    const currentRow = clickedIcon.closest("tr");
    if (currentRow) {
        currentRow.remove();
    }
}


  function addRowAfter(clickedIcon) {
    // Trouver la ligne parente de l'icône cliquée
    const currentRow = clickedIcon.closest("tr");
  
    // Créer une nouvelle ligne
    const newRow = document.createElement("tr");
  
    // Ajouter des cellules dans la nouvelle ligne
    for (let i = 0; i < 4; i++) {
      const newCell = document.createElement("td");
      if (i === 0) {
        // Ajouter un champ input dans la première cellule
        const inputField = document.createElement("input");
        inputField.type = "text";
        inputField.classList.add("form-control");
        inputField.classList.add('w-25'); 
        inputField.setAttribute('name', 'appart[]'); // Style Bootstrap
        inputField.placeholder = "Nouvel appart";
        newCell.appendChild(inputField);

      } else if (i === 1) {
        const icon = document.createElement("i");
        icon.classList.add("bi", "bi-trash", "modif");
        icon.style.color = "green";
        newCell.appendChild(icon);
        // Réattacher un événement à la nouvelle icône
        icon.addEventListener("click", function () {
          
          removeRow(icon); // Ajouter une nouvelle ligne au clic
        });
      } else {
        // Ajouter une cellule vide ou un texte
        
      }
      newRow.appendChild(newCell);
    }
    // Insérer la nouvelle ligne juste après la ligne actuelle
    currentRow.insertAdjacentElement("afterend", newRow);

  }
  var alpha=["A","B","C","D","E","F","G","H"]

  var appart= document.getElementById("appart");

  const trbtn= document.createElement('tr');
  const buttonCell = document.createElement('td');
  var bien= document.getElementById("bien");
  var titre= document.getElementById("titre");
  var insertion=document.getElementById("insertion");
  var nombreElement=document.getElementById("nombreElement");




  if (bien) {
    bien.addEventListener('change', function() {
        const selectedValue = bien.value;

        if (selectedValue == 1) {
          addHTMLToPersonalisation();
          var nombreNiveau= document.getElementById("nombreNiveau");
          var appart= document.getElementById("appart");
          
          nombreNiveau.addEventListener("input",function (params) {
            while (appart.firstChild) {
                appart.removeChild(appart.firstChild);}
            generateLevelsAndRows(nombreNiveau.value, appart, trbtn, alpha);
            

            const modifIcons = document.getElementsByClassName("modif");
            const sub = document.getElementsByClassName("sup");
            Array.from(modifIcons).forEach((icon, index) => {
                icon.addEventListener("click", function () {
                
                  addRowAfter(icon);
                });
            });
            Array.from(sub).forEach((icon, index) => {
                icon.addEventListener("click", function () {
                  removeRow(icon)
                });
                
            });
            titre.innerHTML = "Ajouter mes appartements";
            nombreElement.innerHTML = "Nombre des niveau";
      
          });

          const personnalisationDiv = document.getElementById("personalisation");
          const validateButton = document.createElement('button');
          validateButton.textContent = "Ajouter"; // Texte du bouton
          validateButton.classList.add('btn', 'btn-success');
          validateButton.setAttribute('type', 'submit');
          personnalisationDiv.appendChild(validateButton);
          
        } else if (selectedValue == 2) {
         
          addGalerie();
          const personnalisationDiv = document.getElementById("personalisation");
          const validateButton = document.createElement('button');
          validateButton.textContent = "Ajouter"; // Texte du bouton
          validateButton.classList.add('btn', 'btn-success');
          validateButton.setAttribute('type', 'submit');
          personnalisationDiv.appendChild(validateButton);
          

            titre.innerHTML = "Ajouter une galerie";
   
        }
    });
    
} 
  


</script>
@endsection


