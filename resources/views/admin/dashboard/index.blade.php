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
                    <h6>{{$stat[0][0] + $stat[0][1]}}</h6>
                    <span class="text-success small pt-1 fw-bold">Immeuble : {{$stat[0][0]}} et galerie : {{$stat[0][1]}}</span>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-4 col-12">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Revenue loyer <span id="detailles"> |ce mois | détails</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>${{$stat[1][0] + $stat[1][1]}}</h6>
                    <span class="text-success small pt-1 fw-bold">Immeuble : ${{$stat[1][0]}} et galerie : ${{$stat[1][1]}}</span>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->
          
          <div class="col-xxl-4 col-md-4 col-12">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Dépenses <span>| Voir en détail</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>$ 
                      @if (!empty($stat[4][0]) && isset($stat[4][0]->total_montant))
                          {{ $stat[4][0]->total_montant }}
                      @else
                          0
                      @endif
                    </h6>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div><!-- End Left side columns -->

      <div class="row">
        <div class="col">
          <div class="card info-card revenue-card  ">
            <div class="card-body my-3">
              <div class="row mb-3 justify-content-end">
                <div class="col-md-4">
                
                  <select id="periodeSelect" class="form-select">
                    <option value="1">Janvier - Juin</option>
                    <option value="2" selected>Juillet - Décembre</option>
                  </select>
                </div>
              </div>
              <canvas id="myChart" style="margin-top:55px;"></canvas>
            </div>
          </div>
        </div>
        
        <div class="col">
          <div class="card info-card revenue-card">
            <div class="card-body  my-3">
              <div class="row mb-3  justify-content-end">
                <div class="col-md-4">
              
                  <select id="periodeSelectDepense" class="form-select">
                    <option value="1">Janvier - Juin</option>
                    <option value="2" selected>Juillet - Décembre</option>
                  </select>
                </div>
              </div>
              <canvas id="depense" style="margin-top:55px;"></canvas>
            </div>
          </div>
        </div>

      </div>

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
    // Variables globales pour stocker les données
    let loyerData = null;
    let depenseData = null;
    
    function graphiqueDepense(val, periode){
      var a = "{{ route('admin.dashboard.info_graphique_depense') }}";
    
      $.ajax({
        url: a,
        type: "GET",
        success: function (response) {
          depenseData = response.input[0];
          updateGraphique(depenseData, null, val, periode);
        },
        error: function (xhr, status, error) {
          console.error('Erreur :', error);
        }
      });
    }

    function graphiqueLoyer(val, periode){
      var a = "{{ route('admin.dashboard.grapheLoyer') }}";
      
      $.ajax({
        url: a,
        type: "GET",
        success: function (response) {
          loyerData = {
            immeuble: response.input[0],
            galerie: response.input[1]
          };
          updateGraphique(loyerData.immeuble, loyerData.galerie, val, periode);
        },
        error: function (xhr, status, error) {
          console.error('Erreur :', error);
        }
      });
    }

    function updateGraphique(date_immeuble = null, data_galerie = null, objetd, periode) {
      Chart.register(ChartDataLabels);
      const ctx = document.getElementById(objetd).getContext('2d');

      // Détruire le graphique existant s'il y en a un
      if (window[objetd + 'Chart']) {
        window[objetd + 'Chart'].destroy();
      }

      const datasets = [];
      let yAxisLabel = "MONTANT REVENUE ($)";
      let labels, dataImmeuble, dataGalerie;

      // Déterminer les données à afficher selon la période
      if (periode === "1") {
        // Janvier - Juin
        labels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'];
        dataImmeuble = date_immeuble ? date_immeuble.slice(0, 6) : [];
        dataGalerie = data_galerie ? data_galerie.slice(0, 6) : [];
      } else {
        // Juillet - Décembre
        labels = ['Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'];
        dataImmeuble = date_immeuble ? date_immeuble.slice(6, 12) : [];
        dataGalerie = data_galerie ? data_galerie.slice(6, 12) : [];
      }

      if (date_immeuble && !data_galerie) {
        // Graphique des dépenses
        datasets.push({
          label: 'DEPENSE',
          data: dataImmeuble,
          backgroundColor: 'rgba(77, 108, 108, 0.5)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
          borderRadius: 10,
          barThickness: 30
        });
        yAxisLabel = "DEPENSE ($)";
      } else {
        // Graphique des revenus
        if (date_immeuble) {
          datasets.push({
            label: 'IMMEUBLES',
            data: dataImmeuble,
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            borderRadius: 10,
            barThickness: 50
          });
        }
        if (data_galerie) {
          datasets.push({
            label: 'GALERIES',
            data: dataGalerie,
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            borderRadius: 10,
            barThickness: 30
          });
        }
      }

      window[objetd + 'Chart'] = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
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
              anchor: 'end',
              align: 'end',
              color: '#000',
              font: {
                weight: 'bold',
                size: 12
              },
              formatter: function(value) {
                return value !== null ? value + ' $' : '';
              }
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                align: 'center'
              },
              categoryPercentage: 0.6,
              barPercentage: 1.0
            },
            y: {
              beginAtZero: true,
              grid: {
                display: true,
                color: "rgba(57, 55, 55, 0.05)"
              },
              title: {
                display: true,
                text: yAxisLabel
              }
            }
          }
        }
      });
    }

    $(document).ready(function () {
      // Initialiser les graphiques avec la période par défaut (Juillet-Décembre)
      graphiqueLoyer("myChart", "2");
      graphiqueDepense("depense", "2");
      
      // Gestionnaire d'événement pour le filtre de période des revenus
      $("#periodeSelect").change(function() {
        const periode = $(this).val();
        if (loyerData) {
          updateGraphique(loyerData.immeuble, loyerData.galerie, "myChart", periode);
        } else {
          graphiqueLoyer("myChart", periode);
        }
      });
      
      // Gestionnaire d'événement pour le filtre de période des dépenses
      $("#periodeSelectDepense").change(function() {
        const periode = $(this).val();
        if (depenseData) {
          updateGraphique(depenseData, null, "depense", periode);
        } else {
          graphiqueDepense("depense", periode);
        }
      });
    });
  </script>

@endsection