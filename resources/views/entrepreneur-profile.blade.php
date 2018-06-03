
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
                    @if(isset($entrepreneur))
                        <form method="POST" action="{{ '/entrepreneur/profile/update/'.$entrepreneur->id }}">
                    @else
                        <form method="POST" action="{{ '/entrepreneur/profile/create' }}">
                    @endif
                    <form method="POST" action="#">
                        <div class="col-md-12">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="tagpay_id" class="col-sm-4 col-form-label">ID Tagpay</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="tagpay_id" name="tagpay_id" @if(isset($entrepreneur))value="{{$entrepreneur->tagpay_id}}" @endif placeholder="ID Tagpay">
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
                            <p>Type de service prorposé</p>
                            @if(count($services) > 0)
                                @foreach($services as $serv)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="serviceType{{$serv->id}}" value="{{$serv->id}}" name='serviceType[]' @if(isset($entrepreneur) && $entrepreneur->services != '' && NULL != $entrepreneur->services && in_array($serv->id.'', explode(',', $entrepreneur->services))) checked @endif>
                                    <label class="form-check-label" for="serviceType{{$serv->id}}">{{$serv->title}}</label>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @if(isset($entrepreneur))
                            <button type="submit" class="btn btn-info btn-fill margin-top btn-lg">Enregistrer l'entrepreneur  </button>
                        @else
                            <button type="submit" class="btn btn-info btn-fill margin-top btn-lg">Enregistrer l'entrepreneur  </button>
                        @endif
                    </form>   
                </div>
            </div>
        </div>
    </div>

@include('shared.footer')