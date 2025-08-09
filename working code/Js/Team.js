const teamTrack = document.getElementById('team-slider-track');
const teamSlides = document.querySelectorAll('.team-slide');
const teamDotContainer = document.getElementById('team-dot-container');

function getVisibleTeamCards() {
  if (window.innerWidth <= 600) return 1;
  if (window.innerWidth <= 900) return 2;
  return 3;
}

let teamIndex = 0;
let teamVisibleCards = getVisibleTeamCards();
let teamTotalGroups = Math.ceil(teamSlides.length / teamVisibleCards);

function updateTeamSlider() {
  const slideWidth = teamSlides[0].offsetWidth + 20; // include gap
  teamTrack.style.transform = `translateX(-${teamIndex * slideWidth * teamVisibleCards}px)`;
  updateTeamDots();
}

function createTeamDots() {
  teamDotContainer.innerHTML = '';
  for (let i = 0; i < teamTotalGroups; i++) {
    const dot = document.createElement('div');
    dot.classList.add('team-dot');
    dot.addEventListener('click', () => {
      teamIndex = i;
      updateTeamSlider();
    });
    teamDotContainer.appendChild(dot);
  }
  updateTeamDots();
}

function updateTeamDots() {
  const dots = document.querySelectorAll('.team-dot');
  dots.forEach((dot, i) => {
    dot.classList.toggle('active', i === teamIndex);
  });
}

function nextTeamSlide() {
  teamIndex = (teamIndex + 1) % teamTotalGroups;
  updateTeamSlider();
}

let teamAutoSlide = setInterval(nextTeamSlide, 5000);

document.getElementById('team-slider-container').addEventListener('mouseover', () => clearInterval(teamAutoSlide));
document.getElementById('team-slider-container').addEventListener('mouseout', () => teamAutoSlide = setInterval(nextTeamSlide, 5000));

window.addEventListener('resize', () => {
  teamVisibleCards = getVisibleTeamCards();
  teamTotalGroups = Math.ceil(teamSlides.length / teamVisibleCards);
  teamIndex = 0;
  createTeamDots();
  updateTeamSlider();
});

// Init
createTeamDots();
updateTeamSlider();
