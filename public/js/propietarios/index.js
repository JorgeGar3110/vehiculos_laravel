
var parsleyValidation = false;

$(document).ready(function () {

  $('#tablaPropietarios').bootstrapTable({
    url: `${baseUrl}propietarios/obtenerRegistros`,
    height: 0,
    pageSize: 3,
    pagination: true,
    sidePagination: "server",
    search: false,
    showRefresh: true,
    paginationLoop: true,
    pageList: [10, 25, 50, 100, 200, 'Todo'],
    clickToSelect: false,
    detailView: true,
    queryParams: function (params) {
      var objFilter = {};

      //Obtiene el name y valor de cada input que sirve como filtro
      $('#toolbar').find('input').each(function () {
        if ($(this).hasClass('filtro')) {
          var name = $(this).attr('name');
          var valor = $(this).val();
          objFilter[name] = valor;
        }
      });

      $('#toolbar').find('select').each(function () {
        if ($(this).hasClass('filtro')) {
          var name = $(this).attr('name');
          var valor = $(this).val();
          objFilter[name] = valor;
        }
      });

      //Se establecen los filtros en la propiedad de filtros en la datatable
      params.search = "";
      params.filter = objFilter;
      return params;
    },
    columns: [{
      title: 'CURP',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'curp',
      formatter: function (value, row, index) {
        if (row.nombre !== null) {
          return `<h5 class="mrg10A">${row.curp.toUpperCase()}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Propietario',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'nombre_completo',
      formatter: function (value, row, index) {
        if (row.nombre !== null) {
          return `<h5 class="mrg10A">${row.nombre_completo.toUpperCase()}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Fecha nacimiento',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'fecha_nacimiento',
      formatter: function (value, row, index) {
        if (row.nombre !== null) {
          return `<h5 class="mrg10A">${row.fecha_nacimiento.toUpperCase()}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Genero',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'genero',
      formatter: function (value, row, index) {
        if (row.nombre !== null) {
          return `<h5 class="mrg10A">${row.genero.toUpperCase()}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Acciones',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'id',
      formatter: function (value, row, index) {
        let btn;

        btn = `<div>`;
        btn += `<button onClick="obtenerPropietario('${btoa(row.id)}')" class="btn btn-info margin5">Editar</button>`;
        btn += `<button onClick="eliminarPropietario('${btoa(row.id)}')" class="btn btn-danger margin5">Eliminar</button>`;
        btn += `</div>`;

        return btn;
      },
    },
    ],
    onLoadSuccess: function (data) {

    }
  });

});

$('#btnRegistrar').on('click', function () {
  reiniciarForm();
  $('#formPropietario').attr('action', `${baseUrl + urlGuardar}`);
  $("#modalPropietario").modal("show");
});

$('#btnLimpiar').on('click', function () {
  $('#toolbar').find('input').each(function () {
    if ($(this).hasClass('filtro')) {
      $(this).val('');
    }
  });

  $('#toolbar').find('select').each(function () {
    if ($(this).hasClass('filtro')) {
      $(this).val('');
    }
  });

  $('#tablaPropietarios').bootstrapTable('refresh');
});

$('#btnBuscar').on('click', function () {
  $('#tablaPropietarios').bootstrapTable('refresh');
});

function reiniciarForm() {
  document.getElementById("formPropietario").reset();
  $("#formPropietario").find('.parsley-success').removeClass('parsley-success');
  $("#formPropietario").find('.parsley-error').removeClass('parsley-error');
  $("#formPropietario").find('.parsley-errors-list').remove();
}

function obtenerPropietario(colorId) {

  reiniciarForm();

  let formData = new FormData();
  formData.append('id', colorId);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

  $.ajax({
    url: `${baseUrl}propietarios/obtenerPropietario`,
    type: 'POST',
    contentType: false,
    data: formData,
    processData: false,
    cache: false,
    success: function (respuesta) {
      if (!respuesta.error) {
        $('#txt_curp').val(respuesta.datos.curp);
        $('#txt_nombre').val(respuesta.datos.nombre);
        $('#txt_ap1').val(respuesta.datos.apellido_paterno);
        $('#txt_ap2').val(respuesta.datos.apellido_materno);
        $('#txt_fecha').val(respuesta.datos.fecha_nacimiento);
        $('#cat_genero').val(respuesta.datos.cat_genero_id);

        $('#txt_id').val(btoa(respuesta.datos.id));

        $('#formPropietario').attr('action', `${baseUrl + urlEditar}`);
        $("#modalPropietario").modal("show");
      }
      else {
        var n = new Noty({
          theme: 'sunset',
          type: 'error',
          text: respuesta.msj,
          callbacks: {
            onShow: function () {
              setTimeout(function () {
                n.close();
              }, 5000);
            }
          }
        }).show();
      }
    },
    error: function () { }
  })
}


function eliminarPropietario(colorId) {

  let formData = new FormData();


  formData.append('id', colorId);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

  swal({
    title: "Información",
    text: "¿Desea eliminar el propietario?",
    icon: 'info',
    buttons: ["Cancelar", "Aceptar"],
    closeOnClickOutside: false,
  })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: `${baseUrl}propietarios/eliminar`,
          type: 'POST',
          contentType: false,
          data: formData,
          processData: false,
          cache: false,
          success: function (respuesta) {
            if (!respuesta.error) {
              var n = new Noty({
                theme: 'sunset',
                type: 'success',
                text: respuesta.msj,
                callbacks: {
                  onShow: function () {
                    setTimeout(function () {
                      n.close();
                    }, 5000);
                  }
                }
              }).show();

              $('#tablaPropietarios').bootstrapTable('refresh');
            }
            else {
              var n = new Noty({
                theme: 'sunset',
                type: 'error',
                text: respuesta.msj,
                callbacks: {
                  onShow: function () {
                    setTimeout(function () {
                      n.close();
                    }, 5000);
                  }
                }
              }).show();
            }
          },
          error: function () { }
        });
      }
    });
}

//Función de envio de formulario al controlador para el guardado del incidente
$('#formPropietario').parsley().on('field:validated', function () {
  var ok = $('.parsley-error').length === 0;
}).on('form:submit', function (e) {

  e.submitEvent.preventDefault();
  parsleyValidation = true;

  swal({
    title: "Información",
    text: "¿Desea guardar el propietario?",
    icon: 'info',
    buttons: ["Cancelar", "Aceptar"],
    closeOnClickOutside: false,
  })
    .then((willDelete) => {
      if (willDelete) {


        let url = $('#formPropietario').attr('action');
        let formData = new FormData(document.getElementById("formPropietario"));

        $.ajax({
          url: url,
          type: 'POST',
          contentType: false,
          data: formData,
          processData: false,
          cache: false,
          success: function (respuesta) {
            if (!respuesta.error) {
              var n = new Noty({
                theme: 'sunset',
                type: 'success',
                text: respuesta.msj,
                callbacks: {
                  onShow: function () {
                    setTimeout(function () {
                      n.close();
                    }, 5000);
                  }
                }
              }).show();
              document.getElementById("formPropietario").reset();
              $("#formPropietario").find('.parsley-success').removeClass('parsley-success');
              $("#modalPropietario").modal("hide");
              $('#tablaPropietarios').bootstrapTable('refresh');

            } else {
              var n = new Noty({
                theme: 'sunset',
                type: 'error',
                text: respuesta.msj,
                callbacks: {
                  onShow: function () {
                    setTimeout(function () {
                      n.close();
                    }, 5000);
                  }
                }
              }).show();

            }
          },
          error: function () {
            var n = new Noty({
              theme: 'sunset',
              type: 'warning',
              text: "No fue posible guardar la información",
              callbacks: {
                onShow: function () {
                  setTimeout(function () {
                    n.close();
                  }, 3000);
                }
              }
            }).show();
          }
        })
      }
    })

  return false;

}).on('field:error', function () {
  //Varifica si la validación del formulario ya fue realizada una vez
  /* if (!parsleyValidation) {
    parsleyValidation = true;
    //Se realiza scroll al elemento del formulario que no cumplio con las reglas de validación del form
    $([document.documentElement, document.body]).animate({ scrollTop: $(this.$element).offset().top }, 100);
    return false;
  } */
});