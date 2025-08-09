
// Toggle "Add Property" submenu
  addPropertyToggle.addEventListener('click', () => {
    const visible = addPropertySubmenu.style.display === 'block';
    addPropertySubmenu.style.display = visible ? 'none' : 'block';
    addPropertyToggle.classList.toggle('active');
    viewPropertySubmenu.style.display = 'none';
    viewPropertyToggle.classList.remove('active');
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
