@extends('hopitaux.app')
@section('content')
<h1>Liste des hopitaux</h1>
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
@endsection
