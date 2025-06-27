<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield('title', ' Admin Mueblería Virtual ISSSTEZAC')</title>
    @include('partials.head')
</head>

<body class="theme-color-5 bg-effect">

    <!-- Loader Start -->
    @include('partials.loader')
    <!-- Loader End -->

    <!-- Header Start -->
    @include('admin.headeradmin')
    <!-- Header End -->
    @include('admin.menuadmin')
 

    <!-- Footer Start -->
    @include('partials.footer')
    <!-- Footer End -->


    <div class="item-section">
        <button class="close-button">
            <i class="fas fa-times"></i>
        </button>
        <h6>
            <i class="iconly-Bag-2 icli"></i>
            <span id="cart-count-dos">0</span>
            <br><br>
        </h6>
        
        <button onclick="location.href = '{{ route('cart.index') }}';" class="btn item-button btn-sm fw-bold" id="total-uno">$ 0.00</button>
        <a href="{{ route('cart.index') }}" class="btn item-button btn-sm fw-bold">Ver carrito</a>
    </div>
    <!-- Items section End -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->
    @include('partials.js')

    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        window.authUserId = {{ Auth::check() ? Auth::id() : 'null' }};
        window.syncCartWishlistUrl = "{{ route('sync.cart.wishlist') }}";
    </script>
    <script src="{{ asset('js/syncro.js') }}"></script>
    <!--script para datatables-->
    <script>
        $(document).ready(function () {
            $('#crudTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                }
            });
        });
    </script>
    <!--script para datatable productos-->
    <script>
        $(document).ready(function () {
            $('#productTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
                },
                pageLength: 5,
                order: [[0, 'asc']]
            });
        });
    </script>

    <!-- Modal reutilizable para confirmación de eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" id="genericDeleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteLabel">Confirmar eliminación</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar <strong id="deleteItemName">este elemento</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('confirmDeleteModal');

            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const action = button.getAttribute('data-action');
                    const name = button.getAttribute('data-name');

                    const form = document.getElementById('genericDeleteForm');
                    const itemName = document.getElementById('deleteItemName');

                    form.action = action;
                    itemName.textContent = name;
                });
            }
        });
    </script>
    @include('partials.toasters')
 
</body>

</html>
