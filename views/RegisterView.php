<?php include('subviews/header.php') ?>
<link href="css/Floating_Form.css" rel="stylesheet">
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Consulta</a>
        </li>
        <li class="breadcrumb-item active">Consulta de siniestros</li>
      </ol>
      
         <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-arrow-down"></i> Consultas         
        </div>
        <div class="card-body">
           <?php
              $msg->display();
          ?>
            <div class="container text-center">
              <div ng-app="Appi">
                <div  ng-controller="RegisterController">
                   <div ng-include src="'js/Views/Form_table.html'"></div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>                          

<?php include('subviews/footer.php') ?>



