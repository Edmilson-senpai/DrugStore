$(document).ready(function(){
  var edit=false;
  var funcion;
  buscar_prov();
  $('#form-crear').submit(e=>{
      let id = $('#id_edit_prov').val();
      let nombre = $('#nombre').val();
      let telefono=$('#telefono').val();
      let direccion=$('#direccion').val();
      let correo=$('#correo').val();
      if(edit==true){
        funcion='editar';
      }else{
        funcion='crear';
      }
      $.post('../controlador/ProveedorController.php',{id,nombre,telefono,direccion,correo,funcion},(response)=>{
          if(response=='add'){
              $('#add-prov').hide('slow');
              $('#add-prov').show(1000);
              $('#add-prov').hide(2000);
              $('#form-crear').trigger('reset');
              buscar_prov();
          }if(response=='noadd' || response=='noedit'){
              $('#noadd-prov').hide('slow');
              $('#noadd-prov').show(1000);
              $('#noadd-prov').hide(2000);
              $('#form-crear').trigger('reset');
          }if(response=='edit'){
            $('#edit-prove').hide('slow');
            $('#edit-prove').show(1000);
            $('#edit-prove').hide(2000);
            $('#form-crear').trigger('reset');
            buscar_prov();
        }
      });
      e.preventDefault();
  });
  function buscar_prov(consulta){
      funcion='buscar';
      $.post('../controlador/ProveedorController.php',{consulta,funcion},(response)=>{
          const proveedores = JSON.parse(response);
          console.log(response);
          let template='';
          proveedores.forEach(proveedor => {
              template+=`
                              <div provId="${proveedor.id}" provNombre="${proveedor.nombre}" provTelefono="${proveedor.telefono}" provCorreo="${proveedor.correo}" provDireccion="${proveedor.direccion}" provAvatar="${proveedor.avatar}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
            <div class="card bg-light">
              <div class="card-header text-muted border-bottom-0">
                <h1 class="badge badge-success">Proveedor</h1>
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead">${proveedor.nombre}</h2>
                    
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dirección: ${proveedor.direccion}}</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefono #: ${proveedor.telefono}</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Telefono #: ${proveedor.correo}</li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="${proveedor.avatar}" alt="" class="img-circle img-fluid">
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <button href="#" class="avatar btn btn-sm btn-info" title="Editar logo" type="button" data-toggle="modal" data-target="#cambiologo">
                    <i class="fas fa-image"></i>
                  </button>
                  <button href="#" class="editar btn btn-sm btn-success" title="Editar proveedor" type="button" data-toggle="modal" data-target="#crearproveedor">
                    <i class="fas fa-pencil-alt"></i>
                  </button>
                  <button href="#" class="borrar btn btn-sm btn-danger" title="Borrar proveedor">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          `;
          });
          $('#proveedores').html(template);
      });
  }
  $(document).on('keyup','#buscar_proveedor',function(){
      let valor=$(this).val();
      if(valor!=''){
          buscar_prov(valor);
      }else{
          buscar_prov();
      }
  });

  $(document).on('click','.avatar',(e)=>{
    funcion = "cambiar_logo";
    const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
    const id = $(elemento).attr('provId');
    const nombre = $(elemento).attr('provNombre');
    const avatar = $(elemento).attr('provAvatar');
    $('#logoactual').attr('src',avatar);
    $('#nombre_logo').html(nombre);
    $('#id_logo_prov').val(id);
    $('#funcion').val(funcion);
    $('#avatar').val(avatar);
  });

  $(document).on('click','.editar',(e)=>{
    const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
    const id = $(elemento).attr('provId');
    const nombre = $(elemento).attr('provNombre');
    const direccion = $(elemento).attr('provDireccion');
    const telefono = $(elemento).attr('provTelefono');
    const correo = $(elemento).attr('provCorreo');
    $('#id_edit_prov').val(id);
    $('#nombre').val(nombre);
    $('#direccion').val(direccion);
    $('#telefono').val(telefono);
    $('#correo').val(correo);
    edit=true;
  });


  $('#form-logo').submit(e=>{
    let formData = new FormData($('#form-logo')[0]);
    $.ajax({
        url:'../controlador/ProveedorController.php',
        type:'POST',
        data:formData,
        cache:false,
        processData:false,
        contentType:false
    }).done(function(response){
        const json = JSON.parse(response);
        if(json.alert=='edit'){
            $('#logoactual').attr('src',json.ruta);
            $('#edit-prov').hide('slow');
            $('#edit-prov').show(1000);
            $('#edit-prov').hide(2000);
            $('#form-logo').trigger('reset');
            buscar_prov();
        }else{
            $('#noedit-prov').hide('slow');
            $('#noedit-prov').show(1000);
            $('#noedit-prov').hide(2000);
            $('#form-logo').trigger('reset');
        }
    })
    e.preventDefault();
});

$(document).on('click','.borrar',(e)=>{
  funcion="borrar";
  const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
  const id = $(elemento).attr('provId');
  const nombre = $(elemento).attr('provNombre');
  const avatar =$(elemento).attr('provAvatar');
  const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger mr-1"
      },
      buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
      title: "Estás seguro?",
      text: "La eliminación no es reversible!",
      imageUrl:''+avatar+'',
      imageWidth:100,
      imageHeight:100,
      showCancelButton: true,
      confirmButtonText: "Sí, quiero borrarlo!",
      cancelButtonText: "No, cancela!",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
          $.post('../controlador/ProveedorController.php',{id,funcion},(response)=>{
              
              console.log(response);
          })
        swalWithBootstrapButtons.fire({
          title: "Eliminado!",
          text: 'El proveedor '+nombre+' sido eliminado correctamente.',
          icon: "success"
          
        });
      } else if (
          result.dismiss === Swal.DismissReason.cancel
      ) {
          swalWithBootstrapButtons.fire({
          title: "Cancelado",
          text: 'No se ha realizado la eliminacion',
          icon: "error"
        });
      }
      buscar_prov();
    });
})
});