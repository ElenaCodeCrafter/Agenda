<?php

// Connessione al database usando PDO
require "include/connessioneDB.php";
require "include/sessione.php";
// Funzione per il login
function login($username, $password, $pdo) {
    // Escapare i dati inseriti per prevenire SQL injection
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);

    // Cerca l'utente nel database
    $query = "SELECT * FROM users WHERE username=:username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);//torna campi di DB o null

    if ($user && password_verify($password, $user['password'])) {
        Session::start();
        Session::set('user_id',$user['id']);
        //$_SESSION['user_id'] = $user['id'];
        Session::set('username',$user['username']);
        //$_SESSION['username'] =  $user['username'];
        return true; //l'accesso concesso al utente
    }

    // Login fallito
    return false;
}

// Esempio di utilizzo della funzione di login
if ($_SERVER["REQUEST_METHOD"] == "POST") { //vado a cercare il metodo con cui sono stati passati i dati
    $username = $_POST['username'];//prendo username e password
    $password = $_POST['password'];

    if (login($username, $password, $pdo)) {
        // Redirect alla pagina principale
        header("Location: tasks.php");
        exit();
    } else {
        header("Location: index.php?login=ko");//altrimenti passo parametro "ko" e rinvio alla pagina di login
        
    }
}

// Chiudo la connessione al database
$pdo = null;

?>
