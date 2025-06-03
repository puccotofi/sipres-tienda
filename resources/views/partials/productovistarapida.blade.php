<!-- Inicio del Modal de Vista Rápida -->
<div class="modal fade theme-modal view-modal" id="view" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header p-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row g-sm-4 g-2">
                    <div class="col-lg-6">
                        <div class="slider-image">
                            <img src="{{ full_asset('assets/images/furniture/1.png') }}" class="img-fluid blur-up lazyload" alt="Producto">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="right-sidebar-modal">
                            <h4 class="title-name">Estatuas de Caracoles</h4>
                            <h4 class="price">$360</h4>
                           

                            <div class="product-detail">
                                <h4>Detalles del Producto:</h4>
                                <p>Estatuas para decoración, elaboradas en barro por las manos virginales de artesanas chiapanecas.</p>
                            </div>

                            <ul class="brand-list">
                                <li>
                                    <div class="brand-box">
                                        <h5>Marca:</h5>
                                        <h6>Black Forest</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="brand-box">
                                        <h5>Código de Producto:</h5>
                                        <h6>W0690034</h6>
                                    </div>
                                </li>
                            </ul>
                            <div class="modal-button">
                                <button onclick="location.href = 'cart.html';" class="btn btn-md add-cart-button icon">
                                    Agregar al carrito
                                </button>
                                <button onclick="location.href = 'product-left.html';" class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                    Ver más detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin del Modal de Vista Rápida -->