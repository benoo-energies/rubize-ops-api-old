
<div class="sidebar" data-background-color="white" data-active-color="warning">
    
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="/home" class="simple-text">
                Admin Benoo
            </a>
        </div>

        <ul class="nav">
            
            
            <li @if($active == "home") class="active"@endif>
                <a href="/home">
                    <i class="ti-home"></i>
                    <p>Accueil</p>
                </a>
            </li>
            <li @if($active == "entrepreneur") class="active"@endif>
                <a href="/entrepreneurs">
                    <i class="ti-user"></i>
                    <p>Entrepreneurs</p>
                </a>
            </li>
            <li @if($active == "survey") class="active"@endif>
                <a href="/surveys">
                    <i class="ti-check-box"></i>
                    <p>Enquêtes</p>
                </a>
            </li>
            <li @if($active == "sales") class="active"@endif>
                <a href="/sales">
                    <i class="ti-money"></i>
                    <p>Ventes ent.</p>
                </a>
            </li>
            <li @if($active == "product") class="active"@endif>
                <a href="/products">
                    <i class="ti-shopping-cart"></i>
                    <p>Services ent.</p>
                </a>
            </li>
            <li @if($active == "entrepreneurs-orders") class="active"@endif>
                <a href="/orders">
                    <i class="ti-package"></i>
                    <p>Commandes </p>
                </a>
            </li>
            <li @if($active == "entrepreneur-products") class="active"@endif>
                <a href="/entrepreneurs/products">
                    <i class="ti-bolt"></i>
                    <p>Produits B2B </p>
                </a>
            </li>
{{--             <li @if($active == "kpi") class="active"@endif>
                <a href="/kpi">
                    <i class="ti-pie-chart"></i>
                    <p>KPI</p>
                </a>
            </li> --}}
            <li>
                <a href="/logout">
                    <i class="ti-close"></i>
                    <p>Déconnexion</p>
                </a>
            </li>
        </ul>
    </div>
</div>
