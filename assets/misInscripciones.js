$(document).ready(() => {
    if (window.location.pathname == "/mis-inscripciones") {
        $("#tablaInscripciones").hide()
        $(".inscripcion_loader").show()
        $.ajax({
            url: window.location.pathname + "/obtener-inscripciones",
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data != 0) {
                    data.forEach(element => {
                        $("#inscripciones-festivales").append(`<tr id="${element.id}">
                    <th scope="row" id="inscripcion-nombreFestival">${element.fiestas.nombre}</th>
                    <td id="inscripcion-imgFestival"><img src="../uploads/img/${element.fiestas.imagen}" alt="imagen festival" class="imgFest" width="50px" height="50px"></td>
                    <td><a class="config_festivales desinscribirse" id="btn-desinscribirse" data-id="${element.id}"><i class="fa-solid fa-circle-minus"></i></a></td>
                    </tr>`)
                    })
                    borrarInscripcion();
                    $("#tablaInscripciones").show()
                    $(".inscripcion_loader").hide()
                } else {
                    $("#tablaInscripciones").hide();
                    $(".inscripcion_loader").hide()
                    $(".inscripciones").append(`<p class="centrar-texto">No te has suscrito a ningun festival, apuntate al que quieras ;)</p>`)
                }
            },
        })


        function borrarInscripcion() {
            $(".desinscribirse").on("click", (e) => {
                e.preventDefault();
                let idInscripcion = e.currentTarget.getAttribute("data-id");
                $.ajax({
                    url: window.location.pathname + "/borrar-inscripcion",
                    method: "POST",
                    data: {id: idInscripcion},
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            $(`#${idInscripcion}`).remove()
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr["success"]("Te has desuscrito correctamente", "Desuscribirse")
                        }
                    },
                })
            })
        }
    }
})
