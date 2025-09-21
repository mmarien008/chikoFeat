
@extends("leyout.base")

@section("content")
<div class="pagetitle">
    <h1>Paiement loyer</h1>

</div>

@php
    use Carbon\Carbon;

    $currentYear = date('Y');
    $years = range($currentYear - 5, $currentYear + 5); // 5 ans avant/après
    $selectedYear = request('year', $currentYear); // année sélectionnée ou courante

     $months = [
        '01' => 'Janvier', '02' => 'Février', '03' => 'Mars',
        '04' => 'Avril', '05' => 'Mai', '06' => 'Juin',
        '07' => 'Juillet', '08' => 'Août', '09' => 'Septembre',
        '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
    ];

    $dateDebut = Carbon::parse($valeurs[0]->date_debut);

    $selectedMonths = [];
    foreach($valeurs[2] as $loyer){
        if($loyer->date){
            $selectedMonths[] = Carbon::parse($loyer->date)->format('Y-m');
        }
    }
@endphp
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<form method="GET" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <label for="yearSelect" class="form-label fw-semibold">Année :</label>
        </div>
        <div class="col-auto">
            <select name="year" id="yearSelect" class="form-select" onchange="this.form.submit()">
                @foreach($years as $yearOption)
                    <option value="{{ $yearOption }}" @if($yearOption == $selectedYear) selected @endif>{{ $yearOption }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<form action="{{route('loyer.save')}}" method="post">

<div class="row g-2 mb-3">
    @foreach($months as $num => $name)
        @php
            $value = $selectedYear . '-' . $num;
            $monthDate = Carbon::parse($value);
            $isPast = $monthDate->format('Y-m') < $dateDebut->format('Y-m'); // mois avant date_debut
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



  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Paiement du loyé</span></h5>
                    <div class="row">
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
                                    <button type="submit" class="btn btn-primary">Valider le paiment</button>
                                </div>
                                <div class="col">
                                    <div style="">
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
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
    const garantie = parseFloat({{ $valeurs[0]->montant }}); // montant actuel de la garantie
    const loyer = parseFloat({{ $valeurs[0]->loyer }}); // loyer par mois

    function verifierGarantie() {
        // On compte le nombre de mois sélectionnés
        const moisSelectionnes = $('.month-checkbox:checked:not(:disabled)').length;

        const total = moisSelectionnes * loyer;

        if(total > garantie) {
            alert("Attention : la garantie n'est pas suffisante pour couvrir " + moisSelectionnes + " mois !");
            return false;
        }
        return true;
    }

   

    // Vérification avant de soumettre le formulaire
    $('form').on('submit', function(e) {
        if(!verifierGarantie()) {
            e.preventDefault(); // empêche la soumission si la garantie est insuffisante
        }
    });
});

$(document).ready(function() {
    const garantie = parseFloat({{ $valeurs[0]->montant }}); // garantie actuelle
    const loyer = parseFloat({{ $valeurs[0]->loyer }}); // loyer mensuel

    function updateRetraitDisponibilite() {
        const moisActivables = $('.month-checkbox:not(:disabled)').length;
        if (moisActivables > 0) {
            $("#retrait").prop("disabled", false);
        } else {
            $("#retrait").prop("disabled", true).prop("checked", false);
            $("#value").text("pas de retrait sur garantie");
            $("#status_payement").val("0");
        }
    }

    updateRetraitDisponibilite();

    $(".month-checkbox").on("change", function() {
        updateRetraitDisponibilite();
    });

    $("#retrait").on("click", function() {
    if ($(this).is(":checked")) {
        // Récupérer les mois cochés (sauf désactivés)
        const moisSelectionnes = $('.month-checkbox:checked:not(:disabled)');
        const nbMois = moisSelectionnes.length;

        if (nbMois === 0) {
            alert("❌ Vous devez d'abord sélectionner au moins un mois avant de retirer sur garantie.");
            $(this).prop("checked", false); // on empêche l'activation
            $("#value").text("pas de retrait sur garantie");
            $("#status_payement").val("0");
            return;
        }

        // Calcul du montant
        const totalRetrait = nbMois * loyer;
        const resteGarantie = garantie - totalRetrait;

        // Récupérer les noms des mois sélectionnés
        const nomsMois = moisSelectionnes.map(function() {
            return $(this).data("month");
        }).get();

        if (garantie <= 0) {
            alert("Impossible : la garantie actuelle est de 0$, vous ne pouvez pas retirer.");
            $(this).prop("checked", false);
            $("#value").text("pas de retrait sur garantie");
            $("#status_payement").val("0");
        } else if (totalRetrait > garantie) {
            alert(
                "⚠️ Retrait impossible.\n\n" +
                "Vous voulez retirer " + nbMois + " mois (" + totalRetrait + "$), " +
                "mais la garantie actuelle est de seulement " + garantie + "$."
            );
            $(this).prop("checked", false);
            $("#value").text("pas de retrait sur garantie");
            $("#status_payement").val("0");
        } else {
            alert(
                " Retrait sur garantie activé.\n\n" +
                "- Mois sélectionnés : " + nomsMois.join(", ") + "\n" +
                "- Montant du retrait : " + totalRetrait + "$\n" +
                "- Garantie restante : " + resteGarantie + "$"
            );
            $("#value").text("retrait sur garantie");
            $("#status_payement").val("1");
        }
    } else {
        $("#value").text("pas de retrait sur garantie");
        $("#status_payement").val("0");
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


