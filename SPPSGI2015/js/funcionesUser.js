var urlController = "inc/ctrlusuarios/funciones/funcionesUsuarioController.php";
$(document).ready(function () {
    $("#tabsUser a:first").tab('show');
    $(".telef").autoNumeric({aSep: '', vMax: '9999999999', mDec: '0'});
    $.post(urlController, {accionUser: "getSistemas"}, function (data) {
        $("#sistUser").html(data);
        $("#sistUser").bootstrapDualListbox({
            nonSelectedListLabel: '[Disponibles]',
            selectedListLabel: '[Seleccionados]',
            preserveSelectionOnMove: false,
            moveOnSelect: true,
            infoText: false,
            showFilterInputs: true,
            filterPlaceHolder: "Buscar..."
        });
        $("#sistUser").unbind("change").on("change", function () {
            $("select[name='sistUser[]_helper2']").valid();
            if ($("#sistUser").val() && $("#sistUser").val().indexOf("2") !== -1) {
                $.post(urlController, {accionUser: "getSectores"}, function (data) {
                    $("#secUser").html(data);
                    $("#secUser").unbind("change").on("change", function () {
                        $("select[name='secUser[]_helper2']").valid();
                    });
                    if ($("select[name='secUser[]_helper2']").length > 0) {
                        $("#secUser").bootstrapDualListbox("refresh");
                    } else {
                        $("#secUser").bootstrapDualListbox({
                            nonSelectedListLabel: '[Disponibles]',
                            selectedListLabel: '[Seleccionados]',
                            preserveSelectionOnMove: false,
                            moveOnSelect: true,
                            infoText: false,
                            showFilterInputs: true,
                            filterPlaceHolder: "Buscar..."
                        });
                    }
                });
                $("#rowSectores").show();
            } else {
                $("#rowSectores").hide();
            }
        });
    });
//    $.post(urlController, {accionUser: "getOrganizaciones"}, function (data) {
//        $("#depUser").html(data);
//        $("#depUser").unbind("change").on("change", function () {
//            $("select[name='depUser[]_helper2']").valid();
//        });
//        $("#depUser").bootstrapDualListbox({
//            nonSelectedListLabel: '[Disponibles]',
//            selectedListLabel: '[Seleccionadas]',
//            preserveSelectionOnMove: false,
//            moveOnSelect: true,
//            infoText: false,
//            showFilterInputs: true,
//            filterPlaceHolder: "Buscar..."
//        });
//    });
    //se agregan los metodos de validacion
    jQuery.extend(jQuery.validator.messages, {
        number: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">No v\u00e1lido</div>',
        min: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">No v\u00e1lido</div>',
        required: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Campo requerido</div>',
        selectUno: '<div class="alert alert-danger" role="alert" style="z-index:99;">Seleccione una opci&oacute;n</div>',
        email: '<div class="alert alert-danger" role="alert" style="z-index:99;">Correo no v&aacute;lido</div>',
        selectNoVacio: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Seleccione al menos un municipio</div>'
    });
    jQuery.validator.addMethod("selectNoVacio", function (value, element) {
        if ($(element).find("option").length === 0) {
            return false;
        } else {
            return true;
        }
    }, "Seleccione por lo menos un elemento");
    jQuery.validator.addMethod("selectUno", function (value, element) {
        if (value === '-1') {
            return false;
        } else {
            return true;
        }
    }, '<div class="alert alert-danger" role="alert" style=" z-index:99;">Seleccione una opci&oacute;n</div>');
    jQuery.validator.addMethod("activo", function (value, element) {
        if ($(element).attr("disabled")) {
            return true;
        } else {
            if ($.trim($(element).val()) === "") {
                return false;
            } else {
                return true;
            }
        }
    }, "Campo obligatorio");
    jQuery.validator.addClassRules("obligatorio", {
        required: true
    });
    jQuery.validator.addClassRules("seleccion", {
        selectUno: true
    });
    jQuery.validator.addClassRules("passEqual", {
        equalTo: "#passUser"
    });
    jQuery.validator.addClassRules("correo", {
        email: true
    });
    $("#formUser").validate({
        rules: {
            'sistUser[]_helper2': {
                selectNoVacio: true
            },
            'depUser[]_helper2': {
                selectNoVacio: true
            },
            'secUser[]_helper2': {
                selectNoVacio: true
            }
        },
        messages: {
            'sistUser[]_helper2': {
                selectNoVacio: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Seleccione al menos un elemento</div>'
            },
            'depUser[]_helper2': {
                selectNoVacio: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Seleccione al menos un elemento</div>'
            },
            'secUser[]_helper2': {
                selectNoVacio: '<div class="alert alert-danger" role="alert" style="position: absolute; z-index:99;">Seleccione al menos un elemento</div>'
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") === "passUser1") {
                $("#errorPass").addClass("alert-danger");
                $("#errorPass").html('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
            } else {
                error.insertAfter(element);
            }
        }
    });
    $("#passUser1,#passUser").unbind("keyup").on("keyup", function (key) {
        if ($("#passUser1").valid()) {
            $("#errorPass").removeClass("alert-danger");
            $("#errorPass").html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
        }
    });
    $("#btnGuardarUser").unbind("click").on("click", function () {
        guardarUser();
    });
    $("#btnResetUser").unbind("click").on("click", function () {
        limpiarCamposUser();
    });
    $("#modalAvisoUser").on('hidden.bs.modal', function () {
        if ($("#infoBody").find("h1:first").text().indexOf("error") === -1) {
            limpiarCamposUser();
        }
    });
    $("#btnBuscarUser").unbind("click").on("click", function () {
        buscarUser($("#lgnUser"), "usuario");
    });
    $("#lgnUser").unbind("keypress").on("keypress", function (key) {
        if (key.charCode === 13) {
            buscarUser($("#lgnUser"), "usuario");
        }
    });
    $("#btnActualizarUser").unbind("click").on("click", function () {
        if ($("#formUser").valid() && $(".obligatorio:visible").valid() && $(".seleccion").valid() && $("#passUser1").valid()) {
            $("#accionUser").val("updateUser");
            $.post(urlController, $("#formUser").serialize(), function (data) {
                console.log(data);
                var dataRes = $.parseJSON(data);
                if (dataRes.idusu) {
                    $("#infoBody").html("<h1>Usuario actualizado</h1><br/><br/><p>Id de usuario:  " + dataRes.idusu + "</p><br/><p>Usuario:  " + dataRes.lgnusu + "</p>");
                    $("#modalAvisoUser").modal();
                } else if (dataRes.error) {
                    $("#infoBody").html("<h1>Ocurri&oacute; un error</h1><br/><br/><p>" + dataRes.error + "</p>");
                    $("#modalAvisoUser").modal();
                }
            });
        }
    });
    $("#btnInhabilitarUser").unbind("click").on("click", function () {
        if (confirm("\u00BFSeguro que desea inhabilitar el usuario?")) {
            $.post(urlController, {accionUser: "inhabilitaUser", idUser: $("#idUser").val()}, function (data) {
                var dataRes = $.parseJSON(data);
                if (dataRes.idusu) {
                    $("#infoBody").html("<h1>Usuario deshabilitado</h1><br/><br/><p>Id de usuario:  " + dataRes.idusu + "</p><br/><p>Usuario:  " + $("#lgnUser").val() + "</p>");
                    $("#modalAvisoUser").modal();
                } else if (dataRes.error) {
                    $("#infoBody").html("<h1>Ocurri&oacute; un error</h1><br/><br/><p>" + dataRes.error + "</p>");
                    $("#modalAvisoUser").modal();
                }
            });
        }
    });
    $("#btnHabilitarUser").unbind("click").on("click", function () {
        if (confirm("\u00BFSeguro que desea habilitar el usuario?")) {
            $.post(urlController, {accionUser: "habilitaUser", idUser: $("#idUser").val()}, function (data) {
                var dataRes = $.parseJSON(data);
                if (dataRes.idusu) {
                    $("#infoBody").html("<h1>Usuario habilitado</h1><br/><br/><p>Id de usuario:  " + dataRes.idusu + "</p><br/><p>Usuario:  " + $("#lgnUser").val() + "</p>");
                    $("#modalAvisoUser").modal();
                } else if (dataRes.error) {
                    $("#infoBody").html("<h1>Ocurri&oacute; un error</h1><br/><br/><p>" + dataRes.error + "</p>");
                    $("#modalAvisoUser").modal();
                }
            });
        }
    });
    $("#todosModulosSGI").unbind("change").on("change", function () {
        marcarTodos($("#todosModulosSGI"));
    });
    $("#userPermiso").unbind("keypress").on("keypress", function (key) {
        if (key.charCode === 13) {
            buscarUser($("#userPermiso"), "permiso");
        }
    });
    $("#btnBuscarUserPermisos").unbind("click").on("click", function (key) {
        buscarUser($("#userPermiso"), "permiso");
    });

    $("#btnLimpiarPermisos").unbind("click").on("click", function () {
        limpiarCamposPermisos();
    });
    $("#btnGuardarPermisos").unbind("click").on("click", function () {
        guardarPermisos();
    });
    $("#nivelUser").unbind("change").on("change", function () {
        if ($(this).val() === "MUN" || $(this).val() === "UE") {
            $.post(urlController, {accionUser: "getUEs"}, function (data) {
                $("#ueUser").html(data);
                $("#rowUEs").show();
            });
        } else {
            $("#ueUser").html("");
            $("#rowUEs").hide();
            $("#secUser").find("option").show();
            $("#secUser").val("");
            if ($("select[name='secUser[]_helper2']").length > 0) {
                $("#secUser").bootstrapDualListbox("refresh");
            } else {                
                $("#secUser").bootstrapDualListbox("refresh");
            }
        }
    });
    $("#ueUser").unbind("change").on("change", function () {
        $("#secUser").val("");
        $("#secUser").find("option").show();
        $("#secUser option[value='" + $(this).find("option:selected").attr("class") + "']").prop("selected", true);
        $("#secUser").find("option").not("option[value='" + $(this).find("option:selected").attr("class") + "']").hide();
        $("#secUser").bootstrapDualListbox("refresh");
    });
    
    $.post(urlController,{accionUser: "combos"},function(data){
        console.log(data);
        $("#rolUser").html(data);
    });
});

function guardarPermisos() {
    $("#formPermisos input[name='accionUser']").val("mergePermisosSGI");
    $.post(urlController, $("#formPermisos").serialize(), function (data) {
        var dataRes = $.parseJSON(data);
        if (dataRes.error) {
            $("#infoBody").html("<h1>Ocurri&oacute; un error</h1><br/><br/><p>" + dataRes.error + "</p>");
            $("#modalAvisoUser").modal();
        } else {
            $("#infoBody").html("<h1>Permisos guardados para el usuario</h1><br/><br/><p>Id de usuario:  " + dataRes.idusu + "</p><br/><p>Usuario:  " + $("#userPermiso").val() + "</p>");
            $("#modalAvisoUser").modal();
        }

    });
}
function buscarUser(loginUser, tipo) {
    if ($(loginUser).valid()) {
        $.post(urlController, {lgnUser: $(loginUser).val(), accionUser: "buscaUserByLgnUser"}, function (data) {
//            console.log(data);
            var dataRes = $.parseJSON(data);
            if (dataRes.error) {
                $("#infoBody").html("<h1>Ocurri&oacute; un error</h1><br/><br/><p>" + dataRes.error + "</p>");
                $("#modalAvisoUser").modal();
            } else {
                if (tipo === "usuario") {
                    colocarDatosUser(dataRes);
                } else if (tipo === "permiso") {
                    $.post(urlController, {accionUser: "getModulosSGI"}, function (data) {
                        var modulosSGI = $.parseJSON(data);
                        colocarModulosSGI(modulosSGI);
                        $.post(urlController, {accionUser: "getPermisosSGIByUser", idusu: dataRes.idusu}, function (data) {
                            if (data !== null && data !== "") {
                                var permisosSGI = $.parseJSON(data);
                                colocarPermisosSGIUser(permisosSGI);
                            }
                        });
                        colocarDatosUserPermiso(dataRes);
                        $("#btnGuardarPermisos").show();
                    });
                }
            }

        });
    }
}

function colocarModulosSGI(modulos) {
    var idContenedorModulo;
    var idContenedorModuloSec;
    var contadorColum = 0;
    var valorBaseDatos;
    $("#contenidoModulosSGI").html("");
    console.log(modulos);
    for (i = 0; i < modulos.length; i++) {
        valorBaseDatos = modulos[i].idMnu + "-" + modulos[i].Xi + "-" + modulos[i].Yi;
        if (modulos[i].submodulo === "0") {
            idContenedorModulo = "modulo" + modulos[i].modulo + "-" + modulos[i].submodulo;
            idContenedorModuloPadre = "modulo" + modulos[i].modulo + "-" + modulos[i].submodulo;
            addPanel($("#contenidoModulosSGI"), modulos[i].etiqueta, idContenedorModulo, valorBaseDatos, true);
            contadorColum = 0;
        } else if (modulos[i].submodulo !== "0" && modulos[i].link === "0") {
            idContenedorModuloSec = "modulo" + modulos[i].modulo + "-" + modulos[i].submodulo;
            if(idContenedorModulo !== idContenedorModuloPadre){
                addPanel($("#" + idContenedorModuloPadre), modulos[i].etiqueta, idContenedorModuloSec, valorBaseDatos, false);
            }else{
                addPanel($("#" + idContenedorModulo), modulos[i].etiqueta, idContenedorModuloSec, valorBaseDatos, false);
            }
            idContenedorModulo = "modulo" + modulos[i].modulo + "-" + modulos[i].submodulo;
            contadorColum = 0;
        } else if (modulos[i].submodulo !== "0" && modulos[i].link === "1") {
            addModulo($("#" + idContenedorModulo), modulos[i].etiqueta, valorBaseDatos, contadorColum);
            contadorColum++;
        } else if (modulos[i].submodulo !== "0" && modulos[i].orden !== "0") {
            addModulo($("#" + idContenedorModulo), modulos[i].etiqueta, valorBaseDatos, contadorColum);
            contadorColum++;
        }
        if (contadorColum === 3) {
            contadorColum = 0;
        }
    }
    $("#permisosSGI").show();
}

function guardarUser() {
    if ($("#formUser").valid() && $(".obligatorio:visible").valid() && $(".seleccion").valid() && $("#passUser1").valid()) {
        $("#accionUser").val("pushUser");
        $.post(urlController, $("#formUser").serialize(), function (data) {
//            console.log(data);
            var dataRes = $.parseJSON(data);
            if (dataRes.idusu) {
                $("#infoBody").html("<h1>Registro de usuario exitoso</h1><br/><br/><p>Id de usuario:  " + dataRes.idusu + "</p><br/><p>Usuario:  " + dataRes.lgnusu + "</p>");
                $("#modalAvisoUser").modal();
            } else if (dataRes.error) {
                $("#infoBody").html("<h1>Ocurri&oacute; un error</h1><br/><br/><p>" + dataRes.error + "</p>");
                $("#modalAvisoUser").modal();
            }
        });
    }
}

function marcarTodos(elemento) {
    if ($(elemento).prop("checked")) {
        $(elemento).parents(".row:first").parent().find("input[type='checkbox']").prop("checked", true);
    } else {
        $(elemento).parents(".row:first").parent().find("input[type='checkbox']").prop("checked", false);
    }
}
function colocarPermisosSGIUser(permisos) {
    for (i = 0; i < permisos.length; i++) {
        $("input[value='" + permisos[i].idMnu + "-" + permisos[i].Xi + "-" + permisos[i].Yi + "']").prop("checked", true);
    }
}

function colocarDatosUser(user) {
    $("#nombreUser").val(user.nombreUsu);
    $("#apPatUser").val(user.aPaternoUsu);
    $("#apMatUser").val(user.aMaternoUsu);
    $("#emailUser").val(user.emailUsu);
    $("#telUser").val(user.telefonoUsu);
    $("#extUser").val(user.extUsu);
    $("#descUser").val(user.dscusu);
    $("#idUser").val(user.idusu);
    $("#tipoUser option[value='" + user.tpousu + "']").prop("selected", true);
    $("#rolUser option[value='" + user.idRol + "']").prop("selected", true);
    $("#nivelUser option[value='" + user.nvlusu + "']").prop("selected", true).change();
    setTimeout(function () {
        if (user.nvlusu === "MUN" || user.nvlusu === "UE") {
            $("#ueUser option[value='" + user.idUE + "']").prop("selected", true);
            $("#secUser").find("option").not("option[value='" + user.sectores + "']").hide();
            $("#secUser").bootstrapDualListbox("refresh");
        }
    }, 2000);
    var sistemas = user.sistema.split(",");
    for (i = 0; i < sistemas.length; i++) {
        $("#sistUser option[value='" + sistemas[i] + "']").prop("selected", true);
    }
    $("#sistUser").bootstrapDualListbox("refresh");
    $("#sistUser").change();
//    var dependencias = user.dependencias.split(",");
//    for (i = 0; i < dependencias.length; i++) {
//        $("#depUser option[value='" + dependencias[i] + "']").prop("selected", true);
//    }
    $("#depUser").bootstrapDualListbox("refresh");
    setTimeout(function () {
        if (sistemas.indexOf('2') !== -1) {
            var sectores = user.sectores.split(",");
            for (i = 0; i < sectores.length; i++) {
                $("#secUser option[value='" + sectores[i] + "']").prop("selected", true);
            }
            $("#secUser").bootstrapDualListbox("refresh");
        }
    }, 1500);
    if (user.estatus === '1') {
        $("#btnInhabilitarUser").show();
        $("#btnHabilitarUser").hide();
    } else {
        $("#btnInhabilitarUser").hide();
        $("#btnHabilitarUser").show();
    }
    $("#btnActualizarUser").show();
}

function colocarDatosUserPermiso(user) {
    $("#userPermiso").attr("disabled", "disabled");
    $("#nombrePer").html(user.nombreUsu + " " + user.aPaternoUsu + " " + user.aMaternoUsu);
    $("#idUserPermiso").val(user.idusu);
    $("#sistemasUserPermiso").val(user.sistema);
    var sistemas = user.sistema.split(",");
    if (sistemas.indexOf('2') !== -1) {
        $("#permisosSGI").show();
    } else {
        $("#permisosSGI").hide();
    }

}

function limpiarCamposPermisos() {
    $("#userPermiso").val("").removeAttr("disabled");
    $("#sistemasUserPermiso").val("");
    $("#idUserPermiso").val("");
    $("#nombrePer").html("");
    $("#permisosSGI").find("input[type='checkbox']").prop("checked", false);
    $("#permisosSGI").hide();
    $("#btnGuardarPermisos").hide();
}

function limpiarCamposUser() {
    $("#formUser").find("input[type='text'],input[type='password']").val("");
    $("#tipoUser option:first,#nivelUser option:first").prop("selected", "selected");
    $("#sistUser").val("");
    $("#sistUser").bootstrapDualListbox("refresh");
    $("#depUser").val("");
    $("#depUser").bootstrapDualListbox("refresh");
    $("#secUser").val("");
    $("#secUser").bootstrapDualListbox("refresh");
    $("#rowSectores").hide();
    $("#btnActualizarUser").hide();
    $("#btnInhabilitarUser").hide();
    $("#btnHabilitarUser").hide();
}

function addPanel(elemento, titulo, idContenedor, valor, primario) {
    var tipoPanel = "panel-default";
    if (!primario) {
        tipoPanel = 'panel-success';
    }   
    var checkTodos = '';
    var panel = '<div class="row panel-body"><div class="panel ' + tipoPanel + '"><div class="panel-heading">' + titulo + '</div><div class="panel-body" id="' + idContenedor + '">' + checkTodos + '</div></div></div>';
    $(elemento).append(panel);
    return true;
}

function addModulo(elemento, etiqueta, valor, contColum) {
    var modulo = '<div class="col-sm-4 panel-body"><div class="input-group input-group-sm col-sm-12"><span class="input-group-addon"><input type="checkbox" value="' + valor + '" name="modulos[]"/></span><span class="form-control">' + etiqueta + '</span></div></div>';
    if (contColum === 0) {
        $(elemento).append('<div class="row"></div>');
    }
    $(elemento).find(".row:last").append(modulo);
    return true;
}