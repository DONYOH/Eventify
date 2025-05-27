<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\Participer;
use App\Models\Place;
use App\Models\Place_reserve;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function mes_reservation()
    {
        $user = Auth::user();
        $Mes_reservation = Participer::where('id_user', $user->id)->paginate(10);
        return response()->json($Mes_reservation, 200);
    }

    public function add_reservation(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'id_event' => 'required|integer',
            'date_reservation' => 'required|date',
        ]);

        $reservation = Participer::create($request->all());

        return response()->json($reservation, 201);
    }

    public function verifier_reservation($id)
    {
        $reservation = Participer::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Données non trouvés'], 404);
        }
        return response()->json($reservation);
    }

    public function update_reservation(Request $request, $id)
    {
        $reservation = Participer::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Données non trouvés'], 404);
        }

        $reservation->update($request->all());

        return response()->json($reservation);
    }

    public function delete_reservation($id)
    {
        $reservation = Participer::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $reservation->delete();

        $place_reserver=Place_reserve::where('id_event','=',$id)->get();
        foreach ($place_reserver as $place_reserver){
            Place_reserve::destroy($place_reserver->id);
        }
        return response()->json(['message' => 'Reservation annulée']);
    }

    public function achat_place(Request $request)
    {
        $event=Place::where('id_type_place','=',$request->input('id_type_place'))
           ->where('id_event','=',$request->input('id_event'))
            ->first();
        $request->validate([
            'id_client' => 'required|integer',
            'id_event' => 'required|integer',
            'numero_place' => rand(100,999),
            'montant_place' => $event->montant_event,
        ]);

        $participation = Place_reserve::create($request->all());

        return response()->json([
            'message' => 'Participation ajoutée avec succès',
            'data' => $participation
        ], 201);
    }


    public function annuler_place($id)
    {
        $place_reserver = Place_reserve::find($id);

        if (!$place_reserver) {
            return response()->json(['message' => 'Participation non trouvée'], 404);
        }

        $place_reserver->delete();

        return response()->json(['message' => 'Participation supprimée avec succès']);
    }

    public function filter(Request $request)
    {
        $query = Evenement::query();

        if ($request->filled('event_name')) {
            $query->where('event_name', 'like', '%' . $request->event_name . '%');
        }

        if ($request->filled('pays')) {
            $query->where('pays', $request->pays);
        }

        if ($request->filled('ville')) {
            $query->where('ville', $request->ville);
        }

        if ($request->filled('idCategorie_event')) {
            $query->where('idCategorie_event', $request->idCategorie_event);
        }

        if ($request->filled('date_event')) {
            $query->whereDate('date_event', $request->date_event);
        }

        // Optionnel : filtre par heure
        if ($request->filled('heure_event')) {
            $query->whereTime('heure_event', $request->heure_event);
        }

        $resultats = $query->paginate(10); // Pagination

        return response()->json($resultats, 200);
    }
}
