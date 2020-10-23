'use strict';
var TripDatablesDataSourceAjaxServer = function() {
	var id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var initTable1 = function() {
		var table = $('#vehicle_trip_data_table').DataTable({
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
				url: HOST_URL+'master/vehicle-trip-data-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					tripId : id,
					columnsDef: [
					'trip_id','site_id','site_name','technician_name','technician_contact','quantity','ro','loading_status','loading_date','loading_start','loading_finish','filling_status','filling_date','site_in','site_out','remark'
					]
				},
			},
			columns: [
			{data: 'trip_id'},     
			{data: 'site_id'},      
			{data: 'site_name'},      
			{data: 'technician_name'},  
			{data: 'technician_contact'},  
			{data: 'quantity'},  
			{data: 'ro'},  
			{data: 'loading_status'},  
			{data: 'loading_date'},  
			{data: 'loading_start'},  
			{data: 'loading_finish'},  
			{data: 'filling_status'},  
			{data: 'filling_date'},  
			{data: 'site_in'},  
			{data: 'site_out'},    
			{data: 'remark'}
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
	TripDatablesDataSourceAjaxServer.init();
});
