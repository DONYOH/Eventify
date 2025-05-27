@extends('Dash_file.app')
@section('title')
    Reservation
@endsection
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Gestion des reservation</h6>
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
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div><br>
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
                    <th>Nom client</th>
                    <th>Date et heure reservation</th>
                    <th>Nombre de place</th>
                    <th>Montant</th>
                </tr>
                </thead>
                <tbody>
                   @foreach($Reservation as $i=>$reservation)
                       <tr>
                           <td>{{$i+1}}</td>
                           <td>{{$reservation->nom}} {{$reservation->prenom}}</td>
                           <td>{{$reservation->date_reservation}}</td>
                           <td>
                               @php
                                  $Place=\App\Models\Place_reserve::where('id_client','=',$reservation->id_user)->where('id_event','=',$reservation->id_event)
                                  ->get();
                               @endphp
                               {{$Place->count()}}
                           </td>
                           <td> {{$Place->sum('montant_place')}}</td>
                       </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection