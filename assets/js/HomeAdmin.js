const track = document.querySelector('.carousel-track');
const slides = Array.from(track.children);
let currentIndex = 0;

function updateSlides() {
  slides.forEach((slide, index) => {
    if (index === currentIndex) {
      slide.classList.add('active');
      slide.classList.remove('left', 'right');
    } else if (index === (currentIndex + 1) % slides.length) {
      slide.classList.add('right');
      slide.classList.remove('active', 'left');
    } else if (index === (currentIndex - 1 + slides.length) % slides.length) {
      slide.classList.add('left');
      slide.classList.remove('active', 'right');
    } else {
      slide.classList.remove('active', 'left', 'right');
    }
  });
}

function moveToNextSlide() {
  currentIndex = (currentIndex + 1) % slides.length;
  updateSlides();
}

setInterval(moveToNextSlide, 3000); // Change every 3 seconds

updateSlides();
