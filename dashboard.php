<?php include('header.php');

// Redirect BEFORE any HTML output
if ($plan === 'freeversion') {
    header('Location: freeversion.php');
    exit; // Always exit after header redirect
}

elseif ($plan === 'plana') {
    header('Location: plana.php');
    exit; // Always exit after header redirect
}
echo $plan;
?>





