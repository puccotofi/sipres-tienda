<div class="header-nav-middle">
    <div class="d-flex justify-content-end align-items-center w-100 gap-3">    
        <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
            <div class="offcanvas offcanvas-end offcanvas-collapse order-xl-2" id="primaryMenu">
                <div class="offcanvas-header navbar-shadow">
                    <h5>Menu</h5>
                    <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                        <div>
                            <a href="{{route('home')}}" class="web-logo nav-logo">
                                    <img src="{{full_asset('assets/images/logo/mueblelogo.png') }}" class="img-fluid blur-up lazyload" alt="" style="width: 120px;">
                                </a>
                            </div>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown dropdown-mega">
                                    <a class="nav-link dropdown-toggle ps-xl-2 ps-0" href="{{route('home')}}" data-bs-toggle="dropdown">Inicio</a>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="">Submenu</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown dropdown-mega">
                                    <a class="nav-link dropdown-toggle ps-0" href="javascript:void(0)" data-bs-toggle="dropdown">Mega
                                        Menu</a>

                                    <div class="dropdown-menu ">
                                        <div class="row">
                                            <div class="dropdown-column">
                                                <h5 class="dropdown-header">Muebles</h5>
                                                <a class="dropdown-item" href="shop-left-sidebar.html">Salas</a>

                                                <a class="dropdown-item" href="shop-left-sidebar.html">Comedores</a>

                                                <a href="shop-left-sidebar.html" class="dropdown-item">Cocinas integrales</a>

                                                <a class="dropdown-item" href="shop-left-sidebar.html">Recamaras</a>

                                                <h5 class="dropdown-header">Línea Blanca</h5>
                                                <a class="dropdown-item" href="shop-left-sidebar.html">Lavadoras</a>

                                                <a class="dropdown-item" href="shop-left-sidebar.html">Estufas</a>

                                                <a href="shop-left-sidebar.html" class="dropdown-item">Tostadores</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                </div>  
            </div>
        </div>
    </div>
