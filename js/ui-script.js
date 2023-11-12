let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () => {
  menu.classList.toggle('fa-times');
  navbar.classList.toggle('active');
}

window.onscroll = () => {
  menu.classList.remove('fa-times');
  navbar.classList.remove('active');
}

var swiper = new Swiper(".hero-slider", {
  spaceBetween: 30,
  loop: true,
  autoplay: {
    delay: 4000,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

let slide = document.querySelectorAll('.slide');
var swiper1 = new Swiper(".reviews-slider", {
  loop: true,
  spaceBetween: 20,
  autoHeight: true,
  grabCursor: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
    renderBullet: function (index, className) {
      return '<span class="' + className + '">' + (index + 1) + "</span>";
    },
  },
  breakpoints: {
    640: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

const bookingList = document.querySelector('.booking-list');
const bookingBtn = document.querySelector('.booking-btn');

bookingBtn.onclick = () => {
  bookingList.classList.toggle('d-show');
  bookingList.classList.toggle('d-none');
};

// Add scroll event listener
window.onscroll = () => {
  bookingList.classList.add('d-none');
  bookingList.classList.remove('d-show');
};

const cross = document.querySelector(".cross");
cross.onclick = () => {
  bookingList.classList.add('d-none');
  bookingList.classList.remove('d-show'); 
}