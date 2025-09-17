@extends('leyout.base')

@section('content')
    <div class="container my-4">


        <!-- Modal -->
        @include('caisse.create')

        <!-- Indicateurs -->
        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Revenus Locatifs</h5>
                    <h3>{{ $locationsCount ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Revenus externes</h5>
                    <h3>{{ $revenuesCount ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Opérations</h5>
                    <h3>{{ $operationsCount ?? 0 }}</h3>
                </div>
            </div>
        </div>


        <!-- Bouton ajouter revenu -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalrevenue">
            Ajouter une revenue externe
        </button>
        <!-- Tableau -->
        <div class="mt-4">
            @include('caisse.revenue')
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique 1 : Répartition par motif
        const ctx1 = document.getElementById('revenuesChart');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: {!! json_encode($revenuesLabels ?? []) !!},
                datasets: [{
                    data: {!! json_encode($revenuesData ?? []) !!},
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1'],
                }]
            }
        });

        // Graphique 2 : Revenus par mois
        const ctx2 = document.getElementById('monthlyChart');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months ?? []) !!},
                datasets: [{
                    label: 'Montant',
                    data: {!! json_encode($monthlyData ?? []) !!},
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
