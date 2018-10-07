
@include('shared.header', ['title' => 'Admin Benoo - Ventes'])
@include('shared.sidebar', ['active' => "sales"])


    <div class="main-panel">
        <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">                        
                        <a class="navbar-brand" href="">Ventes</a>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-md-12 text-center">
                            <form method="POST" action="/sales/export/all">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-warning btn-fill btn-lg margin-bottom"><i class="ti-download"></i> Exporter toutes les ventes</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Export par entrepreneur</h4>
                                    <form method="POST" action="/sales/export/entrepreneur">
                                        {{ csrf_field() }}
                                        <div class="form-group sm-margin-top">
                                            <input type="number" class="form-control form-control-lg" id="idEntrepreneur" name="idEntrepreneur" aria-describedby="emailHelp" placeholder="Numéro entrepreneur">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-fill">Exporter les ventes</button>
                                                        
                                    </form>                                                        
                                </div>
                                <div class="content">
    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Export par gestionnaire</h4>
                                        <form method="POST" action="/sales/export/provider">
                                            {{ csrf_field() }}
                                            <div class="form-group sm-margin-top">
                                                <input type="number" class="form-control form-control-lg" id="idProvider" name="idProvider" aria-describedby="emailHelp" placeholder="Numéro prospect">
                                            </div>
                                            <button type="submit" class="btn btn-info btn-fill">Exporter les ventes</button>
                                                            
                                        </form>   
                                </div>
                                <div class="content">
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>


@include('shared.footer')