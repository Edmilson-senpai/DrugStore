$(document).ready(function(){
    calcularTotal();
    contar_prod();
    RecuperarLocalStorageCarritoCompra()
    RecuperarLocalStorageCarrito();
    $(document).on('click','.agregar-carrito',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('prodId');
        const nombre = $(elemento).attr('prodNombre');
        const descripcion = $(elemento).attr('prodDescripcion');
        const adicional = $(elemento).attr('prodAdicional');
        const precio = $(elemento).attr('prodPrecio');
        const laboratorio = $(elemento).attr('prodLaboratorio');
        const tipo = $(elemento).attr('prodTipo');
        const presentacion = $(elemento).attr('prodPresentacion');
        const avatar=$(elemento).attr('prodAvatar');
        const stock=$(elemento).attr('prodStock');

        const producto = {
            id: id,
            nombre: nombre,
            descripcion: descripcion,
            adicional: adicional,
            precio: precio,
            laboratorio: laboratorio,
            tipo: tipo,
            presentacion: presentacion,
            avatar: avatar,
            stock: stock,
            cantidad: 1
        }
        let id_producto;
        let productos;
        productos = RecuperarLocalStorage();
        productos.forEach(prod => {
            if(prod.id===producto.id){
                id_producto=prod.id;
            }
        });
        if(id_producto === producto.id){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: producto.nombre+" ya está en el carrito de compras",
              });
        }else{
            Swal.fire({
                title: "Hecho!",
                text: "Producto agregado al carrito!",
                icon: "success"
              });
            template=`
            <tr prodId="${producto.id}">
                <td>${producto.id}</td>
                <td>${producto.nombre}</td>
                <td>${producto.descripcion}</td>
                <td>${producto.adicional}</td>
                <td>${producto.precio}</td>
                <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
            </tr>
        `;
        $('#lista').append(template);
        AgregarLocalStorage(producto);
        let contador;
        contar_prod();
        }
    })

    $(document).on('click','.borrar-producto',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('prodId');
        elemento.remove(); 
        EliminarProductoLocalStorage(id);
        contar_prod();
        calcularTotal();

    })

    $(document).on('click','#vaciar-carrito',(e)=>{
        $('#lista').empty();
        EliminarLocalStorage();
        contar_prod();  
    })

    $(document).on('click','#procesar-pedido',(e)=>{
        ProcesarPedido();
    })

    $(document).on('click','#procesar-compra',(e)=>{
        Procesar_compra();
    })

    function RecuperarLocalStorage(){
        let productos;
        if(localStorage.getItem('productos')===null){ /*comparacion estricta ve que sean iguales y del mismo tipo*/
            productos=[];
        }else{
            productos=JSON.parse(localStorage.getItem('productos'));
        }
        return productos
    }
    function AgregarLocalStorage(producto){
        let productos;
        productos = RecuperarLocalStorage();
        productos.push(producto);
        localStorage.setItem('productos',JSON.stringify(productos));
    }
    function RecuperarLocalStorageCarrito(){
        let productos;
        productos = RecuperarLocalStorage();
        funcion = "buscar_id";
        productos.forEach(producto => {
            id_producto=producto.id;
            $.post('../controlador/ProductoController.php',{funcion,id_producto},(response)=>{
                let template_Carrito='';
                let json = JSON.parse(response);
                template_Carrito=`
                                    <tr prodId="${json.id}">
                                        <td>${json.id}</td>
                                        <td>${json.nombre}</td>
                                        <td>${json.descripcion}</td>
                                        <td>${json.adicional}</td>
                                        <td>${json.precio}</td>
                                        <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                                    </tr>
                `;
                $('#lista').append(template_Carrito);
            })
        });
    }

    function EliminarProductoLocalStorage(id){
        let productos;
        productos=RecuperarLocalStorage();
        productos.forEach(function(producto,indice){
            if(producto.id===id){
                productos.splice(producto,1);
            }
        });
        localStorage.setItem('productos',JSON.stringify(productos));
    }
    function EliminarLocalStorage(){
        localStorage.clear();
    }

    function contar_prod(){
        let productos;
        let contador = 0;
        productos=RecuperarLocalStorage();
        productos.forEach(producto=>{
            contador++;
        });
        $('#contador').html(contador);
    }

    function ProcesarPedido(){
        let productos;
        productos = RecuperarLocalStorage();
        if (productos.length === 0){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Debes agregar productos al carrito de compra"
                });
        }else{
            location.href = '../vista/tec_compra.php';
        }
    }

    function RecuperarLocalStorageCarritoCompra(){
        let productos,id_producto;
        productos = RecuperarLocalStorage();
        funcion = "buscar_id";
        productos.forEach(producto => {
            id_producto=producto.id;
            $.post('../controlador/ProductoController.php',{funcion,id_producto},(response)=>{
                let template_compra='';
                let json = JSON.parse(response);
                template_compra=`
                                    <tr prodId="${producto.id}" prodPrecio="${json.precio}">
                                        <td>${json.nombre}</td>
                                        <td>${json.stock}</td>
                                        <td>${json.precio}</td>
                                        <td>${json.descripcion}</td>
                                        <td>${json.adicional}</td>
                                        <td>${json.laboratorio}</td>
                                        <td>${json.presentacion}</td>
                                        <td>
                                            <input type="number" min="1" class="form-control cantidad_producto" value="${producto.cantidad}">
                                        </td>
                                        <td class="subtotales">
                                            <h5>${(json.precio * producto.cantidad).toFixed(2)}</h5>
                                        </td>

                                        <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                                    </tr>
                `;
                $('#lista-compra').append(template_compra);
            })
        });
    }
    $(document).on('click','#actualizar',(e)=>{
        let productos,precios;
        precios=document.querySelectorAll('.precio');
        productos=RecuperarLocalStorage();
        productos.forEach(function(producto, indice){
            producto.precio = precios[indice].textContent;
        });
        localStorage.setItem('productos',JSON.stringify(productos));
        calcularTotal();
    })
    $('#cp').on('input',(e)=>{
        let id,cantidad,producto,productos,montos,precio;
        producto = $(this)[0].activeElement.parentElement.parentElement;
        id=$(producto).attr('prodId');
        precio=$(producto).attr('prodPrecio');
        cantidad = producto.querySelector('input').value;
        montos = document.querySelectorAll('.subtotales');
        productos = RecuperarLocalStorage();
        productos.forEach(function(prod,indice){
            if (prod.id === id) {
                prod.cantidad = cantidad;
                prod.precio = precio;
                montos[indice].innerHTML = `<h5>${(cantidad * productos[indice].precio).toFixed(2)}</h5>`;
            }
        });
        localStorage.setItem('productos',JSON.stringify(productos));
        calcularTotal();
    })
    function calcularTotal(){
        let productos, subtotal, con_igv, total_sin_descuento,pago,vuelto,descuento;
        let total=0,igv=0.18;
        productos = RecuperarLocalStorage();
        productos.forEach(producto=>{
            let subtotal_producto = Number(producto.precio * producto.cantidad);
            total = total+subtotal_producto;
        });
        pago=$('#pago').val();
        descuento=$('#descuento').val();

        total_sin_descuento=total.toFixed(2);
        con_igv=parseFloat(total*igv).toFixed(2);
        subtotal=(total-con_igv).toFixed(2);

        total = total - descuento;
        vuelto=pago-total;

        $('#subtotal').html(subtotal);
        $('#con_igv').html(con_igv);
        $('#total_sin_descuento').html(total_sin_descuento);
        $('#total').html(total.toFixed(2));
        $('#vuelto').html(vuelto.toFixed(2));
    }

    function Procesar_compra(){
        let nombre,dni;
        nombre = $('#cliente').val();
        dni=$('#dni').val();
        if (RecuperarLocalStorage().length === 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No hay productos, Seleccione algunos'
            }).then(function(){
                location.href = '../vista/adm_catalogo.php'
            })
        }else if (nombre==''){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                footer: 'Datos del cliente incompletos'
            })
        }
        else{
            Verificar_stock().then(error=>{
                if(error==0){
                    Registrar_compra(nombre,dni);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se realizo la compra',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function(){
                        EliminarLocalStorage();
                        location.href = '../vista/adm_catalogo.php'
                    })
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: 'Stock incompleto en algun producto'
                    })
                }
            });
            
        }
    }

    async function Verificar_stock() {
        let productos;
        funcion='verificar_stock';
        productos=RecuperarLocalStorage();
        const response = await fetch('../controlador/ProductoController.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion+'&&productos='+JSON.stringify(productos)
        })
        let error = await response.text();

        return error;
    }

    function Registrar_compra(nombre,dni){
        funcion='registrar_compra';
        let total=$('#total').get(0).textContent;
        let productos=RecuperarLocalStorage();
        let json = JSON.stringify(productos);
        $.post('../controlador/CompraController.php',{funcion,total,nombre,dni,json},(response)=>{
            console.log(response);
        });
    }
})