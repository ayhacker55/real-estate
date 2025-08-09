
    // === Phone input (intl-tel-input) setup with mobile fix ===
    const phoneInputField = document.querySelector("#phone");

    if (phoneInputField) {
      const iti = window.intlTelInput(phoneInputField, {
        initialCountry: "ng",
        preferredCountries: ["ng", "us", "gb", "in"],
        separateDialCode: true,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"
      });

      // Prevent modal from opening when tapping the flag dropdown
      const flagDropdown = document.querySelector(".iti__flag-container");
      if (flagDropdown) {
        flagDropdown.addEventListener("click", (e) => {
          e.stopPropagation();
        });
      }

      // Form submission validation
      const form = document.getElementById("quoteForm");
      if (form) {
        form.addEventListener("submit", function (e) {
          e.preventDefault();
          const phoneNumber = iti.getNumber();
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
      }
    }

