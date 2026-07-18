// Call the dataTables jQuery plugin
$(document).ready(function () {
  // Désactiver complètement les paramètres par défaut de DataTables
  $.extend(true, $.fn.dataTable.defaults, {
    "paging": false,
    "info": false,
    "searching": true,
    "ordering": true,
    "lengthChange": false,
    "dom": 'rt<"bottom"f>', // Uniquement la table (t) et la recherche (f)
    "language": {
      "search": "Rechercher :",
      "zeroRecords": "Aucun résultat trouvé",
      "emptyTable": "Aucune donnée disponible"
    }
  });

  // Initialiser les tableaux avec la configuration minimale
  $('#dataTable, #datatable').DataTable();
});
