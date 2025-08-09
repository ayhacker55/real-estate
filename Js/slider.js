
  document.addEventListener("DOMContentLoaded", () => {
    const track = document.getElementById("sliderTrack");
    const slides = document.querySelectorAll(".slide");
    const dotsContainer = document.getElementById("sliderDots");
    let currentIndex = 0;
    const totalSlides = slides.length;

    // Create dots
    slides.forEach((_, i) => {
      const dot = document.createElement("span");
      dot.addEventListener("click", () => goToSlide(i));
      dotsContainer.appendChild(dot);
    });

    const dots = dotsContainer.querySelectorAll("span");
    dots[0].classList.add("active");

    function goToSlide(index) {
      currentIndex = index;
      track.style.transform = `translateX(-${index * 100}%)`;
      dots.forEach(dot => dot.classList.remove("active"));
      dots[index].classList.add("active");
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      goToSlide(currentIndex);
    }

    // Autoplay
    setInterval(nextSlide, 5000);
  });

