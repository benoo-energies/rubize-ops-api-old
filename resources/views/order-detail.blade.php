
@include('shared.header', ['title' => 'Admin Benoo - Détail commande'])
@include('shared.sidebar', ['active' => "entrepreneurs-orders"])

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->
    
    
    <div class="main-panel">
    
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                        <a class="navbar-brand" href="#">Gestion de la commande #{{$order->id}} - 
                        @if($order->status == 1)
                        (Commande à valider) 
                        @elseif($order->status == 2)
                        (Commande validée à expédier) 
                        @elseif($order->status == 3)
                        (Commande en transit) 
                        @elseif($order->status == 4)
                        (Commande reçue) 
                        @elseif($order->status == 5)
                        (Commande annulée) 
                        @endif
                        </a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="col-md-6">
                    <h5 class="margin-bottom"><b>Entrepreneur :</b> {{$entrepreneur->firstname}} {{$entrepreneur->lastname}}</h5>
                    <h5 class="margin-bottom"><b>Date de la commande :</b> {{date('d/m/Y H:i:s', strtotime($order->created_at))}}</h5>
                    <h5 class="margin-bottom"><b>Montant de la commande :</b> {{$order->total}} Fcfa</h5>
                    <h5><b>Détail de la commande :</b></h5>
                    @if(count($details) > 0)
                        <ul>
                            @foreach($details as $detail)
                                <li>{{$detail->quantity}} x {{$detail->product->title}}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-md-6">
                    <form action="/orders/{{$entrepreneur->id}}/{{$order->id}}/update" method="POST">
                        {{ csrf_field() }}

                        <input id="paid" type="checkbox" name="paid" value="1" class="bigcheck" @if($order->paid == 1) checked @endif>
                        <label for="paid" class="bigcheckText">Commande payée</label>                            

                        <h5 class="margin-top">Mise à jour du statut de la commande :</h5>
                        <select class="form-control input-lg margin-bottom" id="status" name="status">
                            <option value="1" @if($order->status == 1) selected @endif>Commande à valider</option>
                            <option value="2" @if($order->status == 2) selected @endif>Commande validée à expédier</option>
                            <option value="3" @if($order->status == 3) selected @endif>Commande en transit</option>
                            <option value="4" @if($order->status == 4) selected @endif>Commande reçue</option>
                            <option value="5" @if($order->status == 5) selected @endif>Commande annulée</option>
                        </select>

                        
                        <h5>Informations sur la commande : </h5>
                        <div class="form-group margin-bottom">
                            <textarea class="form-control" name="information" id="information" rows="10" value="">{{$order->information}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-fill ">Mettre à jour la commande</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

   
@include('shared.footer')