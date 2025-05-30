// Photo Slider
const swiper = new Swiper('.photo-slider', {
  loop: true,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true
  },
  grabCursor: true,
  simulateTouch: true,
  touchRatio: 1
});

// Cookie Banner
window.onload = function () {
  if (localStorage.getItem('cookieAccepted') === 'true') {
    const cookieBanner = document.getElementById('cookieBanner');
    if (cookieBanner) cookieBanner.style.display = 'none';
  }
};

function hideCookieBanner() {
  const cookieBanner = document.getElementById('cookieBanner');
  if (cookieBanner) cookieBanner.style.display = 'none';
  localStorage.setItem('cookieAccepted', 'true');
}

// Flip Card
function flipCard(card) {
  card.classList.toggle("flipped");
}

// Split View Handle
const handle = document.querySelector('.handle');
const topPanel = document.querySelector('.top');
let isDragging = false;

document.addEventListener('mousedown', () => isDragging = true);
document.addEventListener('mouseup', () => isDragging = false);
document.addEventListener('mousemove', (e) => {
  if (!isDragging || !handle || !topPanel) return;
  const splitview = document.querySelector('.splitview');
  const rect = splitview.getBoundingClientRect();
  let offset = e.clientX - rect.left;
  offset = Math.max(0, Math.min(offset, rect.width));
  const percent = (offset / rect.width) * 100;
  handle.style.left = `${percent}%`;
  topPanel.style.width = `${percent}%`;
});

// Info Slider
const slider = document.querySelector(".info-slider");
const dots = document.querySelectorAll(".dot");
const boxes = document.querySelectorAll(".info-box");
let currentSlide = 0;

function goToSlide(index) {
  currentSlide = index;
  if (slider) slider.style.transform = `translateX(-${index * 100}%)`;
  dots.forEach((dot, i) => dot.classList.toggle("active", i === index));
  boxes.forEach((box, i) => box.classList.toggle("active", i === index));
}

dots.forEach((dot, index) => {
  dot.addEventListener("click", () => goToSlide(index));
});

// Product Image Sliders
const thumbSwiper = new Swiper(".thumb-slider", {
  slidesPerView: 4,
  spaceBetween: 10,
  watchSlidesProgress: true,
  breakpoints: {
    768: { slidesPerView: 4 },
    480: { slidesPerView: 3 },
    320: { slidesPerView: 2 }
  }
});

const mainSwiper = new Swiper(".main-slider", {
  spaceBetween: 10,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  thumbs: {
    swiper: thumbSwiper
  }
});

// Toggle Mobile Menu
function toggleMenu() {
  const menu = document.getElementById("mobileMenu");
  if (menu) {
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  }
}

// Update Cart Badge
function updateCartBadge(count) {
  const desktopBadge = document.getElementById('desktop-cart-count');
  const mobileBadge = document.getElementById('mobile-cart-count');

  if (desktopBadge) {
    desktopBadge.style.display = count > 0 ? 'inline-block' : 'none';
    desktopBadge.textContent = count;
  }

  if (mobileBadge) {
    mobileBadge.style.display = count > 0 ? 'inline-block' : 'none';
    mobileBadge.textContent = count;
  }
}

// Load and Update Cart Count from localStorage
function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  updateCartBadge(totalItems);
}

// Redirect on Cart Icon Click + Search Functionality
document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();

  // Cart Click Event
  document.querySelectorAll(".fa-cart-shopping").forEach(icon => {
    icon.style.cursor = "pointer";
    icon.addEventListener("click", () => {
      window.location.href = "cart.html";
    });
  });

  // Search Click Event
  document.querySelectorAll(".fa-magnifying-glass").forEach(icon => {
    icon.style.cursor = "pointer";
    icon.addEventListener("click", () => {
      const query = prompt("Search for products:");
      if (query) {
        window.location.href = `search.html?q=${encodeURIComponent(query)}`;
      }
    });
  });
<<<<<<< HEAD


  // Dynamically routing
  function viewProductDetail(productId) {
    // Store the clicked product ID in localStorage
    localStorage.setItem("selectedProductId", productId);
    // Redirect to the product-detail page
    window.location.href = "product-detail.html";
}
=======
});
>>>>>>> Jayashre2001
