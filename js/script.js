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
  
  // Check if user has already accepted cookies
  window.onload = function() {
    if (localStorage.getItem('cookieAccepted') === 'true') {
      document.getElementById('cookieBanner').style.display = 'none';
    }
  }

  function hideCookieBanner() {
    document.getElementById('cookieBanner').style.display = 'none';
    localStorage.setItem('cookieAccepted', 'true');
  }



  function flipCard(card) {
    card.classList.toggle("flipped");
  }




  function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('active');
  }

  const handle = document.querySelector('.handle');
  const topPanel = document.querySelector('.top');

  let isDragging = false;

  document.addEventListener('mousedown', (e) => {
    isDragging = true;
  });

  document.addEventListener('mouseup', () => {
    isDragging = false;
  });

  document.addEventListener('mousemove', (e) => {
    if (!isDragging) return;

    const splitview = document.querySelector('.splitview');
    const rect = splitview.getBoundingClientRect();
    let offset = e.clientX - rect.left;

    // Clamp between 0 and full width
    offset = Math.max(0, Math.min(offset, rect.width));

    const percent = (offset / rect.width) * 100;
    handle.style.left = `${percent}%`;
    topPanel.style.width = `${percent}%`;
  });


  const slider = document.querySelector(".info-slider");
  const dots = document.querySelectorAll(".dot");

  let currentSlide = 0;

  function goToSlide(index) {
    currentSlide = index;
    slider.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((dot, i) => {
      dot.classList.toggle("active", i === index);
    });
  }

  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      goToSlide(index);
    });
  });
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

  


  
  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      const index = parseInt(dot.getAttribute('data-index'));

      // Update info boxes
      boxes.forEach(box => box.classList.remove('active'));
      boxes[index].classList.add('active');

      // Update dots
      dots.forEach(d => d.classList.remove('active'));
      dot.classList.add('active');
    });
  });