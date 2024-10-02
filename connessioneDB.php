<?php
// Include il file di configurazione del database
require_once 'config.php';
try {
    // Connessione al database usando i parametri definiti nel file di configurazione(per sicurezza)
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    // Gestisci gli errori di connessione al database
    die("Errore di connessione al database: " . $e->getMessage());
}
?>
