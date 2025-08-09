<?php
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}

// Optional: get user plan from sessions
$plan = $_SESSION['plan'] ?? '';
$username = $_SESSION['user'] ?? '';

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seller Plan Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

  <style>
    :root {
      --bg-light: #f9f9f9;
      --bg-dark: #1e1e1e;
      --text-light: #333;
      --text-dark: #f2f2f2;
      --primary: #058b0c;
      --card-light: white;
      --card-dark: #2c2c2c;
    }
    html[data-theme="light"] {
      --bg: var(--bg-light);
      --text: var(--text-light);
      --card: var(--card-light);
    }
    html[data-theme="dark"] {
      --bg: var(--bg-dark);
      --text: var(--text-dark);
      --card: var(--card-dark);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
    }
    .dashboard { display: flex; min-height: 100vh; flex-wrap: wrap; }
    .sidebar {
      width: 220px;
      background: var(--card);
      border-right: 1px solid #ddd;
      padding: 24px 16px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      transition: transform 0.3s ease;
    ;
     
    }
    .sidebar h2 { font-size: 20px; color: var(--primary); margin-bottom: 16px; }
    .sidebar button {
      background: none; border: none; text-align: left;
      padding: 10px; font-size: 15px; color: var(--text); cursor: pointer; border-radius: 6px;
    }
    .sidebar button:hover,
    .sidebar button.active { background: #e6f4ea; color: var(--primary); }

    .submenu {
      display: none;
      flex-direction: column;
      gap: 8px;
      margin-left: 12px;
      margin-top: 4px;
    }
    .submenu button {
      display: block;
      width: 100%;
      padding-left: 20px;
      text-align: left;
      background: none;
      border: none;
      color: var(--text);
      cursor: pointer;
      border-radius: 4px;
    }
    .submenu button:hover { background: #f0f0f0; }

    .logout-btn {
      background: #dc3545;
      color: white;
      border: none;
      padding: 8px;
      border-radius: 6px;
      cursor: pointer;
    }

    /* profile picture */
#profile input {
  display: block;
  width: 100%;
  margin-bottom: 16px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.profile-tabs {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
}

.profile-tab-btn {
  padding: 10px 16px;
  border: none;
  background: var(--primary, #007bff);
  color: white;
  border-radius: 6px;
  cursor: pointer;
  opacity: 0.7;
}

.profile-tab-btn.active {
  opacity: 1;
  background: var(--accent, #28a745);
}

.profile-tab-content {
  display: none;
}

.profile-tab-content.active {
  display: block;
}

    /* end of profile pictyure */

    .vertical-buttons {
  display: flex;
  flex-direction: column;
  gap: 10px; /* Adds spacing between buttons */
}


     .main { flex: 1; 
      padding:20px ; 
      position: relative; 
        overflow-y: auto;   
        height: 100vh;
        width: -200px;
    }
   
     .topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  overflow-x: auto;
  padding-bottom: 8px;
 
  
  position: sticky;
  top:0;
  z-index: 1000; 
     } 

/* over for the btn */

.tab-btn:hover,
.submenu-btn:hover {
  background-color: #28a745; /* green */
  color: white;
}

/* For mobile touch (active/focus) */
.tab-btn:active,
.tab-btn:focus,
.submenu-btn:active,
.submenu-btn:focus {
  background-color: #28a745; /* green */
  color: white;
  outline: none;
}

.tab-btn,
.submenu-btn {
  transition: background-color 0.3s ease;
}


.tab-btn,
.submenu-btn {
  touch-action: manipulation;
}

/* over for the btn */
    
    .theme-switch {
      display: flex; align-items: center; gap: 8px; font-size: 14px;
    }
    .theme-switch input[type="checkbox"] {
      width: 40px; height: 20px; position: relative; appearance: none;
      background: #ccc; outline: none; border-radius: 20px;
      transition: background .3s; cursor: pointer;
    }
    .theme-switch input[type="checkbox"]::before {
      content: ''; position: absolute; width: 18px; height: 18px;
      background: white; border-radius: 50%; top:1px; left:1px; transition: transform .3s;
    }
    .theme-switch input:checked { background: var(--primary); }
    .theme-switch input:checked::before { transform: translateX(20px); }
    .tab { display: none; }
    .tab.active { display: block; }
    .card-grid { display: flex; gap: 20px; flex-wrap: wrap; }
    .card {
      flex: 1; min-width: 220px; background: var(--card);
      padding: 16px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .card h3 { margin: 0 0 8px; color: var(--primary); }
    .card p { margin: 0; font-size: 20px; font-weight: bold; }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table th, table td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    /* Subscription Plan Cards Style */
    .subscription-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 24px;
    }

    .plan-card {
      flex: 1;
      min-width: 260px;
      position: relative;
      background: linear-gradient(135deg, rgba(5,139,12,0.05) 0%, rgba(255,255,255,1) 100%);
      padding: 24px;
      border-radius: 16px;
      border: 1px solid var(--primary);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s, box-shadow 0.3s;
      overflow: hidden;
    }

    .plan-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
    }

    .plan-card.popular .badge {
      position: absolute;
      top: 16px;
      right: 16px;
      background: var(--primary);
      color: white;
      padding: 4px 10px;
      font-size: 12px;
      font-weight: 600;
      border-radius: 12px;
    }

    .plan-card h3 {
      color: var(--primary);
      margin-bottom: 8px;
      font-size: 20px;
    }
    .plan-card p {
      font-weight: 600;
      font-size: 22px;
      margin: 4px 0 16px;
      color: #444;
    }
    .plan-card ul {
      padding-left: 20px;
      margin-bottom: 20px;
      font-size: 14px;
      line-height: 1.6;
    }
    .plan-card ul li {
      margin-bottom: 8px;
    }

    .plan-card button {
      display: block;
      width: 100%;
      padding: 12px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
    }
    .plan-card button:hover { background: #04690a; }



    /* land for rent css */


/* Image preview container */
.image-preview-container {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 8px;
}

/* Style for each image thumbnail inside preview */
.image-thumb {
  position: relative;
  width: 100px;
  height: 100px;
  border: 1px solid #ccc;
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 10px;
}

.image-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.remove-image-btn {
  position: absolute;
  top: 2px;
  right: 2px;
  background: rgba(255, 0, 0, 0.7);
  border: none;
  color: white;
  font-weight: bold;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  cursor: pointer;
  line-height: 18px;
  padding: 0;
}

/* Responsive */
/* @media (max-width: 480px) {
  #land-rent {
    padding: 1rem;
  }

  #land-rent h2 {
    font-size: 1.25rem;
  }

  #land-rent button {
    font-size: 0.95rem;
  }
} */

/* end of land for rent */

    
/* laand for sale */


/* Form container */
.form-container {
  background: #fff;
  padding: 24px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  max-width: 800px;
  margin: 0 auto;
  margin-top: 20px;
}

/* Labels */
.form-container label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  margin-top: 16px;
  color: #333;
}

/* Text inputs, number inputs, selects, textarea */
.form-container input[type="text"],
.form-container input[type="number"],
.form-container select,
.form-container textarea {
  width: 100%;
  padding: 10px 12px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
  margin-bottom: 10px;
  transition: border-color 0.3s;
}

.form-container input:focus,
.form-container select:focus,
.form-container textarea:focus {
  border-color: var(--primary, #007BFF);
  outline: none;
}

/* File input */
.form-container input[type="file"] {
  margin-top: 10px;
}


/* Image preview container */
/* .image-preview-container {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 10px;
  margin-bottom: 20px;
}

.image-preview-container img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 6px;
  border: 1px solid #ccc;
} */

/* Submit button */
.form-container button[type="submit"] {
  background: var(--primary, #007BFF);
  color: white;
  padding: 10px 20px;
  margin-top: 20px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s;
}

.form-container button[type="submit"]:hover {
  background: #0056b3;
}

@media (max-width: 768px) {
  .form-container {
    padding: 16px;
    margin-top: 16px;
    max-width: 100%;
  }

  .form-container input[type="text"],
  .form-container input[type="number"],
  .form-container select,
  .form-container textarea {
    font-size: 15px;
    padding: 10px;
  }

  .form-container label {
    font-size: 14px;
    margin-top: 12px;
  }

  .form-container button[type="submit"] {
    width: 100%;
    font-size: 15px;
    padding: 12px;
  }

/*   .image-preview-container {
    justify-content: center;
  }

  .image-preview-container img {
    width: 100px;
    height: 80px;
  } */
}

@media (max-width: 480px) {
  .form-container {
    padding: 14px;
  }

  .form-container button[type="submit"] {
    font-size: 14px;
    padding: 10px;
  }

  .form-container label {
    font-size: 13px;
  }

 /*  .image-preview-container img {
    width: 100px;
    height: 100px;
  } */
}


/* start active view */
/* Filter bar layout */

/* Better Filter Bar Styling */
/* Basic Reset */


.property-container {
  max-width: 1100px;
  margin: auto;
}

.property-filters {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 20px;
}

.property-filters label {
  font-weight: 500;
}

.property-filters select {
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  min-width: 180px;
}

.property-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 16px;
}

.property-card {
  background-color: #fff;
  border-radius: 10px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
  transition: box-shadow 0.3s ease;
  max-height: 360px;
}

.property-card:hover {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.property-image {
  width: 100%;
  height: 180px;
  max-height: 200px;
  object-fit: cover;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.property-detail {
  padding: 12px;
}

.property-detail h3 {
  font-size: 17px;
  margin-bottom: 6px;
  color: #222;
} 

.property-detail .price {
  color: #008000;
  font-weight: bold;
  margin-bottom: 6px;
}

.property-detail .listed-date,
.property-detail .status {
  font-size: 14px;
  color: #555;
  margin-bottom: 4px;
}

.status.available {
  color: #007b00;
  font-weight: 500;
}

/* Mobile layout: image on left, content on right */
@media (max-width: 600px) {
  .property-card {
    flex-direction: row;
    max-height: unset;
    padding:10px;
  }

  .property-image {
    width: 100px;
    height: 100px�      �moו.�W:nђgft07�H��$*"�9�AP��lVT]�SU-��`:�(ۑx.�;B�p�D}�h��B}8��/�?�b�~[k�UU�%�� ����e��^��j�r�ʋ,����N��sw��0��^���5��_e$���K�~�Mb�_������;7����?��O���t�����ٟ] ��'s�ސfE�����|mne9y��o_�w=��Rdq����W�"!��������x��x<9�*��I�x���ǋ��������~����Ǔ/��{Ǔ'��Ǔ�������w�ww����;�E�w�xX�4-g��x�o�w��ߖ���,�9,��/?xQ~��x<>��Z�ߢ���Ǔ���������S�w|���[�����1��r
�����G|�x�O�ڝ��8�-�y5�f4��E�R/.h�=(wpȧ~~<�T�O��\�g�F�8�y>���h�$%1�j��w��x�~�i��E����(�,�n�}!�z����~[��iy(���g��^)�"�<*��\�4�gq�w�lб1��QQ��zF�h���ZBzb���>-Y�<b��%�=�_:�h�@��^��t>)Vɽ�u�<]��j�������:S�l�
�7�|4d7���Ȼ��?���1j���gĜ��V�K���U~��d���c���|h�F��4DI\l�R��Pn�y��]8��8_���3:��)���QwKrL��i���[kf?�y��V+ak[!	�2I���ja�C�0�e r��/�,OK��ry�b��mN���Cr��r��k7.����dkN~�\�X�7� 2$�3.��K��L��/�e�����$�r�4b�X
@Y�D0j)���_^%���n9���zr�Z�o�Kƒ�����]���9�{lb���z-NU�z�:?,�oСZ0{	�]ı�I'|���=sP��i_%�x4���^19�f`����x���������bhK���%����� �����˅�i�]~����o�~�#5"��_�|�/1�B�����B
���0T����C8�S)������AJ�+u��:��~Wn	lѹC�����/�:#����W_�q��3u���;P�p��T?�S��?@��6����nT��2��3���Ф~o�L�/���{�u��6���ގ��e�-��R�ԏo$�kI���e_����b����ԝ��LHo-�ކ*�(/��i�dX0u��ۥQ :>4�z��H��3d�Q�]sRf��	!�Z���z��iO<� ��v�.s����8-���;�R��G勲/v��?��S�L�	�
�M5����o���%ǫݣ�Nĕ`�EzI3�7�]��ߞ���$Sv���6��:�*/+7i�?��~L��2�\���?ÒF�1���e�R|v�"�G�x/�m�sy���}�۝���+�]������b������e������F�4DF���mg©c�� i>S`g@�]e%�G���@���\�<6e���Ҥٕ2�1x��2�f��4��2y���JnD̯��ޟ� 4���i9�U�ш0!�WC��;Jc}!%�s��}`k[�� [��4yj�J�>��g�`�K�ZH��N�Q2"�9���P�]��W`�O��T�������ZRW[�'�9���m� ���/�+��o{�I���a�,��쓳��\�{��7�\�_����3u��Y���@t}|��y�'���T�!0}KKd%>]�m KO;���"��0+!���c��Ҥ���&�R�>�Y�������GJ�s�}��)2B%m�g�|%��L�<��+W.6R�8��ːdqm��cgT���C�i��Q�wW�m�S��#����Xc[�Я:�#�x�p��	���V����C���A-̧�h����QR�I��GQ���W�R�O�|C���\���d$�n`�����*9�s�lq��O�JN�	'�0J�Ld��?���׳�v��\�������_�?��$kQ��j�4ٖcO��h-��o�����OD�v�)ϣɉ��bI��}���[��E�4��}
t�ǌ\��N�b���H���0��8.F�oF2�>��R�٧4W��Z͟��;�8J�Q��)�#�~�全����w2�@I���e���+=,?:����r܍8%9Y��$^����iI�=!'�)�������`�ȼ�^͢^���(q�,=+�5Q[g)��hT�z�[��~��֠�o��(��g��Y���􋣢�>|
/ե���0��'�LDp�ԗ�TM�;Ӓ�}%qWoG�Ы�yр��cu���O�3B�O�SG�4�G������$ßZ�2Od4������﹧����e����Z.yڋ���n�>�O�;�|�K����/�QR��zV��X�Q9�<l�Ki��$�3�u� ���?K�<�?�ŉc����oPM�/a�<��d$E����`E���aX�����a�Jq�'p�� �����(M�^$\��3���F�7���;�>���(��z Ŧ�c[Rt�)E��i~7ڈ�<!�k�)�+v��H��R��ʗ����odD_�/l.��ͬ��[���Yr�JTܑ�=���R6�XW�bc���ْʚy�����e}�
*B�gl��U	.�uIO���x��w���Mmʯ����$J���T�<�=�%�䝱`/}S�,�D�XF|~/�؟��ؐ���52�ęs셜���fw	�R�����w�Yq��?�$��OxG�(G*B�ƻ���,�]s<�dTǂ���^i��|�:��/�(��>"Y�q���"�:U
g���iV��#y<�q�K�E��\����b�6��1J�ിA���ˑ��R�E�F�t���+]�Ң��"��+i�o�3����P��^� �^�
����OM_^!9-���B֨�Ɛ^���/�q��"���%���I���F$4;��D(�Ȓ�;�m0ā��!��kZS���:�������C���e5����>���'E��E��'$�G |�<��C������eu�ݖKRf9���ݼ�E�����;܌7�z3�����Ɩq�kBO�\� @K�eL�Tk�J�s�{n����D��P�"��OhB��?(}�iw��D��g��<8�Q��|�[��GiDʭ�u۶��$��b%�I��Ŧ�Erψ3	�ԢUz�J+R�ky}�2��
<��Pޓ�t�j��ʋ
8�@���%J�enI�?4R��YV��];s~ڛyM��= aB��@G���}F;(?Fx�M}0~Z�x�r�Y��E���R�����E6�׃����=�����䔬���8�I�h������Ҝ��`�Ľ>)��5�?�ʄ ,������$��4>�#y)�7*{Ɲ�;�rK.��[l
�W6̙8=��d�&=����> ��-JM��M��&�Wߑ��b�+>X���#�V ����D�u���{�V��c��ݺ����㐁T|��)�u���j6O6����A���!:hY|q[�>i�ש�]u� �h)���>�S�Xظ^��9�J.���-?l�6��K���q�Xˑ�t-�$�LG锲֒U�UPwHޡ��e�/�ĥ���G*+���{̷��	Z=x#��|�tV2Jy9����p���U�������`!,�H����N4�)%��хQ���G��=�9����͂֝�{ZZ��e9���!�V�f�CY�'uC���iw�����(��i�E]�7ȝ��=��o�X���'ҳ�P:�X՞��fL&Q�n>ʪ!~ݧ�0�ܱ�9�ܖ��F��8���(���nSJ�9���RZ/�i�
��TgM�O�b�J��}��e���u�4q���Iʇ�|RS
��Dv�k8�7'v�w���	{�G蹜��$��<#g@� 9���ZN��>ż�S��L�-7e$̎sj������\'x��n�WiZ<n�-�Ҷ]��aB
�׵e��QI�4�)6��	I�O2��ez�.����/E�H;X���D۬㮜l]h��
=���Y�H��Ot�]���\(�n�G���p *��G�'}�h3�{<9�����~%��u7TZX�d��b^3PP�����XL�}����df[$Q�^��Nq^0�����&�٪^�ȯF=r5�S�C ��i5$�!����:�%3����=�tw��o�J@�W#�;����X����sH��&��a�x��s
3�]>���qKv�1���C�k�;䷪H��6Il��ls�Ū�߽N���k߬̂C�\���P�P]u&�&<45j��8|��U�+O���jnp!�6 8����z����;Ae�G�.3˝��B<6�FZO�@��%X��8'�18��0�e	����;���"Qٙ�2���ta#ʢnA�Ra��r<��v�w@����m�:5��5�=O\���Ky�����LX��y��dmV�$��X`�W���� }����9$e�O.�>'�7█�ͼ��tw�O����Qr����Bf�����@�b�x=#��\1�]C�0AQhO��zI�;�6g�aPn&�i�A��7D>�6��� q^��?i�C�Ms{�͉M�T3�z�c<��}�����'�EVև�AS�x�õ*�=��[<��u���*�gO
�nj��?P O�>I/4W�*�'�bU�#:;�^Հ��5�x�e*��'�}�Tl,I���%zQ���W��������.'��+���&��e����#�9�I�\NhY/Q(�$rK5��$��o�NÂ���eA�}�W-pe��(z�����[r�'`o�@̖=\�'�θ�I��� PG�M�G��_��T���.�����S�B/��n�d	�\�w��aie2�0!��f~����Pg����F�Q���8G
�~@ \��n����_1�t����G�a�:�N%��N�d�K��I�Fҁ��ŲDh϶� C���t^�z��n�+*O��Y�'�I��g�1�Uy:$���X��|����VF�>��ʥIbs�Ûc�;��4g���1���q�B6�M���x�q"�Kʻ�M�=O>����u�Z��=���\����eQ?��^���G���pd'��6x,,3�6WH��=�O�EZ�[���W��M������Kl�i?r9H�b�<��TG�A���Mv*�!��Ǹ�o�15o�8ts�u+���	V�N�Z@��
(Fڵ�J��zcͯ]����0��%��-��V�\��s�ap�FY[sY��m.��]`;m����v(ćG�L���dPę�8�0&���3%��{�8#=q�N`͙W	��$�ǯ]����E��<}~�o>�uP�E�M��/���_��T6>9R2kO�M�j�OW��G���zN n�rw�As��6��!���t`/J��
��h�#�3͂��@~"�����A��oU<�V������w�5����xnr;n��{��;>�:�6E;j{[�W��E	~��l��M-����X�������N���߃��Q�7O5����/���{P��Z�����t߃01qp3T�(�/���%6�r=O�}��������>����t�n!���2?����y�T���;d�&���o����2u$Z�:�y�VUG��;`���0��k����n��,@��H����n��Ix!��}(A.�9wJ�H��1� �o�=�E}һ��,Gq"j�u˫�Tg*�l���Q�wR?vXq�a�5��&�����2�6���XO+� �!q6qj�4���&j4b��&��"�*I���YLҞ�f����CzZ�
#�ʚ��5��Q�4�m</�V�?�冚~X.@dI�x�$�֒r���^@���K�����~��Z'����]��Sͬ��*]��b�t":�����',��lH�Q��d Skf�Z�׭���~�#��m�x�/�g�~v�N���&��&ƞ�I��@���a�<bF�z|O����"�k=?�`W�'YxO��8�Lìw��RP�M��p���<*PFϬ�����B�;�X����G�yzaXC��~[U��Kڽ�
��a)�E�'�{�=��a�T[��_��R�K�< �Ye�P�Ca��Pz�Bje�l3��� ���R2#�S��g�O�iدPԀ*1p�N�Q��#�)!���*taޱj��G%g� b-�$Dڊ��$4/�2k�pVAJ�RC��ܡ򓱺��aIYsۅ�^��yq.|;�C0��\ҳnRw�-���K3KuA��gj���C֪��}���c�h���A�B��Y��i�ث~�U��5r��U΂�H�G�ろ�p�#k�E�b#g�e��?D�(�8O���3q�~U�+\�ԇ/��|~�j���Dc �����0� ~| A+���ŽR�^�y�e�Q�	�*�>Ώ��\y�w@�#ޝaXh[�kn/�P�k��-���CyX����R���7��_y&�>��e��p�铼w�WK��J��wBE�걅U�0F�]h[R�V���i��H'hwS/����Ce�X5'������	��E�� ��!{pO��y�]æR���fЂ��`��S�Q����*�~�/̒���M�+^ʬ��R��ʑ�Ŏ�N�TxQ��9�x��ut��Zc.l�;�K�?�@��� ���6fV�#n��*���@�\�[�Is���q�*�q,��؆#���d�m�S�ҽa����\�^��	r��?�͗���Zr��<qq�a�X�*hI\����A�e�#}���!ae��T�
}���t�%@r ��Y�-�C4"{��ьV{�ա�s�D\eC�Bv q��=>64�ƋC)�wmdHe�CsŹm�C�s�G���2�\��J ���Q�P��=����&���Zt5�I�s�EE���RqU#�ؒ�鉛+�?�
2X�9NF�tqZ��ض�J���2�F^�	+�c�T	�	�(�*�S}�S-ftأwӓ	pӓ�Hl}̵2���-1�Pi�5])��K�5�]�����]���V����~)�h�h�x�� �
l-�����hM;M�Tt&+�?X��|)�uw����E�fK�"������O�*���(H�Cф�CǺ;��TPO��C��P(��M8�^�Ryj4d�.ku<2�ю
���wh�*�_�,~G�����B�;=�kH��=-'P�A-�d'�Q&���ҧ�;C���k�R�FCP].����^v�
�uǃ�J�'qz�T�o,��ď��<W�0:�Ġ0����UnB�'襀i��|�z!vu����[/����T��5�.���y Ì�uX'I�$7Q)��H��}@�F�J���qp�e,I*�\�39�ms)u�vǔ�zK��c=�p�]�Z���r2�{��Րp��[3ڬy9�W�jQ�Js�&�$m�j�Ģ�g6̬q�Odq�(�i��Pj���*������v��R�wK�ӛ�����j�־eKo�c�+��ǌX�]1:�&�V�k^�=�}sh��'��4��?�W��9�9�8M⴬�`b"���,�poǊ�t�0Nha����l|k)�IV�P�V�o.����h8�Yq)틮�bP�w���;GtFi���\W�+e,7��D`���)M7�LG)�OZ�Tf�k��z���I]z$UZh���M��r�LW���T�g��#��M3 ؤ5l?���?�T7�$���f4�޶�MM���t��G�De�O�6^��W�B%QAVQޝ\H��8Jh_������9��ݵ��R 'N�LnC%�^��۵E�?_J�),�U&�Q�|�:՝�s�>3��)���\������g^F���T�ކ<��W�W���ӝ<h>JgTʼ'�*�I��#����]vX�H�	�z����$W2% ��gޕ_�/�Cfy+EOM�_[+F������7�;�p�8�O�1E��U`&qJ�!I�8�/d4ϥ5�X�^͒cT��T���6�ǯ�pyX�}������̶T��lqt�����l�I�Q��ϵV/`z����1��-PdKMY��õ�k"8�4�5
�US�����V�"��D��u:�9�J�<�k��`�o�	��CXr�����iƠl�a(�5�(1�uK�P���s��$����h�c�2��_�E�yP=tG`��`�VE�CS	;c�7�F�a���6����d��Vyt���y�SڂOy�9ƯD�*O�B�K%��S��S��8q{O/A��x�т�\+��,��D�t���ʙp��nU@��p*[�,$�b��|�C��<��yz�u�J���A�ᓐ����l�4#,M����|�g���%��_h�U�k��
�x��n~<�Êϝ}�Ub6;�o�ww�,8Ě�����}�������<'�m	�煹� b-[,�f�Rup�˾�)$6ilM��ԑ��*A�F0_�t8SB��v�8�,�쯞��~���	�o�륈u���@ӂ�m+CO�y��n�,��1s�q_/eB�o�U|�����X,���*c�z2ʢ���`�DY���2&�ښ�WP=T��^��1V��|�0M�h���)+EM���#Jm=4�3���\y�+E��de��N?8�V��R�O�E�jʺ��uڍ�1I�E��Ӗk8w�lU�4�9]��M5kRxl�Ξu�$yi_�p*��I)�V7�Caz���5$�������L%��P-��.�M��䐇�wM���Q�y%�_��\���Q�j3 o:F���K�
b��14Ďh�s0���W��M�V�+�$����)nnW����a�+��RygS�q�u��7^�l�&%�0�S�k���"g�Z��\�)/DyR�_�]pH��Z�X��ތ�ڤ�s捖�&W+��2ւ�|�/�nh�N'l�Iku��mCk��+1U2��vI��kq����������''��-��L`Bh�Y��ۜ�Yd_��7)�£}L�h 3a��;�j�̱��-7�������DӐR�D��9 �tt�.�a��5��NJp�]�׻�sK�l[|�����7��,����IYcG#o��,[���^���q�!�݈����;�G;��e�/WF̛�)���Ki�e_�%��N[�a����7Ļ��sF���'z��O��'��q�Ο�H���Un�~�څ�r;.��H���2���g��*��)5����M������d6�m���$an`	l� ~�Tx��Y���'`�(����B�v(�\��s@	w��s��U'�3wP�� VR���gEu���e�B�#s�a�=�@�r��Z䱄�{�w��l�$-p�S�n��o�6�OB�+@a4ФY>4Rx��h��/wpb\	ޮc�6�֜�U��Z˝�����I&��|��Ȅ������R~���u~¬�X5���@�o�O��lܒ:�	��Q���r	�̵0�}8ƥ����t�3�����HӬm�s#�kɈ��IE����!����9e�(J���S2ɉР�Մ*Ψ �C1�rr�>Z�?��h2��b��r��/^ψs��Z��A���.D�Hf1@$�{���K��4�WV�J�?�ک*�w�X�7��O�d�Q�C�c]��Wĉ�������ì��͉�Q�r����Wׯ�UEˎ(`cЌ�9 ���J��TZUk�~�S�1����a�:
8�h��Ḱ�?�p�cQ�FB��0�" F��~���R��QdËIE�ހ^t��#*_*+���y�S�ʘ]�v�WkY���j�?�Gh�Z�O�Z��Ԯ�t�Ii�
�@`���l;����UN��kZ��M1�Z���h2]L���r�d�*m_hߺ�y�V�������#b�Qڣ��Y[�2<�e=Li+Ѹ�1�{M��v�t���į�$�i%�oI�fڣ��*�v�\u�˚�!m�nj��A�@4!p?6��8e�������n ?��n��T�`�J)�T��56�RβA�@$Uf�`���!1�F�#�T���E���&Q�0c�j�gɣw��:�A�$*H����,5!�"���/�O%/�;�Tf��5���^�cER<\�B�
5ƹ �74X�؉�F�x�����ß�_S�W�A� o�L�F]�ΎJ�2W[	ʓT������M[�;Lf>���}h>=�Tt��ށ��'�{Ǡ���jG�����w+'�/Qn�Y(���;)~`w$��V�}�w6`W�.��_~���{�������?���2j��eψD3a���d�����g�#~���k��q��[�/Y ����V��ꂈ�#n��dx���U��	���ø+�e|'j��C1_i[�N�k�S����h�A��at�l�Ѩ�s�H���EW�"j�#2�}��)�R<�J���DR�
B�B3C�4�&�	���T�;�2!���{()
]�3�x����!e�f~8Lb҃6���h��G��b`�ZҐ�8F��J>~<�a7��~K�7��D�y0nB�N5Ux�Bp�嚢��s����W�J��v�7��׽ʟR��u��N����Q�ؽ��sU*R8�zyO!U 36\�v�=
�̞�Y�5�	w��Y���������_���6�#9� tlD�m��x��qY ��2!	r+��K�&y ���$�j���PI+oz�O��=��v�5Z������?K@+�E+����~�Jf�i�-zKn�)��N&���*������f
��%�p�j����<�-oҍQB�ԭ��˧���_>�_R<���}��S���������q���l��b�5��]� XYk<f�n6;�ͩ{��,��h�z�ڍ�ݛ�˴&���{ZC�8h!#�o9@��,X�K�{�����sOH'|��	k,�;[a93�Qxy�Z�I牁mN�n�[�!?�x~A9�U����Q�'��2YJ"K�Fgj4�y�����{�H{��iV�]�+FQل]�R�G��`[X��¬����(cT<�K����(����V�s�:]��.u%:����Tel�Ǐ`F��Σ[���hՍ!MT��}�}1��ް��\Q��T	5p��S��>�%z	�.Б��ib�z_��K�Jc�e���^�*X���@Ǭ�H�F�˟;�9:��M��so����p�D���o�����a����y5j�O�o���� /�J�G�IY~��IX::�f-��5�;�"���/�%�LӦ��냞�z��啩҂�E�Nz��7O�}T� 0�c�d^�8ĹH���LO�j݀�7P"�_�7L"�Eѭ]�[�D&q�r@��xjֶJ���K�.�cI��Ĺ2�T|(C�j@	�3����Qm%Qf�v%��K�c�O&^7S�T'�
9	e�g>������qp';������� ��ή�B��N�V:��{����/�Dp���T�
�'d�vم����*J�g�^܍
�AUş�c��9�՝�?e�t��x��+ϖ�u�l8%�4n��u�w�xk���v�-wY����q�.'S�BC�I��]:+�����v�ج���F�8���*��h�=��b�/�3��:�-gq?N�d�ؤ]�yg���Ch:�9�rk�GV�_b ���u��ӌ8�c|U�0[��8����q	G��h�0+de����7��r��nB�gR���b3w��s�N{�R�z�;�CK(��u�n�\�mr�
���LG�J�����\��z7'�1�&G���s���
D��y�J���,g�zFz<X������6�>D_w����]J��ؼA����짼!�bT�8�6�jc*Ŭ����9�W�~.��@z֡h�����̏��'�.۪1�،c�����_`2k�9���ő^��B���ϴ���5Zky�'X�k��fk���,4�ZfyR��"�����7��Oc�A�m��ئ�����J��>���\����v�%�� ����`R�.u$Fr�WI:*�>l�o�4�/Uv�Xv��jU���8e[�^�|aN�+z"�>o[R�@�S,h�M�_���،Al7�zr�Z�#�����Sd�bһ�y9��fY� ��	�$��
��,O��Z�Xߚ���W>K��;�k�^�X�Ϊ���~(�f��6��͜d���8E�SZ����Y�1֑Birx�|��cP�����F�7�9N��K��d�#��(��?$��c�D^��2_��������~�r��^%������LuU:�^���	&�q|F��H��DYw���Ą�3�%�y�%����ֳ�cY��B)+�R����_�|�/Q�!�Z�e嘪LKo_h��t���~�� iJ����A�^��>�?鄷����]n����^�ڵC�F\����o�[�G�뎻vD�a(����,ش{����?�-A�J�&E�?�8��l;fN�*���Fk՟�t@ 3V8�3b_����C��=�5r7�b'ߍq�O� ��ˌ�o@��k������3��@��d�cb�\}?V�=�O�_=G[]�ρI���WX\2�/TI��K�h�������5dړIa�j�3�-'��4&�|�D�D�=�Q�T�a e�ayAW$�E0��8�/��g���;$�F�DCW��暏}�7�b�F=whX��G��C�}�O{�d �6\��?M���"~����qA͵���a�u.��������?�Ai����m���©j@����q�3Y�{��t_V���4����EJTA�˫t�y!~({��j��Ax�W�wc�
�70�Z��+;�d��,DXsZ[X۱�9tØ���`�v��^�{�|�RYr=�jw�	���è��a�f����5��g�������\$�I�=�S�u 4P��
"oš|\��)�
R�̃�P��%����'�ݫ3�ڣ�=��%<V
�c�3ڪG߹�����i�GF=�6'r��?"l�׻�0 ?���m,�V�~�6ǐq�a�ZC\�@�j��I�:���1z1���FT����V@���OUn错J��fʓ�.�r7곐�=)S��-��~����A����~C���\&��n>N?�ZץA'�E�����z�{�i�R�2)6�t�`ͺhj�W���kр x���e�x����a+j���pe�f�Xx@G��҃�Ђm�%D�������RJM�ϱ\r�3��7D���:���&=QLP�T��S|^��<B~o2�����{<��E���:����_��"���˔�p�����C�*-a2ɽ�"����i/;q¿�@�
�*U+G6NK�k�2����YT�>��r*�	q>*EE7�H�f�䎽�K�t�v Zޑ�·�m��)����r�bm^&.�a�GF����. ]�]�f�?�r6Ƴh,UK{��8T��E�T4��oB�;xh}3X�bBYW��� ���3L�:��6lv)���L&����������0�FY���s�U��'R�� �z$��.}N����W����P�3�a؉ D��Q�����{�`���.�RZ	m�%܎�Vr��$�I2��P�O�9�ˀr�WRZ������Å�δt�x�(K���`PSA�߷r��$*Fiҧ�py}=�f����O*�����"�t�;φ��M39:Ĳ>N�]h�P�d�2�1�|���z`��:�ЎH��k�ac��Iٻ'��̦W�ׁn1�t��/`ǩ�+FwŎTlN낂 �GE�Jרּ�Uy�^o>���Y���lWf-:*]pR�j������l�gM�@��� M���6�I�εV/��S���w����� �*�ʨ�6�H��~�r@��<N�?<��WFk��8�fΨ�/ӴK\`A��mY"�RT@�cIlB�vw����i��F��A�k���e���p���<��[M3����Ҳ >M�(�.�y�<j��'Ӌt��m���^�\�H�3!�bpyu��>�x0�	B}�gRS>���+������Z�y��G�'����o�Rؾ�ZD�Bf��S02�-���g�9l�ץ8�i�\FPk��L��S�N��95��DY����Ë�*eB�
�T���+�?�T�B��F�G��ciS�O��S��e�����\.K���U�e_����/��kj🬯7�P���R��3d1�^���6m���X�y{0�F��Y+�����/!���΁V.�g]:�Z�2o�A޻-�y��ʹ��^��)^��<�Z:)�[rxፙ቏���[ �da�:\[8V8r\v��nu��;Qw���z�������z]�Ѹ+$�-F%ڜů�Ld��;F8�k�1ank�+0{ƃV��4�����7�R���rY�O'�C��I	�s���`�U�m��V�}�����4 ���}���284����(�䃟}x�xS��z�dQ��S�C��aj�ކZ�g�@�a��MF�oe2n(�-X?&�fwéU')����]������lhv8�A�@?��=��� �\#�S�P?A`��988���_� ��U�+��tv.7Ӓ��V�*b+e�[n;f��"���i~�H�2qJ��?Kġ��;#g}F�u��T������P����ϏM~q�C����.�qZ�����u�^��lA^�Y z�U�j�eF��O�]=Efe}G�	ҫ������ڮkY��қ�N\^܀}e��,�ӷ��C�S�l�׿@t�Wk�����+gN�l��������pu�O�C1ܟ8�P�ZÖ=�2��������9&���a���K ������{j�n��@/��2���ǡ������l�({;��7�`���/B�;WN!Z���=�|R��)�!o7v\�@.���(ăeg� ���k9�t���L`�J�ْ�6iN�eH�҂����/��0��肎�̆ �3Kٚww�3m~6�.�̅����T�[k���4��ފjlQ�p��-�i���y��J<�����Q�ÄG�̕�}�2BK���b�E�B �gH"z>`	eHk�Uz+�F|WYUu���C�Za}U�V���tl���fE���[S���&Hu��V��
S�h��C��Nְ�������#m�^�|.xU����L��P�Ch�Y�t��,׵;�9qERf��u��5s�� L������AV$G��9����?T��!�p�.H�\��i�R3���6�K��ڭ3ת�ô��	�ne�n�����З�Y�O�̻�JN��d��}i���(׾-�9����l���حVm����#ɾT��=\���{6ƴ��;�ym%9��L�!7X]z���C��!TZq7�u�aXWKˣ�%S<�J���_ -~G��{*�iANGXC��J?9U���-,<�_1�&z;�j^�v�+B��ʄGdX֏�I��J�=��=E�g(v΂��'���5%^u"�ėde�^tX,����y8�+p8M�;j�,�M^�[��)��c�1�(r�	gn�"0rab�3*�4M�+9��`�Y�Z�	2N=J#�ϵ�����݃��U��������7��;�+n���6�/�N9�y�%����y��8�X����P��J��n:|%%�.F�������U0�L/\�;�ѧqj�~�� ʲ�[J;���E�u9�5JoWd�<�z���*Jǰn�.�]���3�0Ck0^�A5�7��w�h���Pu�ZI^U{�D#�ܔRP�&%��y����r0;Й^X�>��@	��M����S�	�P.]Vie�����TE�g1U�=�`�׼P3t��ܦ�+�W�ѳ�i�{f�����H{���J��"]Dn�?W���z��UT��j�˪�a�����6S�v$_<��VZ@�i�П1������c~�'�it�|4Ҭ�H���D�O�W�}��&?#kΈ҂3Q�;���D\��{fm��`:C����%�~�gk�ə�����g�>8�=���d=�Yw}��#,�0A!�T�*��'��KCME���8Q�G���)�8��<#��i����������d�������_h���Ӎ��}��k�rk��K���с�f�g��kUR�뫚�5ʁ>T�5�e��pP��byQ�Ü5=J7�ٙ@,p�>?��Z"|9���_�>
<[�a<#��}��2D��~�l%[�Ug���ڇ�PpY��j��Wr=�?붙e�@ߓ����6���4^�܈�puӃ�7{N�͋������/;T��x�ܿ3۴��N���i���-zK,+x��:h�3��9;��0 W����ҕ2�o�j�kF$$�yŜ�]~��L8O�O��j���h���&l7e���O*2�&I���H�J�lΔ��ݎ���� O����#PC���K��M����?g���ſ�����~�So؟�C������i���i��4��?����OC�P���OC�������i��4��?����OC�������$��qW���RP��[�7ק�ϻe�����HU���~�t���FJSһ������`�%}B��z��hTl�>"n��i��4�_ρ�C���;���F�O���Q�Ө�i�ʨ�*����
���]rea�}�}�ʥ��K�k˫�.�n�u��
�ڤ����]��U����i����p�ۥ��h��8�|��rZQފ�es�����)6���洼6m�=���f�}��g�)V��V��-���V���u	����4����Z�����d[`����4�I��Tݐ� N�+������SΜ��UB����ݍ(���@�(��F�w����4HhF8$	C�M丼���{�m'/���͢�g��谦~��U��)�e�P�bx��$�`�-��Ü$�BT�>�b�O�}�ݑ�n�|�Dlv�{
��j`�qY_5��r^8^� ?��k�y�w+$!݂�*���̮�� �c�2y��k���c�~EB�;d�*��.5��:��Ӊ�}3t���P�È��������ƈ���l1.�ls�����'3��w�A�_�^��+���}�]y��#�{N�9���	^�����Cm��b.*�B���
rI��v�8������E�A���@�d���P�U�%R��
�gt0����L$��0��i
�ݠ��{]2㣟��줚#�N���b�-�R�9 u�{���6|��i3�UAg����W��E�+~�+O���z��ѻ��k��X����������(����x��#u�*�Q;�!SA7�1��D�<�ձL��O�ؠ��YD-��;�x�_x檐����$�GU���&t����;�h�V�H��f ��Ս(���[�X�O��l�P�Q�WF��"U�4@'*?F�v^���&�©�cFs�z=�P-��ֲ��;�~�*��"�Vb��^AA[�ϥ�4ʍ�V7ƺ��+c����Y�����tN��Ȇe9:a���>;2�;��j�oBY<�Eڛʮz�f��;R*���5�\�.7S�7��x	�&K��D�}���)�"u�C<�o��l��^f�Ȇ��I����x�]+���;��4[H�i���1?�;eʭ�Dv�g���[��I�_�H�D�C��kvR����ըL�muv��1ii&S��uވX�-�kKq�M*Ʋh�&|Î�^xw٥UX��D���/-�2��� =�7!��K��(?���_���C�\%Tk�U����r�NG���@�b+�2��9�������6�D_�����+��'�T2ώs<�~�ZU�7M9���v������|?rN�S�F<����� }v�W��|e��!��	t ����)fr�Ƙ�O�O�fgZ�����@�_�].���Q-��<�˕� :��R����z�������T�z�סfH�7�,��꥙�L��Ζ���f�*�nr"��}T&�/�n~��d�WX���}��H]C�z��r�M^��9�(����xݦ�	�)	ky�w������Ì�8���	��&�r�JGk8��'�w���\@�L�t	�)*�� e��s�*�Vp��(K��ee��:�: ��8ρ�}_^v�6Ʌ�/������迴�R
A���0�m�Vi*=�����鴖-�w�U�Hڼ��5�B9�-#N�~� ��$�Q�c����~_�5�z�K �I�WBJ��?Ѿl�g$IN�o�mp��ɷ\���E~X�����W��$��dWx��X�C���(F���XJ���]��>s`����-l�E�Q}��q��-�$��q��
p��L��v�j���j�ѿ�[45�l��8V�j�^�Z`q*r-�J�������/�
o��$�:b8�J5w-o�� �v���� ��*��c�jV�Tn��e�����g�i� ʲ�UE�}f��f�T����Q��'$�rR������!1��5ܧ�*��aI��rb��Ψ���c-5��e=��ļ8��?Ǵu��j�?NI����Kߦ($��}�*�p;GM�w����GWmyQ(��r�����!#�9λB��:M�?&�08�]e��tl�/��h�d`G�ב�j�kF>��FC��43;��u��|.�
U~~�L�0�r�2(�{q��sx�|9]݈s��U%���>��x.AK�N:���¯�R�����í�"��Pi��[C���ucIڿH������H�e�dN����.*��U�W�ύ�*����Y &)FY����ʦu'&wEᰬ܄+2�H:=`r����� O$6��6L�u_j[^�Ȱ0��y:�{�%]���&!���������w�S�4=&J�.e��Ỳ{�͔����:��ڷ�5|+�&H5\�̕�
8D&j�*�L�(�-�M�����[c���58�;�I��"���泌�}�C�Q���3��_~���{�������?�WEv*���>���"<�o� >�6c���]�L�������F`��a��Mz��zׯ�(�X�k�m�:�Rb�[��aD��&��N{���Rd�>�kЏ=����{!O���1\dP��ɰX�,�D���!��$�x����Z����ǕCA/�J�؂ת�xDF�X��a�
P�En*�VF���=?���A0|���͈��Mf^2��J��G�.e����d�EX�C���C�(��vC_�2��QA���Ԉ�*��.o�3����fL�'[���aŽ<�x@3:�ѻ�U���<z�=h�9�:ׄ��D̵-�]�n]�x�r�:VZc�ӾA�I���xF��x��m�-$�۝�B�oF�RRN�����}hj�� �'�G�C 7b(�ܝ	�lR�[�Q��Ӻ�$sdYUh0���E�>�+�5}\"��%���(u���u���:�4�S�2��yb5xO�����&��}���u9���?�ҐС=�s�``���C�/S9�$K����	���.ZK1����W��i'�s<�J���_"O,^gA�q���j�7�2: �F��?!i�IF��N.��VU�^J%P%�����6��Q�"�t�8x��	��e�=�C�Ԫ�.�}	m�g 21Sa�����;�a���X��3�\8~5tW��nc�g�(���5
�������C�Iky���8�o�|���.���,C 5M�'F���`:�AL3��G2����>�b^�M8v��Uڋ�c�[D���<��PH�_x�f�����Y$-H�-}��ub7�I��r`w�w#JSb��Ur��3�K�+k��%a4:,��$8�`+g�.����X��:<ڡ�a����z��CR�`-{w��av����݀�H�/�/���[2S�`���Q��J��Zb�sb�gJAh�l
V&�J��(�Uv���8��8�a/��6��	U�"�r�HJs�o����Z!F�_r�c�IvRLB-��� ��.�v#+om�ݸ��݌��i(���lˎ�bO�bF	̌ҥy5 ���v����Vi/ڄi:h��Srw5ꃇD��Q�ǲ�mA!�١���4�4�]�Տon�SM��Fl�Y!��P��^�K�l�!u�˔$S{��o�5KSWW��G��?6䶐0�w�J�R�ƾ����}a�y���f���M)��,2M��,-@v|���XR:B���7��N�z��ZUi�qB�%�YX!�������B���Q��u��4���t�"�R�c�U}�%)Ȭsq�;8<�4S��73F/��!�!0�x�Qf�h\d�^�-'����P5�5��J�����e��ɾ�Pz���m��x�e�(��P���v�X
z����(��6��7 #]�� C6ؚ�I��ac�y��^yd1p�;?l:�;�()Zﵘ!����|�� wM�B��ft=�w�mZt���Í�a��X+��snW\����ôA�ɐ5�M�"ʊ��!S)�	�R��ڲ�C��.�ܴ�ep[�����Rv��ߺŔ�[��@h��T�H��Fk\�I|�|��f>3���-gJa�"E�$*���x}�d%*�:�C�G�CG���f�Nܛ���YI�Ÿ�Wh���&�hPN���ۥ��m� ��7���Y9�Xyt֯8S�?͕�֫q���w�ㄬƽ�� �;�X�)&�)3�{p�䡑$�TZ�����7���uo����ޤ��!IY:�٭��S,d$*����\o��toԠr�Jf8!�[�7�GՄ."���T�o�G=����B[�R�̒�w�e:J{,��r��+��6�{v��E�1��	���^v�_���5z�WR$��=i�m��}���L�ٟ�_�||iJ�M>���r�zCl�Q�2��%N�×�+���2����:R��~G���)�q:*�I�W�5|f���4x�i��z�T��C5>���q�����f���]�Xz)f.&�6��V�&:E��9{��7�F���~\��h<�7Ȁ�!lL#b(Lh�;�a�֊"1>Lc�	;6ٯ����U���L�8�{���*͎�4�槬�s��q�q.�y�i��Х�w#���9����F��|s��FG��b�
5՟�mWzӸ��Qk_݈��1����^{�a7�:���wYru��8�Պ49;�ڌ���Vdט�N��`QV�ӎ%��ˬMR�JS��ht�����{\�.�Lz�7V��3<��:�O�^��͠� ��XW�����tZ��MC>���2����[��7�_�#�X|ט��*"YHh����Z�U�	��5�^�-Ęc��2���X
��u3'�7���:o{W�d�#c;و��[�l�9Iv%�(g6]Wtz��C��?���{iâd �f~=�A`M������L�|1�j� x7�@Y���F�+I���5e��$c��1ME��|}9]�B�NhP��ֳ[��GI��f�x�e���	or�������k�j��	� U^��u:�!*����tɒ\Q2�s]+#�<��7׼Z��A��>�m�fb���2��:0��m5k�m���=�Q��R1ˣU�g�5�}n��]��9CH"FF8���>��z��]�K��}u.p1Se�l���f�F䬉S?y���r+<��R���i�Q�k��Gv�<k�8�$�PK˪(,g/7�S8��
 7��D�S�}:]��	*'3�>�@�HS;	 �~!�(nVQ����5�u�}��=�_�R�hQ^�@$8�h︉�����;m�k���[zTu������e�~J��!%����O���s�����2���`��y��rm�"u��Y=bhmPg��A���H3���®�yI-Y?a)�i>���"��@��Wރ0�������"�����SZ6G�|�:�WvV��ŉ�"R:���6�X)�y[ҘH�p0�Wt�c��q����>B�ʌ�ؑ�efj�It�EfK~ɦ�xJn���0VY�k�
����Zt*>f��s���6�8`��Ζ�\o)]!]��r%�d{x~�Kq���U��wx��|�϶L����(ң���0B�x9L����e(Ǆ�d���ɢ���qC�|��弐c��k?�[��ѳ�@���{s�!����
�/�	���޸�p�/��	7�c����nh0���Y5�����b������}�Ћk{�h��%j<bpA*eܔ�g�a��ࡼð�����{�:NU�)�T�ύ�wr׸?�N@�֔�*1����U3e���]�Z��^uڴ餫���Я`�tO`���w��2՚�����'��� +#f�g��Q.�ׄ��⺙���R���YdE��zA��4'��T0��z���s�kyO�\�UZ�U1�:�EE����|M��:���8Uѕ:�9���/n^g`I���`��f%�Б��W�C��(��l/]~j�Y����Q���dMv3;�|�������`<��iyv��
I�K�����J�_7����m9cC�Y��kG��A"Q�d��.�Vf`�x����C�'��)vpm��py2yW[ ;�1�ǖՏމU���Η�W���jyNP��裯ǳ�w0\�w��Y��jh��-�Ӑ,����W�`��ۋ�;bNC��hMz"*�T�t�h��ĭ�"5�Lu����ů(e6Qs��:P�#j�	�G�������yH����3���Gb�9zWY H�wD���Ӿ�m]������s�!Ƃ��N/��bҨ���&���%�Cwl?�B���C/��\=<H���l�,N������t9%��va��]�`W�Ϗ�����>�X �Va��G��X�/��|q)�P�2L₏%Gv��s�*w�b���_2r�)�
�̢��s3�3��k�3�2��Y.#�gV6����Uw����2C�+rLY��$��@��iWrR+[gĉ�qj���~y,}�;.P׍*o����B����M� �c\A���C}�3=be�޽to�Di��9�#�]��ӝ�n"V|���ڂ��ݤ�~�(K�}7�`���s��Q�vP��-Y]�o\�1+΍qOs.Tw�DE�P����:�r�ѫ�2BP�K�9 JR8YCs��[~��a��w����M霍MAG�4��9��NLGy)-8l�HKFx����l�OdN�O��r�k�^��ẛ~q������C�{�\�$[���1�h�K*��A�e���5h�x=��1�Q�M���IE@�"�+��k���d��3��U�N��`��|BG�}
T>6�W.x�;@�<v���[�'�I��!l����QAh��.��<�I�؜�yr�6oK�-!�9�(S��e��i-��fd9�\p�Ql�%�Wj������"8� Y��c8gu����[�"�Y����t<8"��N���V����Z�H?�!��K���`IC��9UoE*��;㨶��6�s	$?Y����6(�A�](_��m�¸RQN�'���]E��9It��@��0v��~�U}Ѿ����r���g�|�U��W���7�:ڀ��D[��z�rB�NZ�$��?ѿ�WYSR3���{{��b8?T�k-��6 �����K���[Ƥ�s%��`�A�2�כ%���v���$��۔5�/�M������x-�_VP�2��7�8J�=���E�;�*ia�p}t���%M�6?��1@MV$u��3��-(�;��*h7�&��[���{AIU<AC�N$g�M�IG��U5��F*vtTK|�����Y�5�P9^"���O���y�
 ��O:����"?��/}�4R�j��2ZvϨ%�-�wC�ݫ����C�w�vٳ��,��i�H�`�I]��(�Œf.��5�{��,ϊ��X%���m����<!V��:ڋٳ8㡹`��^`�eW���i`p܂�$�c��u��!�.��|�g~*M�r9��(I6��.�~�X��1A�2a/�.���F�	!s�qW!�-�N�v��4E\%;P�Z~I����Kz�0UMJ�_lw�u�NӸ"�ɋ�(#���W����ڟ���I�nZ��:q�0��X]9P�gq�mVm�G���u���L��f��0X���5qC7�4^c��y�V�8�	T��l��9��v�Y�J�efK�����rn��yMGp�d���E��m��޸���Ч�W���.�w���-r�9u����͹E�����p'�C<���F��A/����P� �#�.��ʪ/��z�ͪ�}�Y�wY���ڴz޴@��7��2Gl�;��6����w�M	�,����lPv��W��Xf7B;Ѿ~�êd�7�i�Y.�)wYUs>�^i�hMO�]�2���nF�Wd�\�E	�٫q�,�4���#��jgP���8�IJ�(�#��{�w�b�5��Ҽ���:�Q�w�{�l��2e#Z�#�S0��N��'r��XI�Rr	ͳ7����!�6Q8.{�	���f�F�B}���)�s~��|.�m��lnqWw
��3pՠ��o]�h��`���}0���Je��&5�Ҭ��?~��C��	�G�+��+-��}p�ȫ����ڑ�Iv��~8�Z�ӝ'Ў��:%M��*�����.�R��C�S$z0W�[+�A��+��w�+4W#/��B3�L�|�*���4)����� �Q@nP6"��6h�:Fh)�>OJ \������օ�Ђ��O�:��[Ɨd�ź.j��p�7�\��/�客c�R�_\�( �词��A����n�J[��|��z��\�Y]�p�9�ѱ���@�U-����B=[��l��3�
4�}���ˢXt	b�``��%^KD8���՚b[	&NA��I� } ��T2�.:"���N�N#�!�������5�bT�[�Kc��B"��	��f:�w����Q&fF���& �DqT��@x�`�9���]R�<i�6b4�]32��n�OǬ�q��o��@	�~��������KG�pT��a��V�A$��	b�	,$E�c�3㧅�����Ğa�a�����F1��7��j����.rx3�8mܫ_p�f�T<�\]����Q���o3�A���vc���z8ASo�.�m�0�c�X_s ��OI��"�E1�dB��"$:,�A�qWnH�+Q��9�[��Fw#���;�y̆jc�F��^)
�	���N��ը�ʙ���T��GSVɴ�z��ݡ�M�J�1"��� S'q����4�}W4�琓��_ك�L�����$��jl���:����Cy����G.R�\L�QƚZ�j9��(��5/�^w�^�U�!͊��i��j3l�$M�Ca�05�Cz�=.,a=�	�
]��
�Iw��^��D�5"z����(��̵Z���X����?S(��Y��D�aZ� �WƠ�-O��O�M4�W��Y�T�n��� xCjH��$��ʥ|/����W�rZ%�N�)#f�io��}S��
]HN���P���:�Z\s���3�-�uڦ�	(��dIM�
���Bѓ��y���&J���oڅ��w��h���a-�񈪇9��a�fd�<g(c�7�� e���!�\E�UXt�<9��G��B�tL݅NĞup��Jb�1�z�?Jm���&C/[_�?;0�O�Z�DF� ܭ��5�2��8�ko���&i�A��.�Y^����W�����k��dEw��Zifz�#m�UU�\:xܺ�N�����'�M��^�R����O�j�D�<��G�|�R�o�E�@ ΢N� /���� �q�|�V��H���ZB�%U�����R�z�J�k����N$���ͷUuw����.`p�������F�O�5���Ka�@�0|^��Wa��d�%f�_�J@+J��b�^>�c*�����b�O����Q���j� ���w�K�yܻ�w6���h���M�f�eJԖ9��9�1��}h���i���*�T˥�y�hO��S�׃���~L�B��j;O=�?����z�J������{��4Wv��k� ԫ��ed}�	���sj�f����"�6���X�<�5Jo/���x�;y�u|�K��}<�K@�i@WY����S�z�_�Q����8��ۤ����r�k
�[z���E�0Ʊ�/���[k`q��l �N��(N��x�v�?�K+]�q���Im��}����e�GF�!�^K�|���$��[N��?"w>ӞW����3���?Q�g�nU陮�"ۜ�Gq�����e�U��s5(�K;��\jX7H>J
So�QG.�c�e���k*�n�9J�m�B-TU��t~���C󃙌���<�]:�4�����gy�'
�YDm��g�}5ǈ��O�����?�XK��؝/�.� �"��+��o�T%��+����E���i���/\��3[����l�f-��p�������Z^�*·�����5��ɒJy��#!z������6#�-��8�
ī��҉�Y��
�1���J����-���g�g�XB�Q��kuM�`d]��a�L��S4��	�J3�D��Ar��Y{6k��5;����_A�"i��Y#遰��5��aF
����c��x����V�8z�ʹbDiM�D|��s��^���;S]����#X�b�ڨ72洮;��V�%��rWU�D�����X
��r�F4�WS��ޗ
C�n�.8�����'�iF{:���D��|^w4̝5�
�����_ü���^}�c�R4U�TY@b/�|��Mo�h��6l��7tL_|�a�l��z/��>4��1H�}pnG��|�
S��W$��>�H;��ŵӟ�������h����N[5���gW��/Z���$�p��:���k��go@�L�Oo��M��c�Q` ��@�:�
������r؆I���5���@ZJSfr4��u�Z6�����t�*~(�N(}U}ˎ� Z36�"!���,�"��_cX7v�M׋C\�N�5TW�X�	ߡ$�g*w	�W*g?��{j8/��r�9uU}��'Oc�ʋR��D��+�K<�R��
�����T�_�؛vmٹ [ ��7L�S�T3a5S�P�,��=+Vs���8\��?�o�.�j.u�$^�ω� ��or�w�q�#��05���x�o�%��э�|́d|���	)�ٟ�l.������]u\���3K�q��oZ<v*�W���Ƹ��X��]%|| ��4�� �;v�������<���>x�/�����`�?�                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     �      �[[���~� ؇ب�[q����-
�� ��b�u�bM�y��V��:��!��n�P�oZ�ʒ�"��9���9�)Q;k�v���R�2g�7�gFf#�F$B���s��F�/ՙsw����ڵHpV��3G��d;��}����o��}�UoD�s�o_���K�^�Sh^���'�\*��V�ϯ�6m+<��l�|��e^aOϝ_Y�����!V�>���^4�e���h��,x��<^4K�K�u� B�Gn�G�&k��x��l��p��gІ!��6t���5����.Bp�Ї�Yp��p�h�?�Az�,Y�kֈ�� ��[/���A;d��:�C�a�.5�|[LclV䄜�Q���Vr$+��B�t"���zA��f>����m�͟�u��2�&�=؇�܂��A��>���m�m� ����!3VU�m���K�=��1�Gr�2k��=ڿFB�=Z�(�Y�\'��"��f�n�11y0Cn�=8�{r^���I!��Dp��}k� ���5��c���6����8�=���f����FV��������fo��jv�/s���vĝ�/�p3�Ѕ�\m��\K�I#��x:��%)i�"�Nh0b�m@߀���9�;���'E���8�x��n��{�t�]w�Đ��ͣX��XfAٚ�7���R�������<*��j� �_��$B�jk��C�{��0Z�j��y��L��Z���P�)�����ڑ���f����C�y�ښ��U����׿
ט���݇$"Kݧ2���8���>��mDO�y�oh��w��x�Dn�<��1tᐠ��ԇ5�5䇄�z@f�V��|�憬3Sԯ*��9qI�`Z\��=�rK��@��c�dz�s��;CW���:c�ApD���ܒ�p�Jn�Z���!d���P��&��%k8P;G��49na�1��:�'�N�/�C������,�K4t�WM+�2xMI�p�܃cx��ψ%{N�?����B�"�OP1e�9wcj��.�u��7�&����m��#D�}��-�_�(6�X�jk�1?��7���9&s|�"��C���wPA���54D�M�j¥3-4����#����r�}8��P��� ᚇ1������ة��o!#5����=�o��G�?-4�,�Л0�f�ޖ��"�l��ص�gm�Һgo��WG�A��7����HN4w��v��	>�����Y<`�оJ�m�`=��t���i?��5�m��z8<�P�t�X��)�;�wҡݤM�f!�`���r��C�=c��ZǘA#��fS}��j��2��&�p`"�9�!���J�j���:#w��T>��QG?N^i�@}$�SLDn�ɞ�2����1s��Q�&�h� ��<�����Y'��*�}���	fd9�������l�݈�<^>s(g�O��2�'�Rɸ��=�Eû��z��cΦ	&x����E�0ئ��\=y�a�>G���+�J��P���;@*�lL�����q�׷�+�,\�bŴK��F$6=�b:��E�٤��iTC^Y1�M�囡�j�����+�l��<%'�]@�o��>|��Z�wŦ�>[�m�w��W~%� I�J�#��"�]��䮊����_���2���P�$S��qػv����i���)7����t��&������%�M:|/��D����ň��M͟ͽ��$�F��9������6���.s����\�s��x�I���K*'w1afN������P&e���
GrN1��d����{ͦ4|�`e���WJq蔴.���f��U�R�?.��*g_�:��E�NR��a3Ħ�֙�e���L�B�NtM˄���"ɞg����� [��k�C^g!&E+�E�We���z�d�x+Gj%��}"�C2�b�M���Y5�H?�j��E���jb�4�4�r����N�n������a�d�ZM�L� fKً(Q�h>�3�i���X�3��9���%�i}k�MR�Bَ��J�^�s���Z��)G���T���0��>�U�<.y����O`_A&��W�KUTt�2�8S���+W���D���S�T����4��>�֪�DEC�>���9����q�̏p,��/�(�uNT�Oz�JUv�Nu_���,�o ��D}��9�:9�D��䢢M 1o��q����R���v�D�t���Jiՠ �%�);I/ǐ�XWU�7W�K��*NZ�p���ڦ���7��k��	L��]ʉ
VU������-HJ���_a�O���RVKF"�k�;|��D��M�����C�W�J7q��Ğgm�3�U>�>~����i)9�q��1�7<@�ܣv5屉���&����'ZU����ȩ�>�Zz��'�v;�#��[
�9mq+?���Z�R�u����hͤ�?~؟�U��&Oo*�J���I�"��B��q�U�2����Ѿ9D��0��P�k�(���N���8-c�a�4�W%zJ k'�vZ�VfzW�o��t�$KI|�]؟�l�I�J�qi|L���rY!f�Y�m������b���i��GN>�r���i��qqsϖj�E���\H6x�G�!M��y �7Z��V�u���_-/��Pm.�X����7��r�*D=*./ӏ,���T*��-'�-��5V���,����".�e:ؒ>Ԓ�����`�|��ߖ*��>��/|V���sd�X�C�Y1                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            South","Ohafia"],
  "Adamawa": ["Demsa","Fufore","Ganye","Gayuk","Gombi","Grie","Hong","Jada","Lamurde","Madagali","Maiha","Mayo Belwa","Michika","Mubi North","Mubi South","Numan","Shelleng","Song","Toungo","Yola North","Yola South"]
}


function populateStateAndLGA(stateSelect, lgaSelect) {
  if (!stateSelect || !lgaSelect) return;

  // Populate states dropdown
  stateSelect.innerHTML = '<option value="">Select State</option>';
  lgaSelect.innerHTML = '<option value="">Select LGA</option>';

  Object.keys(nigeriaStatesLGAs).forEach(state => {
    const option = document.createElement('option');
    option.value = state;
    option.textContent = state;
    stateSelect.appendChild(option);
  });

  // When state changes, update LGA dropdown
  stateSelect.addEventListener('change', () => {
    const selectedState = stateSelect.value;
    lgaSelect.innerHTML = '<option value="">Select LGA</option>';

    if(selectedState && nigeriaStatesLGAs[selectedState]) {
      nigeriaStatesLGAs[selectedState].forEach(lga => {
        const option = document.createElement('option');
        option.value = lga;
        option.textContent = lga;
        lgaSelect.appendChild(option);
      });
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  // Find all state & LGA dropdown pairs by class or ids
  // Example with explicit IDs:
  populateStateAndLGA(document.getElementById('state'), document.getElementById('lga'));
  populateStateAndLGA(document.getElementById('stateSale'), document.getElementById('lgaSale'));
   populateStateAndLGA(document.getElementById('stateRent'), document.getElementById('lgaRent'));
     populateStateAndLGA(document.getElementById('state_sale'), document.getElementById('lga_sale'));
      populateStateAndLGA(document.getElementById('statelet'), document.getElementById('lgalet'));
          populateStateAndLGA(document.getElementById('decorState'), document.getElementById('decorLga'));
            populateStateAndLGA(document.getElementById('materialState'), document.getElementById('materialLga'));







  // Add more as needed
});

/* END OF STATES/ LGA */



// === Image uploader setup ===
function setupImageUploader(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  if (!input || !preview) return;

  const uploadedImages = new Set();

  input.addEventListener('change', () => {
    const files = Array.from(input.files);
    files.forEach(file => {
      const fileKey = file.name + file.size;
      if (uploadedImages.has(fileKey)) return;

      uploadedImages.add(fileKey);

      const reader = new FileReader();
      reader.onload = e => {
        const wrapper = document.createElement('div');
        wrapper.className = 'image-thumb';

        const img = document.createElement('img');
        img.src = e.target.result;

        const btn = document.createElement('button');
        btn.className = 'remove-image-btn';
        btn.innerText = '×';
        btn.onclick = () => {
          wrapper.remove();
          uploadedImages.delete(fileKey);
        };

        wrapper.appendChild(img);
        wrapper.appendChild(btn);
        preview.appendChild(wrapper);
      };

      reader.readAsDataURL(file);
    });

    input.value = ''; // Reset input for re-uploading same file
  });
}

// Initialize for all pairs
setupImageUploader('images1', 'imagePreview1');
setupImageUploader('images2', 'imagePreview2');
setupImageUploader('images3', 'imagePreview3');
setupImageUploader('images4', 'imagePreview4');
setupImageUploader('images5', 'imagePreview5');
setupImageUploader('imagesSale', 'imagePreviewSale');
setupImageUploader('decorImages', 'decorImagePreview');
setupImageUploader('materialImages', 'materialImagePreview');





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



/*  view for active*/
    document.getElementById('categoryFilter').addEventListener('change', function () {
      const selected = this.value;
      const cards = document.querySelectorAll('.property-card');

      cards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (selected === 'all' || category === selected) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });

/* end of view  */



  document.addEventListener("DOMContentLoaded", function () {
    const submenuButtons = document.querySelectorAll(".submenu-btn");
    const viewSections = document.querySelectorAll("#view > div"); // All children under #view

    submenuButtons.forEach((btn) => {
      btn.addEventListener("click", function () {
        const formId = btn.getAttribute("data-form");

        // Hide all sections under #view
        viewSections.forEach((section) => {
          section.style.display = "none";
        });

        // Show the selected one
        const selectedSection = document.getElementById(formId);
        if (selectedSection) {
          selectedSection.style.display = "block";
        }
      });
    });

    // Filtering for pending approval section
    const filterSelect = document.getElementById("");
    if (filterSelect) {
      filterSelect.addEventListener("change", function () {
        const selected = this.value.toLowerCase();
        const cards = document.querySelectorAll(".pending-wrapper .property-card");

        cards.forEach((card) => {
          const category = card.dataset.category?.toLowerCase() || "";
          card.style.display = selected === "" || category.includes(selected) ? "flex" : "none";
        });
      });
    }
  });



document.getElementById('landRentForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  // Collect images
  const images = document.getElementById('images1').files;
  for (let i = 0; i < images.length; i++) {
    formData.append('images[]', images[i]);
  }

  // Submit via AJAX
  fetch('submit_land_rent.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(response => {
    alert(response); // Show response from PHP
    form.reset(); // Reset form on success
    document.getElementById('imagePreview1').innerHTML = ''; // Clear image preview
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Submission failed. Please try again.');
  });
});



   

</script>

</body>
</html>
