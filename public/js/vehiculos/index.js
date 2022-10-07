
var parsleyValidation = false;

$(document).ready(function () {

  $('#tablaVehiculos').bootstrapTable({
    url: `${baseUrl}vehiculos/obtenerRegistros`,
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

      //Se establecen los filtros en la propiedad de filtros en la datatable
      params.search = "";
      params.filter = objFilter;
      return params;
    },
    columns: [{
      title: 'Linea',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'linea',
      formatter: function (value, row, index) {
        if (row.linea !== null) {
          return `<h5 class="mrg10A">${row.linea.toUpperCase()}</h5>`
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
      title: 'Acciones',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'id',
      formatter: function (value, row, index) {
        let btn;

        btn = `<div>`;
        btn += `<button onClick="obtenerVehiculo('${btoa(row.id)}')" class="btn btn-info margin5">Editar</button>`;
        btn += `<button onClick="eliminarVehiculo('${btoa(row.id)}')" class="btn btn-danger margin5">Eliminar</button>`;
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
  $('#formVehiculo').attr('action', `${baseUrl + urlGuardar}`);
  $("#modalVehiculo").modal("show");
});

$('#btnLimpiar').on('click', function () {
  $('#toolbar').find('input').each(function () {
    if ($(this).hasClass('filtro')) {
      $(this).val('');
    }
  });

  $('#tablaVehiculos').bootstrapTable('refresh');
});

$('#btnBuscar').on('click', function () {
  $('#tablaVehiculos').bootstrapTable('refresh');
});

function obtenerVehiculo(vehiculoId) {

  reiniciarForm();

  let formData = new FormData();
  formData.append('id', vehiculoId);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

  $.ajax({
    url: `${baseUrl}vehiculos/obtenerVehiculo`,
    type: 'POST',
    contentType: false,
    data: formData,
    processData: false,
    cache: false,
    success: function (respuesta) {
      if (!respuesta.error) {

        $('#marca_id').val(respuesta.datos.cat_marca_id);
        $('#txt_id').val(btoa(respuesta.datos.id));
        $('#txt_linea').val(respuesta.datos.linea);
        $('#txt_modelo').val(respuesta.datos.cat_color_id);
        $('#txt_placa').val(respuesta.datos.placa);
        $('#txt_vin').val(respuesta.datos.vin);
        $('#propietario').val(respuesta.datos.propietario_id);

        $('#formVehiculo').attr('action', `${baseUrl + urlEditar}`);
        $("#modalVehiculo").modal("show");
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


function eliminarVehiculo(vehiculoId) {

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
          url: `${baseUrl}vehiculos/eliminar`,
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

              $('#tablaVehiculos').bootstrapTable('refresh');
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
$('#formVehiculo').parsley().on('field:validated', function () {
  var ok = $('.parsley-error').length === 0;
}).on('form:submit', function (e) {

  e.submitEvent.preventDefault();
  parsleyValidation = true;

  swal({
    title: "Información",
    text: "¿Desea guardar el vehículo?",
    icon: 'info',
    buttons: ["Cancelar", "Aceptar"],
    closeOnClickOutside: false,
  })
    .then((willDelete) => {
      if (willDelete) {


        let url = $('#formVehiculo').attr('action');
        let formData = new FormData(document.getElementById("formVehiculo"));

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
              document.getElementById("formVehiculo").reset();
              $("#formVehiculo").find('.parsley-success').removeClass('parsley-success');
              $("#modalVehiculo").modal("hide");
              $('#tablaVehiculos').bootstrapTable('refresh');

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
  document.getElementById("formVehiculo").reset();
  $("#formVehiculo").find('.parsley-success').removeClass('parsley-success');
  $("#formVehiculo").find('.parsley-error').removeClass('parsley-error');
  $("#formVehiculo").find('.parsley-errors-list').remove();
}
