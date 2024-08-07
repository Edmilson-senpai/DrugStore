<?php
session_start();
if($_SESSION['us_tipo']==2){
    include_once 'layouts/header.php';
?>

  <title>Tec | Catalogo</title>
<?php
    include_once 'layouts/nav_tec.php';
?>

  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../css/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <div class="content-wrapper" style="min-height: 1202.92px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Catálogo de producto</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Catalogo de productos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section>
        <div class="container-fluid">
            <div class="card card-danger">
                <div class="card-header">
                <h3 class="card-title">Lotes en riesgo</h3>
                </div>
                <div class="card-body p-0 table-responsive">
                  <table class="table table-hover text-nowrap" >
                    <thead class="table-info">
                      <th>Cod</th>
                      <th>Productos</th>
                      <th>Stock</th>
                      <th>Lab</th>
                      <th>Presentacion</th>
                      <th>Proveedor</th>
                      <th>Mes</th>
                      <th>Día</th>
                    </thead>
                    <tbody id="lotes" class="table-active">

                    </tbody>
                  </table>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                <h3 class="card-title">Buscar Producto</h3>
                <div class="input-group">
                    <input type="text" id="buscar-producto" class="form-control float-left" placeholder="Ingrese Nombre del prodcuto">
                    <div class="input-group-append">
                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    <div id="productos" class="row d-flex align-items-stretch">   
                      
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>

<script src="../plugins/jquery/jquery.js"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="../js/catalogo.js"></script>
<script src="../js/carrito_tec.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include_once 'layouts/footer.php';
}
else{
    header('Location: ../index.php');
}
?>