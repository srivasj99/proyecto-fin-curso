$(document).ready(() => {
    $("#btn-inscribirse").on("click", (e) => {
        e.preventDefault();
        let idFestival = e.currentTarget.getAttribute("data-id")
        $.ajax({
            url: "/inscribirse",
            method: "POST",
            data: {id: idFestival},
            success: function (data) {
                if(data.resultado){
                    $(".contenedor-festival").find("#btn-inscribirse").remove();
                    $(".contenedor-festival").append(`<a class="boton boton--secundario" id="inscrito">Ya estas suscrito <i class="fa-solid fa-circle-check"></i></a>`)
                }
            },
        })
    })
})