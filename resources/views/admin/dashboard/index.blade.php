@extends("leyout.base")

@section("content")

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
       
        <li class="breadcrumb-item active">Tableau </li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-4 col-12">
            <div class="card info-card sales-card">

             

              <div class="card-body">
                <h5 class="card-title">Locataire <span>| ce mois </span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                   
                    <i class="bi bi-person-fill-add"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{$stat[0][0]+$stat[0][1]}}</h6>
                    <span class="text-success small pt-1 fw-bold">Immeuble : {{$stat[0][0]}} et galerie : {{$stat[0][1]}} 
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-4 col-12">
            <div class="card info-card revenue-card">

             

              <div class="card-body">
                <h5 class="card-title">Revenue loyer <span id="detaille"> |ce mois | detailles</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>${{$stat[1][0]+$stat[1][1]}}</h6>
                    <span class="text-success small pt-1 fw-bold">Immeuble : ${{$stat[1][0]}} et galerie : ${{$stat[1][1]}}
                 
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->
          <div class="col-xxl-4 col-md-4 col-12">
            <div class="card info-card revenue-card">

              

              <div class="card-body">
                <h5 class="card-title">Dépenses <span>| Voir en detaille</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6> $
                      @if (!empty($stat[4][0]) && isset($stat[4][0]->total_montant))
                          {{ $stat[4][0]->total_montant }}
                      @else
                          0
                      @endif
                  </h6>
                  </h6>
                    <span class="text-success small pt-1 fw-bold">
                 
                  </div>
                </div>
              </div>

            </div>
          </div>

       

        </div>
      </div><!-- End Left side columns -->

          <div class="row">
            

            <div class="col ">
              <div class="card info-card revenue-card ">
                <div class="card-body">

                  <canvas id="myChart"  style="margin-top:55px;">
                </div>
              </div>
    
            </div>
            <div class="col">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <canvas id="depense" style="margin-top:55px;">
                </div>
              </div>
          </div>

    

      
      
    


      </canvas>


      <!-- Top Selling -->
      <div class="col-12">
        <div class="card top-selling overflow-auto">

          <div class="card-body pb-0">
        
            <div class="container mt-4">
              <h2>Informations sur les immeubles et galeries</h2>
          
              <!-- Tableau des informations -->
              <table class="table table-hover table-bordered text-center align-middle">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Localisation</th>
                        <th>Locaux occupés</th>
                        <th>Locaux libres</th>
                        <th>Détails occupés</th>
                        <th>Détails libres</th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach($stat[2] as $resultat)
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td><span class="badge bg-primary">Galerie</span> {{ $resultat['galerie_nom'] }}</td>
                            <td class="text-start">
                                <strong>Ville :</strong> {{ $resultat['ville'] }} <br>
                                <strong>Province :</strong> {{ $resultat['province'] }} <br>
                                <strong>Adresse :</strong> {{ $resultat['adresse'] }}
                            </td>
                            <td class="text-success fw-bold">{{ $resultat['nombreOccupes'] }}</td>
                            <td class="text-danger fw-bold">{{ $resultat['nombreLibres'] }}</td>
                            <td>
                                <ul class="list-unstyled m-0">
                                  @forelse ( $resultat['biensOccupes'] as $occupe )
                                  <li style="text-align:Left">✅ {{ $occupe->bien_nom }}</li>
                                  @empty
                                  <li>Aucun bien disponible</li>
                           
                                  @endforelse

                                 

                                </ul>
                            </td>
                            <td>
                                <ul class="list-unstyled m-0">

                                
                                    @forelse ($resultat['biensLibres'] as $libre)
                                        <li style="text-align:Left">{{ $libre->bien_nom }}</li>
                                    @empty
                                        <li>Aucun bien disponible</li>
                                    @endforelse
                                </ul>
                                

                                </ul>
                            </td>
                        </tr>
                    @endforeach
            
                    @foreach($stat[3] as $resultat)
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td><span class="badge bg-warning text-dark">Immeuble</span> {{ $resultat['immeuble_nom'] }}</td>
                            <td class="text-start">
                                <strong>Ville :</strong> {{ $resultat['ville'] }} <br>
                                <strong>Province :</strong> {{ $resultat['province'] }} <br>
                                <strong>Adresse :</strong> {{ $resultat['adresse'] }}
                            </td>
                            <td class="text-success fw-bold">{{ $resultat['nombreOccupes'] }}</td>
                            <td class="text-danger fw-bold">{{ $resultat['nombreLibres'] }}</td>
                            <td>
                                <ul class="list-unstyled m-0">
                                    @foreach($resultat['appartementsOccupes'] as $occupe)
                                        <li style="text-align:Left">✅ Appartement {{ $occupe->numero }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul class="list-unstyled m-0">
                                    @foreach($resultat['appartementsLibres'] as $libre)
                                        <li style="text-align:Left">Appartement {{ $libre->numero }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
          </div>
        </div>
      </div>

    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <script>


    function graphiqueDepance(val){

      var a="{{ route('admin.dashboard.info_graphique_depense') }}";
    
        $.ajax({
            url: a, // URL de la route avec le paramètre
            type: "GET", // Méthode HTTP
            success: function (response) {


              graphique2(response.input[0],null,val);

            },
            error: function (xhr, status, error) {
                console.error('Erreur :', error);
            }
        });

    }



    function graphiqueLoyer(val){
  
        var a="{{ route('admin.dashboard.grapheLoyer') }}";
        // Requête AJAX
        $.ajax({
            url: a, // URL de la route avec le paramètre
            type: "GET", // Méthode HTTP
            success: function (response) {

              graphique2(response.input[0],response.input[1],val);

       

            },
            error: function (xhr, status, error) {
                console.error('Erreur :', error);
            }
        });

}

function graphique2(date_immeuble = null, data_galerie = null, objetd) {
    Chart.register(ChartDataLabels); // Enregistrement du plugin pour afficher les labels
    const ctx = document.getElementById(objetd).getContext('2d');

    const datasets = [];
    let yAxisLabel = "MONTANT REVENUE ($)"; // Valeur par défaut

    if (date_immeuble && !data_galerie) {
        // Cas où seul "immeuble" existe
        datasets.push({
            label: 'DEPENSE', // Nom au singulier
            data: date_immeuble,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            fill: false,
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointRadius: 5,
            pointStyle: 'rect'
        });
        yAxisLabel = "DEPENSE ($)"; // Modification du nom de l'axe Y
    } else if (data_galerie && !date_immeuble) {
        // Cas où seul "galerie" existe
        datasets.push({
            label: 'GALERIE', // Nom au singulier
            data: data_galerie,
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: false,
            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
            pointRadius: 5,
            pointStyle: 'rect'
        });
        yAxisLabel = "REVENUE GALERIE ($)"; // Modification du nom de l'axe Y
    } else {
        // Cas où les deux existent
        if (date_immeuble) {
            datasets.push({
                label: 'IMMEUBLES',
                data: date_immeuble,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointRadius: 5,
                pointStyle: 'rect'
            });
        }

        if (data_galerie) {
            datasets.push({
                label: 'GALERIES',
                data: data_galerie,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: false,
                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                pointRadius: 5,
                pointStyle: 'rect'
            });
        }
    }

    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10
                    }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' $';
                        }
                    }
                },
                datalabels: {
                    align: 'top',
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: function(value) {
                        return value !== null ? value + ' $' : ''; // Affiche uniquement les valeurs non nulles
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: ''
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: yAxisLabel // Modification dynamique du nom de l'axe Y
                    }
                }
            }
        }
    });
}




function graphique(date_immeuble, data_galerie, objetd) {
    Chart.register(ChartDataLabels); // Enregistrement du plugin pour afficher les labels
    const ctx = document.getElementById(objetd).getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            datasets: [
                {
                    label: 'IMMEUBLES',
                    data: date_immeuble,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointRadius: 5,
                    pointStyle: 'rect' // Affiche un petit carré rempli sur le graphique et dans la légende
                },
                {
                    label: 'GALERIES',
                    data: data_galerie,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                    pointRadius: 5,
                    pointStyle: 'rect' // Affiche un petit carré rempli sur le graphique et dans la légende
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                // Configuration de la légende pour utiliser le style des points
                legend: {
                    labels: {
                        usePointStyle: true, // Affiche l'icône du dataset sous forme de point (ici, le style défini 'rect')
                        boxWidth: 10 // Vous pouvez ajuster la taille du carré si nécessaire
                    }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' $';
                        }
                    }
                },
                datalabels: {
                    align: 'top', // Position des labels au-dessus des points
                    color: '#000', // Couleur du texte
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: function(value) {
                        return value !== null ? value + ' $' : ''; // Affiche seulement les montants non nuls
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: ''
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'MONTANT REVENUE ($)'
                    }
                }
            }
        }
    });
}

     

   $(document).ready(function () {
   
          graphiqueLoyer("myChart");

          graphiqueDepance("depense");


    
    });

    

 
  </script>

@endsection