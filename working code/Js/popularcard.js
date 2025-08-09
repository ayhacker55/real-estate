 document.addEventListener('DOMContentLoaded', () => {
    // === Auto-scroll for all .cards-container ===
    document.querySelectorAll('.cards-container').forEach((container, index) => {
      const cards = container.querySelectorAll('.property-card');
      const dotWrapper = document.createElement('div');
      dotWrapper.className = 'dots-container';

      cards.forEach((_, i) => {
        const dot = document.createElement('span');
        dot.className = 'dot';
        if (i === 0) dot.classList.add('active');

        dot.addEventListener('click', () => {
          container.scrollTo({
            left: cards[i].offsetLeft,
            behavior: 'smooth'
          });
        });

        dotWrapper.appendChild(dot);
      });

      container.parentElement.appendChild(dotWrapper);

      container.addEventListener('scroll', () => {
        const scrollLeft = container.scrollLeft;
        const cardWidth = cards[0].offsetWidth + parseInt(getComputedStyle(container).gap) || 0;
        const activeIndex = Math.round(scrollLeft / cardWidth);

        dotWrapper.querySelectorAll('.dot').forEach((d, i) => {
          d.classList.toggle('active', i === activeIndex);
        });
      });

      // Optional auto-scroll
      let scrollAmount = 1;
      let autoScroll;

      function startAutoScroll() {
        stopAutoScroll();
        autoScroll = setInterval(() => {
          container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
          if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 1) {
            container.scrollTo({ left: 0, behavior: 'smooth' });
          }
        }, 3000);
      }

      function stopAutoScroll() {
        clearInterval(autoScroll);
      }

      startAutoScroll();
      container.addEventListener('mouseenter', stopAutoScroll);
      container.addEventListener('mouseleave', startAutoScroll);
    });

    // === Filter functionality ===
    const buttons = document.querySelectorAll('.filter-bar button');
    const sections = document.querySelectorAll('.category-section');

    function showAllCategories() {
      sections.forEach(section => section.classList.add('active'));
    }

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        const filter = button.dataset.filter;

        if (filter === 'all') {
          showAllCategories();
        } else {
          sections.forEach(section => {
            section.classList.remove('active');
            if (section.classList.contains(filter)) {
              section.classList.add('active');
            }
          });
        }
      });
    });

    showAllCategories();
  });