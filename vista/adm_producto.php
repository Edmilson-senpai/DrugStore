<?php
session_start();
if($_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Productos</title>
<?php
    include_once 'layouts/nav.php';
?>

<!-- Lote modal -->
<div class="modal fade" id="crearlote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Crear lote</h3>
            <button data-dismiss="modal" aria-label="close" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-success text-center m-1" id="add-lote" style="display:none;">
            <span><i class="fas fa-check">Se creo correctamente</i></span>
        </div>
          <div class="card-body">
            <form id="form-crear-lote">
                <div class="form-group">
                    <label for="nombre_producto_lote">Producto: </label>
                    <label id="nombre_producto_lote">Nombre producto</label>
                </div>
                <div class="form-group">
                    <label for="proveedor">Proveedor: </label>
                    <select name="proveedor" id="proveedor" class="select2 form-control" style="width:100%"></select>
                </div>
                <div class="form-group">
                    <label for="stock">Stock: </label>
                    <input id="stock" type="number" class="form-control" placeholder="Ingrese Stock" min="0"required>
                </div>
                <div class="form-group">
                    <label for="vencimiento">Fecha de vencimiento: </label>
                    <input id="vencimiento" type="date" class="form-control" placeholder="Ingrese la fecha de vencimiento" required>
                </div>
                <input type="hidden" id="id_lote_prod">
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


<div class="modal fade" id="cambiologo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="exampleModalLabel">Cambiar Logo</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span arian-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <img id="logoactual" src="../img/avatar.png" class="profile-user-img img-fluid img-circle">
            </div>
            <div class="text-center">
                <b id="nombre_logo">                    
                </b>
            </div>
            <div class="alert alert-success text-center m-1" id="edit" style='display:none;'>
                <span><i class="fas fa-check">Se cambio el avatar</i></span>
            </div>
            <div class="alert alert-danger text-center m-1" id="noedit" style='display:none;'>
                <span><i class="fas fa-times">Error</i></span>
            </div>
            <form id="form-logo" enctype="multipart/form-data">
                <div class="input-group mb-3 ml-5 mt-2">
                    <input type="file" name="photo" class="input-group">
                    <input type="hidden" name="funcion" id="funcion">
                    <input type="hidden" name="id_logo_prod" id="id_logo_prod">
                    <input type="hidden" name="avatar" id="avatar">
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

<div class="modal fade" id="crearproducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Agregar producto</h3>
            <button data-dismiss="modal" aria-label="close" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-success text-center m-1" id="add" style="display:none;">
            <span><i class="fas fa-check">Se creo correctamente el Producto</i></span>
        </div>
        <div class="alert alert-danger text-center m-1" id="noadd" style="display:none;">
            <span><i class="fas fa-times">El producto ya existe</i></span>
        </div>
        <div class="alert alert-success text-center m-1" id="edit_prod" style='display:none;'>
                <span><i class="fas fa-check">Se edito correctamente</i></span>
        </div>
          <div class="card-body">
            <form id="form-crear-producto">
                <div class="form-group">
                    <label for="nombre_producto">Nombre</label>
                    <input id="nombre_producto" type="text" class="form-control" placeholder="Ingrese Nombre" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <input id="descripcion" type="text" class="form-control" placeholder="Ingrese la descripcion" required>
                </div>
                <div class="form-group">
                    <label for="adicional">Adicional</label>
                    <input id="adicional" type="text" class="form-control" placeholder="Ingrese Adicional">
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input id="precio" type="number" step="any" class="form-control" value="1" placeholder="Ingrese Precio" min="0" required>
                </div>
                <div class="form-group">
                    <label for="laboratorio">Laboratorio</label>
                    <select name="laboratorio" id="laboratorio" class="select2 form-control" style="width:100%"></select>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="select2 form-control" style="width:100%"></select>
                </div>
                <div class="form-group">
                    <label for="presentacion">Presentacion</label>
                    <select name="descripcion" id="presentacion" class="select2 form-control" style="width:100%"></select>
                </div>
                <input type="hidden" id="id_edit_prod">
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
            <h1>Gestion Productos <button type="button" data-toggle="modal" data-target="#crearproducto" class="btn bg-gradient-primary ml-2">Crear Producto</button></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestion Producto</li>
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
                <h3 class="card-title">Buscar Producto</h3>
                <div class="input-group">
                    <input type="text" id="buscar-producto" class="form-control float-left" placeholder="Ingrese Nombre de Producto">
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


    <?php
include_once 'layouts/footer.php';
}
else{
    header('Location: ../index.php');
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/producto.js"></script>
