// Load cart from localStorage or initialize empty
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Select all "Add to Cart" buttons
const addToCartButtons = document.querySelectorAll('.add-to-cart');

// Add click event listener to each button
addToCartButtons.forEach(button => {
  button.addEventListener('click', function(event) {
    event.stopPropagation(); // prevent parent click

    // Find the product card this button belongs to
    const productCard = this.closest('.product-card');

    // Get product name and price
    const name = productCard.querySelector('.product-info h3').textContent.trim();
    const priceText = productCard.querySelector('.product-info .price').textContent.trim();
    const price = parseFloat(priceText.replace(/[₹, ]/g, ''));

    // Check if item already in cart
    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      cart.push({ name, price, quantity: 1 });
    }

    // Save updated cart to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Optionally update UI or show a toast message
    alert(`${name} added to cart!`);
    console.log('Cart:', cart);
  });
});
