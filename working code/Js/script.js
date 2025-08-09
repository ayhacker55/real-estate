/* pop modal for request quote */
  // Safely run code after DOM is loaded
 document.addEventListener('DOMContentLoaded', () => {
  const openModalBtns = document.querySelectorAll('#openQuoteModal, .quote-btn');
  const modal = document.getElementById('quoteModal');
  const overlay = document.getElementById('modalOverlay');
  const closeModalBtn = document.getElementById('closeModal');
  const toggleFormBtn = document.getElementById('toggleForm');
  const quoteForm = document.getElementById('quoteForm');

  openModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      modal.style.display = 'block';
      overlay.style.display = 'block';
    });
  });

  closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
    overlay.style.display = 'none';
  });

  overlay.addEventListener('click', () => {
    modal.style.display = 'none';
    overlay.style.display = 'none';
  });

  if (toggleFormBtn) {
    toggleFormBtn.addEventListener('click', () => {
      quoteForm.classList.toggle('hidden');
    });
  }
});


  /* end of pop modal for request quote */


  /* validation of inputs for request quote */

 function validateForm(event) {
  event.preventDefault();

  const name = document.getElementById('name');
  const email = document.getElementById('email');
  const phone = document.getElementById('phone');
  const message = document.getElementById('message');

  const namePattern = /^[A-Za-z\s]+$/; // Only letters and spaces
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
  const phonePattern = /^\+?[0-9\s\-()]{7,20}$/; // International formats allowed

  // Check required fields are not empty
  if (
    name.value.trim() === '' ||
    email.value.trim() === '' ||
    phone.value.trim() === '' ||
    message.value.trim() === ''
  ) {
    alert('Please fill out all required fields.');
    return false;
  }

  // Name validation
  if (!namePattern.test(name.value.trim())) {
    alert('Name should only contain letters and spaces.');
    return false;
  }

  // Email validation
  if (!emailPattern.test(email.value.trim())) {
    alert('Please enter a valid email address.');
    return false;
  }

  // Phone number validation
  if (!phonePattern.test(phone.value.trim())) {
    alert('Please enter a valid phone number.');
    return false;
  }

  // Message length check (optional)
  if (message.value.trim().length < 10) {
    alert('Please enter a more detailed message (at least 10 characters).');
    return false;
  }

  // Simulate successful submission
  alert('Quote request submitted successfully!');
  document.getElementById('quoteForm').reset();
  document.getElementById('quoteForm').classList.add('hidden');

  // Optional: hide modal if you're using one
  const quoteModal = document.getElementById('quoteModal');
  const modalOverlay = document.getElementById('modalOverlay');
  if (quoteModal) quoteModal.style.display = 'none';
  if (modalOverlay) modalOverlay.style.display = 'none';

  return true;
}


 


  /* countries pop modal */




  


  /* Countries  */


    /* End validation of inputs for request quote */


    /* Start of both mobile Hamburgermen n Menu */

 document.addEventListener('DOMContentLoaded', function () {
  const hamburger = document.getElementById('hamburgerMenu');
  const mobileNav = document.getElementById('mobileNavMenu');

  const dots = document.getElementById('mobileMenuToggle');
  const mobilePopup = document.getElementById('mobilePopup');

  hamburger.addEventListener('click', function () {
    mobileNav.classList.toggle('active');
    mobilePopup.classList.remove('active'); // Close other if open
  });

  dots.addEventListener('click', function () {
    mobilePopup.classList.toggle('active');
    mobileNav.classList.remove('active'); // Close other if open
  });

  // Close menus when clicking outside
  document.addEventListener('click', function (e) {
    if (!mobileNav.contains(e.target) && !hamburger.contains(e.target)) {
      mobileNav.classList.remove('active');
    }
    if (!mobilePopup.contains(e.target) && !dots.contains(e.target)) {
      mobilePopup.classList.remove('active');
    }
  });

  // Mobile dropdown toggles
  document.querySelectorAll('.mobile-has-dropdown > a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      this.parentElement.classList.toggle('open');
    });
  });
});



