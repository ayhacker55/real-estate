const carousel = document.getElementById('carousel');
    const dots = document.getElementById('dots');

    function getCardWidth() {
      const c = carousel.querySelector('.testimonial');
      return c ? c.offsetWidth : 300;
    }

    function refreshDots() {
      dots.innerHTML = '';
      for (let i = 0; i < carousel.children.length; i++) {
        const d = document.createElement('div');
        d.className = 'dot' + (i === 0 ? ' active' : '');
        dots.appendChild(d);
      }
    }

    function updateDots() {
      const idx = Math.round(carousel.scrollLeft / (getCardWidth() + 16));
      dots.querySelectorAll('.dot').forEach((d,i)=>d.classList.toggle('active', i===idx));
    }

    function autoScroll() {
      const w = getCardWidth() + 16;
      const next = carousel.scrollLeft + w;
      if (next >= carousel.scrollWidth - carousel.offsetWidth) {
        carousel.scrollTo({left:0, behavior:'smooth'});
      } else {
        carousel.scrollBy({left:w, behavior:'smooth'});
      }
    }

    refreshDots();
    carousel.addEventListener('scroll', ()=>requestAnimationFrame(updateDots));
    setInterval(autoScroll, 5000);

    // Modal
    const popup = document.getElementById('ts-formPopup');
    const overlay = document.getElementById('ts-overlay');
    function openForm(){ popup.style.display='block'; overlay.style.display='block'; }
    function closeForm(){ popup.style.display='none'; overlay.style.display='none'; }

    // Star Rating
    const starContainer = document.getElementById('ts-starRating');
    const ratingInput = document.getElementById('ratingInput');
    starContainer.innerHTML = [...Array(5)].map((_,i)=>`<span data-value="${i+1}">★</span>`).join('');
    function updateStars(r){
      starContainer.querySelectorAll('span').forEach((s,i)=>{
        s.classList.toggle('active', i<r);
      });
    }
    starContainer.addEventListener('click', e=>{
      if(e.target.tagName==='SPAN'){
        const v=+e.target.dataset.value;
        ratingInput.value=v;
        updateStars(v);
      }
    });
    starContainer.addEventListener('mouseover', e=>{
      if(e.target.tagName==='SPAN') updateStars(+e.target.dataset.value);
    });
    starContainer.addEventListener('mouseleave', ()=> updateStars(+ratingInput.value));
    updateStars(0);