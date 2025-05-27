@extends('Dash_file.app')
@section('title')
    categorie evenement
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Gestion des catégories d'évènements</h6>
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
                        <h5 class="modal-title" id="exampleModalLabel">Formulaire d'ajout des categories d'évènements</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('Add_categorie')}}">
                            @csrf
                            <label>Libelle categorie événement</label>
                            <input type="text" class="form-control" name="libelle" required><br>
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
                    <th>Evenement categorie</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($Categorie as $i=>$categorie)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$categorie->categorie_name}}</td>
                        <td>{{$categorie->description_event}}</td>
                        <td>
                            <span class="{{ $categorie->status_event == 0 ? 'text-danger' : 'text-success' }}">
                              {{ $categorie->status_event == 0 ? 'Bloqué' : 'Actif' }}
                             </span>
                        </td>
                        <td>
                            <div class="btn-group mb-1">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal{{$categorie->id}}" id="#myBtn">Modifier</a>
                                    <a class="dropdown-item" onclick="return confirm('Voulez-vous supprimé ?')" href="{{route('deleteAdmin',Crypt::encrypt($categorie->id))}}">Supprimer</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal{{$categorie->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Formulaire de modification categorie évènement</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('Update_categorie',Crypt::encrypt($categorie->id))}}">
                                                @csrf
                                                <label>Libelle categorie événement</label>
                                                <input type="text" value="{{$categorie->categorie_name}}" class="form-control" name="libelle" required><br>
                                                <label>Description</label>
                                                <textarea class="form-control" name="description">{{$categorie->description_event}}</textarea><br>
                                                <label>Status: <span class="{{ $categorie->status_event == 0 ? 'text-danger' : 'text-success' }}">
                                                  {{ $categorie->status_event == 0 ? 'Bloqué' : 'Actif' }}
                                                 </span></label>
                                                <select class="form-control" name="status" required>
                                                    <option value="{{$categorie->status_event}}">Changer</option>
                                                    <option value="0">Bloquer</option>
                                                    <option value="1">Activer</option>
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