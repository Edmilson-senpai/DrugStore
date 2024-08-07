<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Editar Datos</title>
<?php
    include_once 'layouts/nav.php';
?>

<!-- Modal -->
<div class="modal fade" id="confirmar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Confirmar Acción'</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span arian-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
            <img src="../img/default.jpg" class="profile-user-img img-fluid img-circle">
        </div>
        <div class="text-center">
            <b>
                <?php
                echo $_SESSION['nombre_us'];
                ?>
            </b>
        </div>
        
        <div class="alert alert-success text-center m-1" id="confirmado" style="display:none;">
            <span><i class="fas fa-check">Editado</i></span>
        </div>
        <div class="alert alert-danger text-center m-1" id="rechazado" style="display:none;">
            <span><i class="fas fa-times">Contraseña Incorrecta</i></span>
        </div>
        <span class="">Ingresa tu contraseña para continuar</span>
        <form id="form-confirmar">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                </div>
                <input id="oldpass" type="password" class="form-control" placeholder="Ingrese contraseña">
                <input type="hidden" id="id_user">
                <input type="hidden" id="funcion">
              </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
            <button type="sumbit" class="btn bg-gradient-primary">Guardar</button>
            </form>
        </div>
      
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="crearusuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Crear Usuario</h3>
            <button data-dismiss="modal" aria-label="close" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
          <div class="alert alert-success text-center m-1" id="add" style="display:none;">
              <span><i class="fas fa-check">Usuario agregado</i></span>
          </div>
          <div class="alert alert-danger text-center m-1" id="noadd" style="display:none;">
              <span><i class="fas fa-times">Error / El DNI ya existe</i></span>
          </div>
            <form id="form-crear">
                <div class="form-group">
                    <label for="nombre">Nombres</label>
                    <input id="nombre" type="text" class="form-control" placeholder="Ingrese Nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellidos</label>
                    <input id="apellido" type="text" class="form-control" placeholder="Ingrese Apellidos" required>
                </div>
                <div class="form-group">
                    <label for="edad">Nacimiento</label>
                    <input id="edad" type="number" class="form-control" placeholder="Ingrese Edad" min="0" required>
                </div>
                <div class="form-group">
                    <label for="dni">Nº DNI</label>
                    <input id="dni" type="number" class="form-control" placeholder="Ingrese Nº DNI" min="0" max="99999999" required>
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input id="pass" type="password" class="form-control" placeholder="Ingrese Password" required>
                </div>
            
        </div>
        <div class="card-footer">
            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
            <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion Usuarios <button type="button" id="boton_crear" data-toggle="modal" data-target="#crearusuario" class="btn bg-gradient-primary ml-2">Crear Usuario</button></h1>
            <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo']?>">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestion Usuarios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    
    <section>
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                <h3 class="card-title">Buscar Usuario</h3>
                <div class="input-group">
                    <input type="text" id="buscar" class="form-control float-left" placeholder="Ingrese Nombre de Usuario o DNI">
                    <div class="input-group-append">
                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </div>
                <div class="card-body">
                  <div id="usuarios" class="row d-flex align-items-stretch">
                      
                  </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php
include_once 'layouts/footer.php';
}
else{
    header('Location: ../index.php');
}

?>
<script src="../js/gestion_usuario.js"></script>
