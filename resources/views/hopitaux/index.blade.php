@extends('hopitaux.app')
@section('content')
    <h1>Recherche</h1>
    <form class=" row" action="{{ route('hopitaux') }}" method="GET">
        @csrf
        <div class="col-md-4">
            <select class="form-select name="etablissement" id="">
                <option value="">Choix</option>
                <option value="Hopitaux">Hopitaux</option>
                <option value="Cliniques">Cliniques</option>
                <option value="Polycliniques">Polycliniques</option>
                <option value="Pharmacies">Pharmacies</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="departement" id="departement" class="form-select">
                <option value="">-- Sélectionner --</option>
                <option value="Alibori">Alibori</option>
                <option value="Atacora">Atacora</option>
                <option value="Atlantique">Atlantique</option>
                <option value="Borgou">Borgou</option>
                <option value="Collines">Collines</option>
                <option value="Donga">Donga</option>
                <option value="Kouffo">Kouffo</option>
                <option value="Littoral">Littoral</option>
                <option value="Mono">Mono</option>
                <option value="Ouémé">Ouémé</option>
                <option value="Plateau">Plateau</option>
                <option value="Zou">Zou</option>
                <option value="Banikoara">Banikoara</option>
                <option value="Kandi">Kandi</option>
                <option value="Malanville">Malanville</option>
                <option value="Cotonou">Cotonou</option>
                <option value="Abomey-calivi">Abomey-calavi</option>
                <option value="Natiningou">Natiningou</option>
                <option value="Abomey calavi">Abomey calavi</option>
                <option value="Porto novo">Porto novo</option>
                <option value="Abomey">Abomey</option>
                <option value="houida">houida</option>
                <option value="allada">allada</option>
                <option value="savê">savê</option>
                <option value="parakou">parakou</option>
                <option value="bohicon">bohicon</option>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" type="submit">Envoyer</button>
        </div>
    </form>
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
