'use strict';
var HandbookTatablesDataSourceAjaxServer = function() {
	var initTable1 = function() {
		var id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
		var table = $('#handbook_trip_data_table').DataTable({
			// scrollY: '50vh',
		   //  scrollX: true,
		   //  scrollCollapse: true,
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
		   	orientation: 'landscape',
		   	pageSize: 'A2',
		   	exportOptions: {
		   		columns: 'th:not(:last-child)'
		   	}
		   }
		   ],
		   ajax: {
		   	url: HOST_URL+'handbook-trips-table',
		   	type: 'POST',
		   	data: {
		   		'_token' : $('meta[name="csrf-token"]').attr('content'),
		   		beatId: id,
		   		columnsDef: [
		   		'plan_date','trip_id','action'
		   		]
		   	},
		   },
		   columns: [
		   {data: 'plan_date'},      
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
		var filter = function() {
			var val = $.fn.dataTable.util.escapeRegex($(this).val());
			table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
		};

		var asdasd = function(value, index) {
			var val = $.fn.dataTable.util.escapeRegex(value);
			table.column(index).search(val ? val : '', false, true);
		};
		$('#kt_search').on('click', function(e) {
			e.preventDefault();
			var params = {};
			$('.datatable-input').each(function() {
				var i = $(this).data('col-index');
				if (params[i]) {
					params[i] += '|' + $(this).val();
				}
				else {
					params[i] = $(this).val();
				}
			});
			$.each(params, function(i, val) {
				// apply search params to datatable
				table.column(i).search(val ? val : '', false, false);
			});
			table.table().draw();
		});
		$('#kt_reset').on('click', function(e) {
			e.preventDefault();
			$('.datatable-input').each(function() {
				$(this).val('');
				table.column($(this).data('col-index')).search('', false, false);
			});
			table.table().draw();
		});
		$('#kt_datepicker').datepicker({
			format: 'dd-mm-yyyy',
			todayHighlight: true,
			templates: {
				leftArrow: '<i class="la la-angle-left"></i>',
				rightArrow: '<i class="la la-angle-right"></i>',
			},
			autoclose: true
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
