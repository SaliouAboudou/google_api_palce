<!DOCTYPE html>
<html>

<head>
    <title>Liste des Hôpitaux du Bénin</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f5f5f5;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-..." crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row gap-1 py-2">
            <div class="col-md-2">
                <a class="btn btn-primary" href="{{ route('cliniques') }}">Liste des Cliniques</a>
            </div>

            <div class="col-md-2">
                <a class="btn btn-primary" href="{{ route('hopitaux') }}">Liste des hopitaux</a>
            </div>

              <div class="col-md-2">
                <a class="btn btn-warning" href="{{ route('search_hopitaux') }}">Faire une recherche</a>
            </div>
        </div>

        @yield('content')
    </div>
</body>

</html>
