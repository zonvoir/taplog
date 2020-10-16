'use strict';
var PLANDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#trip_datatable').DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			buttons: [
			{ 
				extend: 'csv',
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			},
			{ 
				extend: 'pdf',
				exportOptions: {
					columns: 'th:not(:last-child)'
				},
				orientation: 'landscape',
        		pageSize: 'A2'
			}
			],
			order: [ [0, 'desc'] ],
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
					url: HOST_URL+'trip/trip-data-table',
					type: 'GET',
					data: function(data){
						var start_date = $('#start_date').val();
						var end_date = $('#end_date').val();

						// Append to data
						data.start_date = start_date;
						data.end_date = end_date;
					},
			},
			columns: [
				{data: 'id'},
				{data: 'trip_id'},
				{data: 'effective_date'},
				{data: 'vehicle', name: 'vechile.vehicle_no'},
				{data: 'driver_name', name: 'driver.name' },
				{data: 'filler_name', name: 'filler.name'},
				{data: 'action', orderable: false, searchable: false,},
			],
		});
		
		$('#kt_search').on('click', function(e) {
			e.preventDefault();
			table.draw();
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
			table.button( '.buttons-csv' ).trigger();
		});
		$(document).on('click', '.delete', function(e) {
			var url = $(this).data('href')
			// console.log($(this).data('href'));
		    Swal.fire({
		        title: "Are you sure?",
		        text: "You won't be able to revert this!",
		        icon: "warning",
		        showCancelButton: true,
		        confirmButtonText: "Yes, delete it!"
		    }).then(function(result) {
		        if (result.value) {
		        	$.ajax({
			            url: url,
			            type: "POST",
			            data: {
			                _token: csrf_token
			            },
			            success: function () {
			                Swal.fire(
				                "Deleted!",
				                "Your file has been deleted.",
				                "success"
				            );
			                table.draw();
			            },
			            error: function (xhr, ajaxOptions, thrownError) {
			            	Swal.fire(
				                "Error deleting!",
				                "Please try again.",
				                "error"
				            )
			            }
			        });
		            
		        }
		        
		    });
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
