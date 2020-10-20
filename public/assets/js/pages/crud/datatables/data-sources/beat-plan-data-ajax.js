'use strict';
var PLANDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#plan_data_table').DataTable({
			scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
			// responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			buttons: [
			{ 
				extend: 'excel',
			},
			{ 
				extend: 'pdfHtml5',
				orientation: 'landscape',
        		pageSize: 'A2'
			}
			],
			ajax: {
				url: HOST_URL+'beat-view-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					beat_id: $('input[name="beat_id"]').val(),
					columnsDef: [
						'trip_id','site_id','site_name','site_category','technician_name','technician_contact','quantity','status','loading_date','loading_start','loading_finish','filling_finish','site_in','site_out','vehicle_no','driver_name','driver_contact','filler_name','filler_contact','remark'
					]
				},
			},
			columns: [
			{data: 'trip_id'},     
			{data: 'site_id'},      
			{data: 'site_name'},      
			{data: 'site_category'},     
			{data: 'technician_name'},  
			{data: 'technician_contact'},  
			{data: 'quantity'},  
			{data: 'status'},  
			{data: 'loading_date'},  
			{data: 'loading_start'},  
			{data: 'loading_finish'},  
			{data: 'filling_finish'},  
			{data: 'site_in'},  
			{data: 'site_out'},  
			{data: 'vehicle_no'},  
			{data: 'driver_name'},  
			{data: 'driver_contact'},  
			{data: 'filler_name'},  
			{data: 'filler_contact'},  
			{data: 'remark'}
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

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	PLANDatatablesDataSourceAjaxServer.init();
});
