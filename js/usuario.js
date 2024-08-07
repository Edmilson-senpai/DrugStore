//MENSAJE TEST
$(document).ready(function(){
    var funcion=''
    //tomar id usuario
    var id_usuario = $('#id_usuario').val();
    //variable verificadora de estado editable (flag)
    var edit = false;
    buscar_usuario(id_usuario)
    function buscar_usuario(dato){
        funcion='buscar_usuario'
        $.post('../controlador/UsuarioController.php', {dato,funcion},(response)=>{  
            console.log(response)
            let nombre = '';
            let apellidos = '';
            let edad = '';
            let dni = '';
            let tipo = '';
            let telefono = '';
            let direccion = '';
            let correo = '';
            let sexo = '';
            let extra = '';
            const usuario = JSON.parse(response);
            nombre+=`${usuario.nombre}`;
            apellidos+=`${usuario.apellidos}`;
            edad+=`${usuario.edad}`;
            dni+=`${usuario.dni}`;
            tipo+=`${usuario.tipo}`;
            telefono+=`${usuario.telefono}`;
            direccion+=`${usuario.direccion}`;
            correo+=`${usuario.correo}`;
            sexo+=`${usuario.sexo}`;
            extra+=`${usuario.extra}`;
            $('#nombre_us').html(nombre);
            $('#apellidos_us').html(apellidos);
            $('#edad').html(edad);
            $('#dni_us').html(dni);
            $('#us_tipo').html(tipo);
            $('#telefono_us').html(telefono);
            $('#direccion_us').html(direccion);
            $('#correo_us').html(correo);
            $('#sexo_us').html(sexo);
            $('#extra_us').html(extra);
            
        })
    }
    //evento editar
    $(document).on('click','.edit',(e)=>{
        funcion='tomar_datos';
        edit=true;
        $.post('../controlador/UsuarioController.php',{funcion,id_usuario},(response)=>{
            const usuario = JSON.parse(response);
            $('#telefono').val(usuario.telefono);
            $('#direccion').val(usuario.direccion);
            $('#correo').val(usuario.correo);
            $('#sexo').val(usuario.sexo);
            $('#extra').val(usuario.extra);
        })
    });

    //evento enviar
    $('#form-usuario').submit(e=>{
        if(edit==true){
            let telefono=$('#telefono').val();
            let direccion=$('#direccion').val();
            let correo=$('#correo').val();
            let sexo=$('#sexo').val();
            let extra=$('#extra').val();
            funcion='editar_usuario';
            $.post('../controlador/UsuarioController.php',{id_usuario,funcion,telefono,direccion,correo,sexo,extra},(response)=>{
                if(response='editado'){
                    $('#editado').hide('slow');
                    $('#editado').show(1000);
                    $('#editado').hide(2000);
                    $('#form-usuario').trigger('reset');
                }
                edit=false;
                buscar_usuario(id_usuario);
            })
        }else{
                    $('#noeditado').hide('slow');
                    $('#noeditado').show(1000);
                    $('#noeditado').hide(2000);
                    $('#noform-usuario').trigger('reset');
        }
        e.preventDefault();
    })
    
    // Evento actualizar contrasena
    $('#form-pass').submit(e=>{
        let oldpass=$('#oldpass').val();
        let newpass=$('#newpass').val();
        funcion='cambiar_contra';
        $.post('../controlador/UsuarioController.php',{id_usuario,funcion,oldpass,newpass},(response)=>{
            if(response=='update'){
                $('#update').hide('slow');
                    $('#update').show(1000);
                    $('#update').hide(2000);
                    $('#form-pass').trigger('reset');
            }else{
                $('#noupdate').hide('slow');
                    $('#noupdate').show(1000);
                    $('#noupdate').hide(2000);
                    $('#form-pass').trigger('reset');
            }
        })
        e.preventDefault();
    })
})
