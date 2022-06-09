$(document).ready(() => {
    editar()
    borrar()
    const openModal = $(".openModal");
    const openModalEditar = $(".openModalEditar");
    const modal = $('.modal');
    const modalEdit = $('.modalEditar');
    const closeModal = $('.modal__close');
    let idSeleccionado = "";
    openModal.on("click", (e) => {
        e.preventDefault();
        modal.addClass('modal--show');
    })

    closeModal.on("click", (e) => {
        e.preventDefault();
        modal.removeClass('modal--show');
        modalEdit.removeClass('modal--show--editar');
    })

    /** INSERTAR FESTIVALES **/
    $("#btn-anadir").on("click", (e) => {
        e.preventDefault();
        let fichero = $("#imagenFestival")[0].files[0];
        let nombreFestival = $("#nombreFestival").val();
        let datos = new FormData();

        datos.append('imagen', fichero);
        datos.append('nombreFestival', nombreFestival);
        $.ajax({
            url: window.location.pathname + "/insertar",
            method: "POST",
            data: datos,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (data) {
                if (data[0].resultado) {
                    $("#festivales").append(`
                        <tr id="${data[1].id}">
                            <th scope="row">${data[1].id}</th>
                            <td class="nombreFest">${data[1].nombre}</td>
                            <td><img src="../uploads/img/${data[1].imagen}" alt="imagen festival" width="50px" height="50px" class="imgFest"></td>
                            <td><a class="config_festivales openModalEditar" data-id="${data[1].id}"><i class="fa-solid fa-pencil"></i></a><a class="config_festivales borrar" data-id="${data[1].id}"><i class="fa-solid fa-trash"></i></a></td>
                        </tr>`);
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
                    toastr["success"]("Festival insertado correctamente", "Insertar")
                     editar();
                     borrar();
                } else {
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
                    toastr["error"]("Hubo un error al insertar", "Insertar")
                }
            },
            beforeSend: function () {
                openModal.on("click", (e) => {
                    e.preventDefault();
                    modal.addClass('modal--show');
                })
            },
            complete: function () {
                $("#nombreFestival").val("");
                $("#imagenFestival").val("");
                modal.removeClass('modal--show');
            },
        })
    })

    function editar() {
        /** EDITAR FESTIVALES **/
        $(".openModalEditar").off("click");
        $("#btn-editar").off("click");
        $(".openModalEditar").on("click", (e) => {
            let rowId = e.currentTarget.getAttribute("data-id");
            idSeleccionado = rowId;
            $.ajax({
                url: window.location.pathname + "/obtener-festival",
                method: "POST",
                data: { id: idSeleccionado },
                success: function (data) {
                    if (data[0].resultado) {
                        $("#nombreFestivalEditar").val(data[1].nombre)
                        $(".imagenActual").html(`Imagen Actual: <img src="../uploads/img/${data[1].imagen}" alt="Imagen festival" width="30rem" height="30rem">`)
                        $(".modal__container form").show();
                        $(".modal__loader").hide();
                    } else {
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
                        toastr["error"]("Hubo un error inesperado", "Error")
                        modalEdit.removeClass('modal--show--editar');
                    }
                },
                beforeSend: function () {
                    modalEdit.addClass('modal--show--editar');
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
                    $(".modal__container form").hide();
                    $(".modal__loader").show();
                    toastr["info"]("Un momento..", "Recuperando datos..")
                }
            })
        })


        $("#btn-editar").on("click", (e) => {
            e.preventDefault();
            let fichero = $("#imagenFestivalEditar")[0].files[0];
            let nombreFestival = $("#nombreFestivalEditar").val();
            let datos = new FormData();

            datos.append('imagenEdit', fichero);
            datos.append('nombreFestivalEdit', nombreFestival);
            datos.append('id', idSeleccionado);
            $.ajax({
                url: window.location.pathname + "/editar",
                method: "POST",
                data: datos,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data[0].resultado) {
                        $(`#${idSeleccionado}`).find(".nombreFest").html(data[1].nombre);
                        $(`#${idSeleccionado}`).find("td .imgFest").attr("src", `../uploads/img/${data[1].imagen}`);
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
                        toastr["success"]("Festival editado correctamente", "Editar")
                    } else {
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
                        toastr["error"]("Hubo un error al editar", "Error")
                    }
                },
                complete: function () {
                    $("#nombreFestivalEditar").val("");
                    $("#imagenFestivalEditar").val("");
                    modalEdit.removeClass('modal--show--editar');
                },
            })
        })
    }

    /** BORRAR FESTIVAL **/
    function borrar(){
        $(".borrar").off("click")
        $(".borrar").on("click", (e) => {
            e.preventDefault();
            let datos = new FormData();
            let rowId = e.currentTarget.getAttribute("data-id");
            idSeleccionado = rowId;
            console.log(idSeleccionado)
            datos.append('id', idSeleccionado);
            $.ajax({
                url: window.location.pathname + "/borrar",
                method: "POST",
                data: datos,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data) {
                        $(`#${idSeleccionado}`).remove();
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
                        toastr["success"]("Festival borrado correctamente", "Borrar")
                    } else {
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
                        toastr["error"]("Hubo un error al borrar", "Error")
                    }
                }
            })
        })
    }
})