'use strict';
var PLANDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#plan_datatable').DataTable({
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
				extend: 'pdf',
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			}
			],
			/*dom: 'Bfrtip',*/
			/*buttons: [*/
			/*'copy', 'csv', 'excel', 'pdf', 'print',*/
				/*{
					extend: 'excelHtml5',
					exportOptions: {
						columns: 'th:not(:last-child)'
					},
				},
				{
					extend: 'pdf',
					exportOptions: {
						columns: 'th:not(:last-child)'
					},
				}*/
				/*],*/
				ajax: {
					url: HOST_URL+'beat-plan-data-table',
					type: 'POST',
					data: {
						'_token' : $('meta[name="csrf-token"]').attr('content'),
					// parameters for custom backend script demo
					columnsDef: [
					'id','added_date', 'mp_zone',
					'effective_date', 'client_name', 'mode',
					'cstatus','action'
					],
				},
			},
			columns: [
			{data: 'added_date'},
			{data: 'mp_zone'},
			{data: 'effective_date'},
			{data: 'client_name'},
			{data: 'mode'},
			{data: 'cstatus'},
			{data: 'action', responsivePriority: -1},
			],
			columnDefs: [
			{
				targets: -1,
				title: 'Action',
				orderable: false,
				render: function(data, type, full, meta) {
					return '\
					<a href="'+HOST_URL+'trip/beat-plan-data?beat_id='+full.id+'" class="btn btn-sm btn-clean btn-icon" title="View details">\
					<i class="la la-eye"></i>\
					</a>\
					<a href="'+HOST_URL+'edit-beat-plan/'+full.id+'" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
					<i class="la la-edit"></i>\
					</a>\
					<a href="'+HOST_URL+'delete-beat-plan/'+full.id+'" class="btn btn-sm btn-clean btn-icon" title="Delete">\
					<i class="la la-trash"></i>\
					</a>\
					';
				}
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
				var i = 2;
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

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	PLANDatatablesDataSourceAjaxServer.init();
});
