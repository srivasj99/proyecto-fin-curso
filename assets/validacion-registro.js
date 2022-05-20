$(document).ready(() => {
    $("#nombre_usuario").change(() => {
        if ($("#nombre_usuario").val() == "") {
            $("#nombre_usuario").siblings(".texto-obligatorio").css("display", "block")
            $("#nombre_usuario").css('border', 'red 2px solid');
            $("#cruz").css('display', 'none');
        } else {
            $("#nombre_usuario").siblings(".texto-obligatorio").css("display", "none")
            $.ajax({
                url: window.location.pathname + "/usuarios",
                method: "POST",
                data: {usuario: $("#nombre_usuario").val()},
                success: function (data) {
                    if (data.resultado) {
                        $("#nombre_usuario").css('border', 'red 2px solid');
                        $("#tick").css('display', 'inline');
                    } else {
                        $("#nombre_usuario").css('border', 'green 2px solid');
                        $("#cruz").css('display', 'inline');
                    }
                },

                dataType: "json",
                beforeSend: function () {
                    $("#cruz").css('display', 'none');
                    $("#tick").css('display', 'none');
                    $("#preloader").css('display', 'inline');
                },
                complete: function () {
                    $("#preloader").css('display', 'none');
                }
            })
        }
    })

    $("#email").change(() => {
        if ($("#email").val() == "") {
            $("#email").siblings(".texto-obligatorio").css("display", "block")
            $("#email").css('border', 'red 2px solid');
            $("#email").siblings("#cruz").css('display', 'none');
        } else {
            $("#email").siblings(".texto-obligatorio").css("display", "none")
            $.ajax({
                url: window.location.pathname + "/email",
                method: "POST",
                data: {email: $("#email").val()},
                success: function (data) {
                    if (data.resultado) {
                        $("#email").css('border', 'red 2px solid');
                        $("#email").siblings("#tick").css('display', 'inline');
                    } else {
                        $("#email").css('border', 'green 2px solid');
                        $("#email").siblings("#cruz").css('display', 'inline');
                    }
                },
                dataType: "json",
                beforeSend: function () {
                    $("#email").siblings("#cruz").css('display', 'none');
                    $("#email").siblings("#tick").css('display', 'none');
                    $("#email").siblings("#preloader").css('display', 'inline');
                },
                complete: function () {
                    $("#email").siblings("#preloader").css('display', 'none');
                }
            })
        }
    })

    $("#nombre").change(() => {
        if ($("#nombre").val() == "") {
            $("#nombre").siblings(".texto-obligatorio").css("display", "block")
            $("#nombre").css('border', 'red 2px solid');
        } else {
            $("#nombre").css('border', '#E1E1E1 1px solid');
            $("#nombre").siblings(".texto-obligatorio").css("display", "none")
        }
    })

    $("#apellidos").change(() => {
        if ($("#apellidos").val() == "") {
            $("#apellidos").siblings(".texto-obligatorio").css("display", "block")
            $("#apellidos").css('border', 'red 2px solid');
        } else {
            $("#apellidos").css('border', '#E1E1E1 1px solid');
            $("#apellidos").siblings(".texto-obligatorio").css("display", "none")
        }
    })

    $("#telefono").change(() => {
        if ($("#telefono").val() == "") {
            $("#telefono").siblings(".texto-obligatorio").css("display", "block")
            $("#telefono").css('border', 'red 2px solid');
        } else {
            $("#telefono").css('border', '#E1E1E1 1px solid');
            $("#telefono").siblings(".texto-obligatorio").css("display", "none")
        }
    })

    $("#contrasena").change(() => {
        if ($("#contrasena").val() == "") {
            $("#contrasena").siblings(".texto-obligatorio").css("display", "block")
            $("#contrasena").css('border', 'red 2px solid');
        } else {
            $("#contrasena").css('border', '#E1E1E1 1px solid');
            $("#contrasena").siblings(".texto-obligatorio").css("display", "none")
        }
    })


    $('#acepto_condiciones').change(() => {
        if ($('#acepto_condiciones').is(':checked')) {
            $("#acepto_condiciones").siblings(".texto-obligatorio").css("display", "none")
        }else{
            $("#acepto_condiciones").siblings(".texto-obligatorio").css("display", "block")
        }
    })
})