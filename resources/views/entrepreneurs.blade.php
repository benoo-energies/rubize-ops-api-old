
@include('shared.header', ['title' => 'Admin Benoo - Entrepreneurs'])
@include('shared.sidebar', ['active' => "entrepreneur"])

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->
    
    
    <div class="main-panel">
    
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Entrepreneurs</a>
                </div>
                
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                            <a href="/entrepreneur/profile/create" class="btn btn-warning btn-fill btn-lg margin-bottom">
                                <i class="ti-plus"></i> Ajouter un entrepreneur
                            </a>
                        </div>
                        <div class="col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">Entrepreneurs actifs ({{count($entrepreneurs)}})</h4>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-striped">
                                            <thead>
                                                <th>#</th>
                                                <th>Numéro</th>
                                                <th>Nom</th>
                                                <th>Prénom</th>
                                                <th>Enquêtes</th>
                                                <th>Clients</th>
                                                <th>Ventes</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                            </thead>
                                            <tbody>
                                                @if(count($entrepreneurs) > 0)
                                                    @foreach ($entrepreneurs as $ent)
                                                        <tr>
                                                            <td>{{$ent->id}}</td>
                                                            <td>{{$ent->telephone}}</td>
                                                            <td>{{$ent->lastname}}</td>
                                                            <td>{{$ent->firstname}}</td>
                                                            <td>{{$ent->surveys()->where('status', 1)->count()}}</td>
                                                            <td>{{$ent->customers()->where('status', 1)->count()}}</td>
                                                            <td>{{$ent->orders()->where('status', 1)->count()}}</td>
                                                            <td><a href="/entrepreneur/profile/{{$ent->id}}" class="btn btn-info btn-fill"><i class="ti-pencil"></i></a></td>
                                                            <td>
                                                                <form method="POST" action="/entrepreneur/profile/delete/{{$ent->id}}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet entrepreneur ?');">
                                                                    {{ csrf_field() }}
                                                                    <button type="submit" class="btn btn-danger btn-fill"><i class="ti-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="7" align="center">
                                                        Aucun entrepreneur enregistré actuellement.
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
        
                                    </div>
                                </div>
                            </div>

                
                </div>
            </div>
        </div>
    </div>

@include('shared.footer')