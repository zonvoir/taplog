'use strict';
var CollectTatablesDataSourceAjaxServer = function() {
	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});
	var initTable1 = function() {
		var table = $('#collection_data_table').DataTable({
			scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
			//responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			buttons: [
			{ 
				extend: 'excel',
				exportOptions: {
					columns: 'th:not(:first-child)'
				}
			},
			{ 
				extend: 'pdfHtml5',
				orientation: 'landscape',
        		pageSize: 'A2',
        		exportOptions: {
					columns: 'th:not(:first-child)'
				}
			}
			],
			ajax: {
				url: HOST_URL+'collection-serverside',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					columnsDef: [
						'action','plan_date','site_id','site_name','site_category','technician','route','quantity','ro','lift_date','lift_start','lift_finish','filling_finish','site_in','site_out','kwh_reading','kwh_reading_img','hmr_reading','hmr_reading_img','gcu_bef_fill_img','fuel_stock_bef_fill','gcu_aft_fill_img','fuel_stock_aft_fill','fuel_guage_bef_fill_img','dip_stick_bef_fill_img','dip_stick_aft_fill_img','eb_meter_reading','eb_meter_reading_img','filling_qty','filling_date','remark','handbook_img','status'
					]
				},
			},
			columns: [
			{data: 'action'},     
			{data: 'plan_date'},     
			{data: 'site_id'},      
			{data: 'site_name'},      
			{data: 'site_category'},     
			{data: 'technician'},  
			{data: 'route'},  
			{data: 'quantity'},  
			{data: 'ro'},  
			{data: 'lift_date'},  
			{data: 'lift_start'},  
			{data: 'lift_finish'},   
			{data: 'filling_finish'},   
			{data: 'site_in'},  
			{data: 'site_out'},  
			{data: 'kwh_reading'},  
			{data: 'kwh_reading_img'},  
			{data: 'hmr_reading'},  
			{data: 'hmr_reading_img'},  
			{data: 'gcu_bef_fill_img'},  
			{data: 'fuel_stock_bef_fill'},  
			{data: 'gcu_aft_fill_img'},  
			{data: 'fuel_stock_aft_fill'},  
			{data: 'fuel_guage_bef_fill_img'},  
			{data: 'dip_stick_bef_fill_img'},  
			{data: 'dip_stick_aft_fill_img'},  
			{data: 'eb_meter_reading'},
			{data: 'eb_meter_reading_img'},
			{data: 'filling_qty'},
			{data: 'filling_date'},
			{data: 'remark'},
			{data: 'handbook_img'},
			{data: 'status'},
			],
			initComplete: function() {
				this.api().columns().every(function() {
					var column = this;
					switch (column.title()) {
						case 'Route':
						column.data().unique().sort().each(function(d, j) {
							$('.datatable-input[data-col-index="6"]').append('<option value="' + d + '">' + d + '</option>');
						});
						break;
					}
				});
			},
			columnDefs: [
			{
				targets: 0,
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
	CollectTatablesDataSourceAjaxServer.init();
});
