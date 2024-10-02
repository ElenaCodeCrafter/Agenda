<?php require "include/header.php" ?>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php require "include/menu.php" ?>
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> </span>Benvenut*! </h4>

              <div class="row">
                <!-- Cornice del form -->
                
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Accedi al tuo account</h5>
                  <?php if(isset($_GET["login"])){ 
                          if($_GET["login"]=="ko"){ ?>
                      <p style="color:red">HAI INSERITO USERNAME O PASSWORD ERRATA!</p>
                    <?php }else{ ?>
                      <div id ="credenzialiErrati"><p style="color:red" > Le credenziali non sono validi. Riprova</p></div>
                    <?php } ?>
                  <?php } ?>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
          <div class="layout-container">
            
              <!-- Content wrapper -->
              <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> </span>Benvenut*! </h4>

                  <div class="row">
                    <!-- Cornice del form -->
                    
                    <div class="col-md-6">
                      <div class="card mb-4">
                        <h5 class="card-header">Accedi al tuo account</h5>
                        <div class="card-body demo-vertical-spacing demo-only-element">
                        <form action = "login.php", method="POST">
                          <div class="input-group">
                            <span class="input-group-text" id="basic-addon11">@</span>
                            <input name="username" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon11"/>
                          </div>

                          <div class="form-password-toggle">
                            <label class="form-label" for="basic-default-password12">Password</label>
                            <div class="input-group">
                              <input
                                name="password"
                                type="password"
                                class="form-control"
                                id="basic-default-password12"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="basic-default-password2"
                              />
                              <span id="basic-default-password2" class="input-group-text cursor-pointer"
                                ><i class="bx bx-hide"></i
                              ></span>
                            </div>
                            <!-- Div separatore -->
                            <div class="separator"></div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Accedi</button>
                            </div>
                          </div>
                          </div>                       
                          </form> 

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- / Cornice del form -->

                <div class="content-backdrop fade"></div>
              </div>
              <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
          </div>

          <!-- Overlay -->
          <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->                  
                    <!-- / Cornice del form -->
                    <div class="content-backdrop fade"></div>
                  </div>
                  <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
              </div>

              <!-- Overlay -->
              <div class="layout-overlay layout-menu-toggle"></div>
            </div>
            <!-- / Layout wrapper -->
</body>
            <!-- Content -->
             <!-- Footer -->
            <?php require "include/footer.php" ?>
