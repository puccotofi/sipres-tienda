
<!-- Modal Vista Rápida (dinámico) -->
<div class="modal fade theme-modal view-modal" id="quickViewModal" tabindex="-1">
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
                        <div class="slider-image text-center">
                            <img id="quickViewImage" src="" class="img-fluid blur-up lazyload" alt="Producto">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="right-sidebar-modal">
                            <h4 class="title-name" id="quickViewTitle"></h4>
                            <h4 class="price" id="quickViewPrice"></h4>

                            <div class="product-detail">
                                <h4>Detalles del Producto:</h4>
                                <p id="quickViewDescription"></p>
                            </div>

                            <ul class="brand-list">
                                <li>
                                    <div class="brand-box">
                                        <h5>Marca:</h5>
                                        <h6 id="quickViewBrand"></h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="brand-box">
                                        <h5>Código de Producto:</h5>
                                        <h6 id="quickViewCode"></h6>
                                    </div>
                                </li>
                            </ul>

                            <div class="modal-button d-flex gap-2">
                                <button class="btn btn-md add-cart-button icon" id="quickViewAddToCart">
                                    Agregar al carrito
                                </button>
                                <a href="#" id="quickViewMoreLink" class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                    Ver más detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin del Modal de Vista Rápida -->