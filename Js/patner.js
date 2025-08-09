const track = document.getElementById('carouselTrack');
    const slides = document.querySelectorAll('.carousel-slide');
    let position = 0;

    function moveCarousel(direction) {
      const slideWidth = slides[0].offsetWidth;
      position += direction;

      if (position < 0) {
        position = slides.length - 1;
      } else if (position >= slides.length) {
        position = 0;
      }

      track.style.transform = `translateX(-${position * slideWidth}px)`;
    }

    setInterval(() => moveCarousel(1), 4000);

    window.addEventListener('resize', () => {
      track.style.transform = `translateX(-${position * slides[0].offsetWidth}px)`;
    });