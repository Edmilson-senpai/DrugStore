<!-- checker -->
<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Atributos</title>
<?php
    include_once 'layouts/nav.php';
?>
<!-- modal -->
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
            <div class="alert alert-success text-center m-1" id="edit" style="display:none;">
                <span><i class="fas fa-check">Se cambio el avatar</i></span>
            </div>
            <div class="alert alert-danger text-center m-1" id="noedit" style="display:none;">
                <span><i class="fas fa-times">Error</i></span>
            </div>
            <form id="form-logo" enctype="multipart/form-data">
                <div class="input-group mb-3 ml-5 mt-2">
                    <input type="file" name="photo" class="input-group">
                    <input type="hidden" name="funcion" id="funcion">
                    <input type="hidden" name="id_logo_lab" id="id_logo_lab">
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


<div class="modal fade" id="crearlab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Gestión Laboratorio</h3>
            <button data-dismiss="modal" aria-label="close" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <div class="alert alert-warning text-center" id="add-laboratorio" style="display: none;">
                <span><i class="fas fa-check m-1">Se agregó correctamente</i></span>
            </div>
            <div class="alert alert-success text-center" id="edit-lab" style="display: none;">
                <span><i class="fas fa-check m-1">Se editó correctamente</i></span>
            </div>
            <div class="alert alert-danger text-center" id="noadd-laboratorio" style="display: none;">
                <span><i class="fas fa-check m-1">Error</i></span>
            </div>
            <form id="form-crear-lab">
                <div class="form-group">
                    <label for="nombre-laboratorio">Nombre</label>
                    <input id="nombre-laboratorio" type="text" class="form-control" placeholder="Ingrese Nombre" required>
                    <input type="hidden" id="id_editar_lab">
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
<!--end modal-->
<!-- modal -->
<div class="modal fade" id="creartipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Crear Tipo</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning text-center" id="add-tipo" style="display: none;">
                        <span><i class="fas fa-check m-1">Se agregó correctamente</i></span>
                    </div>
                    <div class="alert alert-success text-center" id="edit-tip" style="display: none;">
                        <span><i class="fas fa-check m-1">Se editó correctamente</i></span>
                    </div>
                    <div class="alert alert-danger text-center" id="noadd-tipo" style="display: none;">
                        <span><i class="fas fa-check m-1">Error</i></span>
                    </div>
                    <form id="form-crear-tipo">
                        <div class="form-group">
                            <label for="nombre-tipo">Tipo</label>
                            <input id="nombre-tipo" type="text" class="form-control" placeholder="Ingrese Tipo" required>
                            <input type="" id="id_editar_tip">
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
</div>
<!--end modal-->
<!-- modal -->
<div class="modal fade" id="crearpresentacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-dark">
                <div class="card-header">
                <h3 class="card-title">Crear Presentacion</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                    <div class="alert alert-warning text-center" id="add-pre" style="display: none;">
                        <span><i class="fas fa-check m-1">Se agregó correctamente</i></span>
                    </div>
                    <div class="alert alert-success text-center" id="edit-pre" style="display: none;">
                        <span><i class="fas fa-check m-1">Se editó correctamente</i></span>
                    </div>
                    <div class="alert alert-danger text-center" id="noadd-pre" style="display: none;">
                        <span><i class="fas fa-check m-1">Error</i></span>
                    </div>
                    <form id="form-crear-presentacion">
                        <div class="form-group">
                            <label for="nombre-presentacion">Presentacion</label>
                            <input id="nombre-presentacion" type="text" class="form-control" placeholder="Ingrese Nombre" required>
                            <input type="" id="id_editar_pre">
                        </div>           
                        <div class="card-footer">
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                        </div>
                    </form>
            </div>
      </div>
    </div>
  </div>
</div>
<!--end modal-->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gestión de Laboratorio</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </section>  
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills nav-fill shadow-sm">
                                <li class="nav-item"><a href="#laboratorio" class="nav-link active" data-toggle="tab">Laboratorio</a></li>
                                <li class="nav-item"><a href="#tipo" class="nav-link" data-toggle="tab">Tipo</a></li>
                                <li class="nav-item"><a href="#presentacion" class="nav-link" data-toggle="tab">Presentacion</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" >
                                <div class="tab-pane active" id='laboratorio'>
                                    <div class="card-info">
                                        <div class="card-header">
                                            <div class="card-title">Buscar Lab <button type="button" data-toggle="modal" data-target="#crearlab" class="btn bg-gradient-secondary btn-sm m-2">Crear laboratorio</button></div>
                                            <div class="input-group">
                                                <input id="buscar-laboratorio" type="text" class="form-control float-left" placeholder="Ingrese nombres">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover" id="laboratorios">

                                            </table>
                                        </div>
                                        <div class="card-footer">

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id='tipo'>
                                    <div class="card-info">
                                        <div class="card-header">
                                            <div class="card-title">Buscar Tipos<button type="button" data-toggle="modal" data-target="#creartipo" class="btn bg-gradient-secondary btn-sm m-2">Crear Tipo</button></div>
                                            <div class="input-group">
                                                <input id="buscar-tipo" type="text" class="form-control float-left" placeholder="Ingrese tipo">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover" id="tipos">

                                            </table>
                                        </div>
                                        <div class="card-footer">

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id='presentacion'>
                                    <div class="card-info">
                                        <div class="card-header">
                                            <div class="card-title">Buscar Presentacion <button type="button" data-toggle="modal" data-target="#crearpresentacion" class="btn bg-gradient-secondary btn-sm m-2">Crear presentacion</button></div>
                                            <div class="input-group">
                                                <input id="buscar-presentacion" type="text" class="form-control float-left" placeholder="Ingrese presentacion">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover" id="presentaciones">

                                            </table>
                                        </div>
                                        <div class="card-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <section class="content"></section>
  </div>
    
  

<?php
include_once 'layouts/footer.php';
}
else{
    header('Location: ../index.php');
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/gestion_laboratorio.js"></script>
<script src="../js/tipo.js"></script>
<script src="../js/presentacion.js"></script>
