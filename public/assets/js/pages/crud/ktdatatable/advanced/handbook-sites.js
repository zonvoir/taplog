"use strict";
// Class definition

var KTDatatableRecordSelectionDemo = function() {
    // Private functions
    var id = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: HOST_URL + 'handbook-sites-table',
                    data: {
                        '_token' : $('meta[name="csrf-token"]').attr('content'),
                        tripId: id,
                    },
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
        },

        // layout definition
        layout: {
            scroll: false, // enable/disable datatable scroll both horizontal and
            footer: false // display/hide footer
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition
        columns: [{
            field: 'ID',
            title: '#',
            sortable: false,
            width: 20,
            selector: {
                class: ''
            },
            textAlign: 'center',
        }, {
            field: 'site_id',
            title: 'Site Id',
            template: '{{site_id}}',
        }, {
            field: 'site_name',
            title: 'Site Name',
            template: '{{site_name}}',
        }, {
            field: 'technician_name',
            title: 'Technician Name',
            template: '{{technician_name}}',
        },{
            field: 'technician_contact',
            title: 'Technician Contact',
            template: '{{technician_contact}}',
        }, {
            field: 'status',
            title: 'Status',
            // callback function support for column rendering
            template: function(row) {
                var status = {
                    'loaded': {'title': 'Loaded', 'class': 'label-light-primary'},
                    'assigned': {'title': 'Delivered', 'class': ' label-light-info'},
                    'unloaded': {'title': 'Canceled', 'class': ' label-light-danger'},
                    'filled': {'title': 'Filled', 'class': ' label-light-success'},
                    'not_filled': {'title': 'Not Filled', 'class': ' label-light-warning'},
                };
                return '<span class="label label-lg font-weight-bold' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span>';
            },
        }, ],
    };

    // basic demo
    var localSelectorDemo = function() {
        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true,
        };

        options.search = {
            input: $('#kt_datatable_search_query'),
            key: 'generalSearch'
        };

        var datatable = $('#kt_datatable').KTDatatable(options);


        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();

        datatable.on(
            'datatable-on-check datatable-on-uncheck',
            function(e) {
                var checkedNodes = datatable.rows('.datatable-row-active').nodes();
                var count = checkedNodes.length;
                $('#kt_datatable_selected_records').html(count);
                if (count > 0) {
                    $('#kt_datatable_group_action_form').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form').collapse('hide');
                }
            });

        $('#kt_datatable_fetch_modal').on('show.bs.modal', function(e) {
            var ids = datatable.rows('.datatable-row-active').
            nodes().
            find('.checkbox > [type="checkbox"]').
            map(function(i, chk) {
                return $(chk).val();
            });
            console.log(ids);
            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected ID: ' + ids[i];
                c.appendChild(li);
            }
            $('#kt_datatable_fetch_display').append(c);
        }).on('hide.bs.modal', function(e) {
            $('#kt_datatable_fetch_display').empty();
        });
    };

    var serverSelectorDemo = function() {
        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true,
        };
        options.search = {
            input: $('#kt_datatable_search_query_2'),
            key: 'generalSearch'
        };

        var datatable = $('#kt_datatable_2').KTDatatable(options);

        $('#kt_datatable_search_status_2, #kt_datatable_search_type_2').selectpicker();

        datatable.on(
            'datatable-on-click-checkbox',
            function(e) {
                // datatable.checkbox() access to extension methods
                var ids = datatable.checkbox().getSelectedId();
                var count = ids.length;

                $('#kt_datatable_selected_records_2').html(count);

                if (count > 0) {
                    $('#kt_datatable_group_action_form_2').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form_2').collapse('hide');
                }
            });

        $('#kt_datatable_fetch_modal_2').on('show.bs.modal', function(e) {
            var ids = datatable.checkbox().getSelectedId();
            var c = document.createDocumentFragment();
            for (var i = 0; i < ids.length; i++) {
                var li = document.createElement('li');
                li.setAttribute('data-id', ids[i]);
                li.innerHTML = 'Selected ID: ' + ids[i];
                c.appendChild(li);
            }
            $('#kt_datatable_fetch_display_2').append(c);
        }).on('hide.bs.modal', function(e) {
            $('#kt_datatable_fetch_display_2').empty();
        });
    };

    return {
        // public functions
        init: function() {
            localSelectorDemo();
            serverSelectorDemo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableRecordSelectionDemo.init();
});
