@extends('Dash_file.app')
@section('title')
    Evenements
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Gestion des événements</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal"
                    id="#myBtn">
                + Ajouter
            </button>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Formulaire d'ajout d'un événement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('Add_Event')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nom événement</label>
                                    <input type="text" class="form-control" name="nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Catégorie</label>
                                    <select class="form-control" name="categorie" required>
                                        <option value="">Choisir</option>
                                        @foreach($Categorie as $categorie)
                                          <option value="{{$categorie->id}}">{{$categorie->categorie_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Pays</label>
                                    <select class="form-control" name="pays" required>
                                        <option value="">Choisir</option>
                                        @foreach($Pays as $pays)
                                          <option value="{{$pays->nom_fr_fr}}">{{$pays->nom_fr_fr}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Ville</label>
                                    <input type="text" class="form-control" name="ville" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Adresse</label>
                                    <input type="text" class="form-control" name="adresse" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Maps</label>
                                    <input type="text" class="form-control" name="maps" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Date</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Heure</label>
                                    <input type="time" class="form-control" name="heure" required>
                                </div>
                            </div><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="dataTable">
                <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Evenement</th>
                    <th>Categorie</th>
                    <th>Réservation(s)</th>
                    <th>Adresse</th>
                    <th>Date et heure</th>
                    <th>Prix des places</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                     @foreach($Event as $i=>$event)
                         <tr>
                             <td>{{$i+1}}</td>
                             <td>{{$event->event_name}}</td>
                             <td>{{$event->categorie_name}}</td>
                             <td>{{\App\Models\Place_reserve::getTotalReservation($event->id)}}</td>
                             <td>{{$event->adresse_event}}</td>
                             <td>{{$event->date_event}} à {{$event->heure_event}}</td>
                             <td>
                                 @php
                                    $Place=\App\Models\Place::where('id_event','=',$event->id)->get();
                                 @endphp
                                 @foreach($Place as $place)
                                      @php
                                        $Type_place=\App\Models\Typeplace::find($place->id_type_place);
                                      @endphp
                                    @if($Type_place) {{$Type_place->nom_type_place}} : @endif {{$place->montant_event}} Euro,
                                 @endforeach
                             </td>
                             <td>
                                 <div class="btn-group mb-1">
                                     <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                             aria-haspopup="true" aria-expanded="false">
                                         Action
                                     </button>
                                     <div class="dropdown-menu">
                                         <a class="dropdown-item" href="{{route('Participant_Event',Crypt::encrypt($event->id))}}">Voire participants</a>
                                         <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal{{$event->id}}" id="#myBtn">Modifier</a>
                                         <a class="dropdown-item" onclick="return confirm('Voulez-vous supprimé ?')" href="{{route('deleteEvent',Crypt::encrypt($event->id))}}">Supprimer</a>
                                     </div>
                                 </div>
                                 <div class="modal fade" id="exampleModal{{$event->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                      aria-hidden="true">
                                     <div class="modal-dialog" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="exampleModalLabel">Formulaire de modification de l'événement</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                 </button>
                                             </div>
                                             <div class="modal-body">
                                                 <form method="post" action="{{route('Update_Event',Crypt::encrypt($event->id))}}">
                                                     @csrf
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <label>Nom événement</label>
                                                             <input value="{{$event->event_name}}" type="text" class="form-control" name="nom" required>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label>Catégorie : {{$event->categorie_name}}</label>
                                                             <select class="form-control" name="categorie" required>
                                                                 <option value="{{$event->idCategorie_event}}">Changer</option>
                                                                 @foreach($Categorie as $categorie)
                                                                     <option value="{{$categorie->id}}">{{$categorie->categorie_name}}</option>
                                                                 @endforeach
                                                             </select>
                                                         </div>
                                                     </div>
                                                     <br>
                                                     <div class="row">
                                                         <div class="col-md-12">
                                                             <label>Description</label>
                                                             <textarea class="form-control" name="description">{{$event->event_description}}</textarea>
                                                         </div>
                                                     </div><br>
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <label>Pays : {{$event->pays}}</label>
                                                             <select class="form-control" name="pays" required>
                                                                 <option value="{{$event->pays}}">Changer</option>
                                                                 @foreach($Pays as $pays)
                                                                     <option value="{{$pays->nom_fr_fr}}">{{$pays->nom_fr_fr}}</option>
                                                                 @endforeach
                                                             </select>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label>Ville</label>
                                                             <input type="text" value="{{$event->ville}}" class="form-control" name="ville" required>
                                                         </div>
                                                     </div>
                                                     <br>
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <label>Adresse</label>
                                                             <input type="text" value="{{$event->adresse_event}}" class="form-control" name="adresse" required>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label>Maps</label>
                                                             <input type="text" value="{{$event->localisation_maps}}" class="form-control" name="maps" required>
                                                         </div>
                                                     </div>
                                                     <br>
                                                     <div class="row">
                                                         <div class="col-md-4">
                                                             <label>Date</label>
                                                             <input type="date" value="{{$event->date_event}}" class="form-control" name="date" required>
                                                         </div>
                                                         <div class="col-md-4">
                                                             <label>Heure</label>
                                                             <input type="time"  value="{{$event->heure_event}}" class="form-control" name="heure" required>
                                                         </div>
                                                         <div class="col-md-4">
                                                             <label>Status : @if($event->status_event==0) Bloqué @else Actif @endif</label>
                                                             <select class="form-control" name="status_event" required>
                                                                 <option value="{{$event->status_event}}">Changer</option>
                                                                 <option value="1">Activer</option>
                                                                 <option value="0">Bloquer</option>
                                                             </select>
                                                         </div>
                                                     </div><br>
                                                     <div class="modal-footer">
                                                         <button type="submit" class="btn btn-primary">Modifier</button>
                                                         <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </td>
                         </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection