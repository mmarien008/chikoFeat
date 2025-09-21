
@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Paiement loyer</h1>

</div>

@php
    use Carbon\Carbon;

    $months = [
        '01' => 'Janvier', '02' => 'Février', '03' => 'Mars',
        '04' => 'Avril',   '05' => 'Mai',      '06' => 'Juin',
        '07' => 'Juillet', '08' => 'Août',     '09' => 'Septembre',
        '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
    ];
    $year = date('Y');

    // Date de début du loyer
    $dateDebut = Carbon::parse($valeurs[0]->date_debut);
    

    // Extraire les mois déjà payés
    $selectedMonths = [];
  
    foreach($valeurs[2] as $loyer){
        if($loyer->date==null){

        }else{
                $date = Carbon::parse($loyer->date);
          
        $selectedMonths[] = $date->format('Y-m'); // mois déjà payés

        }
    
    }
@endphp


<form action="{{route("loyer.save")}}" method="post">

<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title mb-3">Sélectionner des mois</h5>
    
      <div class="row g-2 mb-3">
        @foreach($months as $num => $name)
            @php
                $value = $year . '-' . $num;
                $monthDate = Carbon::parse($value);
                $isPast = $monthDate->format('Y-m') < $dateDebut->format('Y-m');// mois avant date_debut
                
                $isSelected = in_array($value, $selectedMonths); // mois déjà payé
            @endphp
            <div class="col-6 col-md-4 col-lg-3">
              <div class="form-check p-2 border rounded h-100">
                <input 
                    class="form-check-input month-checkbox" 
                    type="checkbox" 
                     name="moisp[]"
                    value="{{ $value }}-01" 
                    id="m-{{ $num }}" 
                    data-month="{{ $name }}"
                    @if($isSelected) checked disabled
                    @elseif($isPast) disabled
                    @endif
                >
                <label class="form-check-label fw-semibold" for="m-{{ $num }}">{{ $name }}</label>
              </div>
            </div>
        @endforeach
      </div>

      <div class="d-flex align-items-center mb-2">
        <div class="me-3">
          <button id="selectFirst6" class="btn btn-sm btn-outline-primary">Tout cocher (1-6)</button>
          <button id="selectLast6" class="btn btn-sm btn-outline-primary">Tout cocher (7-12)</button>
        </div>
        <div class="flex-grow-1 text-end">
          <button id="getSelected" class="btn btn-sm btn-success">Voir sélection</button>
        </div>
      </div>
      <div id="selectedOutput" class="mt-3"></div>
    </div>
  </div>
</div>


  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Paiement du loyé</span></h5>
                    <div class="row">
                        uffg
                        
                            <div class="row">
                                <div class="col  ">
                                    <div class="fs-6">
                                        Nom complet :{{$valeurs[0]->nom}} {{$valeurs[0]->post_nom}} {{$valeurs[0]->prenom}} 
                                        <input type="text" name="nom" value="" style="display: none">
                                        
                                    </div>

                                    <input type="text" name="id_locataire" value="{{$valeurs[1][0]}}" style="display: none" >
                                    <input type="text" name="id_numNom" value="{{$valeurs[1][1]}}" style="display: none">
                                    <input type="text" name="type" value="{{$valeurs[1][2]}}" style="display: none">
                                    <input type="text" name="loyer" value="{{$valeurs[0]->loyer}}" style="display: none">
                                    
                                </div>
        
                                <div class="col ">
                                    <div class="fs-6">
                                        Type propriété : {{$valeurs[0]->type}}_{{$valeurs[0]->nom_type}} 
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
@csrf

                            <div class="row mt-3">
        
                                <div class="col  ">
                                    <div class="fs-6">
                                        Numero/Nom : {{$valeurs[0]->numero}}
                                    
                                    </div>
                                    
                                </div>

                                <div class="col  fs-6">
                                    Le loyé est fixé à  

                                    <strong>{{$valeurs[0]->loyer}}$</strong>
                                        
                                </div>
        
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <input type="date" value="{{$valeurs[0]->date}}" class="form-control">
                                </div>
                            </div>

                          
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Valider le paiment</button>
                                </div>
                                <div class="col">
                                    <div style="">

                                    
                                        @if (($valeurs[0]->montant % $valeurs[0]->loyer==0)==0)

                                            <div class="row">
                                                <div class="col"  value="0">
                                                    <input type="text" id="status_payement" name="status_payement" value="0" style="display: none">
                                                <span style="color: red"> Garantie actuelle :{{$valeurs[0]->montant}}$</span> 
                                                    <span id="value">pas de retrait sur garantie</span>
                                                </div>
                                                <div class="col">
                                                    <input type="checkbox" id="retrait"
                                                    class="form-check"  type="retrait" name="check">
                                                </div>

                                            </div>
                                            
                                        @elseif(($valeurs[0]->montant % $valeurs[0]->loyer==0)!=0)

                                        <p style="color: red;">la garantie est trop inferieure pour soustraire le loyer , merci</p>

                                        @endif
                                        
                          
                                        
                                        
                                    </div>
                                    
                                </div>

                                <div class="col">
                                    <input type="number" name="montant_loyer"  class="form-control"  max="{{$valeurs[0]->loyer-1}}" min="2" value="" placeholder="Payez une partie du loyé">
                                </div>
            
                            </div>
        
                        </div>
                    </div>
            </div>

        </div>



 

    </div>
  </section>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>

$(document).ready(function() {
    $("#retrait").on("click", function() {
        if ($(this).is(":checked")) {
           
            $("#value").text("retrait sur garantie");
            $("#status_payement").val("1")

        } else {
            $("#value").text("pas de retrait sur garantie");
            $("#status_payement").val("0")
           
        }
    });
});



  </script>
  <script>
  // Remplacesi tu utilises Blade: Blade va injecter l'année.
  // Si c'est du HTML pur, tu peux remplacer manuellement par 2025 ou générer via JS.
  document.addEventListener('click', function(e) {
    if (e.target.id === 'selectFirst6') {
      document.querySelectorAll('.month-checkbox').forEach((cb, idx) => {
        if (idx < 6) cb.checked = true;
      });
    }
    if (e.target.id === 'selectLast6') {
      document.querySelectorAll('.month-checkbox').forEach((cb, idx) => {
        if (idx >= 6) cb.checked = true;
      });
    }
    if (e.target.id === 'getSelected') {
      const checked = Array.from(document.querySelectorAll('.month-checkbox:checked'))
        .map(cb => ({ value: cb.value, label: cb.dataset.month }));
      const out = document.getElementById('selectedOutput');
      if (checked.length === 0) {
        out.innerHTML = '<div class="alert alert-warning py-1">Aucun mois sélectionné</div>';
      } else {
        out.innerHTML = '<div class="alert alert-info py-1">Sélection : ' +
          checked.map(c => c.label + ' (' + c.value + ')').join(', ') + '</div>';
      }
    }
  });
</script>
@endsection


