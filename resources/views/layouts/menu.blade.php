<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            Navigación
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->
    
        
        <!-- Sidebar content -->
        <div class="sidebar-content">
    
            <!-- Main navigation -->
    
            <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
    
                
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">Navegación</div> 
                    <i class="icon-menu" title="Navegación"></i>
                </li>
                
                {{--  menus del sistema  --}}
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link" id="menuEscritorio">
                        <i class="icon-home4"></i>
                        <span>
                            Escritorio
                        </span>
                    </a>
                </li>               
                 {{--  menus para las gestiones del proyecto  --}}
                <li class="nav-item nav-item-submenu" id="menuGestionInformacion">
                    <a href="#" class="nav-link">
                        <i class="far fa-address-card"></i>
                        <span>Gestión de Información</span>
                    </a>
                    <ul class="nav nav-group-sub" data-submenu-title="Gestión de información">
                        @can('G. de estaciones')
                            
                        
                        <li class="nav-item">
                            <a href="{{ route('estaciones') }}" class="nav-link" id="menuEstacion">Estaciones</a>
                        </li> 

                        @endcan
                        
                        @can('G. de emergencias')
                        <li class="nav-item">
                            <a href="{{ route('emergencia') }}" class="nav-link" id="menuEmergencia">Emergencias</a>
                        </li>     
                        @endcan
                        
                        @can('G. de personal operativos')
                            
                        <li class="nav-item">
                            <a href="{{ route('usuarios') }}" class="nav-link" id="menuUsuarios">Personal operativos</a>
                        </li> 

                        @endcan

                        @can('G. de clínicas')
                        <li class="nav-item">
                            <a href="{{ route('clinicas') }}" class="nav-link" id="menuClinicas">Clínicas</a>
                        </li>     
                        @endcan          

                        @can('G. de vehículos')
                            
                        <li class="nav-item">
                            <a href="{{ route('tipoVehiculos') }}" class="nav-link" id="menuVehiculos">Vehículos</a>
                        </li> 

                        @endcan

                        @can('G. de insumos y medicamentos')
                            
                        <li class="nav-item">
                            <a href="{{ route('insumos') }}" class="nav-link" id="menuMedicamentosInsumos">Insumos y medicamentos</a>
                        </li> 

                        @endcan


                    </ul>
                </li>
                 {{-- generar puntos de referencia--}}
                 @can('G. de puntos de referencias')
                 <li class="nav-item nav-item-submenu" id="menuGestionPuntos">
                    <a href="#" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span>Gestión de Puntos de referencia</span>
                    </a>
                    <ul class="nav nav-group-sub" data-submenu-title="Gestión de puntos de referencias">
                    
                        <li class="nav-item">
                            <a href="{{ route('parroquias') }}" class="nav-link" id="menuParroquias">Parroquias</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('barrios') }}" class="nav-link" id="menuBarrios">Barrios</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('puntosReferencia') }}" class="nav-link" id="menuPuntosReferencia">Puntos de referencias</a>
                        </li> 
                    </ul>
                </li>
                @endcan
                {{--  generar asistencia  --}}
                @can('Generar asistencia')
                    
                <li class="nav-item">
                    <a href="{{ route('generarAsistencia') }}" class="nav-link" id="menuGenerarAsistencia">
                        <i class="fas fa-clipboard-list"></i>
                        <span>
                            Generar asistencia
                        </span>
                    </a>
                </li> 

                @endcan
                {{-- generar formulario de emergencia --}}
                <li class="nav-item nav-item-submenu" id="menuGestionFomularios">
                    <a href="#" class="nav-link">
                        <i class="fas fa-journal-whills"></i>
                        <span>Gestión de Formularios</span>
                    </a>
                    <ul class="nav nav-group-sub" data-submenu-title="Gestión de formularios">
                    
                        <li class="nav-item">
                            <a href="{{ route('formularios') }}" class="nav-link" id="menuFormularios">Formularios</a>
                        </li> 
                        
                        @can('crearNuevoFormularioEmergencia', iobom\User::class)
                            <li class="nav-item">
                                <a href="{{ route('nuevo-formulario') }}" class="nav-link" id="menuNuevoFormularios">Nuevo Formulario</a>
                            </li>     
                        @endcan
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mis-formulario') }}" class="nav-link" id="menuMisFormularios">
                        <i class="fa fa-life-ring" aria-hidden="true"></i>
                        <span>
                            Mis formularios
                        </span>
                    </a>
                </li>
                @role('Administrador')
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">SISTEMA</div> 
                    <i class="icon-menu" title="Sistemas"></i>
                </li>

                <li class="nav-item">
                    <a href="{{ route('roles') }}" class="nav-link" id="menuRoles">
                        <i class="fas fa-unlock-alt"></i>
                        <span>
                            Roles y permisos
                        </span>
                    </a>
                </li>
                @endrole
    
                
                
                <!-- /page kits -->
    
            </ul>
        </div>
            
            <!-- /main navigation -->
    
        </div>
        <!-- /sidebar content -->
        
    </div>