document.addEventListener("DOMContentLoaded", function () {
    loadCart();
    loadWishlist();
    updateWishlistCount(); // Actualizar la cantidad de productos en la wishlist al cargar la página
    updateCartCount();
    updateCartTotal();
    updateCartCount();
    updateCartDropdown();
});

// Función para actualizar la cantidad en carrito y wishlist
function updateQuantity(productId, action) {
    const input = document.getElementById(`qty-${productId}`);
    let currentQty = parseInt(input.value) || 1;
   // console.log(`Producto ID: ${productId}, Acción: ${action}, Cantidad actual: ${currentQty}`);
    if (action === "plus") {
        currentQty++;
    } else if (action === "minus" && currentQty > 1) {
        currentQty--;
    }
    //console.log('El nombre del input es:', input.id);
    //console.log(`Nueva cantidad: ${currentQty}`);
    input.value = currentQty;
    onQtyChange(productId);
}

// Función para actualizar la cantidad al cambiar el en el carrito de compras

function onQtyChange(productId) {
    console.log(`Cambiando cantidad del producto ID: ${productId}`);
    const input = document.getElementById(`qty-${productId}`);
    let qty = parseInt(input.value) || 1;
    input.value = qty; // Sanitiza el input

    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const item = cart.find((p) => p.id === productId);
    if (item) {
        item.quantity = qty;
        localStorage.setItem("cart", JSON.stringify(cart));

        // Actualizar subtotal por producto
        document.getElementById(`total-${productId}`).textContent = (
            item.price * qty
        ).toFixed(2);

        updateCartTotal();
    }
}

// Función para agregar al carrito
function addToCart(id, image, url, price, name) {
    const qtyInput = document.getElementById(`qty-${id}`);
    const quantity = parseInt(qtyInput.value) || 1;

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let item = cart.find((item) => item.id === id);

    if (item) {
        item.quantity += quantity;
        toastr.success("Producto Ya esta en el carrito, cantidad actualizada");
    } else {
        cart.push({ id, image, url, price, name, quantity });
        toastr.success("Producto agregado al carrito");
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartTotal();
}

// Función para agregar a la wishlist
function addToWishlist(productId, imageUrl, url, price, name) {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    let existingProduct = wishlist.find((item) => item.id === productId);
    if (!existingProduct) {
        wishlist.push({
            id: productId,
            image: imageUrl,
            url: url,
            price: price,
            name: name,
        });
        localStorage.setItem("wishlist", JSON.stringify(wishlist));
        updateWishlistCount(); // Actualizar contador en el header
        toastr.success("Producto agregado a la lista de deseos");
    } else {
        toastr.success("Este producto ya está en la lista de deseos");
    }
}

// Función para cargar el carrito
function loadCart() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartContainer = document.getElementById("cart-container");

    if (!cartContainer) return;

    if (cart.length === 0) {
        cartContainer.innerHTML =
            "<p class='text-center'>Tu carrito está vacío.</p>";
            updateCartTotal();
        return;
    }

    let htmlContent = `
        <thead>
            <tr class="text-center">
                <th>Imagen</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
    `;

    cart.forEach((item) => {
        htmlContent += `
        <tr>
            <!-- Imagen del Producto -->
            <td class="text-center">
                <a href="${item.url}">
                    <img src="${
                        item.image
                    }" class="img-fluid blur-up lazyload" style="width: 80px;" alt="${
            item.name
        }">
                </a>
            </td>

            <!-- Nombre del Producto -->
            <td class="text-center align-middle">
                <a href="${item.url}" class="name">${item.name}</a>
            </td>

            <!-- Precio Unitario -->
            <td class="text-center text-content align-middle">
                $${parseFloat(item.price).toFixed(2)}
            </td>

            <!-- Cantidad con botones de aumento/disminución -->
            <td class="text-center align-middle">
                <div class="cart_qty">
                    <div class="input-group">
                        <button type="button" class="btn qty-left-minus" onclick="updateQuantity(${
                            item.id
                        }, 'minus')">
                            <i class="fa fa-minus ms-0"></i>
                        </button>
                        <input class="form-control input-number qty-input text-center" type="text" id="qty-${
                            item.id
                        }" value="${item.quantity}"  onchange="onQtyChange(${item.id})">
                        <button type="button" class="btn qty-right-plus" onclick="updateQuantity(${
                            item.id
                        }, 'plus')">
                            <i class="fa fa-plus ms-0"></i>
                        </button>
                    </div>
                </div>
            </td>

            <!-- Total -->
            <td class="text-center text-content align-middle">
                $<span id="total-${item.id}">${(
            item.price * item.quantity
        ).toFixed(2)}</span>
            </td>

            <!-- Acción (Eliminar Producto) -->
            <td class="text-center align-middle">
                <a class="remove close_button text-danger" href="javascript:void(0)" onclick="removeFromCart(${
                    item.id
                })">
                    Eliminar
                </a>
            </td>
        </tr>
    `;
    });

    htmlContent += `</tbody>`;

    cartContainer.innerHTML = htmlContent;
    updateCartTotal();
    console.log("Carrito cargado:", cart);
}

// Función para cargar la wishlist y mostrarla en wishlists/index.blade.php
function loadWishlist() {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    let wishlistContainer = document.getElementById("wishlist-container");

    if (!wishlistContainer) return; // Evita errores si no está en la vista de wishlist

    if (wishlist.length === 0) {
        wishlistContainer.innerHTML =
            "<p class='text-center'>Tu lista de deseos está vacía.</p>";
        return;
    }

    let htmlContent = "";
    wishlist.forEach((chunk, index) => {
        if (index % 6 === 0) {
            htmlContent += '<div class="row">';
        }

        htmlContent += `
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="product-box-4 wow fadeInUp">
                    <div class="product-image">
                        <div class="label-flex">
                            <button class="btn p-0 wishlist btn-wishlist notifi-wishlist" onclick="removeFromWishlist(${
                                chunk.id
                            })">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <a href="${chunk.url}">
                            <img src="${chunk.image}" class="img-fluid" alt="${
                            chunk.name
                        }">
                        </a>

                        <ul class="option">
                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="Vista Rápida">
                                <a href="${chunk.url}">
                                    <i class="iconly-Show icli"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="product-detail">
                        <a href="${chunk.url}">
                            <h5 class="name">${chunk.name}</h5>
                        </a>
                        <h5 class="price theme-color">
                            $${parseFloat(chunk.price).toFixed(2)}
                        </h5>
                        <div class="price-qty">
                            <div class="counter-number">
                                <div class="counter">
                                    <div class="qty-left-minus" onclick="updateQuantity(${
                                        chunk.id
                                    }, 'minus')">
                                        <i class="fa-solid fa-minus"></i>
                                    </div>
                                    <input class="form-control input-number qty-input" type="text" id="qty-${
                                        chunk.id
                                    }" value="1">
                                    <div class="qty-right-plus" onclick="updateQuantity(${
                                        chunk.id
                                    }, 'plus')">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                </div>
                            </div>

                            <button class="buy-button buy-button-2 btn btn-cart" onclick="addToCart(${
                                chunk.id
                            }, '${chunk.image}', '${chunk.url}', '${
                                chunk.price
                            }')">
                                <i class="iconly-Buy icli text-white m-0"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        if ((index + 1) % 6 === 0) {
            htmlContent += "</div>"; // Cierra la fila cada 6 productos
        }
    });

    wishlistContainer.innerHTML = htmlContent;
}

// Función para editar una reseña (manteniendo la funcionalidad previa)
function editReview(reviewId, rating, comment) {
    document.getElementById("review_id").value = reviewId;
    document.getElementById("review_rating").value = rating;
    document.getElementById("review_comment").value = comment;
}

// Función para actualizar la cantidad de productos en el icono de la wishlist en el header
function updateWishlistCount() {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    let wishlistCountElement = document.getElementById("wishlist-count");

    if (wishlistCountElement) {
        wishlistCountElement.textContent = wishlist.length;
    }
}

function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartElement = document.getElementById("cart-count-uno");
    let cartElement2 = document.getElementById("cart-count-dos");

    if (cartElement) {
        cartElement.textContent = cart.length;
        cartElement2.textContent = cart.length;
    }
}

// Función para actualizar el total del carrito
function updateCartTotal() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let subtotal = cart.reduce(
        (sum, item) => sum + (item.price * item.quantity),
        0
    );
    //let shipping = cart.length > 0 ? 6.9 : 0; // Agregar envío si hay productos
    let shipping = 0; // Por ahora, no se aplica costo de envío
    let total = subtotal + shipping;

    // Guardar total en LocalStorage para usarlo en cualquier vista
    localStorage.setItem("cartTotal", total.toFixed(2));

    // Actualizar en la vista si existen los elementos
    if (document.getElementById("subtotal")) {
        document.getElementById("subtotal").textContent = `$ ${subtotal.toFixed(
            2
        )}`;
    }
    if (document.getElementById("total")) {
        document.getElementById("total").textContent = `$ ${total.toFixed(2)}`;
    }
    if (document.getElementById("total-uno")) {
        document.getElementById("total-uno").textContent = `$ ${total.toFixed(2)}`;
    }
    if (document.getElementById("cart-dropdown-total")) {
        document.getElementById("cart-dropdown-total").textContent = `$ ${total.toFixed(2)}`;
    }
}

// Función para eliminar un producto del carrito
function removeFromCart(productId) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart = cart.filter((item) => item.id !== productId);
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    updateCartTotal();
    updateCartDropdown();
    loadCart();

    // Eliminar también de la base de datos si el usuario está logueado
    if (window.authUserId) {
        fetch("/cart/" + productId, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
        })
            .then((res) => {
                if (!res.ok)
                    throw new Error(
                        "❌ No se pudo eliminar de la base de datos"
                    );
                console.log(
                    "🧹 Producto eliminado de BD (carrito):",
                    productId
                );
            })
            .catch((err) => console.error(err));
    }
}

// Función para eliminar un producto de la wishlist
function removeFromWishlist(productId) {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    wishlist = wishlist.filter((item) => item.id !== productId);
    localStorage.setItem("wishlist", JSON.stringify(wishlist));
    updateWishlistCount();
    loadWishlist();

    // Eliminar también de la base de datos si el usuario está logueado
    if (window.authUserId) {
        fetch("/wishlist/" + productId, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
        })
            .then((res) => {
                if (!res.ok)
                    throw new Error(
                        "❌ No se pudo eliminar de la base de datos"
                    );
                console.log(
                    "💔 Producto eliminado de BD (wishlist):",
                    productId
                );
            })
            .catch((err) => console.error(err));
    }
}

// Simulación del proceso de pago
function checkout() {
    toastr.success("Redirigiendo a la página de pago...");
}

function updateCartDropdown() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartDropdown = document.getElementById("cart-dropdown");
    let cartTotalElement = document.getElementById("cart-dropdown-total");

    if (!cartDropdown || !cartTotalElement) return;

    if (cart.length === 0) {
        cartDropdown.innerHTML =
            "<li class='text-center'>Tu carrito está vacío.</li>";
        cartTotalElement.textContent = "$ 0.00";
        return;
    }

    let htmlContent = "";
    let total = 0;

    cart.forEach((item) => {
        let itemTotal = item.price * item.quantity;
        total += itemTotal;

        htmlContent += `
            <li class="product-box-contain">
                <div class="drop-cart">
                    <a href="${item.url}" class="drop-image">
                        <img src="${
                            item.image
                        }" class="blur-up lazyload" alt="${
            item.name
        }" style="width: 50px; height: 50px; object-fit: cover;">
                    </a>

                    <div class="drop-contain">
                        <a href="${item.url}">
                            <h5 class="text-truncate" style="max-width: 150px;">${
                                item.name
                            }</h5>
                        </a>
                        <h6><span>${item.quantity} x</span> $ ${parseFloat(
            item.price
        ).toFixed(2)}</h6>
                        <button class="close-button close_button" onclick="removeFromCart(${
                            item.id
                        }, true)">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </li>
        `;
    });

    cartDropdown.innerHTML = htmlContent;
}
