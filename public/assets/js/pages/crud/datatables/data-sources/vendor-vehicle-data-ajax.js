'use strict';
var HandbookTatablesDataSourceAjaxServer = function() {
	var initTable1 = function() {
		var table = $('#vendor_vehicles_table').DataTable({
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
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			},
			{ 
				extend: 'pdfHtml5',
				orientation: 'landscape',
				pageSize: 'A2',
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
					'rc_doc',      
					'insurance_no',      
					'insurance_doc',      
					'insurance_upto',  
					'fitness_cert_no',
					'fitness_cert_doc',      
					'fitness_cert_upto',      
					'permit_no',      
					'permit_doc',      
					'permit_upto',      
					'created_at',   
					'action',   
					]
				},
			},
			columns: [   
			{data: 'vehicle_number'},      
			{data: 'rc_doc'},      
			{data: 'insurance_no'},      
			{data: 'insurance_doc'},      
			{data: 'insurance_upto'}, 
			{data: 'fitness_cert_no'}, 
			{data: 'fitness_cert_doc'},      
			{data: 'fitness_cert_upto'},      
			{data: 'permit_no'},      
			{data: 'permit_doc'},      
			{data: 'permit_upto'},      
			{data: 'created_at'},   
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
	HandbookTatablesDataSourceAjaxServer.init();
});
