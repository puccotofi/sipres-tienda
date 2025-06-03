document.addEventListener("DOMContentLoaded", function () {
    loadCart();
    loadWishlist();
    updateWishlistCount(); // Actualizar la cantidad de productos en la wishlist al cargar la página
});

// Función para actualizar la cantidad en carrito y wishlist
function updateQuantity(productId, action) {
    let qtyInput = document.getElementById(`qty-${productId}`);
    let quantity = parseInt(qtyInput.value);

    if (action === "plus") {
        quantity++;
    } else if (action === "minus" && quantity > 1) {
        quantity--;
    }

    qtyInput.value = quantity;
}

// Función para agregar al carrito
function addToCart(productId, imageUrl, url, price, name) {
    let quantity = parseInt(document.getElementById(`qty-${productId}`).value);
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let existingProduct = cart.find((item) => item.id === productId);
    if (existingProduct) {
        existingProduct.quantity += quantity;
    } else {
        cart.push({
            id: productId,
            image: imageUrl,
            url: url,
            price: price,
            name: name,
            quantity: quantity,
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    // Si el producto está en wishlist, eliminarlo al agregar al carrito
    removeFromWishlist(productId);

    alert("Producto agregado al carrito y eliminado de la lista de deseos");
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
        alert("Producto agregado a la lista de deseos");
    } else {
        alert("Este producto ya está en la lista de deseos");
    }
}

// Función para eliminar un producto de la wishlist
function removeFromWishlist(productId) {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    wishlist = wishlist.filter((item) => item.id !== productId);
    localStorage.setItem("wishlist", JSON.stringify(wishlist));
    updateWishlistCount();
    loadWishlist();
}

// Función para cargar el carrito
function loadCart() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
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
            <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
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
