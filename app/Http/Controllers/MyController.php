<?php

namespace App\Http\Controllers;

use App\Models\Categorie_event;
use App\Models\Evenement;
use App\Models\Place;
use App\Models\Place_reserve;
use App\Models\Typeplace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\Routing\Matcher\Dumper\getCommonPrefix;

class MyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function deconnexion(){
        Auth::logout();
        return redirect('login');
    }
    public function TableauBord(){
        return view('Admin.tb');
    }

    public function Admin(){
        $User=User::where('role','<>',"client")->get();
        return view('Admin.admin',compact('User'));
    }

    public function Add_Admin(Request $request){
          $add=new User();
          $add->nom=strtoupper($request->input('nom'));
          $add->prenom=$request->input('prenom');
          $add->status=1;
          $add->email=$request->input('email');
          $add->password=Hash::make("1234");
          $add->role=$request->input('role');
          //vérification du doublon
          $doublon=User::where('email','=',$add->email)->get();
          if($doublon->count()>0){
              return back()->with("error","Désolé, ce mail est a été attribué à un autre compte.");
          }else{
              $add->save();
              return back()->with("success","Le compte de $add->nom $add->prenom a été créer avec succès en tant que $add->role.");
          }
    }

    public function Update_Admin(Request $request,$id){
        $add = User::find(decrypt($id));
        $add->nom = strtoupper($request->input('nom'));
        $add->prenom = $request->input('prenom');
        $add->status = $request->input('status');
        $add->role = $request->input('role');
        $add->email = $request->input('email');
        // Vérification du doublon d'email
        $emailDoublon = User::where('email', $add->email)
            ->where('id', '!=', $add->id)
            ->exists();

        if ($emailDoublon) {
            return back()->with("error", "Désolé, cet e-mail est déjà attribué à un autre compte.");
        }

        // Vérification du doublon nom + prénom
        $nomPrenomDoublon = User::where('nom', $add->nom)
            ->where('prenom', $add->prenom)
            ->where('id', '!=', $add->id)
            ->exists();

        if ($nomPrenomDoublon) {
            return back()->with("error", "Un utilisateur avec le même nom et prénom existe déjà.");
        }
        // Si tout est bon, on sauvegarde
        $add->save();
        return back()->with("success", "Admin $add->nom $add->prenom a été modifié avec succès en tant que $add->role.");

    }

    public function deleteUser($id){
        User::destroy(decrypt($id));
        return back()->with("success","Utilisateur supprimé avec succès.");
    }

    public function Type_place(){
        $Type=Typeplace::OrderBy('nom_type_place','asc')->get();
        return view('Place.type',compact('Type'));
    }

    public function Add_type_place(Request $request){
          $add=new Typeplace();
          $add->nom_type_place=$request->input('nom');
          $add->description_type_place=$request->input('description');
          //vérification du doublon
          $doublon=Typeplace::where('nom_type_place','=',$add->nom_type_place)->get();
          if($doublon->count()>0){
              return back()->with("error","Désolé, le type de place existe déjà.");
          }else{
              $add->save();
              return back()->with("success","Type de place $add->nom_type_place ajouté avec succès.");
          }
    }

    public function Update_type_place(Request $request,$id){
        $add=Typeplace::find(decrypt($id));
        $add->nom_type_place=$request->input('nom');
        $add->description_type_place=$request->input('description');
        $add->status_type_place=$request->input('status');
        //vérification du doublon
        $doublon=Typeplace::where('nom_type_place','=',$add->nom_type_place)->get();
        if($doublon->count()>1){
            return back()->with("error","Désolé, le type de place $add->nom_type_place existe déjà.");
        }else{
            $add->save();
            return back()->with("success","Type de place $add->nom_type_place modifié avec succès.");
        }
    }

    public function deleteTypePlace($id){
        Typeplace::destroy(decrypt($id));
        return back()->with("success","Type de place supprimé avec succès.");
    }

    public function Categorie_event(){
        $Categorie=Categorie_event::OrderBy('categorie_name','asc')->get();
        return view('Evenement.categorie',compact('Categorie'));
    }

    public function Add_categorie(Request $request){
        $add=new Categorie_event();
        $add->categorie_name=$request->input('libelle');
        $add->description_event=$request->input('description');
        //vérification doublon
        $doublon=Categorie_event::where('categorie_name','=',$add->categorie_name)->get();
        if($doublon->count()>0){
            return back()->with("error","Désolé, catégorie de l'evenement $add->categorie_name existe déjà.");
        }else{
            $add->save();
            return back()->with("success","Catégorie d'événement $add->categorie_name ajouté avec succès.");
        }
    }

    public function Update_categorie(Request $request,$id){
        $add=Categorie_event::find(decrypt($id));
        $add->categorie_name=$request->input('libelle');
        $add->description_event=$request->input('description');
        $add->status_event=$request->input('status');
        //vérification doublon
        $doublon=Categorie_event::where('categorie_name','=',$add->categorie_name)->get();
        if($doublon->count()>1){
            return back()->with("error","Désolé, catégorie de l'evenement $add->categorie_name existe déjà.");
        }else{
            $add->save();
            return back()->with("success","Catégorie d'événement $add->categorie_name modifié avec succès.");
        }
    }

    public function deleteAdmin($id){
        Categorie_event::destroy(decrypt($id));
        return back()->with("success","Catégorie d'événement supprimé avec succès.");
    }

    public function Evenement(){
        $Pays=DB::table('pays')->OrderBy('nom_fr_fr','asc')->get();
        $Categorie=Categorie_event::OrderBy('categorie_name','asc')->get();
        $Event=DB::table('evenements')
            ->join('categorie_events','evenements.idCategorie_event','=','categorie_events.id')
            ->select('evenements.*','categorie_events.categorie_name as categorie_name')
            ->OrderBy('evenements.id','desc')->get();

        return view('Evenement.add',compact('Pays','Categorie','Event'));
    }

    public function Participant_Event($id){
        $Reservation=DB::table('participers')
              ->join('users','participers.id_user','=','users.id')
              ->join('evenements','participers.id_event','=','evenements.id')
              ->select('participers.*','users.nom as nom','users.prenom as prenom','evenements.event_name as event_name')
              ->where('participers.id_event','=',decrypt($id))
              ->get();
        return view('Evenement.reservation',compact('Reservation'));
    }

    public function Client(){
        $User=User::where('role','=',"client")->get();
        return view('Admin.client',compact('User'));
    }
    public function Add_Event(Request $request){
           $add=new  Evenement();
           $add->event_name=$request->input('nom');
           $add->event_description=$request->input('description');
            $add->pays=$request->input('pays');
            $add->ville=$request->input('ville');
            $add->localisation_maps=$request->input('maps');
            $add->adresse_event=$request->input('adresse');
            $add->idCategorie_event=$request->input('categorie');
            $add->heure_event=$request->input('heure');
            $add->date_event=$request->input('date');
            //vérification
            $doublon=Evenement::where('event_name','=',$add->event_name)->get();
            if($doublon->count()>0){
                return back()->with("error","Désolé, cet évenement $add->event_name existe déjà.");
            }else{
                if($add->date_event>date('Y-m-d')){
                    $add->save();
                    return back()->with("success","$add->event_name ajouté avec succès.");
                }else{
                    return back()->with("error","Désolé, $add->event_name est programmé sur une date déjà passé.");
                }
            }
        }

        public function Update_Event(Request $request,$id){
            $add=Evenement::find(decrypt($id));
            $add->event_name=$request->input('nom');
            $add->event_description=$request->input('description');
            $add->pays=$request->input('pays');
            $add->ville=$request->input('ville');
            $add->localisation_maps=$request->input('maps');
            $add->adresse_event=$request->input('adresse');
            $add->idCategorie_event=$request->input('categorie');
            $add->heure_event=$request->input('heure');
            $add->date_event=$request->input('date');
            $add->status_event=$request->input('status_event');
            //vérification
            $doublon=Evenement::where('event_name','=',$add->event_name)->get();
            if($doublon->count()>1){
                return back()->with("error","Désolé, cet évenement $add->event_name existe déjà.");
            }else{
                if($add->date_event>date('Y-m-d')){
                    $add->save();
                    return back()->with("success","$add->event_name modifié avec succès.");
                }else{
                    return back()->with("error","Désolé, $add->event_name est programmé sur une date déjà passé.");
                }
            }
        }

        public function deleteEvent($id){
             Evenement::destroy(decrypt($id));
            return back()->with("success","Evenement supprimé avec succès.");
        }

    public function Place(){
        $Event=DB::table('evenements')
            ->join('categorie_events','evenements.idCategorie_event','=','categorie_events.id')
            ->select('evenements.*','categorie_events.categorie_name as categorie_name')
            ->where('evenements.date_event','>',date('Y-m-d'))
            ->where('evenements.status_event','=',1)
            ->OrderBy('evenements.id','desc')->get();

        $Type_place=Typeplace::where('status_type_place','=',1)->get();

        $Prix=DB::table('places')
            ->join('typeplaces','places.id_type_place','=','typeplaces.id')
            ->join('evenements','places.id_event','=','evenements.id')
            ->select('places.*','typeplaces.nom_type_place as nom_type_place','evenements.event_name as event_name')
            ->get();
        return view('Place.add',compact('Event','Type_place','Prix'));
    }

    public function Add_Price(Request $request){
         $add=new Place();
         $add->id_event=$request->input('evenement');
         $add->id_type_place=$request->input('type_place');
         $add->montant_event=$request->input('montant');
         //vérification du doublon
          $doublon=Place::where('id_event','=',$add->id_event)
              ->where('id_type_place','=',$add->id_type_place)
              ->get();
          if($doublon->count()>0){
              return back()->with("error","Désolé, la place a été ajouté.");
          }else{
              $add->save();
              return back()->with("success","Le prix pour la place a été attribué avec succès.");
          }
    }

    public function Update_Price(Request $request,$id){
        $add=Place::find(decrypt($id));
        $add->id_event=$request->input('evenement');
        $add->id_type_place=$request->input('type_place');
        $add->montant_event=$request->input('montant');
        $add->status_place=$request->input('status');
        //vérification du doublon
        $doublon=Place::where('id_event','=',$add->id_event)
            ->where('id_type_place','=',$add->id_type_place)
            ->get();
        if($doublon->count()>1){
            return back()->with("error","Désolé, la place a été ajouté.");
        }else{
            $add->save();
            return back()->with("success","Modification reussit avec succès.");
        }
    }

    public function deletePrice($id){
         Place::find(decrypt($id));
        return back()->with("success","Prix supprimé avec succès.");
    }


}
