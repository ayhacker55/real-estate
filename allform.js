// === Toggle Sidebar & Theme ===
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
}

function toggleTheme() {
  document.documentElement.setAttribute(
    'data-theme',
    document.getElementById('themeToggle').checked ? 'dark' : 'light'
  );
}

// === DOM Ready ===
document.addEventListener("DOMContentLoaded", function () {
  const loadedForms = {};

  // === Hide All Forms and Views ===
  function hideAllFormsAndViews() {
    document.querySelectorAll('.form-container').forEach(f => f.style.display = 'none');
    document.querySelectorAll('#view > div').forEach(v => v.style.display = 'none');
  }

document.querySelectorAll('.tab-btn').forEach(button => {
  button.addEventListener('click', () => {
    const tabId = button.getAttribute('data-tab');

    // 👉 Hide all tabs
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(tab => tab.style.display = 'none');

    // 👉 Show the selected tab
    const target = document.getElementById(tabId);
    if (target) {
      target.classList.add('active');
      target.style.display = 'block';
    }

    // 👉 Hide default message if not on Add tab
    const msg = document.getElementById('add-default-message');
    if (msg && tabId !== 'add') msg.style.display = 'none';

    // 👉 Hide all submenus unless Add or View is selected
    document.querySelectorAll('.submenu').forEach(sub => sub.style.display = 'none');
    const submenu = button.closest('.menu-item')?.querySelector('.submenu');
    if ((tabId === 'add' || tabId === 'view') && submenu) {
      submenu.style.display = 'block';
    }

    // 👉 Hide all form/view content
    document.querySelectorAll('.form-container').forEach(f => f.style.display = 'none');
    document.querySelectorAll('#view > div').forEach(v => v.style.display = 'none');

    // 👉 Auto-close sidebar on mobile
    if (window.innerWidth < 768) {
      document.getElementById('sidebar')?.classList.remove('open');
    }
  });
});



  // === Submenu Buttons (Add & View Property Options) ===
  document.querySelectorAll('.submenu-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const formId = btn.getAttribute('data-form');
      const container = document.getElementById(formId);

      if (!container) return;

      hideAllFormsAndViews();

      const isAddTab = document.getElementById('add').classList.contains('active');
      const isViewTab = document.getElementById('view').classList.contains('active');

      if (isAddTab || isViewTab) {
        if (!loadedForms[formId]) {
          fetch(`${formId}.html`)
            .then(res => res.ok ? res.text() : Promise.reject("Failed to load content"))
            .then(html => {
              container.innerHTML = html;
              container.style.display = 'block';
              loadedForms[formId] = true;
              initializeDynamicComponents(formId);
            })
            .catch(err => {
              container.innerHTML = `<p style="color:red;">${err}</p>`;
              container.style.display = 'block';
            });
        } else {
          container.style.display = 'block';
        }
      }

      // Hide default message for Add
      const msg = document.getElementById('add-default-message');
      if (msg) msg.style.display = 'none';

      // ✅ Close sidebar on mobile after submenu selected
      if (window.innerWidth < 768) {
        document.getElementById('sidebar').classList.remove('open');
      }
    });
  });

  // === Optional: Category Filter for View (if present)
  const filterSelect = document.getElementById("categoryFilter");
  if (filterSelect) {
    filterSelect.addEventListener("change", function () {
      const selected = this.value;
      const cards = document.querySelectorAll(".property-card");
      cards.forEach(card => {
        const category = card.getAttribute("data-category");
        card.style.display = (selected === "all" || category === selected) ? "flex" : "none";
      });
    });
  }

  // === Dynamic Component Setup (State/LGA + Image Preview) ===
  const idMap = {
    'land-sale': ['stateSale', 'lgaSale'],
    'land-rent': ['state', 'lga'],
    'property-rent': ['stateRent', 'lgaRent'],
    'property-sale': ['state_sale', 'lga_sale'],
    'decor': ['decorState', 'decorLga'],
    'building': ['materialState', 'materialLga'],
    'building-material': ['materialState', 'materialLga'],
    'shortlet': ['statelet', 'lgalet'],
    'active': [],
    'pending': [],
  };

  function initializeDynamicComponents(formId) {
    const formElement = document.getElementById(formId);
    if (!formElement) return;

    const [stateId, lgaId] = idMap[formId] || [];
    const stateSelect = stateId ? formElement.querySelector(`#${stateId}`) : null;
    const lgaSelect = lgaId ? formElement.querySelector(`#${lgaId}`) : null;

    if (stateSelect && lgaSelect) {
      populateStateAndLGA(stateSelect, lgaSelect);
    }

    formElement.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
      const previewId = input.getAttribute('data-preview');
      setupImageUploader(input.id, previewId);
    });
  }

  function populateStateAndLGA(stateSelect, lgaSelect) {
    const stateToLGA = {
      "Abia": ["Aba North", "Aba South", "Umuahia", "Ohafia"],
      "Lagos": ["Ikeja", "Epe", "Ikorodu", "Badagry", "Alimosho"],
      "FCT": ["Abaji", "Bwari", "Gwagwalada", "Kuje", "Kwali", "Municipal"]
    };

    stateSelect.innerHTML = `<option value="">Select State</option>`;
    lgaSelect.innerHTML = `<option value="">Select LGA</option>`;

    Object.keys(stateToLGA).forEach(state => {
      const opt = document.createElement("option");
      opt.value = state;
      opt.textContent = state;
      stateSelect.appendChild(opt);
    });

    stateSelect.addEventListener("change", () => {
      const selected = stateSelect.value;
      lgaSelect.innerHTML = `<option value="">Select LGA</option>`;
      if (stateToLGA[selected]) {
        stateToLGA[selected].forEach(lga => {
          const opt = document.createElement("option");
          opt.value = lga;
          opt.textContent = lga;
          lgaSelect.appendChild(opt);
        });
      }
    });
  }





//iamge
function setupImageUploader(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  if (!input || !preview) return;

  input.addEventListener('change', (event) => {
    const files = Array.from(event.target.files);

    files.forEach(file => {
      const reader = new FileReader();
      reader.onload = () => {
        // Create wrapper using your .image-thumb class
        const wrapper = document.createElement('div');
        wrapper.className = 'image-thumb';

        // Create img
        const img = document.createElement('img');
        img.src = reader.result;

        // Create remove button
        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '×';
        removeBtn.className = 'remove-image-btn';
        removeBtn.addEventListener('click', () => {
          wrapper.remove();
        });

        // Assemble thumbnail
        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        preview.appendChild(wrapper);
      };

      reader.readAsDataURL(file);
    });

    // Clear input to allow re-selecting same image
    input.value = '';
  });
}





  // Profile tab switch
  document.querySelectorAll('.profile-tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      // Remove 'active' from all buttons and tab contents
      document.querySelectorAll('.profile-tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.profile-tab-content').forEach(tab => tab.classList.remove('active'));

      // Add 'active' to clicked button and corresponding tab
      this.classList.add('active');
      const target = this.getAttribute('data-profile-tab');
      document.getElementById('profile-' + target).classList.add('active');
    });
  });

function toggleAdvanced() {
  const advanced = document.getElementById("advancedFilters");
  advanced.classList.toggle("hidden");
}

 document.getElementById("showPlansBtn").addEventListener("click", function() {
    const plans = document.getElementById("plans");
    plans.style.display = plans.style.display === "none" ? "block" : "none";
  }); 



document.querySelectorAll('.tab-btn').forEach(button => {
  button.addEventListener('click', () => {
    const target = button.getAttribute('data-tab');
    document.querySelectorAll('.tab').forEach(tab => {
      tab.style.display = 'none';
    });
    document.getElementById(target).style.display = 'block';
  });
});



/* analysis */
});




/* analysis */
 new Chart(document.getElementById("statusChart"), {
    type: "pie",
    data: {
      labels: ["Approved", "Pending", "Rejected"],
      datasets: [{
        data: [22, 4, 2],
        backgroundColor: ["#28a745", "#ffc107", "#dc3545"]
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'bottom' } }
    }
  });

  new Chart(document.getElementById("categoryChart"), {
    type: "bar",
    data: {
      labels: ["Land", "Property", "Shortlet", "Decor", "Materials"],
      datasets: [{
        label: "Uploads",
        data: [8, 10, 5, 3, 2], // Example numbers
        backgroundColor: "#007bff"
      }]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true } }
    }
  });

  const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

  const monthlyChart = new Chart(monthlyCtx, {
    type: 'bar',
    data: {
      labels: [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      ],
      datasets: [
        {
          label: 'Uploads',
          data: [12, 19, 14, 17, 23, 21, 25, 22, 18, 16, 14, 20],
          backgroundColor: '#3498db'
        },
        {
          label: 'Approved',
          data: [10, 17, 13, 14, 21, 20, 23, 19, 15, 14, 12, 18],
          backgroundColor: '#2ecc71'
        },
        {
          label: 'Sold',
          data: [4, 8, 6, 9, 12, 14, 15, 13, 10, 9, 7, 11],
          backgroundColor: '#f39c12'
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: false
        },
        legend: {
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Number of Properties'
          }
        }
      }
    }
  });
