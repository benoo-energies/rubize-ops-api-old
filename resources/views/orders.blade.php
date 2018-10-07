
@include('shared.header', ['title' => 'Admin Benoo - Commandes entrepreneurs '])
@include('shared.sidebar', ['active' => "entrepreneurs-orders"])

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->
    
    
    <div class="main-panel">
    
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Commandes entrepreneurs</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="col-md-4 col-lg-2">
                            <a href="/orders" class="btn btn-secondary @if($type == "")btn-fill @endif btn-block margin-bottom">
                                <i class="ti-list"></i> &nbsp;&nbsp; Toutes 
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <a href="/orders?type=1" class="btn btn-secondary @if($type == 1)btn-fill @endif btn-block margin-bottom">
                                <i class="ti-check-box"></i> &nbsp;&nbsp; A valider
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <a href="/orders?type=2" class="btn btn-secondary  @if($type == 2)btn-fill @endif btn-block margin-bottom">
                                <i class="ti-package"></i> &nbsp;&nbsp; A expédier
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <a href="/orders?type=3" class="btn btn-secondary  @if($type == 3)btn-fill @endif btn-block margin-bottom">
                                <i class="ti-truck"></i> &nbsp;&nbsp; En transit
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <a href="/orders?type=4" class="btn btn-secondary  @if($type == 4)btn-fill @endif btn-block margin-bottom">
                                <i class="ti-dropbox"></i> &nbsp;&nbsp; Reçues
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <a href="/orders?type=5" class="btn btn-danger  @if($type == 5)btn-fill @endif btn-block margin-bottom">
                                <i class="ti-trash"></i> &nbsp;&nbsp; Annulées
                            </a>
                        </div>
                    </div>
                </div>


                <div class="row">
                        <div class="col-md-12 ordersListing">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Liste des produits actifs</h4>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    
                                    <table class="table table-striped">
                                        <thead>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Entrepreneur</th>
                                            <th class="text-center">Téléphone</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Payée</th>
                                            <th class="text-center">&nbsp;</th>
                                        </thead>
                                        <tbody class="text-center">
                                            @if(count($orders) > 0)
                                                @foreach ($orders as $order)
                                                <tr>
                                                    {{ csrf_field() }}
                                                    <td>{{$order->id}}</td>
                                                    <td>{{date('d/m/Y H:i:s', strtotime($order->created_at))}}</td>
                                                    <td>{{$order->entrepreneur->firstname}} {{$order->entrepreneur->lastname}}</td>
                                                    <td>{{$order->entrepreneur->telephone}}</td>
                                                    <td>{{$order->total}} Fcfa</td>
                                                    <td class="text-center">
                                                        @if($order->status == 1)
                                                        <span class="badge badge-1">
                                                            A valider
                                                        </span>
                                                        @elseif($order->status == 2)
                                                        <span class="badge badge-2">
                                                            A expédier
                                                        </span>
                                                        @elseif($order->status == 3)
                                                        <span class="badge badge-3">
                                                            En transit
                                                        </span>
                                                        @elseif($order->status == 4)
                                                        <span class="badge badge-4">
                                                            Reçue
                                                        </span>
                                                        @elseif($order->status == 5)
                                                        <span class="badge badge-5">
                                                            Annulée
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="paid">
                                                        @if($order->paid == 1)
                                                            <i class="ti-check text-success"></i> 
                                                        @else
                                                            <i class="ti-close text-danger"></i> 
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="/orders/{{$order->entrepreneur->id}}/{{$order->id}}" class="btn btn-info btn-fill">
                                                            <i class="ti-search"></i> 
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" align="center">
                                                        Aucune commande enregistrée actuellement.
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