<div class="option-list" style="margin-left: 10px;">
    <ul>
        <li>
            <a href="javascript:void(0)" class="header-icon user-icon search-icon">
                <i class="iconly-Profile icli"></i>
            </a>
        </li>
        <li>
            @auth
                <a href="{{ route('dashboard') }}" class="header-icon search-box search-icon">
                    <i class="iconly-Profile icli"></i>
                    <a>{{ Auth::user()->name }}</a>
                </a>
            @else
                <a href="{{ route('login') }}" class="header-icon search-box search-icon">
                    <i class="iconly-Profile icli"></i>
                </a>
            @endauth
        </li>
        <li class="onhover-dropdown">
            <a href="{{ route('wishlist.index') }}" class="header-icon swap-icon">
                <small id="wishlist-count" class="badge-number">0</small>
                <i class="iconly-Heart icli"></i>
            </a>
        </li>
        <li class="onhover-dropdown">
            <a href="{{ route('cart.index') }}" class="header-icon bag-icon">
                <small id="cart-count-uno" class="badge-number">0</small>
                <i class="iconly-Bag-2 icli"></i>
            </a>
            <div class="onhover-div">
                <ul class="cart-list" id="cart-dropdown">
                    <!-- Los productos del carrito se insertarán aquí dinámicamente -->
                </ul>

                <div class="price-box">
                    <h5>Total :</h5>
                    <small>+Envio</small>
                    <h4 class="theme-color fw-bold" id="cart-dropdown-total">$ 0.00</h4>
                </div>
                <div class="button-group">
                    <a href="{{ route('cart.index') }}" class="btn btn-sm cart-button">Ver Carrito</a>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-sm cart-button theme-bg-color
                    text-white">Proceder al Pago</a>
                </div>
            </div>
        </li>
        <li class="onhover-dropdown">
            <a href="javascript:void(0)" class="header-icon swap-icon">
                <i class="iconly-Profile icli"></i>
            </a>
        </li>
        <li class="right-side onhover-dropdown">
            <div class="delivery-login-box">
                <div class="delivery-detail">
                    <h6>Hola,</h6>
                    <h5>{{ Auth::user()->name ?? 'Mi Cuenta'}}</h5>
                </div>
            </div>
            <div class="onhover-div onhover-div-login">
                <ul class="user-box-name">
                    @auth
                        <!-- Si el usuario está autenticado -->
                        <li class="product-box-contain">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="product-box-contain">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="text-danger">
                                    Cerrar Sesión
                                </a>
                            </form>
                        </li>
                    @else
                        <!-- Si el usuario no está autenticado -->
                        <li class="product-box-contain">
                            <a href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>

                        <li class="product-box-contain">
                            <a href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endauth
                </ul>
            </div>

        </li>
    </ul>
</div>