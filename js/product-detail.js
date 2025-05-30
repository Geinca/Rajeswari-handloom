// Fetch the selected product ID from localStorage
const productId = localStorage.getItem("selectedProductId");

// Dummy product data
const products = [
    {
        id: 1,
        name: "Handloom Berhampur Silk Saree",
        price: "₹ 29,597.56",
        oldPrice: "₹ 36,996.95",
        image: "image/saree1.webp",
        description: "Authentic handwoven Berhampur Silk Saree with exquisite craftsmanship."
    },
    {
        id: 2,
        name: "Handloom Berhampur Silk Saree",
        price: "₹ 21,597.56",
        oldPrice: "₹ 27,996.95",
        image: "image/saree2.webp",
        description: "Elegant handloom saree with rich texture and intricate patterns."
    }
];

// Get the product based on the ID
const product = products.find(p => p.id == productId);

// Display product details on the page
const productDetail = document.getElementById("productDetail");

if (product) {
    productDetail.innerHTML = `
        <div class="product-info">
            <h2>${product.name}</h2>
            <img src="${product.image}" alt="${product.name}">
            <p><del>${product.oldPrice}</del> <span class="price">${product.price}</span></p>
            <p class="product-description">${product.description}</p>
            <button class="add-to-cart-btn" onclick="addToCart(${product.id})">Add to Cart</button>
            <a href="index.html" class="back-btn">Back to Products</a>
        </div>
    `;
} else {
    productDetail.innerHTML = `<p>Product not found!</p>`;
}

// Add to cart function
function addToCart(id) {
    alert("Product added to cart!");
}
