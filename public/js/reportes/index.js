
var parsleyValidation = false;

$(document).ready(function () {

  $('#tablaReportes').bootstrapTable({
    url: `${baseUrl}reportes/obtenerRegistros`,
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
      $('#toolbar').find('select').each(function () {
        if ($(this).hasClass('filtro')) {
          var name = $(this).attr('name');
          var valor = $(this).val();
          objFilter[name] = valor;
        }
      });

      //Obtiene el name y valor de cada input que sirve como filtro
      $('#toolbar').find('input').each(function () {
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
      title: 'No. Reporte',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'no_reporte',
      formatter: function (value, row, index) {
        if (row.no_reporte !== null) {
          return `<h5 class="mrg10A">${row.no_reporte.toUpperCase()}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Linea',
      align: 'center',
      valign: 'middle',
      field: 'linea',
      formatter: function (value, row, index) {
        if (row.linea !== null) {
          return `<h5 class="mrg10A">${row.linea}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Modelo',
      align: 'center',
      valign: 'middle',
      field: 'modelo',
      formatter: function (value, row, index) {
        if (row.modelo !== null) {
          return `<h5 class="mrg10A">${row.modelo}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'VIN',
      align: 'center',
      valign: 'middle',
      field: 'vin',
      formatter: function (value, row, index) {
        if (row.vin !== null) {
          return `<h5 class="mrg10A">${row.vin}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Placa',
      align: 'center',
      valign: 'middle',
      field: 'placa',
      formatter: function (value, row, index) {
        if (row.placa !== null) {
          return `<h5 class="mrg10A">${row.placa}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Fecha Robo',
      align: 'center',
      valign: 'middle',
      field: 'fecha_robo',
      formatter: function (value, row, index) {
        if (row.fecha_robo !== null) {
          return `<h5 class="mrg10A">${row.fecha_robo}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Hora Robo',
      align: 'center',
      valign: 'middle',
      field: 'hora_robo',
      formatter: function (value, row, index) {
        if (row.hora_robo !== null) {
          return `<h5 class="mrg10A">${row.hora_robo}</h5>`
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
        btn += `<button onClick="obtenerReporte('${btoa(row.reporte_robo_id)}')" class="btn btn-info margin5">Editar</button>`;
        btn += `<button onClick="eliminarReporte('${btoa(row.reporte_robo_id)}')" class="btn btn-danger margin5">Eliminar</button>`;
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
  $('#formReporte').attr('action', `${baseUrl + urlGuardar}`);
  $("#modalReporte").modal("show");
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

  $('#tablaReportes').bootstrapTable('refresh');
});

$('#btnBuscar').on('click', function () {
  $('#tablaReportes').bootstrapTable('refresh');
});

function obtenerReporte(vehiculoId) {

  reiniciarForm();

  let formData = new FormData();
  formData.append('id', vehiculoId);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

  $.ajax({
    url: `${baseUrl}reportes/obtenerReporte`,
    type: 'POST',
    contentType: false,
    data: formData,
    processData: false,
    cache: false,
    success: function (respuesta) {
      if (!respuesta.error) {

        $('#vehiculo_id').val(respuesta.datos.vehiculo_id);
        $('#txt_id').val(btoa(respuesta.datos.id));
        $('#txt_fecha').val(respuesta.datos.fecha_robo);
        $('#txt_hora').val(respuesta.datos.hora_robo);
        $('#txt_detalles').val(respuesta.datos.detalles);

        $('#formReporte').attr('action', `${baseUrl + urlEditar}`);
        $("#modalReporte").modal("show");
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


function eliminarReporte(vehiculoId) {

  let formData = new FormData();


  formData.append('id', vehiculoId);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

  swal({
    title: "Información",
    text: "¿Desea eliminar e vehículo?",
    icon: 'info',
    buttons: ["Cancelar", "Aceptar"],
    closeOnClickOutside: false,
  })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: `${baseUrl}reportes/eliminar`,
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

              $('#tablaReportes').bootstrapTable('refresh');
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
$('#formReporte').parsley().on('field:validated', function () {
  var ok = $('.parsley-error').length === 0;
}).on('form:submit', function (e) {

  e.submitEvent.preventDefault();
  parsleyValidation = true;

  swal({
    title: "Información",
    text: "¿Desea guardar el  reporte de robo del vehículo?",
    icon: 'info',
    buttons: ["Cancelar", "Aceptar"],
    closeOnClickOutside: false,
  })
    .then((willDelete) => {
      if (willDelete) {


        let url = $('#formReporte').attr('action');
        let formData = new FormData(document.getElementById("formReporte"));

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
              document.getElementById("formReporte").reset();
              $("#formReporte").find('.parsley-success').removeClass('parsley-success');
              $("#modalReporte").modal("hide");
              $('#tablaReportes').bootstrapTable('refresh');

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

function reiniciarForm() {
  document.getElementById("formReporte").reset();
  $("#formReporte").find('.parsley-success').removeClass('parsley-success');
  $("#formReporte").find('.parsley-error').removeClass('parsley-error');
  $("#formReporte").find('.parsley-errors-list').remove();
}
