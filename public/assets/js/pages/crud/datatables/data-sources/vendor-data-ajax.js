'use strict';
var VendorDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#vendor_data_table').DataTable({
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
				url: HOST_URL+'vendor/vendor-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					columnsDef: [
						'vendor_code','name','type','billing_address','state','gst_no','latitute','longitude','vendor_category','created_at','action'
					]
				},
			},
			columns: [
			{data: 'vendor_code'},     
			{data: 'name'},      
			{data: 'type'},      
			{data: 'billing_address'},     
			{data: 'state'},  
			{data: 'gst_no'},  
			{data: 'latitute'},  
			{data: 'longitude'},  
			{data: 'vendor_category'},  
			{data: 'created_at'},
			{data: 'action'}
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
	VendorDatatablesDataSourceAjaxServer.init();
});
