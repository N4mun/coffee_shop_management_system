<?php
session_start();

if(isset($_POST['item_index'])) {
    $item_index = $_POST['item_index'];
    
    // Remove the item from the session array
    unset($_SESSION['basket'][$item_index]);
    
    // Reorder the array keys to maintain continuity
    $_SESSION['basket'] = array_values($_SESSION['basket']);
}

// Redirect back to the main page or wherever necessary
header("Location: userhome.php");
exit();
?>
