<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Connexion - Tchiko House</title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:400,600,700|Poppins:400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main class="d-flex align-items-center justify-content-center min-vh-100 bg-light">

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">

          <!-- Logo -->
          <div class="text-center mb-4">
            <a href="#" class="d-flex align-items-center justify-content-center">
              <img src="assets/img/logo.jpg" alt="Logo" class="img-fluid rounded-circle" width="80">
              <span class="ms-2 h4 mb-0">Tchiko House</span>
            </a>
          </div>

          <!-- Card -->
          <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

              <h5 class="card-title text-center mb-3">Connexion à votre compte</h5>
              <p class="text-center small text-muted">Entrez votre numéro et votre mot de passe</p>

              <!-- Formulaire -->
              <form action="{{ route('Tologin') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <!-- Phone -->
                <div class="mb-3">
                  <label for="yourPhone" class="form-label">Numéros de téléphone</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                    <input type="text" name="phone" class="form-control" id="yourPhone" required>
                    <div class="invalid-feedback">Insérez votre numéro</div>
                  </div>
                  @error('phone')
                    <div class="text-danger small">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                  <label for="yourPassword" class="form-label">Mot de passe</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Insérez votre mot de passe</div>
                  </div>
                </div>

                <!-- Button -->
                <div class="d-grid">
                  <button class="btn btn-primary" type="submit">Connexion</button>
                </div>

              </form><!-- End Form -->

            </div>
          </div><!-- End Card -->

        </div>
      </div>
    </div>

  </main>

  <!-- Vendor JS -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
