<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AJAX avec Laravel</title>
</head>
<body>
    <button id="ajaxButton">Envoyer une requête AJAX</button>
    
    <p id="response"> gfdtudtu</p>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Configuration CSRF pour les requêtes AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Événement clic sur le bouton
            $('#ajaxButton').click(function () {
                $.ajax({
                    url: "{{ route('getData') }}", // URL de la route
                    type: "POST", // Méthode HTTP
                    data: { name: "Utilisateur", age: 25 }, // Données envoyées
                    success: function (response) {
                        
                        // Affiche la réponse dans le DOM
                        $('#response').text(response.message + " : " + JSON.stringify(response.input));
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur :', error);
                    }
                });
            });
        });
    </script>
</body>
</html>
