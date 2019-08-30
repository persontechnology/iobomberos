<div class="navbar navbar-expand-lg navbar-light">

    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
        <span class="navbar-text">
            &copy; 2019 - {{ date('Y') }}. <a href="#">{{ config('app.name','BOMBEROS') }}</a> por <a href="http://www.soysoftware.com" target="_blank">Romel & Jessica</a>
        </span>

        <ul class="navbar-nav ml-lg-auto">
            <li class="nav-item">
                <a href="" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Soporte</a>
            </li>
            <li class="nav-item">
                <a href="" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Documentación</a>
            </li>
            <li class="nav-item">
                <a href="" class="navbar-nav-link font-weight-semibold">
                    <span class="text-pink-400"><i class="icon-share2 mr-2"></i> Acerca del sistema</span>
                </a>
            </li>
        </ul>
    </div>

</div>