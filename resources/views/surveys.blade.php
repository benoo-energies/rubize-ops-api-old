
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
                </div>
            </div>
        </div>
    </div>

@include('shared.footer')