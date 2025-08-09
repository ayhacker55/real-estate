document.addEventListener('DOMContentLoaded', () => {
  const tabLoginBtn = document.getElementById('tab-login');
  const tabRegisterBtn = document.getElementById('tab-register');
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');

  document.getElementById('goto-login').addEventListener('click', () => {
    tabLoginBtn.click();
  });

  tabLoginBtn.addEventListener('click', () => {
    tabLoginBtn.classList.add('active');
    tabRegisterBtn.classList.remove('active');
    loginForm.classList.add('active');
    registerForm.classList.remove('active');
    clearRegisterErrors();
  });

  tabRegisterBtn.addEventListener('click', () => {
    tabRegisterBtn.classList.add('active');
    tabLoginBtn.classList.remove('active');
    registerForm.classList.add('active');
    loginForm.classList.remove('active');
  });

  document.getElementById('goto-register').addEventListener('click', () => {
    tabRegisterBtn.click();
  });

  const otpPopup = document.getElementById('otp-popup');
  const otpInput = document.getElementById('otp-input');
  const otpErrorMsg = document.getElementById('otp-error-msg');
  const verifyOtpBtn = document.getElementById('verify-otp-btn');

  let generatedOTP = null;

  const registerSubmit = registerForm.querySelector('button[type="submit"]');

  registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    clearRegisterErrors();
    if (validateRegisterForm()) {
      generatedOTP = Math.floor(100000 + Math.random() * 900000);
      console.log("Generated OTP (for demo):", generatedOTP);
      otpPopup.classList.add('active');
      otpInput.value = '';
      otpErrorMsg.textContent = '';
      otpInput.focus();
    }
  });

  function validateRegisterForm() {
    let valid = true;

    const fullName = document.getElementById('full-name').value.trim();
    if (fullName.length < 3) {
      document.getElementById('err-fullname').textContent = 'Full name must be at least 3 characters.';
      valid = false;
    }

    const username = document.getElementById('reg-username').value.trim();
    if (username.length < 3) {
      document.getElementById('err-username').textContent = 'Username must be at least 3 characters.';
      valid = false;
    }

    const email = document.getElementById('email').value.trim();
    if (!validateEmail(email)) {
      document.getElementById('err-email').textContent = 'Please enter a valid email.';
      valid = false;
    }

    const phone = document.getElementById('phone-number').value.trim();
    if (!/^\d{10,15}$/.test(phone)) {
      document.getElementById('err-phone').textContent = 'Enter a valid phone number (10-15 digits).';
      valid = false;
    }

    const password = document.getElementById('reg-password').value;
    if (password.length < 6) {
      document.getElementById('err-password').textContent = 'Password must be at least 6 characters.';
      valid = false;
    }

    const confirmPassword = document.getElementById('confirm-password').value;
    if (confirmPassword !== password) {
      document.getElementById('err-confirmpassword').textContent = 'Passwords do not match.';
      valid = false;
    }

    return valid;
  }

  function clearRegisterErrors() {
    document.getElementById('err-fullname').textContent = '';
    document.getElementById('err-username').textContent = '';
    document.getElementById('err-email').textContent = '';
    document.getElementById('err-phone').textContent = '';
    document.getElementById('err-password').textContent = '';
    document.getElementById('err-confirmpassword').textContent = '';
  }

  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  verifyOtpBtn.addEventListener('click', () => {
    const enteredOtp = otpInput.value.trim();
    if (enteredOtp.length !== 6 || isNaN(enteredOtp)) {
      otpErrorMsg.textContent = 'Please enter a valid 6-digit OTP.';
      return;
    }
    if (enteredOtp !== generatedOTP.toString()) {
      otpErrorMsg.textContent = 'Incorrect OTP, please try again.';
      return;
    }

    otpPopup.classList.remove('active');
    alert('Registration successful!');
    registerForm.reset();
    tabLoginBtn.click();
  });

  document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', () => {
      const targetId = icon.getAttribute('data-target');
      const input = document.getElementById(targetId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
      } else {
        input.type = 'password';
        icon.textContent = '👁️';
      }
    });

    icon.textContent = '👁️';
  });

  const forgotPasswordLink = document.getElementById('forgot-password-link');
  const forgotPopup = document.getElementById('forgot-password-popup');
  const fpStep1 = document.getElementById('fp-step1');
  const fpStep2 = document.getElementById('fp-step2');
  const fpStep3 = document.getElementById('fp-step3');

  const fpEmailInput = document.getElementById('fp-email');
  const fpEmailError = document.getElementById('fp-email-error');
  const fpSendOtpBtn = document.getElementById('fp-send-otp-btn');

  const fpOtpInput = document.getElementById('fp-otp-input');
  const fpOtpError = document.getElementById('fp-otp-error');
  const fpVerifyOtpBtn = document.getElementById('fp-verify-otp-btn');

  const fpNewPasswordInput = document.getElementById('fp-new-password');
  const fpNewPasswordError = document.getElementById('fp-new-password-error');
  const fpConfirmPasswordInput = document.getElementById('fp-confirm-password');
  const fpConfirmPasswordError = document.getElementById('fp-confirm-password-error');
  const fpResetPasswordBtn = document.getElementById('fp-reset-password-btn');

  let fpGeneratedOTP = null;

  forgotPasswordLink.addEventListener('click', () => {
    forgotPopup.classList.add('active');
    fpStep1.style.display = 'block';
    fpStep2.style.display = 'none';
    fpStep3.style.display = 'none';
    fpEmailInput.value = '';
    fpEmailError.textContent = '';
  });

  fpSendOtpBtn.addEventListener('click', () => {
    fpEmailError.textContent = '';
    const email = fpEmailInput.value.trim();
    if (!validateEmail(email)) {
      fpEmailError.textContent = 'Please enter a valid email.';
      return;
    }
    fpGeneratedOTP = Math.floor(100000 + Math.random() * 900000);
    console.log("Forgot Password OTP (demo):", fpGeneratedOTP);

    fpStep1.style.display = 'none';
    fpStep2.style.display = 'block';
    fpOtpInput.value = '';
    fpOtpError.textContent = '';
    fpOtpInput.focus();
  });

  fpVerifyOtpBtn.addEventListener('click', () => {
    const otp = fpOtpInput.value.trim();
    if (otp.length !== 6 || isNaN(otp)) {
      fpOtpError.textContent = 'Please enter a valid 6-digit OTP.';
      return;
    }
    if (otp !== fpGeneratedOTP.toString()) {
      fpOtpError.textContent = 'Incorrect OTP, please try again.';
      return;
    }
    fpStep2.style.display = 'none';
    fpStep3.style.display = 'block';
    fpNewPasswordInput.value = '';
    fpConfirmPasswordInput.value = '';
    fpNewPasswordError.textContent = '';
    fpConfirmPasswordError.textContent = '';
  });

  fpResetPasswordBtn.addEventListener('click', () => {
    fpNewPasswordError.textContent = '';
    fpConfirmPasswordError.textContent = '';
    const newPass = fpNewPasswordInput.value;
    const confirmPass = fpConfirmPasswordInput.value;
    if (newPass.length < 6) {
      fpNewPasswordError.textContent = 'Password must be at least 6 characters.';
      return;
    }
    if (confirmPass !== newPass) {
      fpConfirmPasswordError.textContent = 'Passwords do not match.';
      return;
    }
    forgotPopup.classList.remove('active');
    alert('Password reset successful!');
  });

  [otpPopup, forgotPopup].forEach(popup => {
    popup.addEventListener('click', (e) => {
      if (e.target === popup) {
        popup.classList.remove('active');
      }
    });
  });
});
