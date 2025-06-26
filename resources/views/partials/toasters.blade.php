  <!-- componente para toast de error -->
   
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="toastError" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
        </div>
    </div>
     @if (session('error'))
        <script>
            const toast = new bootstrap.Toast(document.getElementById('toastError'));
            document.querySelector('#toastError .toast-body').textContent = '{{ session('error') }}';
            toast.show();
        </script>
    @endif
  <!-- componente para toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="toastDeleted" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('deleted') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
        </div>
    </div>
    @if (session('deleted'))
        <script>
            const toastElement = document.getElementById('toastDeleted');
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        </script>
    @endif
<!-- componente para toast de éxito -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            const toastEl = document.getElementById('toastSuccess');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        </script>
    @endif
    
