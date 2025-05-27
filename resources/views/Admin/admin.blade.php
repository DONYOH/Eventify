@extends('Dash_file.app')
@section('title')
    Admins
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Gestion des administrateurs</h6>
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
                        <h5 class="modal-title" id="exampleModalLabel">Formulaire d'ajout d'un administrateur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('Add_Admin')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nom</label>
                                    <input type="text" class="form-control" name="nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Prenom</label>
                                    <input type="text" class="form-control" name="prenom" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Type utilisateur</label>
                                    <select class="form-control" name="role" required>
                                        <option value="">Choisir</option>
                                        <option value="Super Admin">Super Admin</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Modérateur">Modérateur</option>
                                    </select>
                                </div>
                            </div>
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
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Role</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($User as $i=>$user)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$user->nom}}</td>
                    <td>{{$user->prenom}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$user->email}}</td>
                    <td><span class="{{ $user->status == 0 ? 'text-danger' : 'text-success' }}">
                       {{ $user->status == 0 ? 'Bloqué' : 'Actif' }}
                    </span>
                    </td>
                    <td>
                        <div class="btn-group mb-1">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal{{$user->id}}" id="#myBtn">Modifier</a>
                                <a class="dropdown-item" onclick="return confirm('Voulez-vous supprimé ?')" href="{{route('deleteUser',Crypt::encrypt($user->id))}}">Supprimer</a>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Formulaire de modification administrateur</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{route('Update_Admin',Crypt::encrypt($user->id))}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Nom</label>
                                                    <input value="{{$user->nom}}" type="text" class="form-control" name="nom" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Prenom</label>
                                                    <input value="{{$user->prenom}}" type="text" class="form-control" name="prenom" required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Status :
                                                        <span class="{{ $user->status == 0 ? 'text-danger' : 'text-success' }}">{{ $user->status == 0 ? 'Bloqué' : 'Actif' }}</span></label>
                                                    <select class="form-control" name="status" required>
                                                        <option value="{{$user->status}}">Changer</option>
                                                        <option value="1">Activer</option>
                                                        <option value="0">Bloquer</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Type utilisateur: {{$user->role}}</label>
                                                    <select class="form-control" name="role" required>
                                                        <option value="{{$user->role}}">Changer</option>
                                                        <option value="Super Admin">Super Admin</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Modérateur">Modérateur</option>
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>E-mail</label>
                                                    <input value="{{$user->email}}" type="email" class="form-control" name="email" readonly>
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