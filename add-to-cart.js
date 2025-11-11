document.addEventListener("DOMContentLoaded", () => {
    const addToCartButton = document.getElementById("add-to-cart");

    addToCartButton.addEventListener("click", () => {
        const productId = addToCartButton.dataset.id;
        const productName = addToCartButton.dataset.name;
        const productPrice = parseFloat(addToCartButton.dataset.price);

        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Vérifier si le produit est déjà dans le panier
        const existingProduct = cart.find(product => product.id === productId);
        if (existingProduct) {
            existingProduct.quantity++;
        } else {
            cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        alert("Produit ajouté au panier !");
    });
});
