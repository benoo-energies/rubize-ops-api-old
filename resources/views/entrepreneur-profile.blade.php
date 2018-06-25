
@include('shared.header', ['title' => 'Admin Benoo - Fiche entrepreneur'])
@include('shared.sidebar', ['active' => "entrepreneur"])

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->
    
    
    <div class="main-panel">
    
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    @if(isset($entrepreneur))
                    <a class="navbar-brand" href="#">{{$entrepreneur->firstname}} {{$entrepreneur->lastname}}</a>
                    @else
                    <a class="navbar-brand" href="#">Nouvel entrepreneur</a>
                    @endif
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (session('status'))
                        @if (session('status') == 'done')
                            <div class="alert alert-success" role="alert">
                                <p>Le mot de passe a bien été réinitialisé.</p>
                            </div>
                        @else 
                            <div class="alert alert-danger" role="alert">
                                <p>Une erreur s'est produite lors de le réinitialisation du mot de passe.</p>
                            </div>
                        @endif
                    @endif
                    @if(isset($entrepreneur))
                        <form method="POST" action="{{ '/entrepreneur/profile/update/'.$entrepreneur->id }}">
                    @else
                        <form method="POST" action="{{ '/entrepreneur/profile/create' }}">
                    @endif
                        <div class="col-md-12">
                            <h3>Informations client</h3>
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="tagpay_id" class="col-sm-4 col-form-label">ID Tagpay</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="tagpay_id" name="tagpay_id" @if(isset($entrepreneur))value="{{$entrepreneur->tagpay_id}}" @endif placeholder="ID Tagpay">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label">Mot de passe</label>
                                <div class="col-sm-4">
                                    @if(isset($entrepreneur))
                                <a href="#" class="btn btn-danger btn-fill" data-toggle="modal" data-target="#confirm-password">Réinitialiser le mot de passe</a>
                                    @else
                                        <input type="text" class="form-control" id="password" name="password" placeholder="Mot de passe" value="{{$randPin}}">
                                    @endif
                                    </div>
                                </div>                            
                            <div class="form-group row">
                                <label for="firstname" class="col-sm-4 col-form-label">Prénom</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="firstname" name="firstname" @if(isset($entrepreneur))value='{{$entrepreneur->firstname}}' @endif placeholder="Prénom">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastname" class="col-sm-4 col-form-label">Nom</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="lastname" name="lastname" @if(isset($entrepreneur)) value="{{$entrepreneur->lastname}}" @endif placeholder="Nom">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-4 col-form-label">Téléphone</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="telephone" name="telephone" @if(isset($entrepreneur))value="{{$entrepreneur->telephone}}" @endif placeholder="Téléphone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="longitude" name="longitude" @if(isset($entrepreneur))value="{{$entrepreneur->longitude}}" @endif placeholder="Longitude">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="latitude" class="col-sm-4 col-form-label">Latitude</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="latitude" name="latitude" @if(isset($entrepreneur))value="{{$entrepreneur->latitude}}" @endif placeholder="Latitude">
                                </div>
                            </div>
                            
                            <h3>Services proposés</h3>
                            @if(count($services) > 0)
                                @foreach($services as $serv)
                                    <label class="checkbox-inline">
                                        <input class="form-check-input" type="checkbox" id="serviceType{{$serv->id}}" value="{{$serv->id}}" name='serviceType[]' @if(isset($entrepreneur) && $entrepreneur->services != '' && NULL != $entrepreneur->services && in_array($serv->id.'', explode(',', $entrepreneur->services))) checked @endif>{{$serv->title}}
                                    </label>
                                @endforeach
                            @endif
                            @if(isset($products))
                                <h3>Tarifs produits</h3>
                                @if(count($products) > 0)
                                    @foreach($products as $product)

                                        <div class="form-group">
                                            <label for="service_{{$product->id}}" class="col-sm-4 col-md-2 col-form-label">{{$product->title}}</label>
                                            <div class="col-sm-4 col-md-2">
                                                <input type="number" step="any" class="form-control" id="service_" name="service_{{$product->id}}" value="@if(isset($entrepreneur)){{$product->entrepreneurPrice($entrepreneur->id)}}@else{{$product->entrepreneurPrice(0)}}@endif" placeholder="0.00">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif

                            <div class="clearfix"></div>

                            @if(isset($entrepreneur))
                                <button type="submit" class="btn btn-info btn-fill margin-top btn-lg">Enregistrer l'entrepreneur  </button>
                            @else
                                <button type="submit" class="btn btn-info btn-fill margin-top btn-lg">Enregistrer l'entrepreneur  </button>
                            @endif
                        </div>
                    </form>   
                </div>
            </div>
        </div>
    </div>

    @if(isset($entrepreneur))
    <div class="modal fade" id="confirm-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Réinitialisation de mot de passe</h6>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Etes-vous sûr de vouloir réinitialiser le mot de passe de l'entrepreneur<br>"{{$entrepreneur->firstname." ".$entrepreneur->lastname}}" ?</p>
                        <h4 class="text-center">Le nouveau de passe sera : {{$randPin}}</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="/entrepreneur/password/{{$entrepreneur->id}}" method="POST">
                            {{ csrf_field() }}
                            <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                            <input type="text" name="password" id="password" value="{{$randPin}}" class="hidden">
                            <input type="text" name="entrepreneurId" id="entrepreneurId" value="{{$entrepreneur->id}}" class="hidden">
                            <button type="submit" class="btn btn-danger btn-fill">Réinitialiser</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@include('shared.footer')