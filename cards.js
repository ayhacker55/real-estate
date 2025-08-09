






  // Modal functions
  function showModal(id) {
    document.getElementById(id).style.display = 'block';
  }
  
  function closeModal(id) {
    document.getElementById(id).style.display = 'none';
  }
  
  function togglePasswordVisibility(inputId, iconElement) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
      input.type = 'text';
      iconElement.textContent = '🙈';
    } else {
      input.type = 'password';
      iconElement.textContent = '👁️';
    }
  }
  
  function startRegistration() {
    alert('Registration info submitted. OTP sent to your email.');
    closeModal('registerModal');
    showModal('registerOtpModal');
  }
  
  // Add click handler for postPropertyBtn
  document.getElementById('postPropertyBtn').addEventListener('click', function() {
    showModal('authChoiceModal');
  });
  
  // Your existing JavaScript functions can remain here
 
  
  // Other existing functions...
/*     function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('mobile-visible');
    }


    function togglePopup(id) {
  const popup = document.getElementById(id);
  if (!popup) return;

  if (popup.classList.contains('active')) {
    popup.classList.remove('active');
  } else {
    // Close any other open popups first
    document.querySelectorAll('.popup-overlay.active').forEach(el => el.classList.remove('active'));
    popup.classList.add('active');
  }
}

function closePopup(event) {
  if (event.target.classList.contains('popup-overlay')) {
    event.target.classList.remove('active');
  }
}


  function togglePopup(id) {
    document.getElementById(id).style.display = 'flex';
  }

  function closePopup(event) {
    event.target.style.display = 'none';
  }
 */
  function goBack() {
  window.history.back();
}




/* new from me */


    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('visible');
    }
    function togglePopup(id) {
      document.getElementById(id).style.display = 'flex';
    }
    function closePopup(event) {
      if (event.target.classList.contains('popup-overlay')) {
        event.target.style.display = 'none';
      }
    }
    function hidePopupById(id) {
      document.getElementById(id).style.display = 'none';
    }
    function resetFilters(popupId) {
      const popup = document.getElementById(popupId);
      if (!popup) return;
      popup.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.checked = radio.defaultChecked;
      });
      popup.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
      });
      popup.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
      });
      popup.querySelectorAll('input[type="number"], input[type="text"]').forEach(input => {
        input.value = '';
      });
    }
    function applyFilters(popupId) {
      alert("Filters applied! (Implement your filter logic here.)");
      hidePopupById(popupId);
    }

    document.addEventListener('click', function(event) {
  const sidebar = document.querySelector('.sidebar');
  const toggle = document.querySelector('.filter-toggle');
  if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
    sidebar.classList.remove('visible');
  }
});

/* + button js */

function toggleFilterSection(button) {
  const filterSection = button.closest('.filter-section');
  const content = filterSection.querySelector('.filter-content');
  
  if (content.style.display === 'none' || content.style.display === '') {
    content.style.display = 'block';
    button.textContent = '−'; // change + to −
  } else {
    content.style.display = 'none';
    button.textContent = '+';
  }
}




/* js for pop registration/login */
 


/* js for end of pop registration/login */
/* account */
const accountBtn = document.getElementById('accountinfo');
  const dropdown = document.getElementById('accountDropdown');
  const modal = document.getElementById('accountModal');
  const accountLabel = document.getElementById('accountLabel');
  let isLoggedIn = false;

  // Modal Forms
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const showLogin = document.getElementById('showLogin');
  const showRegister = document.getElementById('showRegister');
  const switchToRegister = document.getElementById('switchToRegister');
  const switchToLogin = document.getElementById('switchToLogin');

  accountBtn.addEventListener('click', () => {
    if (isLoggedIn) {
      // Show dropdown
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
      const rect = accountBtn.getBoundingClientRect();
      dropdown.style.top = `${rect.bottom + window.scrollY}px`;
      dropdown.style.left = `${rect.left + window.scrollX}px`;
    } else {
      // Show login modal
      modal.style.display = 'flex';
      showLoginForm(); // default to login
    }
  });

  function closeAccountModal() {
    modal.style.display = 'none';
  }

  function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
  }

  showLogin.addEventListener('click', showLoginForm);
  showRegister.addEventListener('click', showRegisterForm);
  switchToRegister.addEventListener('click', (e) => {
    e.preventDefault();
    showRegisterForm();
  });
  switchToLogin.addEventListener('click', (e) => {
    e.preventDefault();
    showLoginForm();
  });

  function showLoginForm() {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
  }

  function showRegisterForm() {
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
  }

  // Handle Login Submission
  loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    // You can replace this with real auth logic
    isLoggedIn = true;
    modal.style.display = 'none';
    accountBtn.innerHTML = '✅ <span>You\'re Logged In</span>';
  });

  // Handle Register Submission
  registerForm.addEventListener('submit', function(e) {
    e.preventDefault();
    // You can handle registration logic here
    alert("Registered successfully! Now log in.");
    showLoginForm();
  });

  // Handle Logout
  document.getElementById('logoutBtn').addEventListener('click', () => {
    isLoggedIn = false;
    dropdown.style.display = 'none';
    accountBtn.innerHTML = '👤 <span>Account</span>';
  });

  // Hide dropdown when clicked outside
  document.addEventListener('click', function(event) {
    if (!accountBtn.contains(event.target) && !dropdown.contains(event.target)) {
      dropdown.style.display = 'none';
    }
  });

// Make Buy button trigger login/register modal
const buyButtons = document.querySelectorAll('.buy-button');

buyButtons.forEach(button => {
  button.addEventListener('click', () => {
    if (!isLoggedIn) {
      modal.style.display = 'flex';
      showLoginForm();
    } else {
      alert('You are already logged in. Proceeding to buy...');
      // Optionally, redirect or show next action
    }
  });
});

