<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
            </a>
            <img src="{{asset('img/'.strtolower(session('county')).'-logo.png')}}" class="img img-fluid ml-3" alt=""
                 style="margin-top: 10px; max-width: 62%;">
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="/logout">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>

    </nav>
</div>
