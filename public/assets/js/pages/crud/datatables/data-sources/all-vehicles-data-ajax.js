'use strict';
var HandbookTatablesDataSourceAjaxServer = function() {
	var initTable1 = function() {
		var table = $('#all_vehicles_data_table').DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			buttons: [
			{ 
				extend: 'excel',
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			},
			{ 
				extend: 'pdfHtml5',
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			}
			],
			ajax: {
				url: HOST_URL+'master/all-vehicles-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					columnsDef: [
					'vehicle_number',
					'action'
					]
				},
			},
			columns: [
			{data: 'vehicle_number'},      
			{data: 'action'},      
			],
		});
		$("#exportBeattoPdf").on("click", function() {
			table.button( '.buttons-pdf' ).trigger();
		});
		$("#exportBeattoExcel").on("click", function() {
			table.button( '.buttons-excel' ).trigger();
		});
	};
	return {
		init: function() {
			initTable1();
		},
	};
}();
jQuery(document).ready(function() {
	HandbookTatablesDataSourceAjaxServer.init();
});
