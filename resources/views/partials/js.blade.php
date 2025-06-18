<!-- Última versión de jQuery -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
<!-- Íconos Feather -->
<script src="{{ asset('assets/js/feather/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/feather/feather-icon.js') }}"></script>
<!-- Carga diferida (LazyLoad) -->
<script src="{{ asset('assets/js/lazysizes.min.js') }}"></script>
<!-- Slick Slider -->
<script src="{{ asset('assets/js/slick/slick.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/slick/custom_slick.js') }}"></script>
<!-- Scripts adicionales -->
<script src="{{ asset('assets/js/auto-height.js') }}"></script>
<script src="{{ asset('assets/js/quantity.js') }}"></script>
<!-- Efecto de carrito flotante -->
<script src="{{ asset('assets/js/fly-cart.js') }}"></script>
<!-- Animaciones WOW.js -->
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/custom-wow.js') }}"></script>
<!-- Scripts generales -->
<script src="{{ asset('assets/js/script.js') }}"></script>
<!-- Configuración del tema -->
<script src="{{ asset('assets/js/theme-setting.js') }}"></script>

<!-- sidebar open js -->
<script src="{{ asset('assets/js/filter-sidebar.js') }}"></script>

<!-- Price Range Js -->
<script src="../assets/js/ion.rangeSlider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Vista rapida de producto -->
<script>
    function openQuickViewModal(button) {
        const data = button.dataset;

        document.getElementById('quickViewImage').src = data.image;
        document.getElementById('quickViewTitle').textContent = data.name;
        document.getElementById('quickViewPrice').textContent = `$${data.price}`;
        document.getElementById('quickViewDescription').textContent = data.description || 'Sin descripción.';
        document.getElementById('quickViewBrand').textContent = data.brand || 'N/A';
        document.getElementById('quickViewCode').textContent = data.code || '-';
        document.getElementById('quickViewMoreLink').href = data.url;

        // Configura el botón "Agregar al carrito"
        const addBtn = document.getElementById('quickViewAddToCart');
        addBtn.onclick = function () {
            addToCart(data.id, data.image, data.url, data.price, data.name);
        };
    }
</script>


<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>