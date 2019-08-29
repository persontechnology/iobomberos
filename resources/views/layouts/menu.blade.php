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
                        <i class="fas fa-list"></i>
                        <span>Gestón de Información</span>
                    </a>
                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                        <li class="nav-item">
                            <a href="{{ route('estaciones') }}" class="nav-link" id="menuEstacion">Estaciones</a>
                        </li> 
                        
                        <li class="nav-item">
                            <a href="{{ route('emergencia') }}" class="nav-link" id="menuEmergencia">Emergencia</a>
                        </li> 

                        <li class="nav-item">
                            <a href="{{ route('usuarios') }}" class="nav-link" id="menuUsuarios">Personal operativo</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('clinicas') }}" class="nav-link" id="menuClinicas">Clínicas</a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('puntosReferencia') }}" class="nav-link" id="menuPuntosReferencia">Puntos de referencia</a>
                        </li> 

                    </ul>
                </li>
              
                <li class="nav-item">
                    <a href="{{ route('tipoVehiculos') }}" class="nav-link" id="menuVehiculos">
                        <i class="icon-truck"></i>
                        <span>
                            Vehículos
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