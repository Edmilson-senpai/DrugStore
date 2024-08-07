$(document).ready(function(){
    mostrar_consultas();
    function mostrar_consultas(){
        let funcion='mostrar_consultas';
        $.post('../controlador/VentaController.php',{funcion},(response)=>{
            console.log(response);
            const vistas = JSON.parse(response);
            console.log(vistas.venta_anual);
            $('#venta_dia_vendedor').html(vistas.venta_dia_vendedor.toFixed(2));
            $('#venta_diaria').html(vistas.venta_diaria.toFixed(2));
            $('#venta_mensual').html(vistas.venta_mensual.toFixed(2));
            $('#venta_anual').html(vistas.venta_anual.toFixed(2));
        })
    }
    funcion="listar";

    let datatable = $('#tabla_venta').DataTable({
        "ajax": {
            "url": "../controlador/VentaController.php",
            "method": "POST",
            "data": {funcion:funcion}
        },
        "columns": [
            { data: "id_venta" },
            { data: "fecha" },
            { data: "cliente" },
            { data: "dni" },
            { data: "total" },
            { data: "vendedor" },
            { defaultContent: `<button class=" imprimir btn btn-secondary"><i class="fas fa-print"></i></button>
                                <button class="ver btn btn-success" type="button" data-toggle="modal" data-target="#vista_venta"><i class="fas fa-search"></i></button>
                                <button class="borrar btn btn-danger"><i class="fas fa-window-close"></i></button>`}
        ],
        "language": espanol
    } );

    $('#tabla_venta tbody').on('click','.imprimir',function(){
        let datos = datatable.row($(this).parents()).data();
        let id= datos.id_venta;
        $.post('../controlador/PDFController.php',{id},(response)=>{
            console.log(response);
        });
    })

    $('#tabla_venta tbody').on('click','.borrar',function(){
        let datos = datatable.row($(this).parents()).data();
        let id= datos.id_venta;
        funcion ="borrar_venta";
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-1',
                cancelButton: 'btn btn-danger m-1'
            },
            buttonsStyling: false
        })

            swalWithBootstrapButtons.fire({
            title: 'Estas seguro de eliminar la venta: '+id+'?',
            text: "No se podra revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, se eliminará!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                $.post('../controlador/DetalleVentaController.php',{funcion,id},(response)=>{
                    if(response=='delete'){
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'La venta: '+id+' ha sido eliminada correctamente',
                            'success'
                          )
                    }
                    else if(response='nodelete'){
                        swalWithBootstrapButtons.fire(
                            "No se elimino",
                            "No tienes permiso para eliminar esta venta",
                            "error"
                          )
                    }
                })
              
            } else if ( result.dismiss === Swal.DismissReason.cancel) {
              swalWithBootstrapButtons.fire(
                "No se elimino",
                "La venta no se elimino",
                "error"
              )
            }
          });
          
    })


    $('#tabla_venta tbody').on('click','.ver',function(){
        let datos = datatable.row($(this).parents()).data();
        let id= datos.id_venta;
        funcion = "ver";
        $('#codigo_venta').html(datos.id_venta);
        $('#fecha').html(datos.fecha);
        $('#cliente').html(datos.cliente);
        $('#dni').html(datos.dni);
        $('#vendedor').html(datos.vendedor);
        $('#total').html(datos.total);
        $.post('../controlador/VentaProductoController.php',{funcion,id},(response)=>{
            console.log(response);
            let registros = JSON.parse(response);
            let template="";
            $('#registros').html(template);
            registros.forEach(registro => {
                template+=`
                    <tr>
                        <td>${registro.cantidad}</td>
                        <td>${registro.precio}</td>
                        <td>${registro.producto}</td>
                        <td>${registro.descripcion}</td>
                        <td>${registro.adicional}</td>
                        <td>${registro.laboratorio}</td>
                        <td>${registro.presentacion}</td>
                        <td>${registro.tipo}</td>
                        <td>${registro.subtotal}</td>

                    </tr>
                `;
                $('#registros').html(template);
            });
        })
    })
})
    /*new DataTable('#tabla_venta', {
        ajax: {
            "url": "../controlador/VentaController.php",
            "method": "POST",
            "data":{funcion:funcion}
        },
        columns: [
            { data: 'id_venta' },
            { data: 'fecha' },
            { data: 'cliente' },
            { data: 'dni' },
            { data: 'total' },
            { data: 'vendedor' }
        ]
    });*/

let espanol = {
    "aria": {
        "sortAscending": "Activar para ordenar la columna de manera ascendente",
        "sortDescending": "Activar para ordenar la columna de manera descendente"
    },
    "autoFill": {
        "cancel": "Cancelar",
        "fill": "Rellene todas las celdas con <i>%d<\/i>",
        "fillHorizontal": "Rellenar celdas horizontalmente",
        "fillVertical": "Rellenar celdas verticalmente"
    },
    "buttons": {
        "collection": "Colección",
        "colvis": "Visibilidad",
        "colvisRestore": "Restaurar visibilidad",
        "copy": "Copiar",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %d fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir",
        "createState": "Crear Estado",
        "removeAllStates": "Borrar Todos los Estados",
        "removeState": "Borrar Estado",
        "renameState": "Renombrar Estado",
        "savedStates": "Guardar Estado",
        "stateRestore": "Restaurar Estado",
        "updateState": "Actualizar Estado"
    },
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "processing": "Procesando...",
    "search": "Buscar:",
    "searchBuilder": {
        "add": "Añadir condición",
        "button": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condición",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangría",
        "title": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "value": "Valor",
        "conditions": {
            "date": {
                "after": "Después",
                "before": "Antes",
                "between": "Entre",
                "empty": "Vacío",
                "equals": "Igual a",
                "not": "Diferente de",
                "notBetween": "No entre",
                "notEmpty": "No vacío"
            },
            "number": {
                "between": "Entre",
                "empty": "Vacío",
                "equals": "Igual a",
                "gt": "Mayor a",
                "gte": "Mayor o igual a",
                "lt": "Menor que",
                "lte": "Menor o igual a",
                "not": "Diferente de",
                "notBetween": "No entre",
                "notEmpty": "No vacío"
            },
            "string": {
                "contains": "Contiene",
                "empty": "Vacío",
                "endsWith": "Termina con",
                "equals": "Igual a",
                "not": "Diferente de",
                "startsWith": "Inicia con",
                "notEmpty": "No vacío",
                "notContains": "No Contiene",
                "notEndsWith": "No Termina",
                "notStartsWith": "No Comienza"
            },
            "array": {
                "equals": "Igual a",
                "empty": "Vacío",
                "contains": "Contiene",
                "not": "Diferente",
                "notEmpty": "No vacío",
                "without": "Sin"
            }
        },
        "data": "Datos"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de búsqueda",
            "_": "Paneles de búsqueda (%d)"
        },
        "count": "{total}",
        "emptyPanes": "Sin paneles de búsqueda",
        "loadMessage": "Cargando paneles de búsqueda",
        "title": "Filtros Activos - %d",
        "countFiltered": "{shown} ({total})",
        "collapseMessage": "Colapsar",
        "showMessage": "Mostrar Todo"
    },
    "select": {
        "cells": {
            "1": "1 celda seleccionada",
            "_": "%d celdas seleccionadas"
        },
        "columns": {
            "1": "1 columna seleccionada",
            "_": "%d columnas seleccionadas"
        },
        "rows": {
            "1": "1 fila seleccionada",
            "_": "%d filas seleccionadas"
        }
    },
    "thousands": ",",
    "datetime": {
        "previous": "Anterior",
        "hours": "Horas",
        "minutes": "Minutos",
        "seconds": "Segundos",
        "unknown": "-",
        "amPm": [
            "am",
            "pm"
        ],
        "next": "Siguiente",
        "months": {
            "0": "Enero",
            "1": "Febrero",
            "10": "Noviembre",
            "11": "Diciembre",
            "2": "Marzo",
            "3": "Abril",
            "4": "Mayo",
            "5": "Junio",
            "6": "Julio",
            "7": "Agosto",
            "8": "Septiembre",
            "9": "Octubre"
        },
        "weekdays": [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado"
        ]
    },
    "editor": {
        "close": "Cerrar",
        "create": {
            "button": "Nuevo",
            "title": "Crear Nuevo Registro",
            "submit": "Crear"
        },
        "edit": {
            "button": "Editar",
            "title": "Editar Registro",
            "submit": "Actualizar"
        },
        "remove": {
            "button": "Eliminar",
            "title": "Eliminar Registro",
            "submit": "Eliminar",
            "confirm": {
                "_": "¿Está seguro que desea eliminar %d filas?",
                "1": "¿Está seguro que desea eliminar 1 fila?"
            }
        },
        "multi": {
            "title": "Múltiples Valores",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, haga click o toque aquí, de lo contrario conservarán sus valores individuales."
        },
        "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\"> Más información<\/a>)."
        }
    },
    "decimal": ".",
    "emptyTable": "No hay datos disponibles en la tabla",
    "zeroRecords": "No se encontraron coincidencias",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
    "infoFiltered": "(Filtrado de _MAX_ total de entradas)",
    "lengthMenu": "Mostrar _MENU_ entradas",
    "stateRestore": {
        "removeTitle": "Eliminar",
        "creationModal": {
            "search": "Buscar",
            "button": "Crear",
            "columns": {
                "search": "Columna de búsqueda",
                "visible": "Columna de visibilidad"
            },
            "name": "Nombre:",
            "order": "Ordenar",
            "paging": "Paginar",
            "scroller": "Posición de desplazamiento",
            "searchBuilder": "Creador de búsquedas",
            "select": "Selector",
            "title": "Crear nuevo",
            "toggleLabel": "Incluye:"
        },
        "duplicateError": "Ya existe un valor con el mismo nombre",
        "emptyError": "No puede ser vacío",
        "emptyStates": "No se han guardado",
        "removeConfirm": "Esta seguro de eliminar %s?",
        "removeError": "Fallo al eliminar",
        "removeJoiner": "y",
        "removeSubmit": "Eliminar",
        "renameButton": "Renombrar",
        "renameLabel": "Nuevo nombre para %s:",
        "renameTitle": "Renombrar"
    },
    "infoEmpty": "No hay datos para mostrar"
};