let date = new Date();
let state = $('#switch');
let sw = $("#sw-btn");
let check = $("#check");
let espera = $("#ch-espera");

function formatDate(fecha, formato){
    let date = formato.replace('yyyy', fecha.getFullYear())
    .replace('mm', fecha.getMonth()+1)
    .replace('dd', fecha.getDate())
    .replace('HH', fecha.getHours())
    .replace('MM', fecha.getMinutes())
    .replace('SS', fecha.getSeconds())
    return date
}

sw.click(function(){
    let id = $("#serv").text();
    let pet;
    if(state.hasClass('justify-start')){
        state.removeClass('bg-green-500');
        state.addClass('bg-red-500');
        state.removeClass('justify-start');
        state.addClass('justify-end');
        check.addClass('hidden');
        pet = $.post('/up/change/state/'+id, {estado: 'Cerrado', fin: formatDate(date, 'yyyy/mm/dd HH:MM:SS')});
    }else{
        if(state.hasClass('justify-end')){
            state.removeClass('bg-red-500');
            state.addClass('bg-green-500');
            state.addClass('justify-start');
            state.removeClass('justify-end');
            check.removeClass('hidden');
            pet = $.post('/up/change/state/'+id, {estado: 'Abierto'});
        }
    }

    pet.done(function(data){
        location.reload();
    })
})

espera.change(function(e){
    let id = $("#serv").text();
    let estado = "";
    if($(this).is(':checked')){
        estado = "Espera";
    }else{
        estado = "Abierto";
    }
    let change = $.post('/up/change/state/'+id, {estado: estado} );
    change.done(function(data){
        location.reload()
    })
})

let asign = $("#btn-asign");
let list_user = $("#list-users");
let users = $("#users");

asign.click(function(){
    if(list_user.hasClass('hidden')){
        list_user.removeClass("hidden")
        users.html('')
        fetch('/get/users')
        .then(res => res.json())
        .then(data => {
            data.forEach(el => {
                users.append(`
                    <li class="flex items-center hover:bg-gray-300 px-3 py-1 cursor-pointer">
                        <span class="hidden">`+el.usuario_id+`</span>
                        <img src="http://router.host/img/`+el.imagen+`" class="w-10 h-10 rounded-full" />
                        <p class="mx-3">`+el.nombre+`</p>
                    </li>
                `)
            })

            $("#users > li").each((index, el) => {
                $(el).click(function(){
                    let user_id = this.children[0].textContent
                    let id = $("#serv").text()
                    console.log(id)
                    let change = $.post('/up/change/support/'+id, {user: user_id});
                    change.done(function(data){
                        location.reload();
                    })
                })
            })
        })
    }else{
        if(!list_user.hasClass('hidden')){
            list_user.addClass("hidden")
        }
    }
})

$("#clean").click(function(){
    $("#estado").val('all');
    $("#prioridad").val('all');
    location.href = '/services';
})

$("#filtre").click(function(){

    let estado = $("#estado").val();
    let prioridad = $("#prioridad").val();

    location.href = '/filter/serv/'+estado+'/'+prioridad;

})

$("#new-serv").click(function(){
    $("#mod-serv").removeClass('hidden');
    $("#mod-serv").addClass('modal');
})

$("#close-serv").click(function(){
    $("#mod-serv").removeClass('modal');
    $("#mod-serv").addClass('hidden');
})

$(document).ready(function(){
    fetch('/get/devices')
    .then(res => res.json())
    .then(data => {
        data.forEach(el => {
            $("#disp").append(`
                <option value="`+el.equipo_id+`">`+el.nombre+`</option>
            `)
        })
    })

    fetch('/get/users')
    .then(res => res.json())
    .then(data => {
        data.forEach(el => {
            $("#user").append(`
                <option value="`+el.usuario_id+`">`+el.nombre+`</option>
            `)
        })
    })
})

function createServ(){

    let serv = {
        descripcion: $("#desc").val(),
        servicio: $("#service-m").val(),
        prioridad: $("#prio").val(),
        estado: 'Abierto',
        fecha: formatDate(date, 'yyyy/mm/dd HH:MM:SS'),
        equipo: $("#disp").val(),
        user: $("#user").val()
    }

    return serv;

}

$("#save-serv").click(function(){
    let serv = createServ();
    let add = $.post('/services', serv);

    add.done(function(data){
        location.reload();
    })
})