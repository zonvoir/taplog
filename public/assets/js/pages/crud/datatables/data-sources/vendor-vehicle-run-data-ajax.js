'use strict';
var RunDatablesDataSourceAjaxServer = function() {
	var id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var initTable1 = function() {
		var table = $('#vendor-vehicle-run-data-table').DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			/*scrollY: '50vh',
			scrollX: true,
			scrollCollapse: true,*/
			buttons: [
			{ 
				extend: 'excel',
			},
			{ 
				extend: 'pdfHtml5',
				orientation: 'landscape',
				pageSize: 'A2',
			}
			],
			ajax: {
				url: HOST_URL+'vendor/vehicle-run-data-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					vehicle_id : id,
					columnsDef: [
					'trip_id',      
					'vehicle_number',      
					'effective_date',      
					'client',      
					'km',  
					'action',      
					]
				},
			},
			columns: [    
			{data: 'trip_id'},      
			{data: 'vehicle_number'},      
			{data: 'effective_date'},      
			{data: 'client'},      
			{data: 'km'},  
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
	RunDatablesDataSourceAjaxServer.init();
});
