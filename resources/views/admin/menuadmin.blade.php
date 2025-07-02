<div class="d-flex min-vh-100">
    <!-- Sidebar -->
    <nav class="bg-dark text-white p-2" style="width: 15%;">
        <div class="text-center mb-4">
            <a href="">
                <img src="{{ full_asset('assets/images/logo/mueblelogo.png') }}" alt="Logo" class="img-fluid" style="width: 120px;">
            </a>
        </div>

        <ul class="nav flex-column">

            <li class="nav-item mb-2">
                <a href="{{ route('admin.admindashboard') }}" class="nav-link text-white">
                    <i class="fa-solid fa-house me-2"></i> Inicio
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.orders.index') }}" class="nav-link text-white">
                    <i class="fa-solid fa-box me-2"></i> Pedidos
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white" onclick="toggleSubmenu(event)">
                    <i class="fa-solid fa-gears me-2"></i> Catálogos
                    <i class="fa fa-chevron-down float-end"></i>
                </a>
                <ul class="nav ms-2" style="display: none;">
                    <li class="">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">Categorías</a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.brands.index') }}" class="nav-link text-white">Marcas</a>
                    </li>
                    <li class="">
                        <a href="{{ route('admin.products.index') }}" class="nav-link text-white">Productos</a>
                    </li>
                     <li class="">
                        <a href="{{ route('admin.suppliers.index') }}" class="nav-link text-white">Proveedores</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mb-2">
                <a href="" class="nav-link text-white">
                    <i class="fa-solid fa-book me-2"></i> otro Menu
                </a>
            </li>
            <li class="nav-item mb-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light w-100">
                        <i class="fa-solid fa-door-open me-2"></i> Cerrar sesión
                    </button>
                </form>
            
            </li>
        </ul>
    </nav>

    <!-- Contenido -->
    <main class="flex-grow-1 p-4">
        @yield('content')
    </main>
</div>
<!-- Scripts para controlar el menu -->
<script>
    function toggleSubmenu(e) {
        e.preventDefault();
        const submenu = e.currentTarget.nextElementSibling;
        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
    }
</script>