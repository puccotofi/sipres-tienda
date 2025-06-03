document.addEventListener("DOMContentLoaded", function () {

    const syncUrl = window.syncCartWishlistUrl;

    console.log("📦 Detectando usuario y datos de carrito...");

    if (window.authUserId) {
        let cart = localStorage.getItem("cart");
        let wishlist = localStorage.getItem("wishlist");

        console.log("🛒 localStorage.cart:", cart);
        console.log("💖 localStorage.wishlist:", wishlist);

        if (cart || wishlist) {
            console.log("🚀 Enviando datos al backend para sincronizar...");

            fetch(syncUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    cart: JSON.parse(cart || "[]"),
                    wishlist: JSON.parse(wishlist || "[]"),
                }),
            })
                .then((res) => {
                    if (!res.ok) {
                        throw new Error(
                            "❌ Error en la respuesta del servidor"
                        );
                    }
                    return res.json();
                })
                .then((res) => {
                    console.log("✅ Respuesta del servidor:", res);

                    if (res.success) {
                        localStorage.removeItem("cart");
                        localStorage.removeItem("wishlist");
                        console.log(
                            "🧹 Datos antiguos eliminados del localStorage."
                        );

                        // Validar y regenerar
                        if (res.cart && Array.isArray(res.cart)) {
                            localStorage.setItem(
                                "cart",
                                JSON.stringify(res.cart)
                            );
                            console.log(
                                "🛒 Nuevo cart sincronizado:",
                                res.cart
                            );
                        }

                        if (res.wishlist && Array.isArray(res.wishlist)) {
                            localStorage.setItem(
                                "wishlist",
                                JSON.stringify(res.wishlist)
                            );
                            console.log(
                                "💖 Nueva wishlist sincronizada:",
                                res.wishlist
                            );
                        }
                    }
                })
                .catch((err) => {
                    console.error("❌ Error durante la sincronización:", err);
                });
        } else {
            console.log("⚠️ No hay datos que sincronizar.");
        }
    } else {
        console.log(
            "🔒 Usuario no autenticado, no se sincroniza localStorage."
        );
    }
});
