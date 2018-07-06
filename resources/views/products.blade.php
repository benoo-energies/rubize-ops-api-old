
@include('shared.header', ['title' => 'Admin Benoo - Produits'])
@include('shared.sidebar', ['active' => "product"])

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->
    
    
    <div class="main-panel">
    
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Produits</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Liste des produits actifs</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <div class="col-sm-12 createProduct margin-bottom">
                                    
                                    <form class="form-inline" method="POST" action="/product/create">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="title">Titre : </label>
                                            <input type="text" class="form-control mb-5 mr-sm-5" id="title" placeholder="" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label for="service_type_id">Catégorie : </label>
                                            @if(count($serviceType) > 0)
                                            <select class="form-control" id="service_type_id" name="service_type_id">
                                                @foreach($serviceType as $serv)
                                                <option value="{{$serv->id}}">{{$serv->title}}</option>
                                                @endforeach
                                            </select>
                                            @endif                                        
                                        </div>
                                        <div class="form-group">
                                            <label for="service_type_id">Image : </label>
                                            <select class="form-control" id="picture" name="picture">
                                                <option value="batterie.jpg">Batterie</option>
                                                <option value="biere.jpg">Bière</option>
                                                <option value="bureautique.jpg">Bureautique</option>
                                                <option value="cinema.jpg">Cinéma</option>
                                                <option value="cybercafe.jpg">Cyber Café</option>
                                                <option value="froid.jpg">Froid</option>
                                                <option value="grand-kit.jpg">Grand kit</option>
                                                <option value="impression.jpg">Impression</option>
                                                <option value="kit-autonome.jpg">Kit autonome</option>
                                                <option value="lampe.jpg">Lampe</option>
                                                <option value="moyen-kit.jpg">Moyen Kit</option>
                                                <option value="multimedia.jpg">Multimédia</option>
                                                <option value="petite-lampe.jpg">Petite lampe</option>
                                                <option value="photocopie.jpg">Photocopie</option>
                                                <option value="recharge.jpg">Recharge</option>
                                                <option value="scanner.jpg">Scanner</option>
                                                <option value="soda.jpg">Soda</option>
                                                <option value="telephone.jpg">Telephone</option>
                                                <option value="viande.jpg">Viande</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="price_fcfa">Prix (Fcfa) : </label>
                                            <input type="text" class="form-control mb-2 mr-sm-2" id="price_fcfa" placeholder="" name="price_fcfa">
                                        </div>
     
                                        <button type="submit" class="btn btn-warning btn-fill mb-2">Créer le produit</button>
                                    </form>
                                </div>
                                
                                <table class="table table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Titre</th>
                                        <th>Catégorie</th>
                                        <th>Image</th>
                                        <th>Prix (Fcfa)</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </thead>
                                    <tbody>
                                        @if(count($products) > 0)
                                            @foreach ($products as $prod)
                                                <tr>
                                                    <form method="POST" action="/product/update/{{$prod->id}}">
                                                        {{ csrf_field() }}
                                                        <td>{{$prod->id}}</td>
                                                        <td><input type="text" name="title" class="form-control" id="title" value="{{$prod->title}}" placeholder=""></td>
                                                        <td>
                                                            @if(count($serviceType) > 0)
                                                                <select class="form-control" id="service_type_id" name="service_type_id">
                                                                @foreach($serviceType as $serv)
                                                                    <option value="{{$serv->id}}" @if($serv->id == $prod->service_type_id) selected @endif >{{$serv->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select class="form-control" id="picture" name="picture">
                                                                <option value="batterie.jpg" @if($prod->picture == 'batterie.jpg') selected @endif >Batterie</option>
                                                                <option value="biere.jpg" @if($prod->picture == 'biere.jpg') selected @endif >Bière</option>
                                                                <option value="bureautique.jpg" @if($prod->picture == 'bureautique.jpg') selected @endif >Bureautique</option>
                                                                <option value="cinema.jpg" @if($prod->picture == 'cinema.jpg') selected @endif >Cinéma</option>
                                                                <option value="cybercafe.jpg" @if($prod->picture == 'cybercafe.jpg') selected @endif >Cyber Café</option>
                                                                <option value="froid.jpg" @if($prod->picture == 'froid.jpg') selected @endif >Froid</option>
                                                                <option value="grand-kit.jpg" @if($prod->picture == 'grand-kit.jpg') selected @endif >Grand kit</option>
                                                                <option value="impression.jpg" @if($prod->picture == 'impression.jpg') selected @endif >Impression</option>
                                                                <option value="kit-autonome.jpg" @if($prod->picture == 'kit-autonome.jpg') selected @endif >Kit autonome</option>
                                                                <option value="lampe.jpg" @if($prod->picture == 'lampe.jpg') selected @endif >Lampe</option>
                                                                <option value="moyen-kit.jpg" @if($prod->picture == 'moyen-kit.jpg') selected @endif >Moyen Kit</option>
                                                                <option value="multimedia.jpg" @if($prod->picture == 'multimedia.jpg') selected @endif >Multimédia</option>
                                                                <option value="petite-lampe.jpg" @if($prod->picture == 'petite-lampe.jpg') selected @endif >Petite lampe</option>
                                                                <option value="photocopie.jpg" @if($prod->picture == 'photocopie.jpg') selected @endif >Photocopie</option>
                                                                <option value="recharge.jpg" @if($prod->picture == 'recharge.jpg') selected @endif >Recharge</option>
                                                                <option value="scanner.jpg" @if($prod->picture == 'scanner.jpg') selected @endif >Scanner</option>
                                                                <option value="soda.jpg" @if($prod->picture == 'soda.jpg') selected @endif >Soda</option>
                                                                <option value="telephone.jpg" @if($prod->picture == 'telephone.jpg') selected @endif >Telephone</option>
                                                                <option value="viande.jpg" @if($prod->picture == 'viande.jpg') selected @endif >Viande</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control" name="price_fcfa" id="price_fcfa" value="{{$prod->price_fcfa}}" placeholder=""></td>
                                                        
                                                        <td><button type="submit" class="btn btn-info btn-fill"><i class="ti-save"></i></button></td>
                                                    </form>
                                                    <td>
                                                        <form method="POST" action="/product/delete/{{$prod->id}}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
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