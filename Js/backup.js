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
    const message = document.getElementById('message');

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;


    if (name.value.trim() === "" || message.value.trim() === "") {
      alert("Please fill out all required fields.");
      return false;
    }

    if (!emailPattern.test(email.value)) {
      alert("Please enter a valid email.");
      return false;
    }

    // Simulate submission
    alert("Quote request submitted successfully!");
    document.getElementById('quoteForm').reset();
    document.getElementById('quoteForm').classList.add('hidden');
    document.getElementById('quoteModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';

    return true;
  }


 


  /* countries pop modal */

  document.addEventListener("DOMContentLoaded", () => {
    const phoneInputField = document.querySelector("#phone");

    const iti = window.intlTelInput(phoneInputField, {
      initialCountry: "ng", // Set default country to Nigeria
      preferredCountries: ["ng", "us", "gb", "in"],
      separateDialCode: true,
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js" // ⬅️ Required for formatting & validation
    });

    // Form submission and validation
    document.getElementById("quoteForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const phoneNumber = iti.getNumber(); // E.164 format
      const isValid = iti.isValidNumber();

      if (!isValid) {
        alert("Please enter a valid phone number.");
        return false;
      }

      alert("Form submitted successfully!\nPhone: " + phoneNumber);
      this.reset();
      document.getElementById('quoteForm').classList.add('hidden');
      document.getElementById('quoteModal').style.display = 'none';
      document.getElementById('modalOverlay').style.display = 'none';
    });
  });

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

    // Optional: close menus when clicking outside
    document.addEventListener('click', function (e) {
      if (!mobileNav.contains(e.target) && !hamburger.contains(e.target)) {
        mobileNav.classList.remove('active');
      }
      if (!mobilePopup.contains(e.target) && !dots.contains(e.target)) {
        mobilePopup.classList.remove('active');
      }
    });
  });

    /* end of both mobile Hamburgermen n Menu */