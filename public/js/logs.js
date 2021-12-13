$(document).ready(function() {

    $('#logsTable tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="text-center" />');
    });

    // DataTable
    var table = $('#logsTable').DataTable({
        initComplete: function() {
            // Apply the search
            this.api().columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
            $('#logsTable tfoot tr').appendTo('#logsTable thead');
        },
        "language": {
            "lengthMenu": "Mostrar _MENU_",
            "zeroRecords": "No se encontró resultados",
            "info": "Visualizando _PAGE_ de _PAGES_ páginas",
            "infoEmpty": "No hay resultados disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total de resultados)",
            "search": "Buscar",
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente",
                "first": "Primera",
                "last": "Última",

            }
        },
        dom: 'lBfrtip',
        responsive: true,
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-danger',
                orientation: 'landscape',
                pageSize: 'TABLOID',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info',
                orientation: 'landscape',
                pageSize: 'TABLOID',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'copyHtml5',
                text: '<i class="fas fa-copy"></i> ',
                titleAttr: 'Copiar',
                className: 'btn btn-warning',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv"></i> ',
                titleAttr: 'Exportar a SVG',
                className: 'btn btn-primary',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            }
        ]
    });

});