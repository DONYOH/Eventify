@extends('Dash_file.app')
@section('title')
    Place
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Gestion des prix des places</h6>
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
                        <h5 class="modal-title" id="exampleModalLabel">Formulaire du prix des places par événement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('Add_Price')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Evenement</label>
                                    <select class="form-control" name="evenement" required>
                                        <option value="">Choisir</option>
                                        @foreach($Event as $event)
                                            <option title="{{$event->event_description}}" value="{{$event->id}}">{{$event->event_name}} - {{$event->categorie_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Type de place</label>
                                    <select class="form-control" name="type_place" required>
                                        <option value="">Choisir</option>
                                        @foreach($Type_place as $type_place)
                                            <option value="{{$type_place->id}}">{{$type_place->nom_type_place}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><br>
                            <label>Montant ( Euro )</label>
                            <input type="number" min="0" class="form-control" name="montant" required><br>
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
                    <th>Place</th>
                    <th>Prix</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                     @foreach($Prix as $i=>$prix)
                         <tr>
                             <td>{{$i+1}}</td>
                             <td>{{$prix->event_name}}</td>
                             <td>{{$prix->nom_type_place}}</td>
                             <td>{{$prix->montant_event}}</td>
                             <td>@if($prix->status_place==0) bloqué @else Actif @endif</td>
                             <td>
                                 <div class="btn-group mb-1">
                                     <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                             aria-haspopup="true" aria-expanded="false">
                                         Action
                                     </button>
                                     <div class="dropdown-menu">
                                         <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal{{$prix->id}}" id="#myBtn">Modifier</a>
                                         <a class="dropdown-item" onclick="return confirm('Voulez-vous supprimé ?')" href="{{route('deletePrice',Crypt::encrypt($prix->id))}}">Supprimer</a>
                                     </div>
                                 </div>
                                 <div class="modal fade" id="exampleModal{{$prix->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                      aria-hidden="true">
                                     <div class="modal-dialog" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="exampleModalLabel">Formulaire modification du prix des places événement</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                 </button>
                                             </div>
                                             <div class="modal-body">
                                                 <form method="post" action="{{route('Update_Price',Crypt::encrypt($prix->id))}}">
                                                     @csrf
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <label>Evenement : {{$prix->event_name}}</label>
                                                             <select class="form-control" name="evenement" required>
                                                                 <option value="{{$prix->id_event}}">Changer</option>
                                                                 @foreach($Event as $event)
                                                                     <option title="{{$event->event_description}}" value="{{$event->id}}">{{$event->event_name}} - {{$event->categorie_name}}</option>
                                                                 @endforeach
                                                             </select>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label>Type de place : {{$prix->nom_type_place}}</label>
                                                             <select class="form-control" name="type_place" required>
                                                                 <option value="{{$prix->id_type_place}}">Changer</option>
                                                                 @foreach($Type_place as $type_place)
                                                                     <option value="{{$type_place->id}}">{{$type_place->nom_type_place}}</option>
                                                                 @endforeach
                                                             </select>
                                                         </div>
                                                     </div><br>
                                                     <div class="row">
                                                         <div class="col-md-6">
                                                             <label>Montant ( Euro )</label>
                                                             <input value="{{$prix->montant_event}}" type="number" min="0" class="form-control" name="montant" required>
                                                         </div>
                                                         <div class="col-md-6">
                                                             <label>Status : @if($prix->status_place==0) bloqué @else Actif @endif</label>
                                                             <select class="form-control" name="status" required>
                                                                 <option value="">Choisir</option>
                                                                 <option value="1">Activer</option>
                                                                 <option value="0">Bloquer</option>
                                                             </select>
                                                         </div>
                                                     </div>
                                                    <br>
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