// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
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
      }
    });
});
