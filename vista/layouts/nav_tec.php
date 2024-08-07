 <!-- Tell the browser to be responsive to screen width -->
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../img/logo.png" type="image/png">
<link rel="stylesheet" href="../css/carrito.css">
<link rel="stylesheet" href="../css/compra.css">
<link rel="stylesheet" href="../css/datatables.css">

<!--select2-->
<link rel="stylesheet" href="../css/select2.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/css/all.min.css">
  <!-- Ionicons -->
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="dropdown mt-1" id="cat-carrito" style="display:none">

        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="nav-icon fas fa-shopping-cart">
            <span id="contador" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span> 
          </i>
        </button>

        <div class="dropdown-menu" >
          <table class="carro table table-hover text-nowrap p-0">
            <thead class="table-success">
              <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Adicional</th>
                <th>Precio</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="lista">

            </tbody>
          </table>         
          <a href="#" id="procesar-pedido"class="btn btn-info btn-block p-2"  >Realizar compra</a>
          <a href="#" id="vaciar-carrito"class="btn btn-danger btn-block p-2" >Vaciar carrito</a>
        </div>
    </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <a href="../controlador/Logout.php">Cerrar Sesion</a>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../vista/adm_catalogo.php" class="brand-link">
      <img src="../img/logo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Farmacia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img id="avatar4"src="../img/avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
              <?php
                echo $_SESSION['nombre_us'];
              ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-header">Modulo de trabajo</li>
          <li class="nav-item">
            <a href="../vista/adm_catalogo.php" class="nav-link">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Catalogo
              </p>
            </a>
          </li>        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  