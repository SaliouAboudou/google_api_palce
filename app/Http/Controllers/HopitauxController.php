<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;

use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Facades\Http;

class HopitauxController extends Controller
{

    public function index()
    {
        return view('hopitaux.app');
    }

    public function clinique()
    {

        $cliniques = Etablissement::whereRaw("LOWER(name) LIKE '%clinique%' OR LOWER(name) LIKE '%clinical%'")->get();
        // dd($cliniques);
        return view('hopitaux.clinique', ['cliniques' => $cliniques]);
    }

    public function hopitaux()
    {
        $hopitaux = Etablissement::whereRaw("
                LOWER(name) NOT LIKE '%clinique%'
                AND LOWER(name) NOT LIKE '%clinical%'
            ")->get();
        return view('hopitaux.hopitaux', ['hopitaux' => $hopitaux]);
    }


    public function listeHopitaux(Request $request)
    {

        $etablissement = $request->input('etablissement', 'Hopital');
        $departement = $request->input('departement', 'Atlantique');



        $apiKey = config('services.google_places.api_key');
        $query = "$etablissement de $departement du Bénin";
        // $query = 'clinique du departement Zou du benin';

        // dd($query);

        $hopitaux = [];
        $nextPageToken = null;
        $iteration = 0;

        do {
            $params = [
                'query' => $query,
                'key' => $apiKey,
            ];

            if ($nextPageToken) {
                $params['pagetoken'] = $nextPageToken;
                sleep(2); // Nécessaire pour que le token soit actif
            }

            $response = Http::withOptions(['verify' => false])
                ->get('https://maps.googleapis.com/maps/api/place/textsearch/json', $params);

            $json = $response->json();
            $results = $json['results'] ?? [];

            foreach ($results as $place) {
                $placeId = $place['place_id'] ?? null;
                $phone = 'Non disponible';

                if ($placeId) {
                    $detailResponse = Http::withOptions(['verify' => false])->get('https://maps.googleapis.com/maps/api/place/details/json', [
                        'place_id' => $placeId,
                        'fields' => 'formatted_phone_number',
                        'key' => $apiKey,
                    ]);

                    $phone = $detailResponse->json()['result']['formatted_phone_number'] ?? 'Non disponible';

                    // ⚠️ Vérifie si l’établissement existe déjà
                    $existing = Etablissement::where('place_id', $placeId)->first();

                    if (!$existing) {
                        // Création dans la base si pas encore présent
                        $etablissement = Etablissement::create([
                            'name' => $place['name'] ?? 'Inconnu',
                            'formatted_address' => $place['formatted_address'] ?? 'Adresse inconnue',
                            'vicinity' => $place['vicinity'] ?? (explode(',', $place['formatted_address'])[1] ?? 'N/A'),
                            'contact' => $phone,
                            'place_id' => $placeId,
                        ]);

                        $hopitaux[] = $etablissement;
                    } else {
                        // Déjà en base, on l’ajoute juste à la liste
                        $hopitaux[] = $existing;
                    }
                }
            }

            $nextPageToken = $json['next_page_token'] ?? null;
            $iteration++;
        } while ($nextPageToken && $iteration < 4);

        return view('hopitaux.index', compact('hopitaux'));
    }



    public function imprimerPDFClinique()
    {
        // Configuration des options de Dompdf
        $options = new Options();
        $options->set('chroot', realpath('')); // Pour sécuriser l'accès aux fichiers
        $options->set('isRemoteEnabled', true); // Pour charger des images externes (CDN, etc.)

        $cliniques = Etablissement::whereRaw("LOWER(name) LIKE '%clinique%' OR LOWER(name) LIKE '%clinical%'")->get();
        // Générer le contenu HTML à partir d'une vue Laravel
        $htmlContent = view('hopitaux.documents.imprimerPDFClinique', ['cliniques' => $cliniques])->render();

        // Créer l'instance de Dompdf
        $dompdf = new Dompdf($options);

        // Charger le HTML
        $dompdf->loadHtml($htmlContent);

        // Configurer la taille et l'orientation
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $dompdf->render();

        // Nom du fichier PDF
        $prefixe = 'cliniques';
        $date_et_heure = date('Ymd_His');
        $nom_pdf = $prefixe . '_' . $date_et_heure . '.pdf';

        // Retourner le PDF dans le navigateur sans téléchargement
        return $dompdf->stream($nom_pdf, ['Attachment' => false]);
    }


    public function imprimerPDFHopitaux()
    {
        // Configuration des options de Dompdf
        $options = new Options();
        $options->set('chroot', realpath('')); // Pour sécuriser l'accès aux fichiers
        $options->set('isRemoteEnabled', true); // Pour charger des images externes (CDN, etc.)

        $hopitaux = Etablissement::whereRaw("
                LOWER(name) NOT LIKE '%clinique%'
                AND LOWER(name) NOT LIKE '%clinical%'
            ")->get();
        // Générer le contenu HTML à partir d'une vue Laravel
        $htmlContent = view('hopitaux.documents.imprimerPDFHopitaux', ['hopitaux' => $hopitaux])->render();

        // Créer l'instance de Dompdf
        $dompdf = new Dompdf($options);

        // Charger le HTML
        $dompdf->loadHtml($htmlContent);

        // Configurer la taille et l'orientation
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $dompdf->render();

        // Nom du fichier PDF
        $prefixe = 'hopitaux';
        $date_et_heure = date('Ymd_His');
        $nom_pdf = $prefixe . '_' . $date_et_heure . '.pdf';

        // Retourner le PDF dans le navigateur sans téléchargement
        return $dompdf->stream($nom_pdf, ['Attachment' => false]);
    }
}
