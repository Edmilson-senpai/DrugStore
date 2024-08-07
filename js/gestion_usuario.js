$(document).ready(function(){
  var tipo_usuario =$('#tipo_usuario').val(); 
  if(tipo_usuario==2){
    $('#boton_crear').hide();
  }
  console.log(tipo_usuario);
  buscar_datos();
    var funcion;
    function buscar_datos(consulta){
        funcion='buscar_usuarios_adm';
        $.post('../controlador/UsuarioController.php',{consulta,funcion},(response)=>{
            const usuarios = JSON.parse(response);
            let template='';
            usuarios.forEach(usuario=>{
                template+=`
                <div usuarioId="${usuario.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
            <div class="card text-bg-dark">
              <div class="card-header .text-light border-bottom-0 badge text-bg-success">
                ${usuario.tipo}
              </div>
              <div class="card-body pt-4">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead"><b>${usuario.nombre}${usuario.apellidos}</b></h2>
                    <p class=".text-light text-sm"><b>Adicional: </b>${usuario.extra}</p>
                    <ul class="ml-4 mb-0 fa-ul .text-light">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span> DNI: ${usuario.dni}</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-birthday-cake"></i></span> Edad: ${usuario.edad}</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Residencia: ${usuario.direccion}</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefono #: ${usuario.telefono}</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Correo: ${usuario.correo}</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-smile-wink"></i></span> Sexo: ${usuario.sexo}</li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="${usuario.avatar}" alt="" class="img-circle img-fluid">
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">`;
                if(tipo_usuario==3){
                  if (usuario.tipo_usuario!=3){
                    template+=`
                    <button class="borrar-usuario btn mr-1 btn-danger"  type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-window-close mr-1"></i>Eliminar
                    </button>
                `;
                  }
                  if(usuario.tipo_usuario==2){
                    template+=`
                    <button class="promover btn btn-primary ml-1" type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-sort-amount-up mr-1"></i>Promover
                    </button>
                `;
                  }
                  if(usuario.tipo_usuario==1){
                    template+=`
                    <button class="degradar btn btn-warning ml-1" type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-sort-amount-down mr-1"></i>Degradar
                    </button>
                `;
                  }
                }else{
                  if(tipo_usuario==1 && usuario.tipo_usuario!=1 && usuario.tipo_usuario!=3){
                    template+=`
                    <button class="borrar-usuario btn mr-1 btn-danger"  type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-window-close mr-1"></i>Eliminar
                    </button>
                    `;
                  }
                }
                template+=`
                </div>
              </div>
            </div>
          </div>
                `;
            });
            $('#usuarios').html(template);
        });
    }
    $(document).on('keyup','#buscar',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscar_datos(valor);
        }else{
            buscar_datos(valor);
        }
    });
    $('#form-crear').submit(e=>{
      let nombre = $('#nombre').val();
      let apellido = $('#apellido').val();
      let edad = $('#edad').val();
      let dni = $('#dni').val();
      let pass = $('#pass').val();
      funcion='crear_usuario';
      $.post('../controlador/UsuarioController.php',{nombre,apellido,edad,dni,pass,funcion},(response)=>{
        if(response=='add'){
          $('#add').hide('slow');
          $('#add').show(1000);
          $('#add').hide(2000);
          $('#form-crear').trigger('reset');
          buscar_datos();
      }else{
          $('#noadd').hide('slow');
          $('#noadd').show(1000);
          $('#noadd').hide(2000);
          $('#form-crear').trigger('reset');
      }
      });
      e.preventDefault();
    });
    $(document).on('click','.promover',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id=$(elemento).attr('usuarioId');
      funcion ='promover';
      $('#id_user').val(id);
      $('#funcion').val(funcion);
    });
    $(document).on('click','.borrar-usuario',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id=$(elemento).attr('usuarioId');
      funcion ='borrar_usuario';
      $('#id_user').val(id);
      $('#funcion').val(funcion);
    });
    $(document).on('click','.degradar',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id=$(elemento).attr('usuarioId');
      funcion ='degradar';
      $('#id_user').val(id);
      $('#funcion').val(funcion);
    });
    $('#form-confirmar').submit(e=>{
      let pass=$('#oldpass').val();
      let id_usuario=$('#id_user').val();
      funcion=$('#funcion').val();
      $.post('../controlador/UsuarioController.php',{pass,id_usuario,funcion},(response)=>{
        if(response=='promovido' || response=='degradado' || response=='eliminado'){
          $('#confirmado').hide('slow');
          $('#confirmado').show(1000);
          $('#confirmado').hide(2000);
          $('#form-confirmar').trigger('reset');
          buscar_datos();
      }else{
          $('#rechazado').hide('slow');
          $('#rechazado').show(1000);
          $('#rechazado').hide(2000);
          $('#form-confirmar').trigger('reset');
      }
        buscar_datos();
      })
      e.preventDefault();
    })
})
