// Select all image slider elements
const sliderContainer = document.querySelector('.slider');
const sliderImages = document.querySelectorAll('.slider img');

// Set initial slide index
let slideIndex = 0;

// Create navigation buttons
const prevBtn = document.createElement('button');
prevBtn.className = 'slider-btn prev-btn';
prevBtn.innerHTML = '&#10094;';
const nextBtn = document.createElement('button');
nextBtn.className = 'slider-btn next-btn';
nextBtn.innerHTML = '&#10095;';
sliderContainer.appendChild(prevBtn);
sliderContainer.appendChild(nextBtn);

// Set up event listeners for navigation buttons
prevBtn.addEventListener('click', () => {
  if (slideIndex === 0) {
    slideIndex = sliderImages.length - 1;
  } else {
    slideIndex--;
  }
  updateSlide();
});

nextBtn.addEventListener('click', () => {
  if (slideIndex === sliderImages.length - 1) {
    slideIndex = 0;
  } else {
    slideIndex++;
  }
  updateSlide();
});

// Set up interval for autoplay
let interval = setInterval(() => {
  if (slideIndex === sliderImages.length - 1) {
    slideIndex = 0;
  } else {
    slideIndex++;
  }
  updateSlide();
}, 5000);

// Update slide function
// Update slide function
function updateSlide() {
  // Hide all images
  sliderImages.forEach((image) => {
    image.classList.remove('active');
  });

  // Show current and next three images
  for (let i = slideIndex; i < slideIndex + 4; i++) {
    sliderImages[i % sliderImages.length].classList.add('active');
  }
}

