


document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const addPropertyToggle = document.getElementById('addPropertyToggle');
  const viewPropertyToggle = document.getElementById('viewPropertyToggle');
  const addPropertySubmenu = document.getElementById('addPropertySubmenu');
  const viewPropertySubmenu = document.getElementById('viewPropertySubmenu');
  const formContainer = document.getElementById('formContainer');
  const submenuContent = document.getElementById('submenuContent');
  const dashboardContent = document.getElementById('dashboardContent');
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const closeSidebar = document.getElementById('closeSidebar');
  const navLinks = document.querySelectorAll('.nav-link');

  // Sidebar toggle for mobile
  hamburgerBtn.addEventListener('click', () => {
    sidebar.classList.add('visible');
  });

  closeSidebar.addEventListener('click', () => {
    sidebar.classList.remove('visible');
  });

  // Clear active states
  function clearActiveStates() {
    navLinks.forEach(link => link.classList.remove('active'));
  }



  // Show Dashboard
  document.querySelector('[data-target="dashboard"]').addEventListener('click', () => {
    clearActiveStates();
    dashboardContent.style.display = 'block';
    formContainer.innerHTML = '';
    submenuContent.innerHTML = '';
    addPropertySubmenu.style.display = 'none';
    viewPropertySubmenu.style.display = 'none';
    addPropertyToggle.classList.remove('active');
    viewPropertyToggle.classList.remove('active');
    event.target.classList.add('active');
    if (window.innerWidth <= 768) sidebar.classList.remove('visible');
  });

  // Toggle "Add Property" submenu
  addPropertyToggle.addEventListener('click', () => {
    const visible = addPropertySubmenu.style.display === 'block';
    addPropertySubmenu.style.display = visible ? 'none' : 'block';
    addPropertyToggle.classList.toggle('active');
    viewPropertySubmenu.style.display = 'none';
    viewPropertyToggle.classList.remove('active');
  }); 

  // Toggle "View Property" submenu
  viewPropertyToggle.addEventListener('click', () => {
    const visible = viewPropertySubmenu.style.display === 'block';
    viewPropertySubmenu.style.display = visible ? 'none' : 'block';
    viewPropertyToggle.classList.toggle('active');
    addPropertySubmenu.style.display = 'none';
    addPropertyToggle.classList.remove('active');
  });

  // Add Property submenu buttons
  addPropertySubmenu.addEventListener('click', (e) => {
    if (e.target.matches('button.category-btn')) {
      const category = e.target.getAttribute('data-category');
      dashboardContent.style.display = 'none';
      submenuContent.innerHTML = '';
      renderAddForm(category);
      if (window.innerWidth <= 768) sidebar.classList.remove('visible');
    }
  });


  // approval
 const pendingApprovalLink = document.getElementById('pendingApproval');

pendingApprovalLink.addEventListener('click', (e) => {
  e.preventDefault();

  // Reset all visible views and toggles
  dashboardContent.style.display = 'none';
  submenuContent.innerHTML = '';
  formContainer.innerHTML = '';

  addPropertySubmenu.style.display = 'none';
  viewPropertySubmenu.style.display = 'none';
  addPropertyToggle.classList.remove('active');
  viewPropertyToggle.classList.remove('active');

  // Close mobile sidebar if screen is small
  if (window.innerWidth <= 768) {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.remove('visible');
  }

  // Render Pending Approval Table
  renderPendingApprovalTable();
});

// end of approval

  
  // View Property submenu buttons

viewPropertySubmenu.addEventListener('click', (e) => {
  if (e.target.matches('button.category-btn')) {
    const label = e.target.textContent;
    const category = e.target.getAttribute('data-view');

    dashboardContent.style.display = 'none';
    formContainer.innerHTML = '';
    submenuContent.innerHTML = '';

    if (category === "land") {
      renderAllPropertiesTable(); // 🔥 only for "ALL"
    } else {
      submenuContent.innerHTML = `<p>Display list for ${label} (implement your view logic here)</p>`;
    }

    if (window.innerWidth <= 768) sidebar.classList.remove('visible');
  }
});



 /*  viewPropertySubmenu.addEventListener('click', (e) => {
    if (e.target.matches('button.category-btn')) {
      const label = e.target.textContent;
      dashboardContent.style.display = 'none';
      formContainer.innerHTML = '';


      submenuContent.innerHTML = `<p>Display list for ${label} (implement your view logic here)</p>`;
      if (window.innerWidth <= 768) sidebar.classList.remove('visible');
    }
  }); */
  
  function renderAllPropertiesTable() {
  submenuContent.innerHTML = ''; // Clear previous content

  // === Create layout containers ===
  const wrapper = document.createElement('div');
  wrapper.className = 'table-section-wrapper';
  submenuContent.appendChild(wrapper);

  const tableContainer = document.createElement('div');
  tableContainer.className = 'table-wrapper';
  wrapper.appendChild(tableContainer);

  const paginationContainer = document.createElement('div');
  paginationContainer.id = 'pagination';
  paginationContainer.className = 'pagination fixed-pagination'; // Sticky pagination
  submenuContent.appendChild(paginationContainer);

  // === Search Input ===
  const searchContainer = document.createElement('div');
  searchContainer.className = 'search-container';
  const searchInput = document.createElement('input');
  searchInput.type = 'text';
  searchInput.placeholder = '🔍 Search properties...';
  searchInput.className = 'search-box';
  searchContainer.appendChild(searchInput);
  wrapper.prepend(searchContainer);

  // === Listings Data ===
  const listings = [
    {
      title: 'Land in Ikeja',
      price: 50000,
      location: 'Lagos',
      type: 'land',
      image: 'img/house.jpeg',
      status: 'approved'
    },
    {
      title: 'Apartment Shortlet Abuja',
      price: 30000,
      location: 'Abuja',
      type: 'shortlet',
      image: 'img/house.jpeg',
      status: 'approved'
    },
    {
      title: 'House for Sale in Lekki',
      price: 1000000,
      location: 'Lagos',
      type: 'property-sale',
      image: 'https://via.placeholder.com/80x40?text=House+Lekki',
      status: 'declined'
    },
    {
      title: 'Land for Sale Enugu',
      price: 40000,
      location: 'Enugu',
      type: 'sale',
      image: 'img/house.jpeg',
      status: 'approved'
    },
    {
      title: 'Flat for Rent',
      price: 15000,
      location: 'Ibadan',
      type: 'rent',
      image: 'https://via.placeholder.com/80x40?text=Flat+Rent',
      status: 'approved'
    },
    {
      title: 'Luxury Villa',
      price: 2000000,
      location: 'Lagos',
      type: 'property-sale',
      image: 'https://via.placeholder.com/80x40?text=Villa+Lagos',
      status: 'pending'
    },
    {
      title: 'Commercial Land',
      price: 60000,
      location: 'Port Harcourt',
      type: 'land',
      image: 'https://via.placeholder.com/80x40?text=Land+PH',
      status: 'approved'
    },
    {
      title: 'Duplex for Rent',
      price: 80000,
      location: 'Abuja',
      type: 'rent',
      image: 'https://via.placeholder.com/80x40?text=Duplex+Abuja',
      status: 'declined'
    }
  ];

  const headers = ['title', 'price', 'location', 'type', 'image', 'status'];

  // Build filters
  const filters = {};
  headers.forEach(key => {
    filters[key] = Array.from(new Set(listings.map(item => item[key])));
  });

  // === Build Table ===
  let html = `<table class='listing-table'><thead><tr>`;
  headers.forEach(key => {
    html += `<th>${key.charAt(0).toUpperCase() + key.slice(1)}</th>`;
  });
  html += `</tr><tr>`;
  headers.forEach(key => {
    html += `<th><select data-filter="${key}" class="column-filter"><option value="">All</option>`;
    filters[key].forEach(val => {
      html += `<option value="${val}">${val}</option>`;
    });
    html += `</select></th>`;
  });
  html += `</tr></thead><tbody id='tableBody'></tbody></table>`;
  tableContainer.innerHTML = html;

  let currentPage = 1;
  const rowsPerPage = 5;
  let filteredData = [...listings];

  function applyFiltersAndSearch() {
    const filterValues = {};
    document.querySelectorAll('.column-filter').forEach(select => {
      const key = select.getAttribute('data-filter');
      const val = select.value;
      if (val) filterValues[key] = val;
    });

    const search = searchInput.value.toLowerCase();

    filteredData = listings.filter(item => {
      return Object.entries(filterValues).every(([key, val]) => item[key] == val) &&
        Object.values(item).some(v => String(v).toLowerCase().includes(search));
    });

    currentPage = 1;
    renderTable();
  }

  function renderTable() {
    const tableBody = document.getElementById('tableBody');
    const start = (currentPage - 1) * rowsPerPage;
    const paginated = filteredData.slice(start, start + rowsPerPage);

    tableBody.innerHTML = '';
    paginated.forEach(row => {
      const tr = document.createElement('tr');
      headers.forEach(key => {
        const td = document.createElement('td');
        if (key === 'image') {
          td.innerHTML = `<img src="${row[key]}" alt="Image" style="width:80px; height:40px; object-fit:cover; border-radius:4px;" />`;
        } else {
          td.textContent = row[key];
        }
        tr.appendChild(td);
      });
      tableBody.appendChild(tr);
    });

    renderPagination();
    enableImageZoom();
  }

  function renderPagination() {
    const pageCount = Math.ceil(filteredData.length / rowsPerPage);
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    for (let i = 1; i <= pageCount; i++) {
      const btn = document.createElement('button');
      btn.textContent = i;
      btn.className = i === currentPage ? 'active' : '';
      btn.addEventListener('click', () => {
        currentPage = i;
        renderTable();
      });
      pagination.appendChild(btn);
    }
  }

  function enableImageZoom() {
    document.querySelectorAll('.listing-table img').forEach(img => {
      img.style.cursor = 'zoom-in';
      img.addEventListener('click', () => {
        const overlay = document.createElement('div');
        overlay.className = 'image-zoom-overlay';

        const zoomedImg = document.createElement('img');
        zoomedImg.src = img.src;
        zoomedImg.alt = img.alt || 'Zoomed Image';

        overlay.appendChild(zoomedImg);
        document.body.appendChild(overlay);

        overlay.addEventListener('click', () => {
          document.body.removeChild(overlay);
        });
      });
    });
  }

  document.querySelectorAll('.column-filter').forEach(select => {
    select.addEventListener('change', applyFiltersAndSearch);
  });

  searchInput.addEventListener('input', applyFiltersAndSearch);

  applyFiltersAndSearch();
}



  // Dummy form render function

  
// When the page loads, add event listeners to the buttons
document.querySelectorAll('.category-btn').forEach(button => {
  button.addEventListener('click', () => {
    const category = button.getAttribute('data-category');
    renderAddForm(category);
  });
});

function renderAddForm(category) {
  let formHtml = '';

  switch(category) {
    case 'land':
      formHtml = `
        <form id="landForm" class="add-form">
          <h2>Add Land for Rent</h2>
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required />
          <label for="description">Description:</label>
          <textarea id="description" name="description" required></textarea>

          <label for="state">State:</label>
          <select id="state" name="state" required></select>

          <label for="lga">LGA:</label>
          <select id="lga" name="lga" required></select>

          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required />

          <label for="size">Size (in sq meters):</label>
          <input type="number" id="size" name="size" min="1" required />

          <label for="price">Price (₦):</label>
          <input type="number" id="price" name="price" min="0" required />
          
    <label for="images">Upload Images:</label>
<input type="file" id="images" name="images" multiple accept="image/*" />
<div id="imagePreview" class="image-preview-container"></div>
          <button type="submit">Add Land for Rent</button>
        </form>
      `;
      break;

    case 'sale':
      formHtml = `
        <form id="landSaleForm" class="add-form">
          <h2>Add Land for Sale</h2>
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required />
          <label for="description">Description:</label>
          <textarea id="description" name="description" required></textarea>

          <label for="state">State:</label>
          <select id="state" name="state" required></select>

          <label for="lga">LGA:</label>
          <select id="lga" name="lga" required></select>

          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required />

          <label for="size">Size (in sq meters):</label>
          <input type="number" id="size" name="size" min="1" required />

          <label for="price">Price (₦):</label>
          <input type="number" id="price" name="price" min="0" required />
              <label for="images">Upload Images:</label>
<input type="file" id="images" name="images" multiple accept="image/*" />
<div id="imagePreview" class="image-preview-container"></div>

          <button type="submit">Add Land for Sale</button>
        </form>
      `;
      break;

    case 'rent':
      formHtml = `
        <form id="propertyRentForm" class="add-form">
          <h2>Add Property for Rent</h2>
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required />
          <label for="description">Description:</label>
          <textarea id="description" name="description" required></textarea>

          <label for="state">State:</label>
          <select id="state" name="state" required></select>

          <label for="lga">LGA:</label>
          <select id="lga" name="lga" required></select>

          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required />

          <label for="bedrooms">Bedrooms:</label>
          <input type="number" id="bedrooms" name="bedrooms" min="1" required />

          <label for="bathrooms">Bathrooms:</label>
          <input type="number" id="bathrooms" name="bathrooms" min="1" required />

          <label for="price">Price (₦):</label>
          <input type="number" id="price" name="price" min="0" required />
              <label for="images">Upload Images:</label>
<input type="file" id="images" name="images" multiple accept="image/*" />
<div id="imagePreview" class="image-preview-container"></div>

          <button type="submit">Add Property for Rent</button>
        </form>
      `;
      break;

    case 'property-sale':
      formHtml = `
        <form id="propertySaleForm" class="add-form">
          <h2>Add Property for Sale</h2>
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required />
          <label for="description">Description:</label>
          <textarea id="description" name="description" required></textarea>

          <label for="state">State:</label>
          <select id="state" name="state" required></select>

          <label for="lga">LGA:</label>
          <select id="lga" name="lga" required></select>

          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required />

          <label for="bedrooms">Bedrooms:</label>
          <input type="number" id="bedrooms" name="bedrooms" min="1" required />

          <label for="bathrooms">Bathrooms:</label>
          <input type="number" id="bathrooms" name="bathrooms" min="1" required />

          <label for="price">Price (₦):</label>
          <input type="number" id="price" name="price" min="0" required />
              <label for="images">Upload Images:</label>
<input type="file" id="images" name="images" multiple accept="image/*" />
<div id="imagePreview" class="image-preview-container"></div>

          <button type="submit">Add Property for Sale</button>
        </form>
      `;
      break;

    case 'shortlet':
      formHtml = `
        <form id="shortletForm" class="add-form">
          <h2>Add Apartment for Shortlet</h2>
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required />
          <label for="description">Description:</label>
          <textarea id="description" name="description" required></textarea>

          <label for="state">State:</label>
          <select id="state" name="state" required></select>

          <label for="lga">LGA:</label>
          <select id="lga" name="lga" required></select>

          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required />

          <label for="bedrooms">Bedrooms:</label>
          <input type="number" id="bedrooms" name="bedrooms" min="1" required />

          <label for="bathrooms">Bathrooms:</label>
          <input type="number" id="bathrooms" name="bathrooms" min="1" required />

          <label for="pricePerNight">Price per Night (₦):</label>
          <input type="number" id="pricePerNight" name="pricePerNight" min="0" required />
          <label for="images">Upload Images:</label>
<input type="file" id="images" name="images" multiple accept="image/*" />
<div id="imagePreview" class="image-preview-container"></div>


          <button type="submit">Add Apartment for Shortlet</button>
        </form>
      `;
      break;

    default:
      formHtml = '<p>Please select a valid category.</p>';
  }

  // Insert the form HTML into your container div
  document.getElementById('formContainer').innerHTML = formHtml;

  // After rendering, populate states and LGAs if selects exist
  if (document.getElementById('state') && document.getElementById('lga')) {
    populateStateAndLGA();
  }

  // Setup image preview and other common form logic here if needed
  setupImagePreviewHandling();
}

// Example state/LGA function (reuse your full object here)
function populateStateAndLGA() {
  const nigeriaStatesLGAs = {
  "Abia": ["Aba North", "Aba South", "Isiala Ngwa North", "Isiala Ngwa South", "Obi Ngwa", "Ugwunagbo", "Osisioma", "Ukwa East", "Ukwa West", "Ikwuano", "Umuahia North", "Umuahia South", "Ohafia"],
  "Adamawa": ["Demsa", "Fufore", "Ganye", "Gayuk", "Gombi", "Grie", "Hong", "Jada", "Lamurde", "Madagali", "Maiha", "Mayo Belwa", "Michika", "Mubi North", "Mubi South", "Numan", "Shelleng", "Song", "Toungo", "Yola North", "Yola South"],
  "Akwa Ibom": ["Abak", "Eastern Obolo", "Eket", "Esit Eket", "Essien Udim", "Etim Ekpo", "Etinan", "Ibeno", "Ibesikpo Asutan", "Ibiono-Ibom", "Ika", "Ikono", "Ikot Abasi", "Ikot Ekpene", "Ini", "Itu", "Mbo", "Mkpat-Enin", "Nsit-Atai", "Nsit-Ibom", "Nsit-Ubium", "Obot Akara", "Okobo", "Onna", "Oron", "Udung-Uko", "Ukanafun", "Uruan", "Urue-Offong/Oruko", "Uyo"],
  "Anambra": ["Aguata", "Anambra East", "Anambra West", "Anaocha", "Awka North", "Awka South", "Dunukofia", "Ekwusigo", "Idemili North", "Idemili South", "Ihiala", "Njikoka", "Nnewi North", "Nnewi South", "Ogbaru", "Onitsha North", "Onitsha South", "Orumba North", "Orumba South", "Oyi"],
  "Bauchi": ["Alkaleri", "Bauchi", "Bogoro", "Damban", "Darazo", "Dass", "Ganjuwa", "Giade", "Itas/Gadau", "Jama'are", "Katagum", "Kirfi", "Misau", "Ningi", "Shira", "Tafawa Balewa", "Toro", "Warji", "Zaki"],
  "Bayelsa": ["Brass", "Ekeremor", "Kolokuma/Opokuma", "Nembe", "Ogbia", "Sagbama", "Southern Ijaw", "Yenagoa"],
  "Benue": ["Ado", "Agatu", "Apa", "Buruku", "Gboko", "Guma", "Gwer East", "Gwer West", "Katsina-Ala", "Konshisha", "Kwande", "Logo", "Makurdi", "Obi", "Ogbadibo", "Ohimini", "Oju", "Okpokwu", "Otukpo", "Tarka", "Ukum", "Ushongo", "Vandeikya"],
  "Borno": ["Abadam", "Askira/Uba", "Bama", "Bayo", "Biu", "Chibok", "Damboa", "Dikwa", "Gubio", "Guzamala", "Gwoza", "Hawul", "Jere", "Kaga", "Kala/Balge", "Konduga", "Kukawa", "Kwaya Kusar", "Mafa", "Magumeri", "Maiduguri", "Marte", "Mobbar", "Monguno", "Ngala", "Nganzai", "Shani"],
  "Cross River": ["Abi", "Akamkpa", "Akpabuyo", "Bakassi", "Bekwara", "Biase", "Boki", "Calabar Municipal", "Calabar South", "Etung", "Ikom", "Obanliku", "Obubra", "Obudu", "Odukpani", "Ogoja", "Yakuur", "Yala"],
  "Delta": ["Aniocha North", "Aniocha South", "Bomadi", "Burutu", "Ethiope East", "Ethiope West", "Ika North East", "Ika South", "Isoko North", "Isoko South", "Ndokwa East", "Ndokwa West", "Okpe", "Oshimili North", "Oshimili South", "Patani", "Sapele", "Udu", "Ughelli North", "Ughelli South", "Uvwie", "Warri North", "Warri South", "Warri South West"],
  "Ebonyi": ["Abakaliki", "Afikpo North", "Afikpo South", "Ezza North", "Ezza South", "Ikwo", "Ishielu", "Ivo", "Izzi", "Ohaozara", "Ohaukwu", "Onicha"],
  "Edo": ["Akoko-Edo", "Egor", "Esan Central", "Esan North-East", "Esan South-East", "Esan West", "Etsako Central", "Etsako East", "Etsako West", "Igueben", "Oredo", "Orhionmwon", "Ovia North-East", "Ovia South-West", "Owan East", "Owan West", "Uhunmwonde"],
  "Ekiti": ["Ado Ekiti", "Efon", "Ekiti East", "Ekiti South-West", "Ekiti West", "Emure", "Ido-Osi", "Ijero", "Ikere", "Ikole", "Ilejemeje", "Irepodun/Ifelodun", "Ise/Orun", "Moba", "Oye"],
  "Enugu": ["Aninri", "Awgu", "Enugu East", "Enugu North", "Enugu South", "Ezeagu", "Igbo Etiti", "Igbo Eze North", "Igbo Eze South", "Isi Uzo", "Nkanu East", "Nkanu West", "Nsukka", "Oji River", "Udenu", "Udi", "Uzo Uwani"],
  "FCT": ["Abaji", "Bwari", "Gwagwalada", "Kuje", "Kwali", "Municipal Area Council"],
  "Gombe": ["Akko", "Balanga", "Billiri", "Dukku", "Kaltungo", "Kwami", "Shomgom", "Funakaye", "Gombe"],
  "Imo": ["Aboh Mbaise", "Ahiazu Mbaise", "Ehime Mbano", "Ezinihitte", "Ideato North", "Ideato South", "Ihitte/Uboma", "Ikeduru", "Isiala Mbano", "Isu", "Mbaitoli", "Ngor Okpala", "Njaba", "Nkwerre", "Nwangele", "Obowo", "Oguta", "Ohaji/Egbema", "Okigwe", "Onuimo", "Orlu", "Orsu", "Oru East", "Oru West", "Owerri Municipal", "Owerri North", "Owerri West"],
  "Jigawa": ["Auyo", "Babura", "Birni Kudu", "Biriniwa", "Burtu", "Dutse", "Gagarawa", "Garki", "Gumel", "Guri", "Gwaram", "Gwiwa", "Hadejia", "Jahun", "Kafin Hausa", "Kaugama", "Kazaure", "Kiri Kasama", "Kiyawa", "Miga", "Ringim", "Roni", "Sule Tankarkar", "Taura", "Yankwashi"],
  "Kaduna": ["Birnin Gwari", "Chikun", "Giwa", "Igabi", "Ikara", "Jaba", "Jema'a", "Kachia", "Kaduna North", "Kaduna South", "Kagarko", "Kajuru", "Kaura", "Kauru", "Kubau", "Kudan", "Lere", "Makarfi", "Sabon Gari", "Sanga", "Soba", "Zangon Kataf", "Zaria"],
  "Kano": ["Ajingi", "Albasu", "Bagwai", "Bebeji", "Bichi", "Bunkure", "Dala", "Dambatta", "Dawakin Kudu", "Dawakin Tofa", "Doguwa", "Fagge", "Gabasawa", "Garko", "Garun Mallam", "Gaya", "Gezawa", "Gwale", "Gwarzo", "Kabo", "Kano Municipal", "Karaye", "Kibiya", "Kiru", "Kumbotso", "Kunchi", "Kura", "Madobi", "Makoda", "Minjibir", "Nasarawa", "Rano", "Rimin Gado", "Rogo", "Shanono", "Sumaila", "Takai", "Tarauni", "Tofa", "Tsanyawa", "Tudun Wada", "Ungogo", "Warawa", "Wudil"],
  "Katsina": ["Bakori", "Batagarawa", "Batsari", "Baure", "Bindawa", "Charanchi", "Dandume", "Danja", "Daura", "Dutsi", "Dutsin Ma", "Faskari", "Funtua", "Ingawa", "Jibia", "Kafur", "Kaita", "Kankara", "Kankia", "Katsina", "Kurfi", "Kusada", "Mai'Adua", "Malumfashi", "Mani", "Mashi", "Matazu", "Musawa", "Rimi", "Sabuwa", "Safana", "Sandamu", "Zango"],
  "Kebbi": ["Aleiro", "Arewa Dandi", "Argungu", "Augie", "Bagudo", "Birnin Kebbi", "Bunza", "Dandi", "Fakai", "Gwandu", "Jega", "Kalgo", "Koko/Besse", "Maiyama", "Ngaski", "Sakaba", "Shanga", "Suru", "Wasagu/Danko", "Yauri", "Zuru"],
  "Kogi": ["Adavi", "Ajaokuta", "Ankpa", "Bassa", "Dekina", "Ibaji", "Idah", "Igalamela-Odolu", "Ijumu", "Kabba/Bunu", "Kogi", "Lokoja", "Mopa-Muro", "Ofu", "Ogori/Magongo", "Okehi", "Okene", "Olamaboro", "Omala", "Yagba East", "Yagba West"],
  "Kwara": ["Asa", "Baruten", "Edu", "Ekiti", "Ifelodun", "Ilorin East", "Ilorin South", "Ilorin West", "Irepodun", "Isin", "Kaiama", "Moro", "Offa", "Oke Ero", "Oyun", "Pategi"],
  "Lagos": ["Agege", "Ajeromi-Ifelodun", "Alimosho", "Amuwo-Odofin", "Apapa", "Badagry", "Epe", "Eti-Osa", "Ibeju-Lekki", "Ifako-Ijaiye", "Ikeja", "Ikorodu", "Kosofe", "Lagos Island", "Lagos Mainland", "Mushin", "Ojo", "Oshodi-Isolo", "Shomolu", "Surulere"],
  "Nasarawa": ["Akwanga", "Awe", "Doma", "Karu", "Keana", "Keffi", "Kokona", "Lafia", "Nasarawa", "Nasarawa Egon", "Obi", "Toto", "Wamba"],
  "Niger": ["Agaie", "Agwara", "Bida", "Borgu", "Bosso", "Chanchaga", "Edati", "Gbako", "Gurara", "Katcha", "Kontagora", "Lapai", "Lavun", "Mokwa", "Muya", "Pailoro", "Rafi", "Rijau", "Shiroro", "Suleja", "Tafa", "Wushishi"],
  "Ogun": ["Abeokuta North", "Abeokuta South", "Ado-Odo/Ota", "Egbado North", "Egbado South", "Ewekoro", "Ifo", "Ijebu East", "Ijebu North", "Ijebu North East", "Ijebu Ode", "Ikenne", "Imeko Afon", "Ipokia", "Obafemi Owode", "Odeda", "Odogbolu", "Ogun Waterside", "Remo North", "Shagamu"],
  "Ondo": ["Akoko North-East", "Akoko North-West", "Akoko South-West", "Akoko South-East", "Akure North", "Akure South", "Ese Odo", "Idanre", "Ifedore", "Ilaje", "Ile Oluji/Okeigbo", "Irele", "Odigbo", "Okitipupa", "Ondo East", "Ondo West", "Osogbo", "Ose", "Owo"],
  "Osun": ["Atakunmosa East", "Atakunmosa West", "Boluwaduro", "Boripe", "Ede North", "Ede South", "Egbedore", "Ejigbo", "Ife Central", "Ife East", "Ife North", "Ife South", "Ifedayo", "Ifelodun", "Ila", "Ilesa East", "Ilesa West", "Irepodun", "Irewole", "Isokan", "Iwo", "Obokun", "Odo Otin", "Ola Oluwa", "Olorunda", "Oriade", "Orolu", "Osogbo"],
  "Oyo": ["Afijio", "Akinyele", "Atiba", "Atisbo", "Egbeda", "Ibadan North", "Ibadan North-East", "Ibadan North-West", "Ibadan South-East", "Ibadan South-West", "Ibarapa Central", "Ibarapa East", "Ibarapa North", "Ido", "Irepo", "Iseyin", "Itesiwaju", "Iwajowa", "Kajola", "Lagelu", "Ogbomosho North", "Ogbomosho South", "Ogo Oluwa", "Olorunsogo", "Oluyole", "Ona Ara", "Orelope", "Ori Ire", "Oyo", "Saki East", "Saki West", "Surulere"],
  "Plateau": ["Bokkos", "Barkin Ladi", "Bassa", "Jos East", "Jos North", "Jos South", "Kanam", "Kanke", "Langtang North", "Langtang South", "Mangu", "Mikang", "Pankshin", "Qua'an Pan", "Riyom", "Shendam", "Wase"],
  "Rivers": ["Abua/Odual", "Ahoada East", "Ahoada West", "Akuku Toru", "Andoni", "Asari-Toru", "Bonny", "Degema", "Eleme", "Emuoha", "Etche", "Gokana", "Ikwerre", "Khana", "Obio/Akpor", "Ogba/Egbema/Ndoni", "Ogu/Bolo", "Okrika", "Omuma", "Opobo/Nkoro", "Oyigbo", "Port Harcourt", "Tai"],
  "Sokoto": ["Binji", "Bodinga", "Dange Shuni", "Gada", "Goronyo", "Gudu", "Gwadabawa", "Illela", "Isa", "Kebbe", "Kware", "Rabah", "Sabon Birni", "Shagari", "Silame", "Sokoto North", "Sokoto South", "Tambuwal", "Tangaza", "Tureta", "Wamako", "Wurno", "Yabo"],
  "Taraba": ["Ardo Kola", "Bali", "Donga", "Gashaka", "Gassol", "Ibi", "Jalingo", "Karim Lamido", "Kumi", "Lau", "Sardauna", "Takum", "Ussa", "Wukari", "Yorro", "Zing"],
  "Yobe": ["Bade", "Bursari", "Damaturu", "Fika", "Fune", "Geidam", "Gujba", "Gulani", "Jakusko", "Karasuwa", "Machina", "Nangere", "Nguru", "Tarmuwa", "Yunusari", "Yusufari"],
  "Zamfara": ["Anka", "Bakura", "Birnin Magaji/Kiyaw", "Bukkuyum", "Bungudu", "Gummi", "Gusau", "Kaura Namoda", "Maradun", "Maru", "Shinkafi", "Talata Mafara", "Chafe"]
    // Add all other states and LGAs here
  };

  const stateSelect = document.getElementById('state');
  const lgaSelect = document.getElementById('lga');

  // Reset options
  stateSelect.innerHTML = '<option value="">Select State</option>';
  lgaSelect.innerHTML = '<option value="">Select LGA</option>';

  for (const state in nigeriaStatesLGAs) {
    const option = document.createElement('option');
    option.value = state;
    option.textContent = state;
    stateSelect.appendChild(option);
  }

  stateSelect.addEventListener('change', () => {
    const selectedState = stateSelect.value;
    lgaSelect.innerHTML = '<option value="">Select LGA</option>';
    if (selectedState && nigeriaStatesLGAs[selectedState]) {
      nigeriaStatesLGAs[selectedState].forEach(lga => {
        const option = document.createElement('option');
        option.value = lga;
        option.textContent = lga;
        lgaSelect.appendChild(option);
      });
    }
  });
}

// Placeholder for image preview setup
function setupImagePreviewHandling() {
  const imagesInput = document.getElementById('images');
  const imagePreviewContainer = document.getElementById('imagePreview');
  if (!imagesInput || !imagePreviewContainer) return; // no image input on this form

  let imageFiles = [];

  function renderImagePreviews() {
    imagePreviewContainer.innerHTML = '';
    imageFiles.forEach((file, index) => {
      const imgURL = URL.createObjectURL(file);
      const imgBox = document.createElement('div');
      imgBox.className = 'image-box';

      const img = document.createElement('img');
      img.src = imgURL;
      img.alt = `Image ${index + 1}`;

      const delBtn = document.createElement('button');
      delBtn.type = 'button';
      delBtn.textContent = '×';
      delBtn.title = 'Remove Image';
      delBtn.className = 'remove-image-btn';
      delBtn.addEventListener('click', () => {
        imageFiles.splice(index, 1);
        renderImagePreviews();
      });

      imgBox.appendChild(img);
      imgBox.appendChild(delBtn);
      imagePreviewContainer.appendChild(imgBox);
    });
  }

  imagesInput.addEventListener('change', (e) => {
    for (const file of e.target.files) {
      if (file.type.startsWith('image/') && !imageFiles.some(f => f.name === file.name && f.size === file.size)) {
        imageFiles.push(file);
      }
    }
    renderImagePreviews();
    imagesInput.value = ''; // reset input so same file can be added again if needed
  });
}

  
  // Default to showing dashboard on load
  dashboardContent.style.display = 'block';
});














// approval info

document.getElementById('pendingApproval').addEventListener('click', function (e) {
  e.preventDefault();
  dashboardContent.style.display = 'none';  // Hide dashboard
  submenuContent.style.display = 'block';   // Show submenuContent (if hidden)
  renderPendingApprovalTable();
});


function renderPendingApprovalTable() {
  submenuContent.innerHTML = ''; // Clear previous content

  const wrapper = document.createElement('div');
  wrapper.className = 'approval-section-wrapper';
  submenuContent.appendChild(wrapper);

  const tableContainer = document.createElement('div');
  tableContainer.className = 'approval-table-wrapper';
  wrapper.appendChild(tableContainer);

  const paginationContainer = document.createElement('div');
  paginationContainer.id = 'approvalPagination';
  paginationContainer.className = 'approval-pagination approval-fixed-pagination';
  submenuContent.appendChild(paginationContainer);

  const searchContainer = document.createElement('div');
  searchContainer.className = 'approval-search-container';
  const searchInput = document.createElement('input');
  searchInput.type = 'text';
  searchInput.placeholder = '🔍 Search...';
  searchInput.className = 'approval-search-box';
  searchContainer.appendChild(searchInput);
  wrapper.prepend(searchContainer);

  const listings = [
    { id: 1, type: 'Land for Rent', status: 'pending', message: 'Waiting for manager review' },
    { id: 2, type: 'Shortlet', status: 'declined', message: 'Incomplete documents' },
    { id: 3, type: 'Property for Sale', status: 'approved', message: 'Approved by admin' },
    { id: 4, type: 'Property for Rent', status: 'pending', message: '' },
    { id: 5, type: 'Property for Rent', status: 'pending', message: '' },
    { id: 6, type: 'Property for Rent', status: 'pending', message: '' },
    { id: 7, type: 'Property for Rent', status: 'pending', message: '' }
  ];

  const headers = ['Type', 'Status', 'Message', 'Action'];

  let html = `<table class='approval-listing-table'><thead><tr>`;
  headers.forEach(h => html += `<th>${h}</th>`);
  html += `</tr><tr>`;

  headers.forEach(h => {
    if (h === 'Type') {
      html += `<th>
        <select id="approvalTypeFilter" class="approval-column-filter">
          <option value="">All</option>
          <option value="Land for Rent">Land for Rent</option>
          <option value="Land for Sale">Land for Sale</option>
          <option value="Property for Rent">Property for Rent</option>
          <option value="Property for Sale">Property for Sale</option>
          <option value="Shortlet">Shortlet</option>
        </select>
      </th>`;
    } else {
      html += `<th></th>`;
    }
  });

  html += `</tr></thead><tbody id='approvalTableBody'></tbody></table>`;
  tableContainer.innerHTML = html;

  let currentPage = 1;
  const rowsPerPage = 5;
  let filteredData = [...listings];

  function applyFiltersAndSearch() {
    const typeVal = document.getElementById('approvalTypeFilter').value;
    const searchVal = searchInput.value.toLowerCase();

    filteredData = listings.filter(item => {
      const matchesType = typeVal === '' || item.type === typeVal;
      const matchesSearch = Object.values(item).some(v => String(v).toLowerCase().includes(searchVal));
      return matchesType && matchesSearch;
    });

    currentPage = 1;
    renderTable();
  }

  function renderTable() {
    const tableBody = document.getElementById('approvalTableBody');
    const start = (currentPage - 1) * rowsPerPage;
    const paginated = filteredData.slice(start, start + rowsPerPage);

    tableBody.innerHTML = '';
    paginated.forEach(item => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${item.type}</td>
        <td>${item.status}</td>
        <td>${item.message || '—'}</td>
<td>
  <button class="approval-action-toggle" data-id="${item.id}">⋮</button>
</td>


      `;
      tableBody.appendChild(tr);
    });

    renderPagination();
    attachDropdownHandlers();
  }

  function renderPagination() {
    const pageCount = Math.ceil(filteredData.length / rowsPerPage);
    const pagination = document.getElementById('approvalPagination');
    pagination.innerHTML = '';

    for (let i = 1; i <= pageCount; i++) {
      const btn = document.createElement('button');
      btn.textContent = i;
      btn.className = i === currentPage ? 'active' : '';
      btn.addEventListener('click', () => {
        currentPage = i;
        renderTable();
      });
      pagination.appendChild(btn);
    }
  }


  // pop up modal
  function attachDropdownHandlers() {
  const menu = document.getElementById('floatingActionMenu');
  const updateBtn = document.getElementById('actionUpdateBtn');
  const deleteBtn = document.getElementById('actionDeleteBtn');

  let currentItemId = null;

  document.querySelectorAll('.approval-action-toggle').forEach(button => {
    button.addEventListener('click', (e) => {
      e.stopPropagation(); // Prevent triggering document click

      const rect = button.getBoundingClientRect();
      menu.style.top = `${window.scrollY + rect.bottom + 5}px`;
      menu.style.left = `${window.scrollX + rect.left}px`;
      menu.style.display = 'flex';

      currentItemId = button.dataset.id;
    });
  });

  updateBtn.addEventListener('click', () => {
    alert(`Update clicked for item ID: ${currentItemId}`);
    menu.style.display = 'none';
  });


  // delete
  deleteBtn.addEventListener('click', () => {
    if (confirm('Are you sure you want to delete this item?')) {
      const index = listings.findIndex(i => i.id == currentItemId);
      if (index !== -1) {
        listings.splice(index, 1);
        applyFiltersAndSearch();
      }
    }
    menu.style.display = 'none';
  });

  // Close popup on outside click
  document.addEventListener('click', (e) => {
    if (!menu.contains(e.target)) {
      menu.style.display = 'none';
    }
  });
}
// end of approval


  document.getElementById('approvalTypeFilter').addEventListener('change', applyFiltersAndSearch);
  searchInput.addEventListener('input', applyFiltersAndSearch);

  applyFiltersAndSearch();
}