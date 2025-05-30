<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel - Rajeswari Handloom</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f8f9fa, #eef1f6);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 40px;
    }

    .container {
      width: 100%;
      max-width: 1000px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      padding: 40px;
      overflow: hidden;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #2d3436;
      font-size: 2rem;
    }

    form {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }

    form div {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: 600;
      margin-bottom: 6px;
      color: #636e72;
    }

    input, select {
      padding: 10px 14px;
      border: 1.5px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      transition: border 0.3s;
    }

    input:focus, select:focus {
      border-color: #6c5ce7;
      outline: none;
    }

    button[type="submit"] {
      grid-column: 1 / -1;
      padding: 14px;
      background: #6c5ce7;
      border: none;
      border-radius: 10px;
      color: white;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
    }

    button[type="submit"]:hover {
      background: #5a4bd1;
    }

    .product-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 25px;
    }

    .product-item {
      background: #fdfdfd;
      border-radius: 14px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 20px;
      transition: transform 0.2s;
    }

    .product-item:hover {
      transform: translateY(-6px);
    }

    .product-item img {
      width: 100%;
      max-height: 160px;
      object-fit: cover;
      border-radius: 8px;
      margin: 12px 0;
      background: #f0f0f0;
    }

    .product-item h3 {
      margin: 0 0 10px;
      font-size: 1.1rem;
      color: #2d3436;
    }

    .product-details p {
      margin: 4px 0;
      color: #636e72;
      font-size: 0.95rem;
    }

    .product-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 12px;
    }

    .product-actions button {
      flex: 1;
      margin: 0 4px;
      padding: 8px 0;
      border: none;
      border-radius: 6px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      color: white;
    }

    .product-actions button:first-child {
      background: #00b894;
    }

    .product-actions button:last-child {
      background: #d63031;
    }

    .product-actions button:hover:first-child {
      background: #00997a;
    }

    .product-actions button:hover:last-child {
      background: #c0392b;
    }

    @media (max-width: 600px) {
      body {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Admin Panel - Manage Products</h1>
    <form id="product-form" autocomplete="off">
      <input type="hidden" id="product-id" />

      <div>
        <label for="product-title">Title</label>
        <input type="text" id="product-title" placeholder="Enter product title" required />
      </div>

      <div>
        <label for="product-category">Category</label>
        <select id="product-category" required>
          <option value="" disabled selected>Select category</option>
          <option value="Bomkai Silk">Bomkai Silk</option>
          <option value="Kotpad Cotton">Kotpad Cotton</option>
          <option value="Tissue Silk">Tissue Silk</option>
          <option value="Tusser Silk">Tusser Silk</option>
        </select>
      </div>

      <div>
        <label for="product-price">Price (₹)</label>
        <input type="number" id="product-price" placeholder="Enter price" min="0" step="0.01" required />
      </div>

      <div>
        <label for="product-image">Image URL</label>
        <input type="url" id="product-image" placeholder="Enter image URL" required />
      </div>

      <button type="submit">Add / Update Product</button>
    </form>

    <div class="product-list" id="product-list"></div>
  </div>

  <script>
    const form = document.getElementById('product-form');
    const productListDiv = document.getElementById('product-list');
    let products = JSON.parse(localStorage.getItem('products')) || [];

    function renderProducts() {
      productListDiv.innerHTML = '';
      if (products.length === 0) {
        productListDiv.innerHTML = '<p style="text-align:center; color:#777;">No products added yet.</p>';
        return;
      }

      products.forEach((product, index) => {
        const div = document.createElement('div');
        div.className = 'product-item';
        div.innerHTML = `
          <h3>${product.title}</h3>
          <div class="product-details">
            <p><strong>Category:</strong> ${product.category}</p>
            <p><strong>Price:</strong> ₹${product.price.toFixed(2)}</p>
          </div>
          <img src="${product.image}" alt="${product.title}" />
          <div class="product-actions">
            <button onclick="editProduct(${index})">Edit</button>
            <button onclick="deleteProduct(${index})">Delete</button>
          </div>
        `;
        productListDiv.appendChild(div);
      });
    }

    function editProduct(index) {
      const product = products[index];
      document.getElementById('product-id').value = index;
      document.getElementById('product-title').value = product.title;
      document.getElementById('product-category').value = product.category;
      document.getElementById('product-price').value = product.price;
      document.getElementById('product-image').value = product.image;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function deleteProduct(index) {
      if (confirm('Are you sure you want to delete this product?')) {
        products.splice(index, 1);
        localStorage.setItem('products', JSON.stringify(products));
        renderProducts();
      }
    }

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const id = document.getElementById('product-id').value;
      const title = document.getElementById('product-title').value.trim();
      const category = document.getElementById('product-category').value;
      const price = parseFloat(document.getElementById('product-price').value);
      const image = document.getElementById('product-image').value.trim();

      if (!title || !category || isNaN(price) || !image) {
        alert('Please fill in all fields correctly.');
        return;
      }

      const productData = { title, category, price, image };

      if (id === '') {
        products.push(productData);
      } else {
        products[id] = productData;
      }

      localStorage.setItem('products', JSON.stringify(products));
      form.reset();
      document.getElementById('product-id').value = '';
      renderProducts();
    });

    renderProducts();
  </script>
</body>
</html>