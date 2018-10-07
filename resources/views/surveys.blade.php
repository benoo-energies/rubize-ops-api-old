
@include('shared.header', ['title' => 'Admin Benoo - Enquêtes'])
@include('shared.sidebar', ['active' => "survey"])

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->
    
    
    <div class="main-panel">
    
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Enquêtes</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (session('status'))
                        @if (session('status') == 'addSuccess')
                            <div class="alert alert-success" role="alert"><p>Le village a bien été créé.</p></div>
                        @elseif(session('status') == 'addError')
                            <div class="alert alert-danger" role="alert"><p>Le village n'a pas été créé, un village est déjà enregistré à ce nom.</p></div>
                        @elseif(session('status') == 'updateSuccess')
                            <div class="alert alert-success" role="alert"><p>Le village a été mis à jour.</p></div>
                        @elseif(session('status') == 'updateError')
                            <div class="alert alert-danger" role="alert"><p>Le village n'a pas été mis à jour, un village est déjà enregistré à ce nom.</p></div>
                        @elseif(session('status') == 'updateIdError')
                                <div class="alert alert-danger" role="alert"><p>Impossible de mettre à jour ce village.</p></div>
                        @elseif(session('status') == 'deleteError')
                            <div class="alert alert-danger" role="alert"><p>Impossible de supprimer ce village.</p></div>
                        @elseif(session('status') == 'deleteSuccess')
                            <div class="alert alert-success" role="alert"><p>Le village a bien été supprimé.</p></div>
                            
                        @elseif(session('status') == 'addSuccessEnq')
                        <div class="alert alert-success" role="alert"><p>L'enquêteur a bien été créé.</p></div>
                        @elseif(session('status') == 'addErrorEnq')
                            <div class="alert alert-danger" role="alert"><p>L'enquêteur n'a pas été créé, un enquêteur est déjà enregistré à ce nom.</p></div>
                        @elseif(session('status') == 'updateSuccessEnq')
                            <div class="alert alert-success" role="alert"><p>L'enquêteur a été mis à jour.</p></div>
                        @elseif(session('status') == 'updateErrorEnq')
                            <div class="alert alert-danger" role="alert"><p>L'enquêteur n'a pas été mis à jour, un enquêteur est déjà enregistré à ce nom.</p></div>
                        @elseif(session('status') == 'updateIdErrorEnq')
                                <div class="alert alert-danger" role="alert"><p>Impossible de mettre à jour cet enquêteur.</p></div>
                        @elseif(session('status') == 'deleteErrorEnq')
                            <div class="alert alert-danger" role="alert"><p>Impossible de supprimer cet enquêteur.</p></div>
                        @elseif(session('status') == 'deleteSuccessEnq')
                            <div class="alert alert-success" role="alert"><p>L'enquêteur a bien été supprimé.</p></div>
                        @endif
                    @endif
                    <div class="col-md-12 text-center">
                        <form method="POST" action="/surveys/export/all">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-warning btn-fill btn-lg margin-bottom"><i class="ti-download"></i> Exporter toutes les enquêtes</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Export par entrepreneur</h4>
                                <form method="POST" action="/surveys/export/entrepreneur">
                                    {{ csrf_field() }}
                                    <div class="form-group sm-margin-top">
                                        <input type="number" class="form-control form-control-lg" id="idEntrepreneur" name="idEntrepreneur" aria-describedby="emailHelp" placeholder="Numéro entrepreneur">
                                    </div>
                                    <button type="submit" class="btn btn-info btn-fill">Exporter les enquêtes</button>
                                                    
                                </form>                                                        
                            </div>
                            <div class="content">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Export par prospect</h4>
                                    <form method="POST" action="/surveys/export/prospect">
                                        {{ csrf_field() }}
                                        <div class="form-group sm-margin-top">
                                            <input type="number" class="form-control form-control-lg" id="idProspect" name="idProspect" aria-describedby="emailHelp" placeholder="Numéro prospect">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-fill">Exporter les enquêtes</button>
                                                        
                                    </form>   
                            </div>
                            <div class="content">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <div class="col-md-12 margin-bottom">

                                    <h4 class="title">Gestion des villages enquêtés</h4>   
                                </div>
                                <div class="col-md-12  margin-bottom">
                                    <form method="POST" action="/village/add" class="form-inline">
                                        {{ csrf_field() }}
                                        <div class="form-group {{-- sm-margin-top --}}">
                                            <label for="village">Ajouter un village : </label>
                                            <input type="text" class="form-control form-control-lg" id="village" name="village" placeholder="Village">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-fill">Ajouter</button>
                                    </form>                                 
                                </div>
                            </div>
                            <div class="content text-right">
                                <table class="table table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Village</th>
                                    </thead>
                                    <tbody>
                                        @if(count($villages) > 0)
                                            @foreach ($villages as $village)
                                                <tr>
                                                    <form method="POST" action="/village/update/{{$village->id}}">
                                                        {{ csrf_field() }}
                                                        <td>{{$village->id}}</td>
                                                        
                                                        <td><input type="text" class="form-control" name="village" id="village" value="{{$village->name}}" placeholder=""></td>
                                                        
                                                        <td><button type="submit" class="btn btn-info btn-fill"><i class="ti-save"></i></button></td>
                                                    </form>
                                                    <td>
                                                        <form method="POST" action="/village/delete/{{$village->id}}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce village ?');">
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-fill"><i class="ti-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" align="center">
                                                    Aucun village enregistré actuellement.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="header">
                                <div class="col-md-12 margin-bottom">
                                    <h4 class="title">Gestion des enquêteurs</h4>   
                                </div>
                                <div class="col-md-12 margin-bottom">
                                    <form method="POST" action="/enqueteur/add" class="form-inline">
                                        {{ csrf_field() }}
                                        <div class="form-group {{-- sm-margin-top --}}">
                                            <label for="village">Ajouter un enquêteur : </label>
                                            <input type="text" class="form-control form-control-lg" id="enqueteur" name="enqueteur" placeholder="Nom enquêteur">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-fill">Ajouter</button>
                                    </form>                                 
                                </div>
                            </div>
                            <div class="content text-right">
                                <table class="table table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Enquêteur</th>
                                    </thead>
                                    <tbody>
                                        @if(count($enqueteurs) > 0)
                                            @foreach ($enqueteurs as $enqueteur)
                                                <tr>
                                                    <form method="POST" action="/enqueteur/update/{{$enqueteur->id}}">
                                                        {{ csrf_field() }}
                                                        <td>{{$enqueteur->id}}</td>
                                                        
                                                        <td><input type="text" class="form-control" name="enqueteur" id="enqueteur" value="{{$enqueteur->name}}" placeholder=""></td>
                                                        
                                                        <td><button type="submit" class="btn btn-info btn-fill"><i class="ti-save"></i></button></td>
                                                    </form>
                                                    <td>
                                                        <form method="POST" action="/enqueteur/delete/{{$enqueteur->id}}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enquêteur ?');">
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-fill"><i class="ti-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" align="center">
                                                    Aucun enquêteur enregistré actuellement.
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