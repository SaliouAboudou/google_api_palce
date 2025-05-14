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


</head>

<body>
    <h1>Liste des cliniques</h1>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Localité</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            @php
                $index = 0;
            @endphp

            @forelse ($hopitaux as $hopital)
                <tr>
                    <td>{{ $index += 1 }}</td>
                    <td>{{ $hopital['name'] }}</td>
                    <td>{{ $hopital['formatted_address'] }}</td>
                    <td>{{ $hopital['vicinity'] }}</td>
                    <td>{{ $hopital['contact'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Aucunes données</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
