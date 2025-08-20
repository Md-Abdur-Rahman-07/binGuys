const slider = document.querySelector('.slider');
const sliderItems = document.querySelectorAll('.slider-item');
const prevButton = document.querySelector('.nav-button.prev');
const nextButton = document.querySelector('.nav-button.next');

let currentIndex = 0;

function updateSliderPosition() {
  const sliderWidth = sliderItems[0].offsetWidth;
  slider.style.transform = `translateX(-${currentIndex * sliderWidth}px)`;
}

prevButton.addEventListener('click', () => {
  currentIndex = Math.max(currentIndex - 1, 0);
  updateSliderPosition();
});

nextButton.addEventListener('click', () => {
  currentIndex = Math.min(currentIndex + 1, sliderItems.length - 1);
  updateSliderPosition();
});

window.addEventListener('resize', updateSliderPosition);

// Initialize position on load
updateSliderPosition();