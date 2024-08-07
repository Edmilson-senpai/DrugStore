<?php
session_start();
if($_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Lote</title>
<?php
    include_once 'layouts/nav.php';
?>
<!-- MODAL EDITAR LOTE -->
<div class="modal fade" id="editarlote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Editar lote</h3>
            <button data-dismiss="modal" aria-label="close" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-success text-center m-1" id="edit-lote" style="display:none;">
            <span><i class="fas fa-check">Se editó correctamente</i></span>
        </div>
          <div class="card-body">
            <form id="form-editar-lote">
                <div class="form-group">
                    <label for="codigo_lote">Código lote: </label>
                    <label id="codigo_lote">codigo lote</label>
                </div>
                <div class="form-group">
                    <label for="stock">Stock: </label>
                    <input id="stock" type="number" class="form-control" placeholder="Ingrese Stock" min="0" required>
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


<!-- FIN MODAL EDITAR LOTE -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion Lotes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestion Lotes</li>
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
                <h3 class="card-title">Buscar Lotes</h3>
                <div class="input-group">
                    <input type="text" id="buscar-lote" class="form-control float-left" placeholder="Ingrese Nombre de Producto">
                    <div class="input-group-append">
                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                </div>
                <div class="card-body">
                  <div id="lotes" class="row d-flex align-items-stretch">
                      
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
<script src="../js/lote.js"></script>
