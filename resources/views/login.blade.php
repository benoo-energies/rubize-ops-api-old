@include('shared.header', ['title' => 'Admin Benoo'])
<div class="flex-center position-ref full-height login">
    <div class="row">
    </div>
    <div class="col-xs-12 col-sm-5 col-lg-3">
        <img src="/assets/img/logo-benoo.png" title"Benoo Energies" class="margin-bottom">
        @if(Session::get('message'))
        <p class="alert alert-danger">{{Session::get('message')}}</p>
        @endif
        @if ($errors->any())
        <p class="alert alert-danger">
            {{ $errors->first('email') }}
            {{ $errors->first('password') }}
        </p>
        @endif
        <form method="POST" action="/login">
            {{ csrf_field() }}
            <div class="form-group sm-margin-top">
                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" value="{{old('email')}}">
            </div>
            <div class="form-group sm-margin-top">
                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Mot de passe">
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="remember_me" name='remember_me' @if(old('remember_me')) checked @endif>
                <label class="form-check-label" for="remember_me">Rester connecté</label>
            </div>            
            <button type="submit" class="sm-margin-top btn btn-warning btn-fill">Connexion</button>
        </form>   
    </div>
</div>


@include('shared.footer')