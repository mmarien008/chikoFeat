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
    </div>
  </section>

  <div class="row mb-4">
    <!-- Filtre par mois -->
    <div class="col-12 d-flex justify-content-start mb-2">
        <label class="me-2" for="filterMonth">Filtrer par mois :</label>
        <select id="filterMonth" class="form-select w-auto">
            <option value="">Tous les mois</option>
            <option value="Février">Février</option>
            <option value="Mars">Mars</option>
            <option value="Avril">Avril</option>
            <option value="Mai">Mai</option>
            <option value="Juin">Juin</option>
            <option value="Juillet">Juillet</option>
        </select>
    </div>
</div>

<div class="row">
    <!-- Tableau Utilisateurs -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Détails Utilisateurs</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                   @foreach($stat[2] as $resultat)
                    <table class="table table-bordered" id="tableUsers" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Appartement</th>
                                
                            </tr>
                        </thead>
                        <tbody>
       
                            <tr>
                               <td>
                                <ul class="list-unstyled m-0">
                                  @forelse ( $resultat['biensOccupes'] as $occupe )
                                  <li style="text-align:Left">✅ {{ $occupe->bien_nom }}</li>
                                  @empty
                                  <li>Aucun bien disponible</li>
                                  @endforelse
                                </ul>
                            </td>
                            </tr>
                        @endforeach  

                         @foreach($stat[3] as $resultat)
                    
                            <tr>
                               <td>
                                <ul class="list-unstyled m-0">
                                  <table class="table table-borderless">
    <thead class="text-center"> <!-- pas de fond coloré -->
        <tr>
            <th>Appartement</th>
            <th>Occupant</th>
            <th>Date début</th>
            <th>Statut du loyer</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resultat['appartementsOccupes'] as $occupe)
            <tr>
                <td>{{ $occupe->numero }}</td>
                <td>{{ $occupe->locataire_nom }} {{ $occupe->locataire_prenom ?? '' }}</td>
                <td>{{ $occupe->date_debut }}</td>
                <td>{{ $occupe->loyer_statut == 1 ? 'Payé' : 'Non payé' }}</td>
            </tr>
        @endforeach
        @if(count($resultat['appartementsOccupes']) == 0)
            <tr>
                <td colspan="4" class="text-center">Aucun appartement occupé</td>
            </tr>
        @endif
    </tbody>
</table>

                                </ul>
                            </td>
                            </tr>
                        @endforeach  
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-2">
                    <ul class="pagination justify-content-end mb-0" id="paginationUsers"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Tableau Immeubles -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Détails Immeubles</h6>
                <span class="badge bg-primary">6 mois</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableBuildings" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Nouveaux utilisateurs</th>
                                <th>Croissance</th>
                                <th>Objectif</th>
                                <th>Tendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Février</td><td>1,250</td><td>+5.2%</td><td>92%</td><td>↑</td></tr>
                            <tr><td>Mars</td><td>1,890</td><td>+10.7%</td><td>87%</td><td>↑</td></tr>
                            <tr><td>Avril</td><td>2,340</td><td>+15.3%</td><td>95%</td><td>↑</td></tr>
                            <tr><td>Mai</td><td>3,120</td><td>+18.9%</td><td>89%</td><td>↑</td></tr>
                            <tr><td>Juin</td><td>3,850</td><td>+12.4%</td><td>91%</td><td>↑</td></tr>
                            <tr><td>Juillet</td><td>4,560</td><td>+14.7%</td><td>96%</td><td>↑</td></tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-2">
                    <ul class="pagination justify-content-end mb-0" id="paginationBuildings"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>



  
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

    function paginateTable(tableId, paginationId, rowsPerPage, filterValue = "") {
    const table = document.getElementById(tableId);
    const tbody = table.querySelector("tbody");
    let allRows = Array.from(tbody.querySelectorAll("tr"));

    // Appliquer le filtre
    if(filterValue) {
        allRows.forEach(row => {
            row.style.display = row.cells[0].textContent.includes(filterValue) ? "" : "none";
        });
        allRows = allRows.filter(row => row.style.display !== "none");
    } else {
        allRows.forEach(row => row.style.display = "");
    }

    const totalPages = Math.ceil(allRows.length / rowsPerPage);
    let currentPage = 1;

    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        allRows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? "" : "none";
        });
        renderPagination();
    }

    function renderPagination() {
        const pagination = document.getElementById(paginationId);
        pagination.innerHTML = "";
        for(let i=1; i<=totalPages; i++) {
            const li = document.createElement("li");
            li.className = "page-item" + (i === currentPage ? " active" : "");
            const a = document.createElement("a");
            a.className = "page-link";
            a.href = "#";
            a.textContent = i;
            a.addEventListener("click", (e) => {
                e.preventDefault();
                currentPage = i;
                showPage(currentPage);
            });
            li.appendChild(a);
            pagination.appendChild(li);
        }
    }

    showPage(currentPage);
}

// Fonction pour appliquer filtre à tous les tableaux
document.getElementById("filterMonth").addEventListener("change", (e) => {
    const month = e.target.value;
    paginateTable("tableUsers", "paginationUsers", 5, month);
    paginateTable("tableBuildings", "paginationBuildings", 5, month);
});

// Initialisation
paginateTable("tableUsers", "paginationUsers", 5);
paginateTable("tableBuildings", "paginationBuildings", 5);
  </script>

@endsection