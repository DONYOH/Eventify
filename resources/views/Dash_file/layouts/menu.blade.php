<li class="nav-item">
    <a class="nav-link" href="{{route('TableauBord')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
       aria-controls="collapsePage">
        <i class="fas fa-fw fa-columns"></i>
        <span>Gestion des utilisateurs</span>
    </a>
    <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('Admin')}}">Admins</a>
            <a class="collapse-item" href="{{route('Client')}}">Clients</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
       aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="far fa-fw fa-window-maximize"></i>
        <span>Gestion des places</span>
    </a>
    <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('Type_place')}}">Types de places</a>
            <a class="collapse-item" href="{{route('Place')}}">Prix des places</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
       aria-controls="collapseForm">
        <i class="fab fa-fw fa-wpforms"></i>
        <span>Gestion des évènements</span>
    </a>
    <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('Categorie_event')}}">Categories</a>
            <a class="collapse-item" href="{{route('Evenement')}}">Evenements</a>
        </div>
    </div>
</li>