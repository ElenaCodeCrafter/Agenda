<?php require "include/header.php" ?>
<?php 
Session::start();
// Verifica se la sessione esiste
if (!Session::exists()) {
    // Se la sessione non esiste, reindirizza alla pagina di login
    header("Location: index.php?login=sessione");
    exit();
}else{?>




    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php require "include/menu.php" ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>
            <!-- Search --> 
            <div id="searchGeneralConteiner"class="navbar-nav-right d-flex align-items-center"  style = "margin-top: 15px" >
              <form id="searchForm">
              <div id = "searchStringWithButton" class="navbar-nav align-items-center">
                <div id = "searchString" class="nav-item d-flex align-items-center" style = "margin-bottom: 5px", style="display: inline-block">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input id="searchTerm" name="searchTerm" type="text" class="form-control border-0 shadow-none"  placeholder="Search..." aria-label="Search..." />
                </div>
              
              <!-- /Search -->
              <!-- Bottone di ricerca -->
              <div id="bottoneCerca">
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <button type="submit" class="btn btn-primary" id="searchTasksBtn">CERCA</button>
              </form>
               </div>
                </li>
               <!-- /Bottone di ricerca --> 
              </ul>
            </div>
            </div>
          </nav>
         <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              
              <!-- Div with task table -->
              <div class="card">
                  
                <!-- Add-Task-Botton -->
                 <div id="divDelBottone"> <button type="submit" class="btn btn-primary" id="addTaskBtn"  >Aggiungi</button> </div>
                <!-- /Add-Task-Botton -->
                  <div id ="divDelTitolo"><h5 class="card-header">Your To-Do-s</h5></div>
                <!-- Task Table -->
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="result">
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /Task Table -->
              <!--/ Div with task table -->
              <!--Hidden form x adding a task -->
              <div style="height:20px;">&nbsp;</div>
              <div id="addTaskdiv" class="card">
                <h3 class="card-header">Aggiungi Task</h3>
                <form id="addTaskForm" class="row mb-2" method="POST">
                  <label for="title" class="col-sm-2 col-form-label">Title:</label>
                  <input type="text" id="title" name="title" required>
                  <br>
                  <br>
                  <label for="description">Description:</label>
                  <textarea id="description" name="description" required></textarea>
                  <br>
                  <br>
                  <label for="title">Data:</label>
                  <input type="date" id="date" name="date" required>
                  <br>
                  <br>
                  <label for="description">Status:</label>
                  <select id="status" name="status" required>
                      <option value="Open">Open</option>
                      <option value="In Progress">In Progress</option>
                      <option value="Closed">Closed</option>
                 </select>
                  <br>
                  <br>
                  <div id=addTaskBtn2> <button  type="submit" class="btn btn-primary">Aggiungi nuovo task</button></div>
              </form>
              </div>  
               <!--/Hidden form x adding a task -->  

    <!--Gestione di azioni  -->      
    <script>
        $(document).ready(function () {
            $('#addTaskdiv').hide();
            // Appena la pagina viene caricata la prima volta, leggo tutti i tasks.
            getTasks();

            // Funzione per gestire il click su "Ottieni Tutti i Task"
            $('#getAllTasksBtn').on('click', function () {
                getTasks();
            });

            // Funzione per gestire il click su "Aggiungi Nuovo Task"
            $('#addTaskBtn').on('click', function () {
                $('#addTaskdiv').show();
            });

            // Gestisci la sottomissione del form
            $('#addTaskForm').submit(function (event) {
                event.preventDefault();
                addNewTask();
            });            

            // Funzione per gestire la sottomissione del form di ricerca
            $('#searchForm').on('submit', function (event) {
                event.preventDefault();
                searchTasks($('#searchTerm').val());
            });
            	
        }); 


		// eliminazione di un task tramite chiamata AJAX
		function deleteTask(taskId) {
			

      bootbox.confirm({
        title: "Attention!",
        message: "Are you sure you wanna delete it?",
        buttons: {
            confirm: {
                label: '<span class="fa fa-times">Go!</span>',
                className: 'btn-danger'
            },
            cancel: {
                label: '<span class="fa fa-check">Nah, i changed my mind</span> ',
                className: 'btn-primary'
            }
        },
        callback: function(result) {
            if (result) {
              $.ajax({
              type: 'DELETE',
              url: 'include/api.php',
              contentType: 'application/x-www-form-urlencoded',
              data: { id_task: taskId },
              success: function (data) {
                console.log(data.message);
                
                getTasks(); //dopo aver eliminato task ricarco la tabella
              },
              error: function (xhr, status, error) {
                // Visualizza l'oggetto xhr nella console
                console.log(xhr);
                console.error('Errore nella richiesta:', status, error);
                // Gestisci l'errore in base alle tue esigenze
              }
            });
            } 
        }
      });
    }  


        // Funzione per ottenere tutti i task
        function getTasks() {
            $.ajax({
                type: 'GET',
                url: 'include/api.php',
                dataType: 'json',
                success: function (data) {
                    displayResult(data);
                },
                error: function(xhr, status, error) {
                // Visualizza l'oggetto xhr nella console
                console.log(xhr);
                console.log('Errore nella richiesta:', status, error);                
               }
              });
        }

              // Funzione per aggiungere un task
        function addNewTask() {
                // Recupera i dati dal form
                var titolo = $('#title').val();
                var descrizione = $('#description').val();
                var data = $('#date').val();
                var stato = $('#status').val();

                // Crea un oggetto con i dati del task
                var newTask = { //nome campo: valore
                    title: titolo,
                    description: descrizione,
                    date: data,
                    status: stato
                };

                // Effettua la chiamata AJAX per aggiungere il task
                $.ajax({
                    type: 'POST',
                    url: 'include/api.php',
                    contentType: 'application/json',
                    data: JSON.stringify(newTask),
                    success: function (data) {
                        console.log(data.message);
                        getTasks();
                        $('#addTaskdiv').hide();
                        // Puoi eseguire ulteriori azioni dopo aver aggiunto il task
                    },
                    error: function (xhr, status, error) {
                        console.error('Errore nella richiesta:', status, error);
                        console.log(xhr);
                        // Gestisce l'errore 
                    }
                });
            }

        // Funzione per cercare i task
        function searchTasks(searchTerm) {
            
            $.ajax({
                type: 'GET',
                url: 'include/api.php?search=' + encodeURIComponent(searchTerm),
                dataType: 'json',
                success: function (data) {
                    displayResult(data);
                }
            });
        }

        // Funzione per visualizzare i risultati
        // recupera i dati della chiamata
        function displayResult(data) {
            var resultDiv = $('#result');
            resultDiv.empty();
            //legge i dati
       //srotolo json
			if (data.length > 0) {
        $.each(data, function (index, task) { //data = ciò che abbiamo recuperato dal server
				data = task.date;
				// Dividi la data in anno, mese e giorno - 2024-02-12
				var partiData = data.split('-');
				// Costruisci la nuova data nel formato desiderato 12-02-2024
				var dataDdMmAaaa = partiData[2] + '-' + partiData[1] + '-' + partiData[0];
				var color;
				if(task.status=="Open"){
					color = "bg-label-danger";
				}else if(task.status=="In Progress"){
					color = "bg-label-warning";
				}else if(task.status=="Closed"){
					color = "bg-label-success";
				}
                //resultDiv.append("<tr><td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>"+ task.task_name+"</strong></td><td>"+task.description.substring(0, 20)+"</td><td>"+dataDdMmAaaa+"</td><td><span class='badge "+color+" me-1'>"+task.status+"</span></td><td><a href='#'><span class='badge bg-label-dark badge-pill'>Edit</span></a><a href='javascript:deleteTask("+task.id_task+")' ><span class='badge bg-label-info badge-pill'>Delete</span></a></td></tr>");
				resultDiv.append("<tr><td><i class='fab fa-angular fa-lg text-danger me-3'></i> <strong>"+ task.task_name+"</strong></td><td>"+task.description.substring(0, 20)+"</td><td>"+dataDdMmAaaa+"</td><td><span class='badge "+color+" me-1'>"+task.status+"</span></td><td><a href='javascript:deleteTask("+task.id_task+")' ><span class='badge bg-label-info badge-pill'>Delete</span></a></td></tr>");
                });
            } else {
                resultDiv.append('<p>Nessun risultato trovato.</p>');
            }
        }
		</script>  
            </div>
            <!-- / Content -->
<?php } ?>
            <!-- Footer -->
            <?php require "include/footer.php" ?>
