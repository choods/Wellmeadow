 AOS.init({
        duration: 900, // Animation duration in milliseconds
        offset: 200, // Offset (in px) from the original trigger point
        easing: 'ease-in-out', // Easing function
        once: true, // Whether animation should happen only once - while scrolling down
    });

    const prev = document.querySelector('.prev');
const next = document.querySelector('.next');
const carouselContainer = document.querySelector('.carousel-container');
const carouselSlides = document.querySelectorAll('.carousel-slide img');

let index = 0;
const totalSlides = carouselSlides.length;

function showSlide(index) {
    const offset = -index * 100;
    carouselContainer.style.transform = `translateX(${offset}%)`;
}

prev.addEventListener('click', () => {
    index = (index > 0) ? index - 1 : totalSlides - 1;
    showSlide(index);
});

next.addEventListener('click', () => {
    index = (index < totalSlides - 1) ? index + 1 : 0;
    showSlide(index);
});

document.addEventListener('DOMContentLoaded', function() {
    const card = document.querySelector('.card');
  
    // Toggle between front and back on card click
    card.addEventListener('click', function() {
      card.classList.toggle('flipped');
    });
  });
  