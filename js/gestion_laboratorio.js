$(document).ready(function(){
    buscar_lab();
    var funcion;
    var edit=false;

    $('#form-crear-lab').submit(e=>{
        let nombre_laboratorio = $('#nombre-laboratorio').val();
        let id_editado = $('#id_editar_lab').val();
        if(edit==false){
            funcion='crear';
        }
        else{
            funcion='editar'; 
        }
        $.post('../controlador/laboratoriocontroller.php',{nombre_laboratorio,id_editado,funcion},(response)=>{
            if(response=='add'){
                $('#add-laboratorio').hide('slow');
                $('#add-laboratorio').show(1000);
                $('#add-laboratorio').hide(2000);
                $('#form-crear-lab').trigger('reset');
                buscar_lab();
            }
            if(response=='noadd'){
                $('#noadd-laboratorio').hide('slow');
                $('#noadd-laboratorio').show(1000);
                $('#noadd-laboratorio').hide(2000);
                $('#form-crear-lab').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-lab').hide('slow');
                $('#edit-lab').show(1000);
                $('#edit-lab').hide(2000);
                $('#form-crear-lab').trigger('reset');
                buscar_lab();
            }
            edit==false;
        })
        e.preventDefault();
    });
    function buscar_lab(consulta){
        funcion='buscar';
        $.post('../controlador/laboratoriocontroller.php',{consulta,funcion},(response)=>{
            const laboratorios = JSON.parse(response);
            let cabeza =`                
            <thead class="table-danger">
                <tr>
                    <th scope="col">Laboratorio</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            `;
            let template = '';
            laboratorios.forEach(laboratorio => {
                template+=`
            <tr labId="${laboratorio.id}" labNombre="${laboratorio.nombre}" labAvatar="${laboratorio.avatar}">
                <td>${laboratorio.nombre}</td>
                <td>
                    <img src=${laboratorio.avatar} class="img-fluid rounded" width="70" height="70">
                </td>
                <td>
                    <button class="avatar btn btn-info" title="Cambiar logo" type="button" data-toggle="modal" data-target="#cambiologo">
                        <i class="far fa-image"></i>
                    </button>
                    <button class="editar btn btn-success" title="Editar Laboratorio" type="button" data-toggle="modal" data-target="#crearlab">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="borrar btn btn-danger" title="Borrar Laboratorio">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr> 
                `;
            });
            template=cabeza+template;
            $('#laboratorios').html(template);
            
        })
    }
    $(document).on('keyup','#buscar-laboratorio',function(){
        let valor = $(this).val();
        if(valor!=''){
            buscar_lab(valor);
        }else{
            buscar_lab();
        }
    })
    $(document).on('click','.avatar',(e)=>{
        funcion="cambiar_logo";
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');
        const nombre = $(elemento).attr('labNombre');
        const avatar =$(elemento).attr('labAvatar');
        $('#logoactual').attr('src',avatar);
        $('#nombre_logo').html(nombre);
        $('#funcion').val(funcion);
        $('#id_logo_lab').val(id);
    })

    $('#form-logo').submit(e=>{
        let formData=new FormData($('#form-logo')[0]);
        $.ajax({
            url:'../controlador/laboratoriocontroller.php',
            type:'POST',
            data:formData,
            cache:false,
            processData: false,
            contentType:false
        }).done(function(response){
            console.log(response);
        });
        e.preventDefault();
    })
    $(document).on('click','.borrar',(e)=>{
        funcion="borrar";
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');
        const nombre = $(elemento).attr('labNombre');
        const avatar =$(elemento).attr('labAvatar');
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
                $.post('../controlador/laboratoriocontroller.php',{id,funcion},(response)=>{
                    edit==false;
                })
              swalWithBootstrapButtons.fire({
                title: "Eliminado!",
                text: 'El laboratorio '+nombre+' sido eliminado correctamente.',
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
            buscar_lab();
          });
    })
    $(document).on('click','.editar',(e)=>{
        const elemento =$(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');
        const nombre = $(elemento).attr('labNombre');
        $('#id_editar_lab').val(id);
        $('#nombre-laboratorio').val(nombre);
        edit=true;
    })
});

