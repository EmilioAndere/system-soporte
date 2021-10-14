
    function vaciar(){
        $("#name").text('Nuevo Equipo');
        $("#device").val('');
        $("#serial").val('');
        $("#ip").val('');
        $("#marca").val('0');
        $("#disco").val('0');
        $("#ram").val('0');
        $("#pantalla").val('0');
        $("#compra").val('');
        $("#equipo_id").val('0');
        $("#categoria").val('0');
    }
    
    function getEquipo(){
        let formulario = {
            name: $("#device").val(),
            serial: $("#serial").val(),
            ip: $("#ip").val(),
            fecha: $("#compra").val(),
            marca: $("#marca").val(),
            categoria: $("#categoria").val(),
            ram: $("#ram").val(),
            disco: $("#disco").val(),
            pantalla: $("#pantalla").val(),
        }
        return formulario;
    }

    function table(){
        var table = $("#equipos")[0].children;
        for (let index = 0; index < table.length; index++) {
            if((index % 2) == 0){
                table.item(index).classList.add('bg-gray-300','text-white', 'hover:bg-blue-200', 'hover:text-black');
            }else{
                table.item(index).classList.add('hover:bg-blue-200', 'hover:text-white');
            }
        }
        $("tr").click(function(){
            let equipo_id = this.children.item(0).textContent;
            fetch('/get/equipo/'+equipo_id)
            .then(res => res.json())
            .then(data => {
                $("#name").text('Equipo: '+data[0].nombre);
                $("#device").val(data[0].nombre);
                $("#serial").val(data[0].serial);
                $("#ip").val(data[0].ip_equipo);
                $("#marca").val(data[0].marca_id);
                $("#disco").val(data[0].disco_id);
                $("#ram").val(data[0].ram_id);
                $("#pantalla").val(data[0].pantalla_id);
                $("#compra").val(data[0].fecha_compra);
                $("#equipo_id").val(data[0].equipo_id);
                $("#categoria").val(data[0].categoria_id);
                if(data[0].empleado_id === null){
                    $('#empleado').val('Sin Asignar');
                    $("#detail").addClass("hidden")
                    $("#accion").text('Asignar');
                    $("#accion").addClass('bg-green-400')
                }else{
                    $("#accion").text('Quitar Equipo');
                    $("#detail").removeClass("hidden")
                    $("#accion").addClass('bg-yellow-400')
                    fetch('/get/empleado/'+data[0].empleado_id)
                    .then(res => res.json())
                    .then(data => {
                        $('#empleado').val(data[0].nombre);
                        $('#empleado_id').val(data[0].empleado_id);
                    })
                }
            })
            $('#modal').removeClass('hidden');
            $('#modal').addClass('modal');
        })
    }

    fetch('/get/devices')
    .then(res => res.json())
    .then(data => {
        data.forEach(el => {
            $("#equipos").append('<tr class="text-center"><td class="cursor-pointer">'+el.equipo_id+'</td><td class="cursor-pointer">'+el.marca+'</td><td class="cursor-pointer">'+el.nombre+'</td><td class="cursor-pointer">'+el.ip+'</td><td class="cursor-pointer">'+el.fecha_compra+'</td></tr>');
            
        })
        table();
        
    });

    $("#search-eq").keyup(function(){
        let search = $("#search-eq").val()
        if(search == ''){
            $("#equipos").html(' ')
            fetch('/get/devices')
            .then(res => res.json())
            .then(data => {
                data.forEach(el => {
                    $("#equipos").append('<tr class="text-center"><td class="cursor-pointer">'+el.equipo_id+'</td><td class="cursor-pointer">'+el.marca+'</td><td class="cursor-pointer">'+el.nombre+'</td><td class="cursor-pointer">'+el.ip+'</td><td class="cursor-pointer">'+el.fecha_compra+'</td></tr>')
                })
                table()
            })
        }else{
            
            fetch('/get/eq/'+search)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                $("#equipos").html(' ')
                data.forEach(el => {
                    
                    $("#equipos").append('<tr class="text-center"><td class="cursor-pointer">'+el.equipo_id+'</td><td class="cursor-pointer">'+el.marca+'</td><td class="cursor-pointer">'+el.nombre+'</td><td class="cursor-pointer">'+el.ip_equipo+'</td><td class="cursor-pointer">'+el.fecha_compra+'</td></tr>')
                })
                table();
            })
        }
    })

    $(document).click(function(event){

        if(event.target.id == 'modal'){
            $("#modal").removeClass('modal');
            $("#modal").addClass('hidden');
        }

    })

    $(document).ready(function(){
        fetch('/get/marca')
        .then(res => res.json())
        .then(data => {
            data.forEach(el => {
                $("#marca").append('<option value="'+el.marca_id+'">'+el.nombre+'</option>')
            })
        })
        fetch('/get/disco')
        .then(res => res.json())
        .then(data => {
            data.forEach(el => {
                $("#disco").append('<option value="'+el.disco_id+'">'+el.tipo+' - '+el.capacidad+' '+el.medida+'</option>')
            })
        })
        fetch('/get/ram')
        .then(res => res.json())
        .then(data => {
            data.forEach(el => {
                $("#ram").append('<option value="'+el.ram_id+'">'+el.tipo+' - '+el.capacidad+' '+el.medida+'</option>')
            })
        })
        fetch('/get/pantalla')
        .then(res => res.json())
        .then(data => {
            data.forEach(el => {
                $("#pantalla").append('<option value="'+el.pantalla_id+'">'+el.tipo+' - '+el.tamano+'</option>')
            })
        })
        fetch('/get/categoria')
        .then(res => res.json())
        .then(data => {
            data.forEach(el => {
                $("#categoria").append('<option value="'+el.categoria_id+'">'+el.nombre+'</option>')
            })
        })
        fetch('/get/stock')
        .then(res => res.json())
        .then(data => {
            $("#Stock").text(data[0].stock);
        })
        fetch('/get/asign')
        .then(res => res.json())
        .then(data => {
            $("#Asignados").text(data[0].stock);
        })
    })

    $("#btn-edit").click(function(){
        document.getElementById("btn-save").disabled = false
    })

    $("#btn-cancel").click(function(){
        $("#modal").removeClass('modal');
        $("#modal").addClass('hidden');
    })

    function showAlert(msg, state = true){
        let icon = state ? 'success' : 'error'; 
        Swal.fire({
            position: 'top-end',
            icon: icon,
            title: msg,
            showConfirmButton: false,
            timer: 2000
        })
        setTimeout(() => {
            $(location).attr('href', '/devices');
        },2000);
    }

    $("#btn-save").click(function(){
        let formulario = {
            name: $("#device").val(),
            serial: $("#serial").val(),
            ip: $("#ip").val(),
            fecha: $("#compra").val(),
            marca: $("#marca").val(),
            categoria: $("#categoria").val(),
            ram: $("#ram").val(),
            disco: $("#disco").val(),
            pantalla: $("#pantalla").val(),
        }
        let post = $.post('/up/equipo/'+$("#equipo_id").val(), formulario);

        post.done(function( data ) {
           if(data > 0){
                showAlert('Las modificaciones han sido aplicadas');
           }else{
                showAlert('Error al realizar la actualizacion', false);
           }
        });
    })

    $("#btn-delete").click(function(){
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'bg-green-500 rounded-md mx-2 p-2 text-white',
            cancelButton: 'bg-red-500 rounded-md mx-2 p-2 text-white'
        },
        buttonsStyling: false
        })
        
        swalWithBootstrapButtons.fire({
        title: 'Estas Seguro?',
        text: "No podras revertir esta accion",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, Cancelar!',
        reverseButtons: true
        }).then((result) => {
            if(result.isConfirmed){
                let id = $("#equipo_id").val();
                fetch('/del/equipo/'+id, {
                    method: 'POST'
                }).then(res => res.json())
                .then(data => {
                    if(data.rows > 0){
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El equipo ha sido eliminado.',
                            'success'
                        )
                        setTimeout(() => {
                            $(location).attr('href', '/devices')
                        }, 2000);
                    }else{
                        swalWithBootstrapButtons.fire(
                            'Error',
                            'Ha ocurrido un error al eliminarlo)',
                            'error'
                        )
                    }
                })
            }else if(result.dismiss === Swal.DismissReason.cancel){
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Has cancelado la accion',
                    'error'
                )
            }
        })
    })

    $("#detail").click(function(event){
        event.preventDefault();
        $('#modal-empleado').removeClass('hidden');
        $('#modal-empleado').addClass('modal');
        fetch('/get/empleado/'+$("#empleado_id").val())
        .then(res => res.json())
        .then(data => {
            $("#name-emp").text(data[0].nombre)
            $("#puesto").text(data[0].puesto)
            $("#telefono").text(data[0].telefono)
            $("#mail").text(data[0].mail)
            $("#pic-empleado").attr('src', data[0].imagen)
            fetch('/get/sede/'+data[0].sede_id)
            .then(res => res.json())
            .then(data => {
                $("#sede").text(data[0].nombre)
            })
            fetch('/get/ubicacion/'+data[0].ubicacion_id)
            .then(res => res.json())
            .then(data => {
                $("#departamento").text(data[0].nombre)
            })
        })
    })

    $("#cancel").click(function(){
        $("#modal-empleado").removeClass('modal');
        $("#modal-empleado").addClass('hidden');
    })

    $("#accion").click(function(e){
        e.preventDefault();
        let action = $("#accion").text();
        let id = $("#equipo_id").val();
        if(action != 'Asignar'){
            fetch('/up/change/'+id, { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if(data.affect > 0){
                    showAlert('El equipo ya no esta asignado');
                }else{
                    showAlert('Error', false);
                }
            })
        }else{
            $('#new-empleado').removeClass('hidden');
            $('#new-empleado').addClass('modal');
            $("#list-emp").html(' ')
            fetch('/get/empleado')
            .then(res => res.json())
            .then(data => {
                data.forEach(el => {
                    $("#list-emp").append('<li class="hover:bg-gray-100 rounded-full my-2 px-2 cursor-pointer"><span>'+el.empleado_id+'</span> - '+el.nombre+' - '+el.puesto+'</li>')
                })
                $("#list-emp > li").each((index, el) => {
                    el.addEventListener('click', function(e){
                        let id_emp = e.srcElement.children[0].textContent
                        let id = $("#equipo_id").val();
                        let post = $.post('/up/change/'+id, { emp_id: id_emp });

                        post.done(function( data ) {
                            let resp = JSON.parse(data);
                            if(resp.affect > 0){
                                showAlert('El equipo ha sido asignado');
                            }else{
                                showAlert('Error', false);
                            }
                        });
                    })
                })
            })
        }
    })

    $("#search-emp").keyup(function(){
        let search = $("#search-emp").val()
        if(search == ''){
            $("#list-emp").html(' ')
            fetch('/get/empleado')
            .then(res => res.json())
            .then(data => {
                data.forEach(el => {
                    $("#list-emp").append('<li class="hover:bg-gray-100 rounded-full my-2 px-2 cursor-pointer"><span class="hidden">'+el.empleado_id+'</span>'+el.nombre+' - '+el.puesto+'</li>')
                })
            })
        }else{
            $("#list-emp").html(' ')
            fetch('/get/emp/'+search)
            .then(res => res.json())
            .then(data => {
                console.log(data)
                data.forEach(el => {
                    // console.log(el.nombre)
                    $("#list-emp").append('<li class="hover:bg-gray-100 rounded-full my-2 px-2 cursor-pointer"><span class="hidden">'+el.empleado_id+'</span>'+el.nombre+' - '+el.puesto+'</li>')
                })
            })
        }
    })

    $("#cancel-new").click(function(){
        $("#new-empleado").removeClass('modal');
        $("#new-empleado").addClass('hidden');
    })

    $("#new-eq").click(function(){
        vaciar();
        $("#modal").removeClass('hidden');
        $("#modal").addClass('modal');
        $("#asignado").addClass('hidden');
        $("#detail").addClass('hidden');
        $("#btn-delete").addClass('hidden');
        $("#btn-cancel").addClass('hidden');
        $("#btn-save").addClass('hidden');
        $("#btn-new").removeClass('hidden');
    })

    $("#btn-new").click(function(){
        let equipo = getEquipo();
        let post = $.post('/up/equipo/'+$("#equipo_id").val(), equipo);

        post.done(function( data ) {
            // console.log(typeof(data))
            showAlert('Se ha registrado el dispositivo numero '+data);
        });
    })

    
