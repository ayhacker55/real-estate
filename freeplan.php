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
    height: 100px‹      í½mo×•.úW:nÑ’gft07 HÉæŒ$*"Ÿ9£APìŞlVT]»SU-‰Ñ`:(Û‘x.;BÎpÍD}è¦h“ùB}8„È/¸?áb×~[k¿UU³%Ë °Øİûeíµ×^¯ÏjrÒÊ‹,îíÿöN±çswÉÚ0êŞ^Ø¥·5Èò_e$ê¿ºKÖ~ÕMb’_ÿ«ÿóşó¿¼;7åïüó?ÿİOÏøá¿tîÿÍóáÙŸ] ÿİ'säŞfEş÷ÿ°²|mne9yç¿Şo_¼w=£ºRdqÚÏÛî·Wã"!ííãñáñøàxòøx<9¿*ÿûIëxü¼üÇ‹ãÉÖñø›ãñ~ùü³Ç“/Ç{Ç“'Çã—Ç“­Öñø«ãñwåwwÅÿ—ã´;íE’w³xXÄ4-gûüxüoåwÇß–ßİÿ,Ç9,§İ/?xQ~ğâx<>÷Zå¸ß¢ÀŠÇÇ“íòÿù•ÿñ¬S®w|À¿ğ[æø•½à1ãór
¾ˆ‰±åG|³xıOæÚö•8½-éy5îf4§ëEëR/.hÆ=(wpÈ§~~<ùT­O’¹\´gÂFÇ8Äy>îÜæ•h$%1Ÿj±ÁwÊÿxÕ~Ği’ÅEœöçÓ(Ù,ân}!Êzúèùñ~[ÎÎiy(ÿßØg»Ó^)¢"Ç<*¿û\õ4Îgq¤wÕlĞ±1ÖÅQQĞôzFñh°çÑZBzb·‚·>-Yª<bôó%ö=ù_:íh”@â•ÿ^êÒt>)VÉ½¢u»<]ÍÄjƒ­ãñËñ»Ò:Sò ¸lš
å¨7Ó|4d7—ôÔÈ»åù?‘÷1jëşÙgÄœåŠVŞKÅÿ»U~öªd»Çúcö——|h¹FÃË4DI\l®RšñPnôyù³]8¯¸8_±³Ë3:ä·ù)¸œQwKrLäŞi•ãî[kf?ûy»ÓV+ak[!	é2I‚ù¥jaâC±0¾e rÆå„/¥,OK¬³ryŠbømNÍúÅCrÙÇrƒŠk7.…ÃŞñdkN~¾\ŠXÇ7¸ 2$ê3.‰öK‘ùLŠ»/ùeû¢œù‰$Ârå4bŸX
@YúD0j)œ³É_^%éŸÛn9û¡’zróZóoìKÆ’²şşÙŞ]Áë÷9{lbõŠ z-NU›zÜ:?,¿oĞ¡Z0{	è]Ä±ˆI'|ùåâ=sP®İi_%½x4ğ´«^19œf`ïˆÇıÏxö½çæ—õÓîØbhKà—»%·ù¶åÚ øµç—óšË…íiù]~ÎûÇão¸~±#5"Á€_”|µ/1—B‚¼„ÌúB
×ğ»ó0T±äÚC8ÚS)›•ôÚ×İAJ¸+u…:õ~Wn	lÑ¹Cßú–õ/Ì:#¸¬‡åW_Éqé3uÅùã;P›p¨âT?ŒS?@¤Ç6·”öânTĞÈ2¾ù3ÆÓÏĞ¤~oŒLîµ/´™˜{¿uÿÜ6õÂéŞÓşeš-¥ÉR¢Ôo$çkIÅ‹ïe_¨˜œìb÷ÖëÏÔø¹LHo-êŞ†*ã(/è€ği»dX0u·œÛ¥Q :>4Áz¿üH²ë3dÊQ¹]sRf¿—	!˜Z™êízÅÙiO<Œ …”v©.sù‹¯ù8-­ÈË;õR¾áGå‹²/v¯ï?ÛîSÈLå³	¨
ŸM5şŸ¶¶o¿©‡%Ç«İ£·NÄ•`©EzI3–7º]¾’ß²÷º$Svöíó6Å:ê*/+7iê?îİ~L’¡2á…\ê“òÿ?Ã’Fë1¥¾£e¾R|v•"­Gêx/˜m¼syü´”}ğÛÖÂê+ï]ş¢²øŸb¡¥…©šà±e‘³«¸‡õFµ4DFÛÄômgÂ©c»¶ i>S`g@ƒ]e%…GÙ²¹@’¿‘\é<6eÉØêÒ¤Ù•2õ1xø¡2ÍfãÇ4‘«2yùçÖJnDÌ¯€òµŞŸØ 4„•×i9™U½Ñˆ0!â‹WC›Æ;Jc}!%òsğÕ}`k[¾• [×ç4yjÈJ—>ÇÃgš`ŸK÷ZHªøNâ—Q2"ù9ºş¡P„]êÌW`›O¤òªTåàĞçåĞÿZRW[ö'ô9¨°üm¨ ­¢æ/‚+ù©o{Iª÷öaø,«ì“³©Ğ\Œ{³Ã7ù\_ı„é×3u‹øY‡Éó˜¦@t}|•äyÔ'À”şTˆ!0}KKd%>]™m KO;¼·Õ"Àğ0+!Ãı³c÷ÖÒ¤¹ŸÁ&‘RÉ>¡YïÌñøœöGJs¢}ƒ…)2B%mÀg‡|%•¢LÜ<‡¿+W.6R8ÙÖËdqmŠôŒcgTê´‡ÜC iª·QíwWÚmÂSÃé½#½¯ª·Xc[ÂĞ¯:¬#œxápò½à	ÁÑVà¹ñ©çCû£A-Ì§íœhÌöÕQRÄIœöGQ²õ¡WüRÚOâ|Cºîÿ\‰­Ñd$ín`·è£ãñÿ*9÷s’lq­âOå§JNî	'ı0JåLd¯ñ?ø—æ×³øv¥¹\Ğïä÷ÿ_ğ?‹Ÿ$kQ‹©já4Ù–cOÔæ³h-îÊoîËíìÈODvà)Ï£É‰ëÏbIâÊ}ª—÷[’­Eñ¯£4–ß}
t÷ÇŒ\’íNûb”ö“H†öş0á·ê8.FùoF2Ä>ú³R¶Ù§4W›àZÍŸ…Æ;¸8JúQ¦¿)·#í~ôå…¨ˆñÕáw2æ@I»Óşe”´+=,?:ö˜àrÜ8%9Y‰Ã$^…ïıiIÀ=!'ß)…ú·ÂÂá×`òÈ¼«^Í¢^ÌÔİ(q,=+ú5Q[g)‡ÊhTÄzó[Òõ~ÄØÖ Óo‰¸(ü±g²¨Yÿ™Íô‹£¢«>|
/Õ¥¼ ê0¿’'ùLDpñÔ—ãTMò;Ó’³}%qWoGœĞ«’yÑ€šõcu§µêOæ3B O‰SG’4‡G¿²¨ˆÿ$ÃŸZ 2Od4ÊùøÏãÉï¹§—ı™¬eä®üû§Z.yÚ‹€’n”>ÿOğ;ø|©K’ˆùË/ÿQRœó¸zVµÈXê¯Q9ë<lÁKi¦$—3ƒu‰ ü¶Í?K™<Â?ÊÅ‰c‹óø¿oPM˜/aâ<ş£d$Eï·İÙ`E”€ÙaXèÀ˜÷¢a”Jqö'p± £‰ƒüÇ(M£^$\±Ø3ğßF·7äª;Ë>ŠÓÍ(»¥z Å¦Éc[Rtì)E¦üi~7Úˆ“<!ükÿ)ß+vŞÿHÓÛRØî”Ê—’¢ßÈodD_ç/l.øÇÍ¬¿ù[ÌÑêYrıJTÜ‘Ä=š°R6ôXWâbc¤¨é¨Ù’Êšy¯Œî‘Áe}É
*Bıgl­ÂU	.¹uIO‹Œ±x„§wŸçüMmÊ¯ˆÀ™ş$J¢şT›<ú=º%…ä±`/}Sş,¿D³XF|~/ÒØŸ³¨Ø¸ÄÁ52ŒÄ™sì…œ¾ü”fw	“RéíÁÿùw•Yq¤•?ö$²”OxGª(G*B¦Æ»¶™Ò,¿]s<ådTÇ‚Şäå^i‡‹|™:å•/ğ(ùÀ>"YŞq¥˜"ã:U
g‹È×iVŒú#y<qôKôE­¸\¥¿Öb¹6©ì1J¼à´¿Aš±÷Ë‘İÊRùE±Fõtåõ+]éÒ¢ˆó"’ù+i¨o×3µ·–áPßå¹^‘ ¨^È
ÉÖäÇOM_^!9-˜´½BÖ¨ÒÆ^Ííá/Õq­"¿¥‘%œöøI¯ÄéF$4;®ÁD(™È’Ğ;Ñm0Ä¤Ö!¢ìkZSµ¾é:‚•»¤‡µïC‘È˜e5ÄÊèà>ïä'E”ıE„Ù'$õG |€<«åC´ºÅÀ–Òeu”İ–KRf9Œ·é…İ¼E±Úğçò;ÜŒ7·z3ëä÷”½Æ–qó·kBOù\› @KûeLŠTkõJ’sÖ{nëöŸD¬ÿP°"àçOhB×å¥?(}ÉÂ˜iwÚÿD³Ñg†‰<8™Q²Ë|Ú[ é¯GiDÊ­ÀuÛ¶í¢$¡£b%ÄI”ÅÅ¦ˆErÏˆ3	ÂÔ¢Uz†J+Rîky}Ç2øş
<ÚPŞ“†tßjÃÕÊ‹
8ê†@µóş%J”enI¾?4R¾œYVêÎ];s~Ú›yM÷Ï= aBîæ@G¢¨½}F;(?Fx×M}0~Z›xÌr¡YÆó³®Eƒ€ãR°İ²§„E6Ô×ƒ®ù¾²=õ‹¹˜ä”¬üú8›I°h«¶áØ÷ÒœáÑ`ŸÄ½>)¬Å5º?“Ê„ ,¸ˆ£¤$ŠŒ4>’#y)ã7*{Æ“;ÅrK.…™[l
‡W6Ì™8=‰ºdƒ&=’Áàé> –-JMĞÚMÇÊ&†Wß‘³Âbà»+>X®»å#ğ¸”V ù”§†D¯uàÒİ{ëVû¤cÀıİºÕö¥ºãT|‚‚)Åu³¥‹j6O6¹ßàªA‘Ê!:hY|q[æ>iµ×©–]uŠ ±h)½Ñ>ó‡›SÎXØ¸^¹9çJ.’ä-?lÇ6¢´Kô²÷q¬XË‘Òt-º$¿LGé”²Ö’U»UPwHŞ¡µÍeï›/ıÄ¥ôñ”õG*+³™´{Ì·¥¤	Z=x#¸ş|İtV2Jy9°“…Ùp©µU¨¤’ÜÁ¾°`!,ÎHš™¨¨N4Å)%ğ¯Ñ…Q–‘´G©ò©=Ç9«ó¦ÒÏÍ‚ÖÙ{ZZ›×e9ı˜Ş!ÙV£f¬CY‡'uC©öiwÄÔù…(í“ïiã¯E]¥7È˜Ü=Ñ©o×XşºÊ'Ò³âP:íXÕ½¸fL&QÍn>Êª!~İ§â©0ÑÜ±´9ï½Ü–Ó¼FÙç8¿ëÉ(‹’ÙnSJí9ÉˆƒRZ/iú
ÕÖTgMÔOâbãJÄÜ}’¿eî´îŸàu4qıÏIÊ‡×|RS
‹òŒDvÔk8§7'v˜wšöû	{±Gè¹œû±$§Ê<#g@ 9¿„ZN»¾>Å¼¿Sé„ÓL­-7e$ÌsjèìÊúÒù\'x§µn¹WiZ<n…-½Ò¶] ƒaB
ò×µe¸«QIó4Ò)6â´ÿ	I‹O2šöezù.¯ååğ/EìH;XñïéDÛ¬ã®œl]h¹Ö
=«„ëYÏH¾ñOt”]Ìèİ\(¨nãG—íÛp *ùò¥G´'}ûh3å{<9‰‰õºé~%ÄÅu7TZXdÀ©b^3PP÷ı¡ŒóXLç}“—½†df[$Q–^¥ÜNq^0·¿­¨ñ&–Ùª^éÈ¯F=r5ŠSè‚C ò¹ô‰¿i5$Ë!¢ô§É:Õ%3ï·ÎË=ŞtwåŞoİJ@ÛW#­;’¢Xÿ«¸æsH­‡&¤‹aëxãÇs
3Ã]>áû¡qKvé1¼ßC¿k•;ä·ªH†¨6Il¦Õls¾ÅªÆß½N’²¢kß¬Ì‚Cğ\§ÃÑP‡P]u&²&<45j¾’8|àßU§+O‘Ÿ¾jnp!Ç6 8Œ·ĞõzÙŸ¡‹;AeÆGÇ.3Ë¾á‹B<6üFZOÖ@¬é%Xâ·«8'ó‚18øò¹0¾e	„¤¡æ;õğ"QÙ™¿2–©ta#Ê¢nA²RaÀür<¤£vw@‘ºààmè:5£º5­=O\¯êKyüš›ÁöLX¯Òy™ÉdmVœ$ËõX`àW¿‘…¨ }šÁŒ–9$eíO.å>'ğ7â–ˆ‡Í¼„«twÙOÄ°¿¤QrƒÜÍâBfº° ÷@àb§x=#½¸\1„]Cä0AQhOÎşzIÀ;Ñ6gÈaPn&ƒi¿Aãí7D>6²Çƒ q^é?i¾CûMs{ÒÍ‰MÊT3×zÚc<ÃÙ}…¬š´„'‚EVÖ‡úASéxîÃµ*µ=­[<¸‡u›‰®*çgO
Ïnj¦Ñ?P Oè>I/4W*Ò'ŞbU…#:;¨^Õ€ĞÑ5×x¡e*Œ…'†}ƒTl,IÉîÃ%zQ“æÓWöÏü¥ÏâĞ.'½‹+²îª&²Ğeïô¿ß#¼9ÌI’\NhY/Q(ı$rK5ØÇ$ªÅoôNÃ‚¤—üeA«}ë¸W-pe´¶(zÊÑıÀ[r’'`oˆ@Ì–=\'«Î¸úI¼ñ PG³MñGÖÆ_™æ¤TŠ¶….À…”²SœB/äàn°d	Ô\wÁ¯aie2ÿ0!‹Ñf~…¬˜¦PgÜÃö†FæQ×çÀ8G
¥~@ \²èn¹€ÙÍ_1­tßö³¨G„aë:ñN%èÏNÛdãK÷†I”FÒÿìÅ²DhÏ¶Ç CúÎÃt^zø»nÉ+*OôÚY®'èIøàg1¶Uy:$¶÷¨XÚÁ|ï‹ÒöVFı>‡’Ê¥Ibs‡Ã›c¹;ùñ4g€š€1ÒÁêˆq†B6ÌMµœxî”q"’KÊ»ÚMÃ=O>»œ”ßu¦Zìâˆ=Íøò\³¼¸eQ?‹†^ÅÌGş±“pd'Ÿü6x,,3ß6WH—¦=¼OœEZ¼[š†ç¦W¯€MÕæåõõ¸KlÒi?r9HÇbà<÷­TGAßùûMv*ç!²©Ç¸üoß15oÏ8ts€u+ç×’	V˜NÄZ@Ãá
(FÚµÿJ¢µzcÍ¯]¦ È“0ùí%çÇ-íèV¡\²òsÎap…FY[sY·šm.×è]`;m¦âæâv(Ä‡G°Lî×dPÄ™•8º0&´÷À3%×{Ã8#=q‹N`Í™W	®æ$÷Ç¯]÷ÈÚÅEÚÛ<}~Ôo>ğ«„uPÒEˆM™ğ¨/òîá_ÛûT6>9R2kO’M¿j¢OW¸æGíòúzN nè‡rwÀAsÇ6¼à!†Ë¨t`/J½µ
éñh¶#ü3Í‚öŞ@~"š¸™÷õAíˆÀoU<½V©µâéèw’5Şâ‹×xnr;n”Ó{’;>•:“6E;j{[ÖWêÖE	~µ–lÑûM-“½µX´“âªÁ´ŸÜN¹˜ØßƒÏØQí€7O5†©¬ö/€¯Ğ{PÎİZ‡õöìçtßƒ01qp3Tä(ù/·Ô„%6Œr=Oü}õŸ½ëàŞì>´ş†t¤n!£¸Ÿ2?¶€¸y¯T¨¯Ñ;d°&ª—o¼Òö•2u$Z³:¬y¬VUG¥Â;`Êô´0ñök¹”´Šnø“,@”©HâÎòûnğ•ÆIx!Õä}(A.ä9wJáHíÕ1 éo¦=’E}Ò»™“,Gq"juË«ÖTg*Çl¶¿ëQÌwR?vXqa§5·ÿ&îÄÊğêš2¾6‹ÌÔXO+‹ Û!q6qjØ4½Æ&j4báú&şÄ"à*I’ùËYLÒŠfËÚöõCzZ˜
#ÊšÉ¡5»é®Qí4‚m</ÑVß?¢å†š~X.@dI¥x€$ûÖ’rƒøĞ^@°µ•K›í›¥ï·~èûZ'ÈÉÔá]¯ùSÍ¬–§*]¼óbœt":»¸ÍÑØ',¯“lHŠQ”Èd SkfÌZ¢×­±À~ä#¥Œm»x»/”gµ~v¡NÑğ&ı&ÆÜI³Ê@õ³åa±<bFàz|Oªù†Ù"k=?·`W¹'YxOª¦8¬LÃ¬w·¨RPùMÜápƒ¤·<*PFÏ¬ùãäúŠBø;äX–Öú•G¿yzaXCòå~[UŒ¶KÚ½ˆ
İëa)öEö'ª{Ú=ÑÚaßT[šÒ_ÊÖR¶Kƒ< ã½YeÆPÜCa‹ÙPz˜Bje·l3¼ÓĞ ªÃÈR2#¥Sğôg§OºiØ¯PÔ€*1päNÇQêÙ#¨)!³¯´*taŞ±j¶ŠG%gà b-ë$DÚŠğ Í$4/…2k­pVAJßRC»³Ü¡ò“±º«±aIYsÛ…Ğ^®Äyq.|;íˆC0¢ø\Ò³nRw-ØúÎK3KuAÖîšgj½£«CÖªò×}˜øçc®h»—ùAûBûüY®¸i Ø«~¶Uá¼ø5r¡ÙUÎ‚™H÷Gåã‚äp­#kõEÓb#gÛeŠø?Dé(Ê8Oÿ©ô3qÎ~Uö+\ËÔ‡/€|~ëj”‰æDc ›ŠÀæ0ş ~| A+õãÀZÌŒRÙ^†yeã™Q²	ş*š>Îú£\yŸw@ã#ŞaXh[•kn/ Pæk½Ñ-¨üêCyX¼ƒ’şR•ñË7ÒÕ_y&­>ü­eˆ²p¤é“¼wûWK¿¸JÒ‡wBE‰ê±…U†0F¢]h[R÷VàÖĞiòÊH'hwS/’¼›ÅCe¥X5'¾¾÷§ø…	¨¼EäÁ âÛ!{pO·Şyÿ]Ã¦RËçê·fĞ‚¡‚`ÄÀSùQ’¥°¦*±~Å/Ì’…ŠâMñ+^Ê¬ëßRÚÊ‘¦Å•NûTxQÌÜ9ÿxëëut”ëZc.l;öKÜ?û@¤Çí µ½‘6fVÕ#n§Ó*¢µ©@Ø\‹[ IsÍóqœ*«q,…Ø†#ıãêdõmöSæÒ½a”öì¹Á\Ò^ğ†	rúŠ?ÇÍ—³çÑZrÒå<qq‡a›Xõ*hI\¾ •øAë¤e·#}ßú‹!ae•ùT–
}‰Á˜tÌ%@r ş­YÇ-”C4"{ıÑŒV{³Õ¡¸sD\eCùBv q‘ò=>64ĞÆ‹C)ÿwmdHeºCsÅ¹m³CŞs¿Gù¨Ş2Ã\£÷J éÅQPŒ¼=Çİşò&Š¥íZt5³I¡sÕEE²ÿ¢RqU#éØ’Ôé‰›+ñ?–
2X¨9NFÊtqZÀØ¶ÑJËÿÜ2äF^´	+öc½T	Í	Ğ(Æ*ÇS}ìS-ftØ£wÓ“	pÓ“áHl}Ìµ2çªÌÍ-1·Pi5])®—K…5¯]”ø¤¦ø]â„ôVéõ¤æ~)Ëh®h«xÚÿ ù
l-‘èÜçÊhM;MTt&+¶?X»¯|)ƒuwŒ×áåEfKó"ºô¿§—•Oñ*¥ÉÅ(HÎCÑ„—CÇº;ÆÃTPOšÀCËãP(ÕM8É^Ryj4d÷.ku<2ßÑ
¸¿´whº*á_â,~G„¶Š…à¦Bç;=’kHÓè=-'P¨A-Ád'Q&£¨øÒ§’;C—½kµRîFCP].·ô©î^vü
ˆuÇƒäJÂ'qz£TŠo,‘ÙÄèŞ<WÍ0:ëÄ 0§ÀÔUnBñ'è¥€iÛÏ|‡z!vu²¾àâ[/íº•°Tı5ô.Êš§y ÃŒÒuX'I»$7Q)¾ó”H£Ö}@±FÙJÊš™qpe,I*ß\ 39µms)uŞvÇ”¬zK¡æc=Ípë†]ÇZŸó‘÷r2Š{¿”Õpüê[3Ú¬y9ÂW½jQîJs»&æ$mâjìÄ¢ëg6Ì¬q”Odq§(¡iº°Pj©å*’öö«€Àv°“RˆwKÏÓ›¹¶¶ÍÄj³Ö¾eKoİcá+¼¾ÇŒXÖ]1:ò&×VÌk^Ù=‹}shĞ×'Å4×Õ?­W§Ù9×9Ú8Mâ´¬Ö`b"‚´í,ªpoÇŠèté0NhaºÀÿl|k)ÍIV€P™Vo.§ÉæÊh8¤Yq)í‹®òbP¯wìÌ¡;GtFiİö\W¤+e,7ôÔD`•£ä›)M7¹LG)èOZïTf¼kÉz‘®İI]z$UZh³Š“MÛr˜LWÌÙÃT·g¶Æ#é’M3 Ø¤5l?££¡?ÔT7¨$ùá¹f4‰Ş¶•MM¿œ«t‘¬G£De–Oä6^ˆ¤W¬B%QAVQŞ\HœÅ8Jh_Àõ•âúÙ9ÍóİµµR 'NİLnC%‰^‰ÓÛµEı?_J×), U&ïQƒ|İ:Õ…s>3İõ)¼‘¯\¦®Öë­Ñg^FÔæèTÔŞ†<—ĞWî¸W­ûáÓ<h>JgTÊ¼'©*½Iµ™#²Ë]vX¼Hï¦	z‹¤ˆâ$W2% ø©gŞ•_Â/­Cfy+EOMŞ_[+FÜ€ÃáÏ7Ã;×pŞ8îOÑ1E£U`&qJ!I’8í/d4Ï¥5ã´Xô^Í’cTšáTÚÏò©6„Ç¯ŒpyX}±óùµ›ÙÌ¶TêÜlqtñ˜ô…€lºI¯Q¸ÙÏµV/`z¼€¡Ö1Üß-PdKMYš±Ãµk"8¶45
—USÇøïõVé"¾DÙæu:¼9¼Jò<êk•Ñ`ã…o¢	•¶CXrÀŠ¸š—iÆ l°a(Í5Á(1ĞuK‹P”š·sâÊ$˜èÂšh×c×2şŒ_ãE¯yP=tG`³î`“VEĞCS	;cá7°FaüÔ×6¡ıÖdîÌVyt¬°ËyíSÚ‚Oyğ‘…9Æ¯D*O±BäK%áªŞSšºSÉë8q{O/AƒöxÌÑ‚Œ\+á„ç,«øD¥t«ùÊ™pôˆÏnU@°áp*[Ç,$Âb¨|CØí”<ôôyzóu¦Jï½ÇA×á“ƒôÑlº4#,M¤ˆ‡²|ÿgª‡´%»è_h¬U‘kà¾ù
€xÂşn~<°ÃŠÏ}ÌUb6;ºoáww¤,8Äš·†¦¨î}¨Ãê–ëÿ„<'Æm	èç…¹’ b-[,÷fÍRupË¾Â)$6ilM‡ó¡¸Ô‘øš*AíF0_Êt8SBÄ„v›8à£,¢ì¯àñ~´¨“	å¶oÙë¥ˆu÷„åµ@Ó‚¤m+CO”y÷ãnŞ,øù1s¡q_/eBğ’oÙU|½„˜ÍåX,¯û¢*cïz2Ê¢¤â‹`”DYÅƒ2&Úš³WP=T»Ó^Êó1VÁõ|»0MÍhÎêı)+EM’¥ü#Jm=43Ù»ß\yà+E”ŸdeÂ€ÓêN?8ñVÿÄR®O¢EÁjÊºê£uÚ‡1I‹EÚ±Ó–k8wölU®4Ğ9]ÓùM5kRxlçÎu·$yi_÷p*÷³I)ã¡V7…Caz¾üŠ5$»Ñìù°ü’L%®ñP-ë½Ğ.ÕMµä‡–wMÛïğQ†y%Ò_–ÿ\Œº·Q¾j3 o:FæÒKÇ
b¸¤14Ähçs0‡ŞÿWàMÓVî+‹$¬¸¬¹)nnWÊÇúşaî“+«ÃRygSœq§uÿü7^ƒlÚ&%§0¿SåkúÃÜ"g’Zü‘\û)/DyRÉ_ã]pHáœZ X‰¯ŞŒÊÚ¤­sæ–ı&W+‚Â2Ö‚ˆ|”/ nhşN'l«IkuŸámCk—Ë+1U2˜ïvIÇkq›ÊïôÕêêòê''áü-İL`BhÍY—¥ÛœíYd_€…7)ÚÂ£}Lïh 3aª;ÂjĞÌ±ïÚ-7–â´•öÈ÷½DÓR«D¼å9 å¶tt.ƒaş„5ßïNJp‡]£×»…sKÕl[|´çÙï›ã7Ïö,‚ÆØÂIYcG#oêä,[‰›^¼’æqß!Âİˆƒ¼Ÿ—;ØG;Øeæ/WFÌ›»)°ÉÙKiÔe_ğ%¼„N[äºa–»â7Ä»¸™sFÍìË'zšO¹­'ª–qËÎŸµHéôÀUnë‡~Ú…ºr;.Š„HÀ•ü2¥¬‡g©Ã*ìó)5¸Šú«MÒÜ’úé–d6Âm¸ù$an`	l¥ ~TxÅÙYš­à'`¸(ë•á¸‘Bv(“\ñÊs@	wíá™sëå’U'Ê3wPÜ VRÀ¹³gEuÇ”eBî#s¯aÛ=Ø@ñ•rœëZä±„{àw®“l¥$-pãSİnĞíoô6ÔOBÌ+@a4Ğ¤Y>4Rx—ğhúµ/wpb\	Ş®cĞ6ĞÖœ‹UşÈZËèä²Àâê¯I&Ñ|‰ EÌúƒò¡à¸÷ÒR~ÿşùu~Â¬îX5œúí@ëoîO¥¢lÜ’:¥	¼ò›QÌğör	²Ìµ0•}8Æ¥Ÿ•†tÙ3îá˜ıïHÓ¬mÂs#ğkÉˆº«IE‚ƒ„²!’»êö9eÊ(Jªà·S2É‰Ğ óÕ„*Î¨ æC1ærr½>Z™?è•h2êªbÒörı/^ÏˆsíşZ¹ïA§½œ.DéHf1@$àµ{¿êÒKı¦4•WVé•J¸?†Ú©*ïw„XË7¢´Oæ“dQÚC¡c]ÒÍWÄ‰†‘ùÿ®±šÃ¬ÍÍÍ‰ÑQÊrÿ¥ƒÑW×¯ªUEË(`cĞŒè¾9 ûÀİJÙùTZUk÷~÷Sš1òÁº¯a›:
8™hÜå´KÌƒ?‹pí„cQ¨FB®è0¤" FÌã~º”®RşÉQdÃ‹IE»Ş€^tŸ•#*_*+Ìäğy­S‘Ê˜]¾vïWkY”ÊújŒ?óGhşZOZ»§Ô®òtIiÃ
³@`æÔêl;çšâÉæUN¡ékZ¦ƒM1óZÌşÍh2]LÄØÜr‡dÅ*m_hßºÅyëVû–¿ı˜€#bÜQÚ£®ŞY[í2<±e=Li+Ñ¸î1»{M•…v¨t¹ĞæÄ¯†$Ëi%ñoIïfÚ£¢Ø*€v‡\uËšÔ!m©nj†›Aº@4!p?6‡ù8e—¶Øø†ºòn ?ş–n›šTÍ`’J)œTƒ¦56ûRÎ²Aï®@$Uf›`ƒÔ!1äFÜ#‡TÅåEÏâè&Q—0cçj¢gÉ£wôË:¾A†$*Hïšõ¬,5! "¤•Ã/ O%/áš;±TfŒÛ5³“¾^ cER<\¦B¼
5Æ¹ ¬74XÙØ‰¥FxØØùş¹ÃŸ†_S¶Wâ´A oñ¬¯L¶F]¥á¿«JÌ2W[	Ê“T¯İû•´©M[á;Lf>²¿}h>=ÆTt°«ŞïÌ'Å{Ç üªäjG·Šš¬w+'›/QnŞY(²ä½×;)~`w$ŸáVØ}Ów6`W£.ÛÃ_~ÿ»Ö{­¿üşßÙÿ?ú×À2jŸ«eÏˆD3a¹“ùdÊÍÌòĞgº#~ Óìˆk­ïq‡é[³/Y £ıšêV³ê‚ˆÒ#n”œdxÂÜU­²	ô¥Ã¸+ÿe|'j•ÉC1_i[ïN£k‚S†ÃÆ÷hºAúatğl”Ñ¨sÛH¦†§EWğ"j²#2™}¬Ã)–R<äJ€ğDRÂ
B¤B3CÄ4—&Œ	äáÒTâ;ä2!½µ¨{()
]ğ3ìx¢¶áÙ!e”f~8LbÒƒ6Ÿ÷Šh›‡Gáb`îZÒù8F•ÇJ>~<Õa7‡”~K¥7¬×Dşy0nB N5Ux½BpÂåš¢³–sñõ®øWôJÕÑv¦7¦‘×½ÊŸR±ÈuÁöN§­£ÅQıØ½åsU*R8õzyO!U 36\ÒvÃ=
ˆÌìYö5Š	w ·YƒÎğ÷æ¦³«Ä_ü´È6¯#9§ tlDÖmˆîxàqY ·œ2!	r+ìæKû&y ›Áå$újÅÄûPI+ozğ²O±=éÚvÿ5Z¨Ìäö…ö?K@+¥E+’Ÿü‹~ûJf€i -zKn¢)N&Ê÷ô*˜’¥ŸùÍf
˜ì%äp®jÇÆıó<Ş-oÒQB Ô­ßüË§ºöÁ_>ı_R<åí}ªúSô¶ƒ÷¬ê­ÓøqìÊ×l½¾bˆ5úö]‡ XYk<fín6;îÍ©{¦ô,İûhšz½Úİ›÷Ë´&ÛøÜ{ZC¢8h!#öo9@ÁÃ,XÂK“{«ÙĞéõsOH'|»˜	k,Æ;[a93ÕQxyıZªIç‰mNónö[·!? x~A9ĞUåƒùQ¯'Œ2YJ"KºFgj4­yì¥‰‘œ{¸H{›—iV¦]ß+FQÙ„]»R G˜‡`[X‡ÓÂ¬çğ‚ç(cT<§K¦›©Ÿ(üëˆ»æ‘Vşs—:]œÀ.u%:éìçÏTelåÇ`Fı”Î£[–„›hÕ!MT“¬}à}1ƒ³Ş°¸î\QµòT	5p­†S€ª>å%z	‹.Ğ‘îÊib”z_†KŸJcße¤ä^ñ†¦*XÒÂåŒ@Ç¬´HœFöËŸ;Á9:é®MÔÔso¦èé…íp·D©²áoà¦ò¼—êa»Ìİy5jÂOõoØáıÜ /ËJÂŒ÷G¦IY~ÛIX::üf-âù5éÂ™;Ô"ì×À/÷%¼LÓ¦áÛëƒÖzüêå•©Ò‚E±NzôÂ7O‘}T† 0øc‡d^È8Ä¹H‰ñ”­ÊLOñjİ€¬7P"³_º7L"úEÑ­]£[÷D&qír@ÿ¯xjÖ¶JòÕÙKµ.’cI†³Ä¹2T|(C˜j@	İ3Óï¦ãéQm%QfÍv%©–KÜcŠO&^7SÜT'‹
9	eíg>°úèÏğ—qp';ˆ’ô ÜÇ ıÅÎ®ÜBœïN²V:÷½{‘‘Êç—/›Dpƒ­T–
í'd‘vÙ…ü¨ü‡*JùgÓ^Ü
šAUÅŸ™c§‹9ùÕã?eŞt°Ûx“ú+Ï–çuÉl8%É4n¾u¥w…xk©Úåv”-wYúš£õq¥.'SÇBC×Iâó]:+¡¯ö¬ÂvõØ¬úè›ïF¦8È×ê™*ò«Èh¨=‡Æb£/¢3õæ:ê-gq?N£d…Ø¤]âyg–ïšæCh:ã9İrkGVô_b ™µu‘¬ÓŒ8ìc|U†0[ĞÇ8óë…ÀÙq	GÒÑhç0+de‘ô”˜7ÿàr²ÉnBî€gRË­Êb3wçäsğN{ŞRêzó½;¥CK(‡‹uŞnï\‘mr¶
§òíLG¥J¯¨˜ª÷\«Êz7'«1‹&GÉÜás„Ëù
DüÑy JâÄğ,gçzFz<X¾­™‡ÈÖ6¿>D_wƒ„°ß]J‹¸Ø¼Aº´ŸÆì§¼!ébTà8ä6Öjc*Å¬Éè«ñÀ9ƒW»~.¼•@zÖ¡h˜ş«§óÌ½ú'ß.Ûª1ŸØŒc²–áöò_`2kã9Ñåá™Å‘^åíBëõ±Ï´«˜‹5Zkyö'XìkãÇfkòóì,4ÕZfyR×Ë"­¦ËàŸ7˜Oc­Aämê‰ÕØ¦µ¯¼’ŸJ—Ù>š±\ñ‹ÕvÊ%¿ï ²¡‰è`Rìµ.u$FråWI:*‘>lÀo¬4¤/UvêXv›ÛjUù·¼8e[á^Æ|aN²+z"ƒ>o[Rñ@å…S,hÏM—_ÆççØŒAl7ïzrëZß#¹ßÀî¾çSdîbÒ»¸y9‰úfY –¯	ñ$ÕÎ
ßÄ,OÙè¢ZãXßšíìØW>KĞä;ók£^ŸXÅÎª²¹¬~(ûföô6œŞÍœd«›Ã8EŒSZˆ¨ÒÃYã1Ö‘Birxå—|ÅÆcPáÊâÅùF¶7ı9N·ÅKÿƒdô#’•(Ÿ°?$›¶c¸D^©œ2_§Öÿ÷ìÿ~şrœ®^%¤¾ŞéçLuU:ú^Ëè×	&¯q|F¨×H›…DYwƒ­ÙÄ„á3Œ%Ày²%ÓØÑÖ³ÃcY›¿B)+ÒR†•ÇÂ_ì|÷/Q”!´Z‡eå˜ªLKo_h«ôtÿÏ–~ÁÔ iJ«ÂãÜAß^­ê>‚?é„·ø¤Óò™]nÁ‹ãñ^ÍÚµCŸF\‰³•½où[´Gšë»vDša(×Êõó,Ø´{İİîÜ?¶-A×JÍ&Eæ?¹8Êã´l;fNî*êí«÷FkÕŸ¨t@ 3V8ì3b_ôŸå•C„é=ƒ5r7ìb'ßqúOê û¡ËŒûo@Äék‚áˆ¼§ù3ÈÏ@çƒÙdªcb\}?V´=’OÀ_=G[]«ÏI“ãğ·WX\2æ/TI¿”K­húìŞÁ¦’í5dÚ“Iaïjê3ß-'œ 4&ã|˜D›D=óQşTÁa e·ayAW$ŠE0ÈÛ8í/’‚gˆ¦è;$ºFÒDCWøªæš}¿7³b˜F=whX—•GÉÖCé}×O{½d Ï6\ê?Mæèè"~»ÿÖqAÍµŠŸóa«u.üÃóŞÿğï?Ai¶Ğ¼¨mî¨ÁÂ©j@„šéáŠq°3YÒ{â½Õt_VúÜÁ4ÖêüEJTA¹Ë«ty!~({­‡j¹å·AxêWËwc•
Ê70¥Z˜á¤+;ğdÛ,DXsZ[XÛ±£9tÃ˜¯íÂ`–î´v§½^ö{¸|ãRYr=ê£jwñ	ÒÔÑÃ¨Ëáa®f¯›¯¥5Àûg¼ÏóîÀà¢Ç\$·IÕ=æSu 4PˆÅ
"oÅ¡|\¾€)í
RÙÌƒ¨PàÌ%’€¯'ç²İ«3èÚ£á=˜î„%<V
Úcš3ÚªGß¹ºËÆ‹ïi¥GF=Î6'r°ü?"lô×»Ò0 ?ªêÍm,°Vé~·6Çq›aëZC\Å@æjœ×I•:àèĞ1z1şíÂFTø¢ğáV@¯OUné”™J¥fÊ“îµ¿ƒ.Îr7ê³ò=)S¡½-Êô~œ©­æ²A€Áéñ~CË‘‚\&šÀn>N?ùZ×¥A'¬EŞş··£z{Ği‹Rñ2)6»t¯`Íºhj´Wˆ†ÃkÑ€ xşÃõe—xÌÍÂÓa+jÄÿápeƒf…Xx@Gâ¹ÆÒƒéĞ‚mÚ%DÖÁ¢ÁßŠÖRJMÏ±\rÍ3š¯7D±éñ:§ş˜&=QLP±Tçã‰S|^¥È<B~o2›–®Ñ{<ÄËE°ç:şŒüÆ_‘ƒ"¨…ÒË”ìpô·ÓÅ¼CÉ*-a2É½â"½·éúi/;qÂ¿à@¥
©*U+G6NKÂkİ2£À…˜YTÍ>‘r*Ò	q>*EE7õHïf–ä½ºK¬tìv ZŞ‘§Â·ğm³í)ûÊ‚²rŒbm^&.ƒaàGF¤©‚. ]Ó]ËfÀ?Âr6Æ³h,UK{¨”8T™§EçT4²»oB¸;xh}3XâbBYW¨•¸ ªÙÆ3LÃ:«›6lv)ËØÓL&‚”¬‚ô÷’÷ô¥0¡FY¢İÁsî±­¡Uƒ¤'R‚¼ Œz$¯Æ.}N•ÂíÉW•ßê¼ãPç3ÊaØ‰ D¨µQÃüÂûï“{Ñ`˜¹.€RZ	mÇ%Üó‰VrÄì$ÕI2æ×PÚOÑ9¡Ë€ršWRZ¦˜õœÁñÃ…Î´tßxÅ(K—××`PSA¤ß·rŒË$*FiÒ§ıpy}=î’‹÷f¸–å»O*¿¾¾›å"Ät®;Ï†ÓâM39:Ä²>N‰]hëPÿd³2Ô1­|©÷”z`´:ÕĞH¶¾kÊac”ùIÙ»'‹™Ì¦Wú×n1¯tĞù/`Ç©¬+FwÅTlNë‚‚ åGEÆJï­ˆíUyí£^o>¥Åë Y€ŸlWf-:*]pRj¼ĞÕÆÛlÎgM@ö«â M÷“•6©Ií´ÎµV/¶–S²˜ÅwˆÚõÙß ©*äÊ¨Õ6ĞHÈÁ~Ïr@Àå<Nì?<é¹â±WFkƒ¸8fÎ¨¢/Ó´K\`AñämY"˜RT@îcIlBÌvwƒèÂÚi«ÄF¢–A€kÕïÂeöûĞpö”î<­Ú[M3»½…—Ò² >Mé(í¢.ğyò<jïÈ'Ó‹tü®m‰¿Ğ^é\µH³3!×bpyuùì>Çx0†	B}îgRS>•¯ì+ğ÷½ŠˆŒZ yûâGµ'š§ÛÑo¼RØ¾éZDÖBfƒÀS02ÿ-¦¥šgó9l×¥8¸iÿ\FPkÇÅL¥¢SïˆN Ü95–„DYªÒıùÃ‹ì‡*eB©
«T’­Ò+µ?éT€Bú”FäGª“ciSûO«¦SîÈe˜õ¨ª–\.K…ÛÈUÀe_¡”±ß/§ÅkjğŸ¬¯7³Pº¬‚Rşä3d1Ë^Ğª±6m­ùğXæ’y{0…F¯ÍY+¼¤¤£•/!÷ ‚ÎV.àg]:ŒZğ2o½AŞ»-¿yƒÜÍ´¾Î^İÇ)^¬„<ĞZ:)ø[rxá™Â‹á‰ÈËô[ Âdaã:\[8V8r\vû´nuã;Qw“÷zµ§–Ëó±âìz]¨Ñ¸+$í-F%ÚœÅ¯âLd²¸;F8«kĞ1ank½+0{ÆƒVœ4³€¼ğÕ7R«ÀûrYúO'òC™µI	Õsçñ‚`šUémé¬ÃVø}„šÎø´4 ÉşÂ}¬ıİ284¥¿Ûö(äƒŸ}xêxS«êz—dQƒ²S÷C•aj†Ş†Zúg@òš¶aËÆMF±oe2n(·-X?&æfwÃ©U')õºÓ]‰óâ‹Ëó±lhv8€Aœ@?€ë¯=„› Û\#ÛSïP?A`é¡Ø988àñâ_û ­ÕU”+’tv.7Ó’”ŒVé*b+e›[n;f¦™"ûİÍi~´Hï¦2qJœƒ?KÄ¡¼Ù;#g}FÎu•ÍT’µÑõ›òPéŒÆçòÏM~qCƒ¥«Ã.îqZ¡½‹“uÑ^˜•lA^†Y zªUñjÓeF½OÀ]=Efe}Gğ	Ò«ïõ÷¿âÚ®kYÛÁÒ›åN\^Ü€}ešò,ûÓ·Å¨CùSËló×¿@tåWk»¢¢ºÖ+gNµlè©„õıŞÔápuçOáC1ÜŸ8„P­ZÃ–=€2«µ–éØ÷å¾9&¥³‹a¾ÍêK ¼›üª‘{j·nææ@/å§ì2¢½Ç¡ö™Ü «ôl°({;´¸7Õ`ÅËü/B€;WN!Zº¥¦=Ë|RŒ)İ!o7v\­@.©´(Äƒegì Œ›‘k9tõ›÷L`ŠJ†Ù’¡6iNÑeH—Ò‚Òø¢ /ºÊ0¼ïè‚€Ì† ñ3KÙšwwŸ3m~6ò»¿.¿Ì…»»Ş›T’[k¸¸¤4ÿùŞŠjlQ«p¦µ-üiÓÔây˜éJ<ˆõËä¾¯QÃ„GÎÌ•Ô}Ü2BKÚÄb´EšB ŸgH"z>`	eHkÒUz+ëF|WYUuùÒòCÃZa}UõV¡™ŠtlğâfEŸ‹Ú[Sƒ’ğ&Hu¤ì¡V£Œ
S‡hˆ†CìªNÖ°ƒÌÏÁ³¯™#m¼^è|.xU„—âÖLŠ Pê§Ch¶YÍtò,×µ;Ö9qERf˜‘u£Ÿ5sœ£ L·‰ÙÚÀ¡AV$G¶Ş9÷®ªò?TÒÍ!ıpÑ.Há\±×iÉR3ìÏÖ6ğK¢·Ú­3×ªÃ´„•	·ne·n¥üÿµÜĞ—¨Y¢OèÌ»øJN÷d­ù}i¼¡û(×¾-‹9Ÿ¹ŞËl¯ù¢Ø­Vm€ÚÚÄ#É¾T¾Š=\ÈÙá{6Æ´Á³;Ğym%9ù£Lï˜!7X]z¤ìöC¤¢!TZq7ßu¦aXWKË£À%S< J†Æú_ -~G¦¥{*’iANGXC¬J?9U†©á-,<Ä_1¼&z;Šj^ÕvÙ+B®›Ê„GdXÖ›I‰ãJ¼=Ïå=E¬g(vÎ‚¡'ˆúĞ5%^u"áÄ—deæ^tX,¢ÎöÅy8à+p8MÔ;jÉ,«M^É[º)‘Æc„1¥(rÜ	gn‰"0rabÑ3*ì4Mİ+9„–`…YÌZ•	2N=J#ˆÏµœ½í‡âİƒòíUõ™ú¢¸€¢¾7°é;î¸+nƒÌÊ6‘/şN9¦y¨%ğ‡Óòy˜Ş8¡XŸÀ¢ÚP÷ÃJßn:|%%ï.F˜²‹•¥§¿U0õL/\›;ÇÑ§qj¯~¾ô… Ê²Ò[J;­îE§u9ê’5JoWd÷<ƒz¹…Ö*JÇ°nâ.©]•Œ3¬0Ck0^·A5–7Åäwéh§ÆPuñZI^U{öD#øÜ”RPİ&%Üİy§±üªr0;Ğ™^XÖ>Õé@	¥·M®£ëÛSï	­P.]Vie ¶’½—TE¸g1Uö=«`ã×¼P3tšâÜ¦ï+æWïÑ³êi›{fôø¥H{±ÁŒJáñ»"]Dn?W±¦éz¼óUT÷ÔjÕËªªa¯ÜŞ¿Ú6Sßv$_<¶ÏVZ@â”iÛĞŸ1ñöµŞ¯†c~ü'øitˆ|4Ò¬˜H›áD¼OËWã}µ&?#kÎˆÒ‚3QÚ;£«ÎD\´ì¤{fmóŒÌ`:Cº½Ÿ%·~ægkçÉ™Ÿı›³gÖ>8Û=óÓód=úYw}ıÃ#,æ0A!†Tß*ô«'’êKCMEÒëƒ8Q¯GÓüı)¢8Ñß<#©Åiõş½¯ÇİÛıÛÃd¸ñë˜öÖúı_h´¾÷ÓŸÃ}Ÿ›kérkÓÖK´°‘Ñ“fæg§kUR®ë«š›5Ê>T÷5ªeÎÿpP ©byQúÃœ5=J7•Ù™@,p–>?§ÜZ"|9†É÷_>
<[åa<#ûğ¬}ûİ2D¶å~£l%[ó²Ug·İÚ‡ÀPpYjüŸWr=Ğ?ë¶™eü@ß“½À·¿6âü4^»Üˆ‰puÓƒ¿7{NİÍ‹€îº¯³‚/;T÷ÄxæÜ¿3Û´øìN…ĞÌiÌş÷-zK,+x°å:hÌ3ÉÚ9;Áå0 W°ßöÒ•2Àoİj¿kF$$îyÅœ¦]~ÕêL8OÒO—˜j°¿Ûh¢Úñ›&l7e¢•ÙO*2Ö&Iñõ–H•J†lÎ”¡ï¿İæùû¢ O¨ßïê#PCõ©¡K­ßMâôöû?g®Ÿ¥Å¿ÿğƒ³ç~úSoØŸ©C§¡ÿÓĞÿièÉièÿ4ôú?ıŸ†şOCÿPŸ†şOCÿ§¡ÿÓĞÿièÿ4ôú?ıŸ†şOCÿ§¡ÿÓĞÿ$ôïqW‹¢úRP“£[Î7×§´Ï»e¼—¬åÍHU¨¿ÿ~ÅtíöúFJSÒ»½±±şëá`£%}BÉÚzôóhTl°>"nùüiÔÿ4ê_ÏúC‰úŸ;úŸFıO£ş§QÿÓ¨ÿiÔÊ¨ÿ*Éùòú
ÉîÄ]rea¾}¡}ıÊ¥ù•K­kË«—.´nu’µ
ÚÚ¤£¬•Ä]’æ¤U°ŸµÖiÆÿ¬p¾Û¥£´hÑÌ8×|´¦rZQŞŠ†esµ„´Ş)6óÈÙæ´¼6mÅ=’ñúf‹}ıg±)V§ıV±ç-õ±ÄV”öÊu	»§ë4”ÍÑçZ­ÕâØşd[`ÿ¹©¨4ÊI‹®Tİè Nû+”¦¢›ºÆSÎœÇò¿UB¥œ­İ(í‰ğ¿@ƒ(íÕFĞwûæçæ4HhF8$	CÅMä¸¼¿­©{¹m'/„ŒÍ¢´gõ©è°¦~„–U­÷)öePÏbxÈÂ$İ`°-½›Ãœ$ÉBT>ÍbÂOª}¡İ‘ínâ|˜Dlvä{
¡j`¬qY_5Ô¢r^8^Ñ ?Ïñk»y¥w+$!İ‚ô*‘·—Ì®öìˆ àcÕ2yÑÃk¯†c÷~EBà;dÅ*Ïò.5‰á:Ïï™Ó‰÷}3tÚÈùPªÃˆÒñÑëü¬éåÆˆ¼™“l1.ñ¢¢ls¤¾Š¦·'3°µw¶Aæ_§^²‡+ƒâÄ}Ô]y®õ#¸{N9¿Î	^£°»êÛCm–b.*£B¶‹‰
rIªvÃ8ŞÕçÀ¶‚EŞAÏûÿ@·d û€P•Uù%R°Ğ
®gt0áş…×L$šè0öôi
Êİ ›©{]2ã£Ÿû—ì¤š#ÙNøÁ¸b¼-ÉRè9 u·{“×É6|±×i3ÔUAgÌÂÇW²‹EÃ+~ù+O¹ñäzæ“ĞÑ»‘kÆêXûõ¸×ôÓÁ„——(Äş†©xô#uª*«Q;¶!SA7Ô1¸¨DÑ<üÕ±L•ÆOØ Ô÷YD-›à;óx¨_xæª¯œ¤ÿ$ÂGUëÕí¾&tÛñíâ;ä²h¦VÕHÍ­f ´¦Õ(½Ë[®XôO¿˜lƒPåQÕWF™’"U¼4@'*?Füv^£ü‹&­Â©ñcFsz=¡P-°ÎÖ²Ÿœ;ö~¦*¥á "­Vb—Š^AA[ûÏ¥²4Ê¬V7ÆºêË+cÍúƒîYùÿû¶œtNôßÈ†e9:aÊÄå>;2Ö;ç¤òjèoBY<ğEÚ›Ê®zfÕ¾;R*øé5õ\›.7Sö7– x	´&î’K“ËDç}›¬ó)é"u¨C<¬o›Êlı¼^fÿÈ†¦ùIû“¸ØxË]+§‡ç;¼Ë4[HËi²ÉÎ1?‰;eÊ­Dvôg£ˆú[³€I‹_ŒH®DÓCğækvRšş°†Õ¨Lmuv«Ì1ii&SÒÈuŞˆXÜ-ókKq„M*Æ²h§&|Ã°^xwÙ¥UX¬úDÜö·/-†2©öó =Î7!ÈëK·ê(?š³ç¯_¤ÕÊC¹\%Tk®UèÄ÷örºNG¯‡@ b+Ô2ÉÁ9ŸËÂèïÃÍ6çD_‹±£®â+°½'ò¼T2Ïs<Î~ÿZU¤7M9ÒÒİvü¬ÙñÁ¹|?rNÿSçF<ËñïâÃ }vîWëÃ|e”İ!› 	t œøüŒ)fr’Æ˜ÍOÈO¬fgZ±¹æ§Ûì@Œ_Õ].”¯”Q-¡¿<¥Ë•¨ :ÃÎRùôÿ‘z–òùôßŞT©zÂ×¡fH‹7ê,”éê¥™ÊL­ÛÎ–ıÉèfù* nr"Èå}T&İ/Òn~‘‘dşWXæğÉ}ÃïH]CÍzô®r¥M^†¡9âµ(¯ˆ¯•xİ¦	×)	ky×w­ôº¯Œ†ÃŒä¹8ÛÚİ	ßì&€rƒJGk8ıú'Îwê´ÂŒ£“\@œL¥t	õ)*¢Ô e©„sÉ*½VpÌê(K—Šeeüì:Ì: »çƒ8Ï«}_^v¶6É…Œ/¥½åõÔè¿´ŞR
AşºÅ0”mÕVi*=–Öø•ãé´–-îwİUŸHÚ¼”Æ5„B9¾-#Nâ~© ŠĞ$ Qªc‰ØÕÜ~_˜5Üz¨K •IÈWBJØ‰?Ñ¾lög$IN·o˜mp¡´É·\ù©ÕE~XŸê¨’ô¡W®‰$®‰dWx† XªC‹‡˜(FĞıXJ¯öë]¡ı>s`»»ıÖ-lšEŠQ}˜ûq®·-™$ë½q¿Œ
p¬ıLÁvĞj¯—ˆjÔÑ¿ò‚[45Îl»à8V‡j·^õZ`q*r-ÖJáëø½ˆß/
oƒí·$ç­:b8ñJ5w-oäÌ §v°­ÒŞ —û*±ícjVˆTnñÖe¦ƒ±ò‡ÿgiÕ Ê²¸UEì}f÷¼fåT…ùô›QÜï'$¯rR´ì‹æùªÂ!1İÖ5Ü§*“ÔaIÍÈrb³¶Î¨Œ·×c-5Àä¨e=†·Ä¼8¦±?Ç´u••j§?NI‚¡¢§Kß¦($ø€}™*‹p;GM’wå­àè²GWmyQ(š×r¡˜¦Á!#¼9Î»B¸:Mó?&É08¸]e‰ tlÀ/•şh¶dÂŒ`G±×‘jãkF>íÀFCùË43;§çu†…|.¿
U~~ëLÉ0¦rı2(Ö{qÎòsx¤|9]İˆsæÉU%‚Ûğ>Ûõx.AKçN:¶ÇñÂ¯İR¾¼¾“iÌí" ­Pi¡µ[CšàœucIÚ¿H³¢ù–½ÖHÃeˆdN´€À”.*™ëU¨WµÏ*¼›ö¶Y &)FYºœ‚ÜÊ¦u'&wEá°¬Ü„+2èH:=`ràò¨ĞÒç O$6Õş6L´u_j[^àÈ°0ı¨y:ü{Ï%]ì’òë&!ı¦¥¿Âï±ÂÖÎwÚSª4=&JÜ.e§Öá»²{óÍ”¦›ƒ¼:‡¹Ú·ÿ5|+œ&H5\’Ì•Ş
8D&j»*…L€(ï-ªMÂ¨Äı¬[cÈõ58ø;óIñŞ"½›¶æ³ŒŞ}×Cò«Q÷”ê3¤ú_~ÿ»Ö{­¿üşßÙÿ?úWEv*†˜½>šÛÃ"<áo¸ >±6cÂÀÃ]ğL ‰‚¼ĞìÎF`ªäa××Mz®¬z×¯‘(³X‰kØm¢:ÙRb©[ÒËaD¸ª&ı†ÂƒN{•¥æºRdà>ükĞ=–›€{!O­éæ1\dP¼ÎÉ°XÍ,ôD‡ïÖ! ß$åx…ãıìZ½À¨œÇ•CA/ğ­J¤Ø‚×ªšxDF¨XíÍaê
PEn*ôVFëëñ=?´†ˆA0|ØËùÍˆ¤İMf^2ÏæJœöG‰.e¶úõõd”EX“C–ÿ‘CŸ(ŸªvC_Ê2š­QAôØ´Ôˆ©*ÿµ.oú3’ô¤úfLÅ'[–õšaÅ½<ıx@3:ìÑ»éU’¤<z¦=hâ9È:×„¿œDÌµ-ñ]ôn]Ûx¾rÛ:VZc»Ó¾A†I¤½çxFåÓxÁäm¾-$¡ÛöBñoFäRRN§¸öÁƒ}hj„Ü ·'½GÀC 7b(ÅÜ	ÚlR§[ØQ„ºÓº”$sdYUh0Œ•¤E²>„+Õ5}\"ì™š%“æÃ(u¬ªu½şà:í¥4‰S²2ê÷yb5xO×ã„åºÅÅ&òø}éóßu9¨“ı?°ÒĞ¡=És¡``ş†Có‹/S9î$K£Äü¥	ßî´ó.ZK1ö¤à•W·İi'”s<ÆJ‡œÏ_"O,^gA‡q×øåjù7¶2: ÅFœö?!iñIF™¿N.ğÜVUÍ^J%P% »À¦Ê6çûQœ"ît§8xÓâº	‰²eİ=ÌCéÔª¿.ë}	m†g 21SaÑÍÜù½;Ïa…À«X‰´3€\8~5tWÓ‚nc®gÿ(££á5
ÖÁ¸ªõã¯ôCÌIky–ÌÉ8Åo|”óİ.Éó˜ã,C 5Mà'F”ğĞ`:†AL3ıÛG2‚¤ÄÇ>üb^õM8våÅUÚ‹×cÒ[DªÀ<§§PH…_x…f¶ÅåÌ“Y$-HÚ-}Öòub7şIóÃr`w¥w#JSbˆŠUrå¯Ü3ìKş+kº‡%a4:,ºé$8¦`+g.‚ª²™Xüò:<Ú¡¥a¶ƒŠz«›CRƒ`-{w‚®av”ááşİ€ÖH–/¯/ğåã…[2Sˆ`“×ÌQæ“äJœ—Zb¸sb¸gJAhl
V&¹JéÕ(åUv«”Í8£ù8®a/‹Ö6ÏÆ	U‰"âŸr©HJsÈo‰ùó•ÑZ!F˜_r´cIvRLB-Õå®Ö ºÚ.óv#+omÔİ¸¸éİŒ¹®i(İğÑlËãbOÜbF	ÌŒÒ¥y5 ¥ˆÖvÒÌÀ×Vi/Ú„i:hÛî´Srw5êƒ‡DŸŠQ¯Ç²ºmA!¤Ù¡²ş†4µ4š]ÙÕon›SM³øFl©Y!¦µP”ù^ã¼Kïl“!uĞË”$S{òáoº5KSWW€ÙGÇã?6ä¶0îwÅJôRšÆ¾¦úì}a­y²¤¼f¯ĞÅM)õ÷,2MäÍ,-@v|‰ñXR:BŠšéª7ÍÓN³z¢´ZUiƒqB½%úYX!ÿ³êùÔÔıB…¹ØQõÉu’å4’¥t"°R•c¥U}Ü%)È¬sqò;8<‡4S÷Ä73F/ÙØ!â!0ƒx˜Qfñh\d’^³-'ô·ÀØP5À5šÒJ•„øŒÌe ™É¾PzƒÓîmÕÑx¼e¥(“ÜPÆó°ÎvŒX
z÷£ˆ³( Ø6ªã7 #]šõ C6ØšƒI²­acØy‰´^yd1pŞ;?l:Ğ;­()Zïµ˜!êº¯|·ì wMŸB»Óft=¡w­mZt­‘ëÃáa”öX+¶ùsnW\Œ²ëÌÃ´A“É5ÁMŸ"ÊŠÕÍ!S)ÿ	üRÇåÚ²äC¨Î.¥Ü´Éep[§±ùÌ¿Rv¹–ßºÅ”Ê[·Ú@h¯TËHƒ­Fk\ıI|æ¿|ú¿f>3‰‹’-gJa¶"EÜ$*²ÍÅx}d%*±:·CƒG²CG½æºéfôNÜ›„˜ÉYIàÅ¸—WhÔú&ÇhPNŠœÛ¥²šmŞ ëÉ7¦ñ«ÌY9‚XytÖ¯8SË?Í•›Ö«qÀüw—ã„¬Æ½µ¸ ;ÖXˆ)&Ë)3½{p£ä¡‘$èTZöÔóÖî´7éåuo×İåŞŞ¤£å!IY:ÏÙ­÷ÜS,d$*ĞÆóğ\o£°toÔ r Jf8!¢[Ã7§GÕ„."±™TòoÌG=“‰À¨B[üRëÌ’ÜwÉe:J{,Ïër¬ì+Èã6Ğ{vœ–E¨1šâ	û Ó^v¸_¿åÅ5z×WR$•‰=iømæó}ª¤´L²ÙŸ¤_»||iJ£M>Œ’Ğr¬zClĞQ†2–È%NˆÃ—Õ+ú˜2¹¤§ò•:Rú¼~G¦š‰)—q:*ˆI½Wò5|fÅşÂ4xĞiÏ÷z«T§€C5>©¬Ëq„´­°êf¥Ÿ]ÇXz)f.&¥6›ßV™&:EÃÎ9{Â×7ÏFƒŒ„~\öh<ş7È€Ş!lL#b(Lh;õaëÖŠ"1>LcÚ	;6Ù¯ÓáÍáU’çÌL¢8…{®—‰*ÍÀ4Ææ§¬ÈsÏÜq¼q.–yĞióüĞ¥´w#–µ¯9œ‰È½F—ò|sÔİFG‰ bÜ
5ÕŸßmWzÓ¸™´Qk_İˆÓÛ1Œù×^{áa7î:ûıÍwYruõî8‹ÕŠ49;€ÚŒ¶ŞÌVd×˜µNÇû`QV»Ó%‹ÀË¬MR²JS‚‘htœ•› {\Â˜ã.ñLzä§7VÆï¸3<ñø:íOâ^ŸùÍ â  úXW ¥®†ÌtZ ÃMC>—÷ğ‘2Íõ·˜[ÜÄ7Æ_¯#åX|×˜ö¡*"YHh®èÿ™ZÄUå	²³5à¡^ç-Ä˜cÎñ2šÉX
ïÿu3'ø7Œ:o{Wd¶#c;Ùˆ²¨[l9Iv%Ä(g6]Wtzêå±Cåğ?›½í‚{iÃ¢d ‡f~=ÊA`M‡¿÷áÈL”|1¶j´ x7§@Y„ûÊFß+IšÄÃ5e½ë$c…Ñ1ME†|}9]ßB½NhP•Ö³[ÍÖGI™¥f¸xıe¼êô	orÃÄÓ÷ŞèçkÂj†¼	† U^²öu:„!*Şî‡Á’tÉ’\Q2•s]+#á<œî7×¼Z€‚AÆÂ>ïmáfb„«Â2»…:0ÖÏm5k‡mô¢º=šQ‘¯R1Ë£Uçg‘5ƒ}nîä]¯Å9CH"FF8îàë>Çæz§ó]…KúÊ}u.p1Se¡l’ÙÂf³Fä¬‰S?yÜú™r+<“àR•¯„i†QÄk¯ÕGvû<kŞ8Ÿ$æPKËª(,g/7˜S8âÕ
 7ãîD¹S¨}:]¿	*'3²>·@‰HS;	 º~!ß(nVQ ­æÕ5àuÅ}±ì=Ÿ_R’hQ^ë@$8´hï¸‰ôÏ”±·;mÙkÂÙœ[zTuı«Šöİeæ~Jìß!%°´ÔïOƒìüs¡Ã÷ 2ôëÚ`å±¨y±¾rm"uÖà·Y=bhmPgäËAëëëH3¿çäÂ®ÍyI-Y?a)îi>’Í"îæ@ÂÖWŞƒ0›œ½Àš§Ò"¹™€  SZ6GÈ|Ş:–WvVËÉÅ‰Ú"R:ëìÄ6«X)ây[Ò˜H§p0æWtŒc—Õq¡õ¸³>B•ÊŒ¦Ø‘Èefj­ItÛEfK~É¦xJn£ ú0VYÂk‚
¶÷¤Zt*>f´›sŞ¤³6ñ‰¨8`“–Î–²\o)]!]šör%ód{x~ûKqëúÙUîÀwxïçœ|åÏ¶L……ã(Ò£˜¼Ä0B²x9L†˜›Áe(Ç„¡dŒ•¿É¢â¡ºqCç|öå¼cİk?¯[ŠåÑ³Õ@‚ßñ¶{s†!‚·¡Ù
µ/¾	“ú­Ş¸‘pı/€£	7œcÇù­Ônh0ÁĞY5âöÜäbŸ’ŠÒ¯â}£Ğ‹k{×h¡Ê%j<bpA*eÜ”îgåa…à¡¼Ã°¿†®„·{:NU™)–T¬ÏÀwr×¸?€N@ÿÖ”º*1Ï¹˜—U3eŒ¼´]ï›Zˆ²^uÚ´é¤«›¡ÍĞ¯`¼tO`èÔĞwÛÖ2Õš–“Ô™ã©'ƒñµï +#fægûÅQ.×„Êõâº™òØçRæş£YdEòüzA²¥4'ô¼T0ızèíºs kyO\‘UZúU1:±EEŸÁÇó|MÑâ:¾İÖ8UÑ•:†9€»¶/n^g`I¡†`ñØf%âĞ‘òÛWŠC«î(À‹l/]~j‚Yü¦öô‹QÄ–²dMv3;Ğ|ŠÃøêÕå`<³îiyvŒø
IûK»ûàìÙJŒ_7„¨Ä¤m9cCÕYäèªkG›»A"Qd‡. Vf`†xãğ›…C•'ûÔ)vpm…¹py2yW[ ;ğ1ËÇ–ÕŞ‰U¢³ÿÎ—åW¡ô·jyNP°îè£¯Ç³Öw0\ wÓãŒY£Üjh°…-óÓ,¿™–W¤`ŠÒÛ‹´;bNCùÄhMz"*ÆTçtìh Ä­Î"5ÏLuüãÿÅ¯(e6Qs¸¼:P—#j­	G©ºÁÇîäßyH±©õ±3ååĞGbç9zWY HüwDÜøÊÓ¾å¾m]£é¥Á°ØôsÚ!Æ‚‚ŞN/³™bÒ¨ØÒõ&Şíğ%øCwl?‘BàØà¼C/„Í\=<H®÷±lØ,N’¥”¹ët9%Ëë¬vaƒÆ]‘`W¨Ïú‚ ÷Ï>èX ¼Va‘¬G£¤Xµ/¾‘|q)¸P·2Lâ‚%GvÉsÍ*wÁb­’›_2r°)Á
ĞÌ¢”s3•3˜Ùk3™2šœY.# gV6âõâÌUwïúŠò£2Cğ+rLY«$á@ÌøiWrR+[gÄ‰âqjı–Û~y,}ğ;.P×*oÍÎ†ÄB£êĞM½ Ùc\Aâ±ÌŞC}¬3=beƒŞ½to˜Di¤Œ9#Û]É¶ÓÒn"V|÷Èì¦Ú‚äİİ¤©~¯(K }7ë‚`ˆÕÂs»·QõvP¶š-Y]ío\Í1+ÎqOs.TwÙDEPÈÀ«Ş:ÀróÑ«£2BPæK9 JR8YCs°ë[~õağÎwÿœ’ÊMéœMAGÅ4“–9äNLGy)-8lÁHKFxà¥†lªOdN¬O´°rÕkä^á˜ã¡áº›~qìı‚æÌõCî{½\„$[Ùà1Ìhæ’K*¦¿A†e½ª5hîx=„º1ªQ¨M‘—àIE@­"¿+ÓÕk«³d’í3•®UNŠæ`¦å|BGÀ}
T>6”W.x†;@ì<v€«ñ[Ú'óIİä!lõéˆùQAh–‘.¨èŸ<ÑI¼Øœòyrº6oKı-!™9û(S„›e¦‡i-ı”fd9í\póˆQlü%æ¬WjŒú´®èÆ"8â Y½c8gu‹³ĞÈ[Ä"¸YÜéÿ¬t<8"–íNû¢«V˜¿¢¢ZéH?¯!¡ÁKÒìí`IC­Ô9UoE*£ÿ;ã¨¶ªÚ6ês	$?YŒ£„ö6(ÍAÎ](_ªªmğÂ¸RQNĞ'ùƒìº]E·À9It›Ã@¼¥0v¿Ï~¿U}Ñ¾Ÿ¡¼…r–÷ñgĞ|ÜUúôWğ¿ö€7›:Ú€ÍÙD[ ézÌrB˜NZ¢$î–?Ñ¿ÕWYSR3À¦¤{{Şb8?Tˆk-§¿6 Òëõñ…KŞ¡–[Æ¤›s%ÌË`¼Aî2ÿ×›%‰÷¹v°¿­$ÂÒÛ”5/ÆMÀ«ÙÜÕx-à_VPÍ2£Ÿ7Û8JØ=Á©¾Eâ;Á*ia¾p}t¨ıÖ%MÃ6?À÷1@MV$u‘Ş3³-(Ğ;½Ñ*h7§Â•& Î[ôµŸ{AIU<ACšN$g“MÔIGÁÀU5ÁäF*vtTK|‹úÓ¢Yğ5ŠP9^"àèOõ§¹yã
 ¡òO:’¹¹"?Ëå/}ó4R¬j°2ZvÏ¨%¼-ªwCİ«øÅÒèC¥wÅvÙ³Âú,îÇi”H¸`”I]¡Ã(üÅ’f.•ô5‰{„ı,ÏŠõ‡X%Èñìm¤Œİù<!V¦Ó:Ú‹Ù³8ã¡¹`±ì^`ÈeW†ú‡i`pÜ‚¾$»c€õu’æ!´.®ë|ãg~*M¨r9ê£(I6—Ò.÷~ÕXŠá1Aä2a/ë.„ÅÇF’	!sqW!Œ-ÇN°v‡ÿ4E\%;PëZ~Iõµ÷ÂKz‘0UMJò_lwÒuµNÓ¸"‚É‹»(# ÊWóêÎÚŸ‰úÖIïnZƒ¯:qÆ0·ÜX]9PgqÂmVm£G´îèuíŞñLº»f·š0Xøñœê5qC7È4^cÌÜyÆVØ8Ğ	Tú¿l—…9§×v€YÑJ¯efK’¤ÇÕárnäİyMGpêd™µ“EçØmóÌŞ¸¡áÔĞ§òW°íÚ.”wØàÔ-rê9u‹¸ùòÍ¹Eşº®Æp'õC<”õâFó©ãA/÷¯İñP– ¨#.«şÊª/óôz³Íªï}ÏYõwYõçßÚ´zŞ´@—Û7¾2Gl¦;Éë¸6ˆá×ÜwM	ø,…ø‹lPv«ÁW½©Xf7B;Ñ¾~ÿÃªdû7ÛiñY.á)wYUs>Ó^iùhMO°]…2ñş¤nF®Wdö\´E	£Ù«q¹,¸4­¿ª#´‘jgPØ ¿8ôIJ²(°#ÄÑ{ÜwŞbœ5¦åÒ¼™„:ùQw¬{–lƒ­2e#Z£#€S0èŒÓNÙà'r®¸XIRr	Í³7÷•Óç!ë¸6Q8.{¶	ìâÀfá¿FÊB}‰•º)ös~Êı|.ámµîlnqWw
±ë3pÕ çËo]óŸÂŠhöü`“ªÍ}0åæøJe©«&5„Ò¬±ê?~şóC€Ê	ûG•+şé”+-ÉĞ}p¤È«úï»„Ú‘şIvŞêµ~8åZ¹Ó'ĞçÕ:%M—†*Ÿˆ™ñŒî.’RÄCïS$z0WÙ[+ŞA‚×+›•w³+4W#/ˆãB3ÜL§|Ï*³À4)ÛíõâÑ ”Q@nP6"°á6h¦:Fh)¢>OJ \ÿŠº£š¯Ö…–Ğ‚ÂúOŸ:ÒÕ[Æ—d¿Åº.jóp‡7ú\ÌÅ/Ãå®¢c³R‡_\³( äè¯’„AÌ®´ïnİJ[­¿|úÿzıê\·Y]ápà9ŠÑ±Ç¬Â@ùU-ŠÌ¡µB=[†Ål´­3Â
4®}¡í…ÓË¢Xt	bÃ``°ù%^KD8±„¨Õšb[	&NAå²ÄIº } –¿T2È.:"Õ‹¦NğN# !¤ŸŠµÌœ¤5ŠbT—[ÃKcƒB"µÌ	Õê»f:£w²®áÆQ&fFÄõ& …DqT–ù@xƒ`’9ÉîÄ]R¢<i®6b4Æ]32Ÿ¤n¢OÇ¬ÆqÁ©o„»@	’~‡‚™®¨ßêñKGÅpT»µaìVA$şï	bÃ	,$Eøcü3ã§…š€ŸÈöÄaåa³›±ê»íF1ùÖ7¹ójº“²².rx3¼8mÜ«_pˆf T<—\]¶¬òQ¤ºÔo3˜A ©ívc€™¤z8ASo•.äm”0ğcĞX_s ÍØOI–"æE1ödB’è"$:,âAœqWnHù+Qà€9ª[îFw#Øşû;àyÌ†jcÅF”Ş^)
ê 	ïö¹NøÆÕ¨Ê™áÀºT’GSVÉ´¦z¡Åİ¡ÃMJ¼1"³ì Ó S'qò²ïòò4û}W4®ç“§ú_ÙƒŞLüäôîÇ$êôjl«¥î:«Ÿ¸Cy›Šˆ†G.R\L†QÆšZéj9±š(›¢5/´^w¤^ÂU!ÍŠåòi”Îj3l $M¤Ca©05©Czë=.,a=Ò	â
]ÖØ
­Iw·Ğ^”ğD5"z˜†—(ˆ„ÌµZÉáÚX·™¡?S(¡¨Y”ÒD…aZü ÀWÆ İ-O×öOÔM4ĞW”×YôTånÂ¶Ê xCjHãº$¾Ê¥|/½¾–ªW€rZ%¬N™)#f´io£€}SÕí¹
]HN“¹§PÖãÇ:¢Z\sîìÙ3ö-ñ‚uÚ¦ü	(­ıdIMş
£äÖBÑ“ìÙyíüÉ&Jû£¨oÚ…şöwõçh«ø®a-¡ñˆª‡9¢êa«fdÈ<g(c™7êÅ e³ÇÀ!£\E¬UXtÇ<9³ÓG¹šBÀtLİ…NÄupÕ·Jbê‘1‚zÃ?Jm¾”Ù&C/[_©?;0ĞOšZ¶DFë Ü­ªê5¥2ú”8°ko¤¥ñ&i˜AôÖ.ÇY^Ü‰…ÃWÑÎÓüÚk³ˆdEw‹ÔZifzµ#m´UU»\:xÜº•N¾€‰¬“'êM¨^õR¤»÷ÒOĞj®DÉ<™ GÜ|¬RşoÇE‘@ Î¢Nƒ /ü³ÉÓ Ÿqâ°|´V¨ÌH…€§ZB”%Uˆ÷”’R¸z˜JÆkŞÊÍØN$‚¸Í·UuwÇÀØÀ.`p”çÌÁşÁñFâO¨5ïëÊKaÄ@ó¹0|^½Wa­éˆd¥%fõÂ’_ÒJ@+JŠ÷bİ^>„c*÷°ÂÂ†İÒbOŠ÷–´Q¯’‰jö Ëè¯ÚwëK¬yÜ»Üw6Ê×Öh±¬ÂM†f´eJÔ–9±9á1‘¿}hæéÕi¹*»TË¥ÉyãhOíüSË×ƒáñ~Lí“BÀïj;O=¡?û²µ°zãJë½Öü•ÕÖ{­¥4WvŠkÑ Ô«ûÍed}‹	ˆƒ¢sj½f€÷íÈ"ƒ6¡°—XÔ<ê’5Jo/¹şøxü;yÿu|ùK¹}<èK@Ôi@WY „•¬S£zğ_ÕQ£¼‡·8‰ÓÛ¤§Î¹ÅrÈk
Î[zğïÆEÙ0Æ±‚/°›ú[k`qíÌl ÇNûƒ(Nœ“x“v ?øK+]ìq¸’ÆImîè‚}¼½™¥e²GFò!˜^KÈ|¼çİ$Š½[Nİù?"w>ÓWéõòÕ3‘œ©?Q¯gönUé™®›"ÛœïGqêè¤ÜÄåeUæs5(ó››K;Û\jX7H>J
SoĞQG.şce†Ëk*•n×9J¯mB-TUˆ¯t~¯´ùCóƒ™Œõˆ<¢]:Ü4”ÂçÒégy'
•YDm«g}5ÇˆŠO¢Œø»?şXKÿêØ/Ì.Á ‹"ø+¡†o¶T%–³+å¼”âE‹Äìiı™/\¼×3[­Éûl¶f-’™p„ÿ¹Ÿé‚óÑZ^°*Â·Ÿ‹ûñ±5îõÉ’Jyìö#!z¢ÖÁ˜¢6#ü-°8„
Ä«÷˜Ò‰İYÌù
œ1‚·˜JëÈ×Õ-§éà¦ggªXB¹QºŠkuMÇ`d]’´aÈL¿¯S4°Ì	¹J3ÂD°÷Ar‚ŸY{6k¨’5;Á‹É_Aê"i’¢Y#é°Äà5¼íaF
Ş»“ªc—êx£»£¿VÏ8z•Ê¹bDiMàD|ä™s«À^£§â;S]å’ô°#X¤b™Ú¨72æ´®;«¤Vì%úŞrWUšDˆõ‚ì¬X
”ºr¾F4ŒWSğ×Ş—
C¡n .8°§«”ç'œiF{:¤€¨Dîç|^w4Ì5 
¦ƒºÁ_Ã¼Ùòä^}£c”R4UºTY@b/ÿ|³å»Moìh™à6lå7tL_|ã¶aµlõãz/ºƒ>4 Ï1Hì±}pnG“Ñ|Ñ
SÀåW$µÜ>ÄH;¦§ÅµÓŸ˜œÛ×ôµhÅÆÕÕN[5ÄşgW‚¿/ZÄÓ$¯pÁ«:×çĞkÒıgo@€LÉOoä†ıMíıcÅQ` Âû@ã:Ô
Áø·¯ÌrØ†I·¹ç5Òúï@ZJSfr4ñª¾Ëu›Z6¾×çÎÔtí*~(µN(}U}ËÁ Z36’"!µ¡º,ó"§¸_cX7v¤M×‹C\şN²5TWêXˆ	ß¡$äg*w	ıW*g?Üô{j8/Ãúr©9uU}ÅÌ'Oc‚Ê‹RùİDŸ¨+õK<êR´¡
à–·ö‰T­_Â’Ø›vmÙ¹ [ Õ¸7LÖSÙT3a5S‹Pá,”ë=+VsäÌî8\‡¦?ØoŒ.âj.uê$^¨Ï‰ä ‡Öor¿w¹q…#”ï05«‘âxîoı%×âÑï|Ìd|äÈÂ	)ãÙŸ l.ŸÒã­ó–ı]u\ØÈÄ3K¼q´ŸoZ<v*”Wê„„Æ¸ĞÀX™]%|| ¢ñ4·å¯ ·;v»ÿşü<ø¯ï>xğ/ïş·ÿº`Ÿ?Ç                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     ‹      í[[ÛÖ~ï¯ Ø‡Ø¨–[qâÊŞš-
ˆ µıbÄu´bM‘yäõV°—:¶÷!‚¶nûP oZíÊ’÷"ı…9ÿ¨˜9‡)Q;kÃvú²ĞRç2gÎ7ßgFf#âF$B×æås¢êFÖ/Õ™sw­ÚğïÚµHpV‹ì3GØ¼d;Ë}±²øĞo¿½}ç¼UoDÕs·o_¼ø»KŸ^ºSh^¼øñ'Ÿ\*ãV°Ï¯¬6m+<ÇÎl«|še^aOÏ_Y­ó—À„!Vš>«ñ¨Î^4ï¹e¬±ºh„Ü,xÃ<^4KëK¥u³ BæGnàGÅ&k”İxè×lßp…gĞ†!ôå6t §Ğ5àÚ´å.BpÇĞ‡¡Yp˜ïp¯hÂ?äAzø,YñkÖˆø ğ„[/šğœ–èA;d×Ù:·CîaÙ.5„|[LclVä„œûQ•…ÜVr$+ğûBËt"Ÿ ğ³¦zAÄÇf>ƒ¶ÜÁmåÍŸµu•³2‹&ü=Ø‡®Ü‚®ÜA¥¡> ¡mÈmÂ ¡‹ÚÃ!3VUŸm•¸Kõ=ó‰Ü1 Grõ2kú›=Ú¿FBÌ=ZÔ(©Y×\'¢ "Œˆfƒnå11y0CnË=8”{r^ĞÅõI!¢Dpü§}k– ›‘à5Âé¼c¨Õå6Š†º…8Å=ĞÎØfÃõËÁFVÙÏå ºÏïÆfoğ’ÃjvÃ/sÁÁËvÄÀ/³p3„Ğ…Ó\mç¬ë\KĞI#êÚx:úâ%)i½"ÚNh0b·m@ß€Ğ´á¥9;¨å¸Ş'E‰ñï8óxòn’Ü{ÿtô]wáÄÛÙÍ£XŠ”XfAÙšø7¬ÅÚRº÷µİü‘›<*šğ”jõ â_÷ÿ$BÎjk¬ÆCö{Íë0Zîj´Ğy™‡LğòZ•åôPñª)”÷âµÚ‘Ì÷¡fÇÀáĞC‹yˆÚš¹÷UÿçÂõ×¿
×˜çıìİ‡$"Kİ§2¹ûÚ8ûò‰†Ğ>´ámDOçˆyohõüwßÃx“Dnõ<úÔ1tá £ÎÔ‡5°5ä‡„¹z@f¯VÀ¾|Œæ†¬3SÔ¯*Ïõ9qI‚`Z\ã÷=ÅrK©·@’ªc¤dzœsŒ™;Cî‡Wı›Ñ:c×ApD”À¡Ü’»p°JnÜZ»êÿ!dÔÿßP½Ü&óŒÑ%k8P;GµÖ49naü1Ïî:Ğ'îNÙ/»C†ëü¾ø‚,ıK4tíWM+2xMI”pç¡Üƒcx×Ïˆ%{NĞ?ˆ¡¦¥BŞ"àOP1e‰9wcj²Ë.ó‚u»”7‹&ü›¸µm ¢#DÖ}…Ø-¥_ù(6¯X¢jkŞ1?¹7™ûÿ9&s|‚"¹‡CúŸ§wPA—ëãº54D¼M¹jÂ¥3-4§æúÁ#í£”¨rÇ}8ˆÈPş™å áš‡1®”Á“™Ø©©—o!#5õ­…ù=—oŒ¾G?-4õ,ÎĞ›0€f¬Ş–••"§lçÑØµ¦gmğÒºgo°ĞWGûA®Š7Èı¦HN4wî†îvüÅ	>ô‘ä÷ˆY<`ÁĞ¾JÁm `=Áét¼¬äi?—´5¡m™…z8<ŠPït”XÛÏ)¬; wÒ¡İ¤Mê‡f!ä‘`¡ÈÜrÎÛCÄ=c©àZÇ˜A#Ä§fS}ºÎj¼Õ2´ı&şp`"¢9Û!³İJÈjÜöø:#w¬‰T> QG?N^iï@}$İSLDn¿ÉĞ2ĞÛËí1súúQ&÷hŒ ŸŒ<Í½¬²ŒY'¶*ó}¾ĞÉ	fd9ÌéËÁ†ï¬l—İˆ•<^>s(g¤O˜Î2à'åRÉ¸ÂÛ=ıEÃ»¬‰zèŞcÎ¦	&xû‚üE—0Ø¦ã§\=yƒaò>G„ÇÈ+èJÆ÷P¤òÑ;@*¯lLûøò»q÷×·Œ+Ì,\çbÅ´KóïšF$6=¾b:„E£Ù¤­–iTC^Y1›M­å›¡×j™«¯£à+Ëlõ£<%'È]@Ùo…Ç>|…µZÃwÅ¦í¹>[ïm¥wõæ¡W~%Ö IµJß#ı×"ë]ƒôä®ŠìÔûê_îâÛ2¾¢šPş$S‡€qØ»vı“ó¬iî­ù‹)7ÿÚİt§ı&¨ïÿ—°è%¼M:|/ïã—D†€à—Åˆ©ËMÍŸÍ½«×$ôF¹9ğËÀ¹î÷6ìü€.s‰¶çÖ\¡s£”xÌI’›K*'w1afN® “«¯¸P&eº„÷
GrN1ÙdŞê³×Ğ{Í¦4|Ë`e¿¶™WJqè”´.ÍÒf·µU–R¢?.°ê*g_åÂ‡:ŒEËNRÕëa3Ä¦ÍÖ™ëe‡§—LÍB£NtMË„¼©å"Égªòáô [©ÒkÖC^g!&E+ÌE We¡ËâzÈdÆx+Gj%¥ƒ}"C2¿b›MÊâàY5ËH?êjˆÙEÕëÆjbû4ú4Ír‹ˆŠÔNänÁ º®½ÇaÍd²ZM‹L© fKÙ‹(Q×h>¨3Åió·Š¬Xê3†±9õú¹%±i}kñMRÍBÙñJ¸^ús³îZ¤í)GÊâæT¹ÍÃ0ãÃ>›U<.y²‚‘O`_A&™W×KUTt’2ó8Sïë¨ö+WÀ¸®Då¯ÉïSŠTÿ•º4ıÎ>ñÖªõDEC·>¶€9ÕïÚÌqóÌp,¿×/Ù(àuNTğOz“JUvæNu_¨ìî¨,§o İÏD}±û9Ò:9ÊDİãä¢¢M 1o’qÀ¡›­Rü¡ëvøD‘t¦ñìJiÕ  ê%•);I/ÇïXWUú7W–K«Æ*NZÜpµ€Ú¦¶òÍ7­ék†œ	Lµ]Ê‰
VU ªöĞÑÓ-HJ©ıå_a OüÏêRVKF"ÓkÔ;|‰²Dªñ¡M´ê£ÑÑôCµWÙJ7qå’ÕÄgm¶3­U>˜>~„†§ºi)9äqÉò1½7<@ëÜ£v5å±‰³Ïî&šÔ÷Î'ZUæá¼òÖÈ©Ç>ãZz¿Ê'Ùv;Œ#ä…[
Ó9mq+? ›ŞZ¹RÍu™¡ÇhÍ¤Ş?~ØŸïU’ø&Oo*ÚJµÊÀI"ÓáBÂîqóU2§ìŒ¹Ñ¾9DÄ0”»Pk‡(êˆşN’î“ş8-cÒa°4ÅW%zJ k'³vZ©VfzWÔoÏÛt¤$KI|»]ØŸÀl¢IÁJ‰qi|LôùrY!fôYÆm³¨ˆ–˜àbèêği’ĞGN>ór™êÖiíqqsÏ–j¬EÒÑÍ\H6x™GÚ!M¸òy è7Z›­V«uçüå_-/ÿÚPm.×X½îúë7¿ùr¥*D=*./Ó,ú½‚T*®Ã-'¨-«ñ5V–«,ªòò‹".¢e:Ø’>Ô’ú©ÁıÒ`©|ñß–*•Ï>¾À/|VşÔúsdÕXıC”Y1                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            South","Ohafia"],
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
        btn.innerText = 'Ã—';
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
