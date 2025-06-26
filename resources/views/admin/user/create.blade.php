<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Créer un utilisateur - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6 p-4 shadow rounded bg-light">
      <h3 class="text-center mb-4">Créer un utilisateur</h3>
      <form method="post" action="{{ route('admin.user.store') }}">
        @csrf

        <!-- Nom -->
        <div class="mb-3">
          <label for="name" class="form-label">Nom du gérant</label>
          
          <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Entrez le nom">
          @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <!-- Adresse email -->
        <div class="mb-3">
          <label for="email" class="form-label">Adresse email</label>
          <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Entrez l'adresse email">
          @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <!-- Numéro de téléphone -->
        <div class="mb-3">
          <label for="phone" class="form-label">Numéro de téléphone</label>
          <input type="phone" name="phone" required id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Entrez le numéro de téléphone">
          @error('phone')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <!-- Mot de passe -->
        <div class="mb-3">
          <label for="password" required class="form-label">Mot de passe</label>
          <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Entrez le mot de passe">
          @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

       
        <!-- Bouton de soumission -->
        <div class="d-grid">
          <button type="submit" class="btn btn-success">Créer un gérant</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
