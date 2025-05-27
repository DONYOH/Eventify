@extends('Dash_file.app')
@section('title')
    Types de places
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Gestion des types de places</h6>
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
                        <h5 class="modal-title" id="exampleModalLabel">Formulaire d'ajout du type de place</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('Add_type_place')}}">
                            @csrf
                            <label>Libelle type de place</label>
                            <input type="text" class="form-control" name="nom" required><br>
                            <label>Description</label>
                            <textarea class="form-control" name="description"></textarea><br>
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
                    <th>Libelle type de place</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($Type as $i=>$type)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$type->nom_type_place}}</td>
                        <td>{{$type->description_type_place}}</td>
                        <td>
                            <span class="{{ $type->status_type_place == 0 ? 'text-danger' : 'text-success' }}">
                            {{ $type->status_type_place == 0 ? 'Bloqué' : 'Actif' }}
                          </span></td>
                        <td>
                            <div class="btn-group mb-1">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal{{$type->id}}" id="#myBtn">Modifier</a>
                                    <a class="dropdown-item" onclick="return confirm('Voulez-vous supprimé ?')" href="{{route('deleteTypePlace',Crypt::encrypt($type->id))}}">Supprimer</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal{{$type->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Formulaire de modification du type de place</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('Update_type_place',Crypt::encrypt($type->id))}}">
                                                @csrf
                                                <label>Libelle type de place</label>
                                                <input type="text" value="{{$type->nom_type_place}}" class="form-control" name="nom" required><br>
                                                <label>Description</label>
                                                <textarea class="form-control" name="description">{{$type->description_type_place}}</textarea><br>
                                                <label>Status :  <span class="{{ $type->status_type_place == 0 ? 'text-danger' : 'text-success' }}">
                                                 {{ $type->status_type_place == 0 ? 'Bloqué' : 'Actif' }}
                                                 </span></label>
                                                <select class="form-control" name="status" required>
                                                    <option value="{{$type->status_type_place}}">Changer</option>
                                                    <option value="1">Activer</option>
                                                    <option value="0">Bloquer</option>
                                                </select><br>
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