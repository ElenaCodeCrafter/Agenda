<?php

class Task{
    private $pdo;

    public function __construct($pdo)
    {
	   $this->pdo = $pdo;
    }

    public function addTask($title, $description,$data,$status){
        $stmt = $this->pdo->prepare("INSERT INTO tasks ( task_name, description, date, status) VALUES ( :title, :description,:data, :status )");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':status', $status);        
        $stmt->execute();
    }
		
    public function getAllTasks()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteTask($taskId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id_task = :taskid");
        $stmt->bindParam(':taskid', $taskId);
        $stmt->execute();
    }

    /**
     * Cerca i task di un utente in base a una parola chiave nella descrizione.
     *Un array contenente i task corrispondenti alla ricerca.
     */
    public function searchTasks($keyword){
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE description LIKE :keyword OR task_name LIKE :keyword");
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);//bindValue deve essere trattato come una stringa 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
