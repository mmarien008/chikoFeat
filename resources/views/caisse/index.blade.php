@extends('leyout.base')

@section('content')
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
                    <table class="table table-bordered" id="tableUsers" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Utilisateurs</th>
                                <th>Croissance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Février</td><td>1,250</td><td>+5.2%</td></tr>
                            <tr><td>Mars</td><td>1,890</td><td>+10.7%</td></tr>
                            <tr><td>Avril</td><td>2,340</td><td>+15.3%</td></tr>
                            <tr><td>Mai</td><td>3,120</td><td>+18.9%</td></tr>
                            <tr><td>Juin</td><td>3,850</td><td>+12.4%</td></tr>
                            <tr><td>Juillet</td><td>4,560</td><td>+14.7%</td></tr>
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

<script>
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
