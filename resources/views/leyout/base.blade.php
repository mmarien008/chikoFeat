<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tchiko House</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">


    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}"rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">


</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="">


                <span class="d-none d-lg-block">Tchiko House</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>

        </div><!-- End Logo -->



        <!-- End Search Bar -->



       <nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <!-- Profil utilisateur -->
    <li class="nav-item dropdown pe-3">
      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <!-- Avatar rond -->
        <div class="rounded-circle border px-2 py-2 bg-success text-white">
          <i class="bi bi-person"></i>
        </div>

        <!-- Nom utilisateur -->
        <span class="d-none d-md-block dropdown-toggle ps-2">
          @if (auth()->check())
            {{ auth()->user()->name }}
          @else
            vous devez vous connecté
          @endif
        </span>
      </a>

      <!-- Menu déroulant -->
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header text-center">
          <h6>
            @if (auth()->check())
              {{ auth()->user()->name }}
            @else
              Utilisateur
            @endif
          </h6>
          <span class="text-muted small">Connecté</span>
        </li>

        <li><hr class="dropdown-divider"></li>

        <!-- Déconnexion -->
        <li>
          <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger w-100">Déconnexion</button>
          </form>
        </li>
      </ul>
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->


    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                @if (auth()->check() && auth()->user()->role == 'admin')
                    <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>Tableau de bord</span>
                    </a>
                @endif
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Mes options</li>



            <li class="nav-item mt-3">
                <a class="nav-link collapsed" href="{{ route('propriete.create') }}">
                    <i class="bi bi-buildings"></i>
                    <span>Propriétés</span>
                </a>
            </li><!-- End propriete Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('locataire.index') }}">
                    <i class="bi bi-people"></i>
                    <span> Locataires</span>
                </a>
            </li><!-- End locataire Nav -->



            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('pdf.create') }}">
                    <i class="bi bi-cash-stack"></i>
                    <span> Loyers et garanties </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('caisse.index') }}">
                    <i class="bi bi-cash-stack"></i>
                    <span> Caisse </span>
                </a>
            </li>


            <li class="nav-item">
                @if (auth()->check() && auth()->user()->role == 'admin')
                    <a class="nav-link collapsed" href="{{ route('admin.user.index') }}">
                        <i class="bi bi-person-gear"></i>
                        <span>Gestion des utilisateurs </span>
                    </a>
                @endif
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed"
                    href="{{ auth()->check() && auth()->user()->role == 'admin' ? route('admin.operation.index') : route('operation.create') }}">
                    <i class="bi bi-tools"></i>

                    Opérations <span class="badge" id="notification-icon"></span>

                </a>



            </li>


            <!-- End Blank Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Tous droits réservés
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">Menji Drc</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->


    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>

    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            function actualiserNotifications() {
                $.ajax({
                    url: "{{ route('admin.operation.NotificationOperation') }}", // Route Laravel qui renvoie les notifications
                    type: "GET",
                    dataType: "json",
                    success: function(data) {




                        // Vider avant d'ajouter
                        if (data.input.length > 0) {


                            $("#notification-icon").removeClass("bg-primary");
                            $("#notification-icon").html(`${data.input.length}`);


                            $("#notification-icon").addClass("bg-danger");

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur de chargement des notifications :", error);
                    }
                });
            }

            // Actualiser toutes les 5 secondes
            setInterval(async function() {
                await actualiserNotifications();
            }, 500);

            // Forcer une mise à jour manuelle sur clic
            $("#refresh-btn").click(function() {
                actualiserNotifications();
            });
        });
    </script>

</body>

</html>
