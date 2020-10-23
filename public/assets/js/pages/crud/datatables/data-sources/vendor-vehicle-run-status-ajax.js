'use strict';
var HandbookTatablesDataSourceAjaxServer = function() {
	var id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var initTable1 = function() {
		var table = $('#vendor-vehicle-run-status-table').DataTable({
			///responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			scrollY: '50vh',
			scrollX: true,
			scrollCollapse: true,
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
				url: HOST_URL+'vehicle-run-status-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					vehicle_id : id,
					columnsDef: [
					'effective_date',      
					'site_id',      
					'site_name',      
					'site_category',      
					'technician_name',  
					'technician_contact',
					'qty',      
					'status',      
					]
				},
			},
			columns: [    
			{data: 'effective_date'},      
			{data: 'site_id'},      
			{data: 'site_name'},      
			{data: 'site_category'},      
			{data: 'technician_name'},  
			{data: 'technician_contact'},
			{data: 'qty'},      
			{data: 'status'},         
			],
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
	HandbookTatablesDataSourceAjaxServer.init();
});
