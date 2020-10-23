'use strict';
var HandbookTatablesDataSourceAjaxServer = function() {
	var initTable1 = function() {
		var id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
		var table = $('#handbook_site_data_table').DataTable({
			responsive: true,
			select: {
				style: 'multi',
				selector: 'td:first-child .checkable',
			},
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
				pageSize: 'A2',
			}
			],
			ajax: {
				url: HOST_URL+'handbook-sites-table',
				type: 'POST',
				data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					tripId: id,
					columnsDef: [
					'site_id','site_name','technician_contact','status'
					]
				},
			},
			columns: [
			{data: 'ID'},      
			{data: 'site_id'},      
			{data: 'site_name'},      
			{data: 'technician_name'},     
			{data: 'technician_contact'},     
			{data: 'status'},     
			{data: 'handbook'},     
			],
			headerCallback: function(thead, data, start, end, display) {
				thead.getElementsByTagName('th')[0].innerHTML = `
				<label class="checkbox checkbox-single checkbox-solid checkbox-primary mb-0">
				<input type="checkbox" value="" class="group-checkable"/>
				<span></span>
				</label>`;
			},
			columnDefs: [
			{
				targets: 0,
				orderable: false,
				render: function(data, type, full, meta) {
					var elem =  full.status == 'filled' ? `<label class="checkbox checkbox-single checkbox-primary mb-0">
					<input type="checkbox" value="`+data+`" class="checkable"/>
					<span></span>
					</label>` : ``;
					return elem;
				},
			},
			{
				width: '75px',
				title: 'Status',
				targets: 5,
				render: function(data, type, full, meta) {
					var status = {
						'assigned': {'title': 'Assigned', 'class': 'label-light-primary'},
						'unloaded': {'title': 'Unloaded', 'class': ' label-light-danger'},
						'filled': {'title': 'Filled', 'class': ' label-light-success'},
						'loaded': {'title': 'Loaded', 'class': ' label-light-info'},
						'not_filled': {'title': 'Not Filled', 'class': ' label-light-warning'},
					};
					if (typeof status[data] === 'undefined') {
						return data;
					}
					return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
				},
			},
			{
				width: '75px',
				title: 'Handbook',
				data: 'handbook',
				targets: 6,
				render: function(data, type, full, meta) {
					var elem =  data !== null ? `<a data-fancybox="gallery" href="`+HOST_URL+`public/images/`+data+`"><div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4"><div class="symbol-label" style="background-image: url('`+HOST_URL+`public/images/`+data+`')"></div></div></a>` : `NA`;
					return elem;
				},
			}

			]
		});
		$("#exportBeattoPdf").on("click", function() {
			table.button( '.buttons-pdf' ).trigger();
		});
		$("#exportBeattoExcel").on("click", function() {
			table.button( '.buttons-excel' ).trigger();
		});
		table.on('change', '.group-checkable', function() {
			var set = $(this).closest('table').find('td:first-child .checkable');
			var checked = $(this).is(':checked');
			$(set).each(function() {
				if (checked) {
					$(this).prop('checked', true);
					table.rows($(this).closest('tr')).select();
				}
				else {
					$(this).prop('checked', false);
					table.rows($(this).closest('tr')).deselect();
				}
			});
		});
		var data = [];
		table.on( 'select', function ( e, dt, type, indexes ) {
			if ( type === 'row' ) {
				data = table.rows( indexes ).data().pluck( 'ID' );
				ids.push(data[0]);
				$('#upload-handbook-btn').css('display','block');
			}
		});
		table.on( 'deselect', function ( e, dt, type, indexes ) {
			if ( type === 'row' ) {
				data = table.rows( indexes ).data().pluck( 'ID' );
				ids.splice(ids.indexOf(data[0]), 1);
				if(ids.length == 0){
					$('#upload-handbook-btn').css('display','none');
				}
			}
		});
		$("input[type='search']").on( 'keyup', function () {
			$('#upload-handbook-btn').css('display','none');
			//table.search( this.value ).draw();
		} );

		var handbookUploadDz = new Dropzone("#handbook-upload",{
			method: 'POST',
            url: HOST_URL+"upload-handbook", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
		handbookUploadDz.on("sending", function (file, xhr, formData) {
			formData.append("ids", ids);
		});
		handbookUploadDz.on("success", function(file,resp) {
			if(resp.status == 1){
				this.defaultOptions.success(file, resp.message)
				$('#upload-handbook-btn').css('display','none');
				table.draw();
			}else{
				this.defaultOptions.error(file, resp.message);
			}
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
