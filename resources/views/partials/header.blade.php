<header class="header-2">
    <div class="header-notification theme-bg-color overflow-hidden py-2">
        <div class="notification-slider">
            <div>
                <div class="timer-notification text-center">
                    <h6>
                        <strong class="me-1">¡Bienvenido a Muebleria Virtual ISSSTEZAC!</strong>
                        <strong class="ms-1">Utiliza tu crédito ISSSTEZAC</strong>
                    </h6>
                </div>
            </div>

            <div>
                <div class="timer-notification text-center">
                    <h6>
                        ¡Conoce como tramitar tu Crédito!
                        <a href="{{ url('shop-left-sidebar') }}" class="text-white">¡Informate Aqui!</a>
                    </h6>
                </div>
            </div>
        </div>

        <!-- Botón para cerrar la notificación -->
        <button class="btn close-notification">
            <span>Cerrar</span> <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="top-nav top-header sticky-header sticky-header-3">
        <div class="container-fluid-lg">
            <!-- Barra busqueda y usuario-->
            <div class="row d-none d-md-block">
                    <div class="navbar-top">
                        <div class="middle-box">
                            @include("partials.menu")
                        </div>
                        <div class="middle-box">
                            <div class="center-box">
                                <div class="searchbar-box order-xl-1 d-none d-xl-block">
                                    <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                                        <input type="text" name="search" class="form-control" placeholder="Buscar productos..."
                                            value="{{ request('search') }}">
                                        <button type="submit" class="btn search-button">
                                            <i class="iconly-Search icli"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="rightside-menu">
                           @include("partials.topmenuderecha")
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block d-md-none">
                @include("partials.menumobil")
            </div>
        </div>
    </div>
</header>
