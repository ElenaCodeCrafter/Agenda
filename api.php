<?php

header('Content-Type: application/json');

// Include il file di connessione al database e la classe Task
require_once 'connessioneDB.php';  // Assicurati di modificare questo percorso con il tuo file di connessione al database
require_once 'task.php';  // Assicurati di modificare questo percorso con il tuo file della classe Task

// Verifica il metodo della richiesta
$method = $_SERVER['REQUEST_METHOD'];//GET/SET/ALTRO

// Inizializza l'oggetto Task
$task = new Task($pdo);

// Gestisci le richieste
switch ($method) {
    case 'GET':
        // Verifica se è presente il parametro di ricerca
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : null;
        if ($searchTerm !== null) {
            // Cerca un task per termine di ricerca
            $tasks = $task->searchTasks($searchTerm);
        } else {
            // Ottieni tutti i task
            $tasks = $task->getAllTasks();
        }
        echo json_encode($tasks);
        break;
    case 'POST':
        // Aggiungi un nuovo task
        // recupero nella variabile $data, dati decodificati della richiesta effettuata.
        $data = json_decode(file_get_contents('php://input'), true); //recuperiamo dati dal form e li trasformo in json
        $task->addTask($data['title'], $data['description'], $data['date'], $data['status']); //prendo i campi di json e li butto nel DB negli appositi campi
        echo json_encode(['message' => 'Task aggiunto con successo']);
        break;
   
    case 'DELETE':
        // Elimina un task
        parse_str(file_get_contents('php://input'), $data);//data prendo da tasks.php: contentType: 'application/x-www-form-urlencoded',
        //data: { id_task: taskId },
        $task->deleteTask($data['id_task']);
        echo json_encode(['message' => 'Task eliminato con successo']);
        break;
    default:
        // Metodo non supportato
        http_response_code(405);
        echo json_encode(['error' => 'Metodo non supportato']);
        break;
}

?>
