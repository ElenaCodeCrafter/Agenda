<?php 
require "sessione.php";

Session::start();

// Verifica se la sessione esiste
if (Session::exists()) {
    // Se la sessione non esiste, reindirizza alla pagina di login
    Session::destroy();
   
}    
header("Location: ../index.php");

exit();
?>