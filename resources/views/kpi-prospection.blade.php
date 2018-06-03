@include('shared.header', ['title' => 'Admin Benoo - Ventes'])
@include('shared.sidebar', ['active' => "kpi"])


    <div class="main-panel">
        <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">                        
                        <a class="navbar-brand" href="">KPI's Prospection</a>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">

                    
                    <div class="row">
                        <div class="col-md-7 col-lg-8">
                            <div class="row">
                                <div class="col-md-4 col-lg-2">
                                    <div class="card">
                                        Villages enquêtés
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2">
                                    <div class="card">
                                        Vivier entrepreneur
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2">
                                    <div class="card">
                                        Terrain acquis
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2">
                                    <div class="card">
                                        Besoin énergie exprimées
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2">
                                    <div class="card">
                                        Taux de transformation
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" id="energyChartContainer">
                                    Besoin en énergie actuels et futurs
                                    <canvas id="energyChart" width="400" height="250"></canvas>
                                </div>
                                <div class="col-md-12">
                                    Besoin d'investissement moyen en équipement productif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Taux d'équipement en moyen de production d'énergie
                                </div>
                                <div class="col-md-6">
                                    Equipement kits solaires par business
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-4">
                            <h1>CARTE</h1>
                        </div>
                    </div>


                </div>
            </div>
            
{{--                  --}}

@include('shared.footer', ['url_energy' => url('/kpi/prospection/data')])