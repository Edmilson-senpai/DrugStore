$(document).ready(function(){
    var funcion;
    buscar_lote();

    function buscar_lote(consulta){
        funcion='buscar';
        $.post('../controlador/lotecontroller.php',{consulta, funcion},(response)=>{
            const lotes = JSON.parse(response);
            let template='';
            lotes.forEach(lote=>{
                template+=`
            <div loteId="${lote.id}" loteStock="${lote.stock}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">`;
            if(lote.estado=='light'){
                template+=`<div class="card bg-light">
                <div class="card-header border-bottom-0 bg-light">
                <h6>Código: ${lote.id}</h6>
                <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
              </div>`;
            }if(lote.estado=='danger'){
                template+=`<div class="card ">
                <div class="card-header border-bottom-0 bg-danger">
                <h6>Código: ${lote.id}</h6>
                <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
              </div>`;
            }if(lote.estado=='warning'){
                template+=`<div class="card ">
                <div class="card-header border-bottom-0 bg-warning">
                <h6>Código: ${lote.id}</h6>
                <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
              </div>`;
            }
            
              template+=`

              <div class="card-body pt-4">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead"><b>${lote.nombre}</b></h2>
                    <ul class="ml-4 mb-0 fa-ul">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle"></i></span> Descripcion: ${lote.descripcion}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span> Adicional: ${lote.adicional}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span> Laboratorio: ${lote.laboratorio}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyright"></i></span> Tipo: ${lote.tipo}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span> Presentacion: ${lote.presentacion}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-times"></i></span> Fecha de vencimiento: ${lote.vencimiento}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-truck"></i></span> Proveedor: ${lote.proveedor}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span> Mes: ${lote.mes}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-day"></i></span> Día: ${lote.dia}</li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="${lote.avatar}" alt="" class="img-circle img-fluid">
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <button class="editar btn-sm btn-success" type="buttton" data-toggle="modal" data-target="#editarlote">
                      <i class="fas fa-pencil-alt"></i>
                  </button>
                  <button class="borrar btn btn-sm btn-danger">
                      <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
                `;
            });
            $('#lotes').html(template);
        });
    }
    $(document).on('keyup','#buscar-lote',function(){
      let valor = $(this).val();
      if(valor!=""){
          buscar_lote(valor);
      }else{
          buscar_lote();
      }
    });

    $(document).on('click','.editar',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id = $(elemento).attr('loteId');
      const stock = $(elemento).attr('loteStock');
    
      $('#id_lote_prod').val(id);    
      $('#stock').val(stock);  
      $('#codigo_lote').html(id);  
    });

    $('#form-editar-lote').submit(e=>{
      let id = $('#id_lote_prod').val();
      let stock = $('#stock').val();
      funcion = "editar";
      $.post('../controlador/lotecontroller.php',{id,stock,funcion},(response)=>{
        if(response=='edit'){
          $('#edit-lote').hide('slow');
          $('#edit-lote').show(1000);
          $('#edit-lote').hide(2000);
          $('#form-editar-lote').trigger('reset');
        }
        buscar_lote();
      })
      e.preventDefault();
    });

    $(document).on('click','.borrar',(e)=>{
      funcion="borrar";
      const elemento =$(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id = $(elemento).attr('loteId');

      const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger mr-1"
          },
          buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
          title: "Deseas eliminar "+id+"?",
          text: "La eliminación no es reversible!",
          icon:"warning",
          imageWidth:100,
          imageHeight:100,
          showCancelButton: true,
          confirmButtonText: "Sí, quiero borrarlo!",
          cancelButtonText: "No, cancela!",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
              $.post('../controlador/lotecontroller.php',{id,funcion},(response)=>{
                  edit==false;
              })
            swalWithBootstrapButtons.fire({
              title: "Eliminado!",
              text: 'El lote ha sido eliminado correctamente.',
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
          buscar_lote();
        });
  })

});
