'use strict';
var TripsDaTatablesDataSourceAjaxServer = function() {
	var id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var initTable1 = function() {
		var table = $('#vehicle_trip_data_table').DataTable({
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
				url: HOST_URL+'master/vehicle-trips-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					vehicleId : id,
					columnsDef: [
					'trip_id',      
					'action',   
					]
				},
			},
			columns: [   
			{data: 'trip_id'},      
			{data: 'action'},   
			],
			columnDefs: [
			{
				targets: -1,
				orderable: false,
			}
			]
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
	TripsDaTatablesDataSourceAjaxServer.init();
});
