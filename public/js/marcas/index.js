
var parsleyValidation = false;

$(document).ready(function () {

  $('#tablaMarcas').bootstrapTable({
    url: `${baseUrl}marca/obtenerRegistros`,
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
    cookie: true,
    cookieIdTable: 'tablaForoCookie',
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
      title: 'Marca',
      align: 'center',
      valign: 'middle',
      clickToSelect: false,
      field: 'nombre',
      formatter: function (value, row, index) {
        if (row.nombre !== null) {
          return `<h5 class="mrg10A">${row.nombre.toUpperCase()}</h5>`
        }
        return "<empty> - </empty>";
      }
    },
    {
      title: 'Fecha',
      align: 'center',
      valign: 'middle',
      field: 'created_at',
      formatter: function (value, row, index) {
        if (row.created_at !== null) {
          return `<h5 class="mrg10A">${row.created_at.toUpperCase()}</h5>`
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

        btn = `<button onClick="obtenerMarca('${btoa(row.id)}')" class="btn btn-info">Editar</button>`;
        btn += `<button onClick="eliminarMarca('${btoa(row.id)}')" class="btn btn-danger">Eliminar</button>`;

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
  $('#formMarca').attr('action', `${baseUrl + urlGuardar}`);
  $("#modalMarca").modal("show");
});

$('#btnLimpiar').on('click', function () {
  $('#toolbar').find('input').each(function () {
    if ($(this).hasClass('filtro')) {
      $(this).val('');
    }
  });

  $('#tablaMarcas').bootstrapTable('refresh');
});

$('#btnBuscar').on('click', function () {
  $('#tablaMarcas').bootstrapTable('refresh');
});

function obtenerMarca($marcaId) {

  reiniciarForm();

  let formData = new FormData();
  formData.append('id', $marcaId);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

  $.ajax({
    url: `${baseUrl}marca/obtenerMarca`,
    type: 'POST',
    contentType: false,
    data: formData,
    processData: false,
    cache: false,
    success: function (respuesta) {
      if (!respuesta.error) {
        $('#txt_marca').val(respuesta.datos.nombre);
        $('#txt_id').val(btoa(respuesta.datos.id));

        $('#formMarca').attr('action', `${baseUrl + urlEditar}`);
        $("#modalMarca").modal("show");
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


function eliminarMarca($marcaId) {

  let formData = new FormData();


  formData.append('id', $marcaId);
  formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

  swal({
    title: "Información",
    text: "¿Desea eliminar la marca?",
    icon: 'info',
    buttons: ["Cancelar", "Aceptar"],
    closeOnClickOutside: false,
  })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: `${baseUrl}marca/eliminar`,
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

              $('#tablaMarcas').bootstrapTable('refresh');
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
$('#formMarca').parsley().on('field:validated', function () {
  var ok = $('.parsley-error').length === 0;
}).on('form:submit', function (e) {

  e.submitEvent.preventDefault();
  parsleyValidation = true;

  swal({
    title: "Información",
    text: "¿Desea guardar la marca?",
    icon: 'info',
    buttons: ["Cancelar", "Aceptar"],
    closeOnClickOutside: false,
  })
    .then((willDelete) => {
      if (willDelete) {


        let url = $('#formMarca').attr('action');
        let formData = new FormData(document.getElementById("formMarca"));

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
              document.getElementById("formMarca").reset();
              $("#formMarca").find('.parsley-success').removeClass('parsley-success');
              $("#modalMarca").modal("hide");
              $('#tablaMarcas').bootstrapTable('refresh');

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
  document.getElementById("formMarca").reset();
  $("#formMarca").find('.parsley-success').removeClass('parsley-success');
  $("#formMarca").find('.parsley-error').removeClass('parsley-error');
  $("#formMarca").find('.parsley-errors-list').remove();
}
