$(document).ready(function () {
    $('#tablaMarcas').bootstrapTable({
        url: `${baseUrl}marca/obtenerRegistros`,
        pagination: true,
        sidePagination: 'server',
        pageSize: 5,
        columns: [
            [{
              field: 'Nombre',
              align: 'center',
              valign: 'middle'
            }]
          ]
    });
});