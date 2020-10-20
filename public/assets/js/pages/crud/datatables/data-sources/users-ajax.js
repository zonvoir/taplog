'use strict';
var USERDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#user_datatable').DataTable({
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
			ajax: {
				url: HOST_URL+'index-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					// parameters for custom backend script demo
					columnsDef: [
					'id','name', 'email',
					'contact', 'type', 'status',
					'created_at','action'
					],
				},
			},
			columns: [
			{data: 'id'},
			{data: 'name'},
			{data: 'email'},
			{data: 'contact'},
			{data: 'type'},
			{data: 'status'},
			{data: 'created_at'},
			{data: 'action', responsivePriority: -1},
			],
			columnDefs: [
			{
				targets: -1,
				title: 'Action',
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
		$('#user_datatable').on('click', '.del-user', function(){
			var id = $(this).attr('user-id');
			Swal.fire({
				title: "Are you sure?",
				text: "You would not be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, delete it!"
			}).then(function(result) {
				if (result.value) {
					$.post( HOST_URL+"user-remove",{'_token' : $('meta[name="csrf-token"]').attr('content'), id: id }, function( resp ) {
						if(resp){
							Swal.fire(
								"Deleted!",
								"User has been deleted.",
								"success"
								)
							table.row( $(this).parents('tr') ).remove().draw();
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
	USERDatatablesDataSourceAjaxServer.init();
});
function userDetails(id) {
	let data = {id: id, "_token": $('meta[name="csrf-token"]').attr('content')};
	$.post( HOST_URL+"user-details-ajax",data, function( resp ) {
		if(resp){
			$("#modalTableUser").html(resp);
			$("#userModal").modal('show');
		}else{
			Swal.fire({
				title: 'Data not updated yet!',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				 icon: "error"
			});
		}
	});
}