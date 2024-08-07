// checker
$(document).ready(function(){
    buscar_tip();
    var funcion;
    var edit=false;
    $('#form-crear-tipo').submit(e=>{
        let nombre_tipo = $('#nombre-tipo').val();
        let id_editado = $('#id_editar_tip').val();
        console.log(id_editado);
        if(edit==false){
            funcion='crear';
        }
        else{
            funcion='editar'; 
            console.log('va a editar');
        }
        
        $.post('../controlador/tipocontroller.php',{nombre_tipo,id_editado,funcion},(response)=>{
            if(response=='add'){
                $('#add-tipo').hide('slow');
                $('#add-tipo').show(1000);
                $('#add-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            if(response=='noadd'){
                $('#noadd-tipo').hide('slow');
                $('#noadd-tipo').show(1000);
                $('#noadd-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-tip').hide('slow');
                $('#edit-tip').show(1000);
                $('#edit-tip').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            edit=false;
        })
        e.preventDefault();
    });

    function buscar_tip(consulta){
        funcion='buscar';
        $.post('../controlador/tipocontroller.php',{consulta,funcion},(response)=>{
            const tipos = JSON.parse(response);
            let cabeza =`                
            <thead class="table-danger">
                <tr>
                    <th scope="col">Laboratorio</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            `;
            let template = '';
            tipos.forEach(tipo => {
                template+=`
            <tr tipId="${tipo.id}" tipNombre="${tipo.nombre}">
                <td>${tipo.nombre}</td>
                <td>
                    <button class="editar-tip btn btn-success" title="Editar tipo" type="button" data-toggle="modal" data-target="#creartipo">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="borrar-tip btn btn-danger" title="Borrar tipo">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
                

            </tr>

                `;
            });
            template=cabeza+template;
            $('#tipos').html(template);
        })
    }

    $(document).on('keyup','#buscar-tipo',function(){
        let valor = $(this).val();
        if(valor!=''){
            buscar_tip(valor);
        }else{
            buscar_tip();
        }
    })

    $(document).on('click','.borrar-tip',(e)=>{
        funcion="borrar";
        console.log(id);
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('tipId');
        const nombre = $(elemento).attr('tipNombre');
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
            icon: 'warning',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/tipocontroller.php',{id,funcion},(response)=>{
                    edit==false;
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire({
                            title: "Eliminado!",
                            text: 'El tipo '+nombre+' sido eliminado correctamente.',
                            icon: "success"
                          });
                        buscar_tip();
                    }else{
                        swalWithBootstrapButtons.fire({
                            title: "No se pudo borrar",
                            text: 'El tipo '+nombre+' no fue borrado porque está siendo usado en un producto',
                            icon: "error"
                          });
                    }
                })
              
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: 'No se ha realizado la eliminacion',
                    icon: "error"
                  });
            }
          });
    })

    $(document).on('click','.editar-tip',(e)=>{
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('tipId');
        const nombre = $(elemento).attr('tipNombre');
        $('#id_editar_tip').val(id);
        $('#nombre-tipo').val(nombre);
        edit=true;
        console.log(funcion);
        console.log(edit);
    })

});

