<div class="collapse navbar-collapse" id="navbar-mobile">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                <i class="icon-paragraph-justify3"></i>
            </a>
        </li>

        {{-- <li class="nav-item dropdown">
            <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                <i class="icon-git-compare"></i>
                <span class="d-md-none ml-2">Actividades</span>
                <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">9</span>
            </a>

            <div class="dropdown-menu dropdown-content wmin-md-350">
                <div class="dropdown-content-header">
                    <span class="font-weight-semibold">Actividades</span>
                    <a href="#" class="text-default"><i class="icon-sync"></i></a>
                </div>

                <div class="dropdown-content-body dropdown-scrollable">
                    <ul class="media-list">
                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i class="icon-git-pull-request"></i></a>
                            </div>

                            <div class="media-body">
                                Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                <div class="text-muted font-size-sm">4 minutes ago</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="dropdown-content-footer bg-light">
                    <a href="#" class="text-grey mr-auto">All updates</a>
                    <div>
                        <a href="#" class="text-grey" data-popup="tooltip" title="Mark all as read"><i class="icon-radio-unchecked"></i></a>
                        <a href="#" class="text-grey ml-2" data-popup="tooltip" title="Bug tracker"><i class="icon-bug2"></i></a>
                    </div>
                </div>
            </div>
        </li> --}}

    </ul>
    @auth
        <span class="badge bg-dark ml-md-3 mr-md-auto">
            Estación: {{ Auth::user()->estacion->nombre }}
        </span>    
    @endauth
    

    <ul class="navbar-nav ml-auto">
        {{-- <li class="nav-item dropdown">
            <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                <i class="icon-people"></i>
                <span class="d-md-none ml-2">Usuarios</span>
            </a>
            
            <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-300">
                <div class="dropdown-content-header">
                    <span class="font-weight-semibold">Usuarios en linea</span>
                    <a href="#" class="text-default"><i class="icon-search4 font-size-base"></i></a>
                </div>

                <div class="dropdown-content-body dropdown-scrollable">
                    <ul class="media-list">
                        <li class="media">
                            <div class="mr-3">
                                <img src="{{ asset('admin/img/user.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
                            </div>
                            <div class="media-body">
                                <a href="#" class="media-title font-weight-semibold">Jordana Ansley</a>
                                <span class="d-block text-muted font-size-sm">Lead web developer</span>
                            </div>
                            <div class="ml-3 align-self-center"><span class="badge badge-mark border-success"></span></div>
                        </li>

                        
                    </ul>
                </div>

                <div class="dropdown-content-footer bg-light">
                    <a href="#" class="text-grey mr-auto">All users</a>
                    <a href="#" class="text-grey"><i class="icon-gear"></i></a>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                <i class="icon-bubbles4"></i>
                <span class="d-md-none ml-2">Mensajes</span>
                <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">2</span>
            </a>
            
            <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                <div class="dropdown-content-header">
                    <span class="font-weight-semibold">Mensajes</span>
                    <a href="#" class="text-default"><i class="icon-compose"></i></a>
                </div>

                <div class="dropdown-content-body dropdown-scrollable">
                    <ul class="media-list">
                        <li class="media">
                            <div class="mr-3 position-relative">
                                <img src="{{ asset('admin/img/user.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
                            </div>

                            <div class="media-body">
                                <div class="media-title">
                                    <a href="#">
                                        <span class="font-weight-semibold">James Alexander</span>
                                        <span class="text-muted float-right font-size-sm">04:58</span>
                                    </a>
                                </div>

                                <span class="text-muted">who knows, maybe that would be the best thing for me...</span>
                            </div>
                        </li>

                        
                    </ul>
                </div>

                <div class="dropdown-content-footer justify-content-center p-0">
                    <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>
                </div>
            </div>
        </li> --}}

        <li class="nav-item dropdown dropdown-user">
            <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                
                @if (Storage::exists(Auth::user()->foto))
                    
                    <img src="{{ Storage::url(Auth::user()->foto) }}" alt="" class="rounded-circle mr-2" width="34px"  height="34px">
                    
                @else
                    <img src="{{ asset('img/user.png') }}" class="rounded-circle mr-2 bg-light" width="34px"  height="34px" alt="">
                @endif	

                <span>{{ Auth::user()->email }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('miPerfil') }}" class="dropdown-item"><i class="icon-user-plus"></i> Mi perfil</a>
                <div class="dropdown-divider"></div>
                <button href="{{ route('logout') }}" class="dropdown-item" onclick="salirSistema(this);">
                    <i class="icon-switch2"></i> Salir del sistema
                </button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <script>
                    function salirSistema(){
                        swal({
                            title: "¿Estás seguro?",
                            text: "De salir de sistema",
                            type: "error",
                            showCancelButton: true,
                            confirmButtonClass: "btn-success",
                            cancelButtonClass: "btn-danger",
                            confirmButtonText: "¡Sí, salir!",
                            cancelButtonText:"Cancelar",
                            closeOnConfirm: false
                        },
                        function(){
                            $('#logout-form').submit();
                        });
                    }
                    
                </script>

            </div>
        </li>
    </ul>
</div>