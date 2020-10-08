<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Taplog') }}</title>
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/black') }}/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('public/black') }}/img/favicon.png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('public/black') }}/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS -->
  <link href="{{ asset('public/black') }}/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <link href="{{ asset('public/black') }}/css/theme.css" rel="stylesheet" />
  <style type="text/css">
    td.details-control {
      background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
      cursor: pointer;
    }
    tr.shown td.details-control {
      background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
  </style>
  <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
  @stack('css')
  <script>
    var base_url  = "<?php echo url('/'); ?>";
    var csrf_token  = "<?php echo csrf_token(); ?>";
  </script>
</head>
<body class="{{ $class ?? '' }}">
  @auth()
  <div class="wrapper">
    @include('layouts.navbars.flash-message')
    @include('layouts.navbars.sidebar')
    <div class="main-panel">
      @include('layouts.navbars.navbar')

      <div class="content">
        @yield('content')
      </div>

      @include('layouts.footer')
    </div>
  </div>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  @else
  @include('layouts.navbars.navbar')
  <div class="wrapper wrapper-full-page">
    <div class="full-page {{ $contentClass ?? '' }}">
      <div class="content">
        <div class="container">
          @yield('content')
        </div>
      </div>
      @include('layouts.footer')
    </div>
  </div>
  @endauth
  <script src="{{ asset('public/black') }}/js/core/jquery.min.js"></script>
  <script src="{{ asset('public/black') }}/js/core/popper.min.js"></script>
  <script src="{{ asset('public/black') }}/js/core/bootstrap.min.js"></script>
  <script src="{{ asset('public/black') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
  <!-- Chart JS -->
  {{-- <script src="{{ asset('public/black') }}/js/plugins/chartjs.min.js"></script> --}}
  <!--  Notifications Plugin    -->
  <script src="{{ asset('public/black') }}/js/plugins/bootstrap-notify.js"></script>

  <script src="{{ asset('public/black') }}/js/black-dashboard.min.js?v=1.0.0"></script>
  <script src="{{ asset('public/black') }}/js/theme.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

  <script>
    var clientPath = "{{ route('client-name-list') }}";
    var siteBasePath = "{{ route('site-name-list') }}";
    var sitePath = "";
    $('#clientname').typeahead({
      source: function(query, process) {
        return $.get(clientPath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('#clientname').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              console.log(current.id);
              $("input[name='client_id']").val(current.id);
              sitePath += siteBasePath+'/'+current.gst;
            } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    $('.clientname').typeahead({
      source: function(query, process) {
        return $.get(clientPath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('.clientname').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              console.log(current.id);
              $("input[name='client_id_update']").val(current.id);
            } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    var zonepath = "{{ route('zone-name-list') }}";
    $('.zone').typeahead({
      source: function(query, process) {
        return $.get(zonepath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('#zone').typeahead({
      source: function(query, process) {
        return $.get(zonepath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('#site_name').typeahead({
      source: function(query, process) {
        return $.get(sitePath, {
          name: query
        }, function(data) {
          $("#hidden-div").show();
          return process(data);
        });
      }
    });
    $('#site_name').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              // console.log(current.id);
              $("input[name='site_id']").val(current.id);
            } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    var effectiveDatePath = '';
    var effectiveDateBasePath = "{{ route('effective-date') }}";
    var routePath = '';
    var routeBasePath = "{{ route('route-name') }}";
    var assetPath = '';
    var assetBasePath = "{{ route('asset-name-list') }}"; 
    $('#zone').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            console.log(current);
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              // console.log(current.id);
              effectiveDatePath += effectiveDateBasePath+'/'+current.name;
              routePath += routeBasePath+'/'+current.name;
              assetPath += assetBasePath+'/'+current.name;
            } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    $('#effective_date').typeahead({
      source: function(query, process) {
        return $.get(effectiveDatePath, {
          name: query
        }, function(data) {

          return process(data);
        });
      }
    });
    var siteIdPath = ''; 
    var siteIdBasePath = "{{'site-details-trip'}}"; 
    $('#effective_date').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              $("#beatPlanIdForS").val(current.id);
              $("#effective_date123").val(current.effective_date);
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              // console.log(current.id);
              siteIdPath = siteIdBasePath+'/'+$("#zone").val()+'/'+current.name;
            } else {
              $(this).val('');
              $("#beatPlanIdForS").val('');
              $("#effective_date123").val('');
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    $('#route').typeahead({
      source: function(query, process) {
        return $.get(routePath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('#route').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("input[name='route_id']").val(current.id);
              $("input[name='route_id_name']").val(current.name);
              
            } else {
              $("input[name='route_id']").val('');
              $("input[name='route_id_name']").val('');
              $(this).val('');
              $(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });  
    var vehiclePath = "{{ route('vehicle-number')}}";
    $('#vehicale_number').typeahead({
      source: function(query, process) {
        return $.get(vehiclePath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('#vehicale_number').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("input[name='vehicale_id']").val(current.id);
              
            } else {
              $("input[name='vehicale_id']").val('');
              $("input[name='vehicale_number']").val('');
              $(this).val('');
              $(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    var driverPath = "{{ route('driver-name')}}";
    $('#driver').typeahead({
      source: function(query, process) {
        return $.get(vehiclePath, {
          name: query
        }, function(data) {
          if(data.length > 0){
            $("input[name='driver_id']").val(data[0].id);
          }
          return process(data);
        });
      }
    });
    $('#asset_name').typeahead({
      source: function(query, process) {
        return $.get(assetPath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('#asset_name').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              // console.log(current.id);
              $("input[name='asset_id']").val(current.id);
            } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    $('#site_id').typeahead({
      source: function(query, process) {
        return $.get(siteIdPath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });  
    $('#site_id').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              // console.log(current.id);
              $("input[name='siteid']").val(current.id);
              $("#site_name").html(current.sitename);
              $("#quantity").html(current.quantity);
            } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    var effectiveDateLoadPath = "{{route('effective-date-load')}}";
    var tripIdLoadPath = '';
    var tripIdLoadBasePath = "{{route('trip-id-load')}}";
    $('#effective_date_load').typeahead({
      source: function(query, process) {
        return $.get(effectiveDateLoadPath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });
    $('#effective_date_load').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              $("#effective_date123").val(current.effective_date);
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              // console.log(current.id);
              tripIdLoadPath = tripIdLoadBasePath+'/'+current.effective_date;
            } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });
    $('#trip_id').typeahead({
      source: function(query, process) {
        return $.get(tripIdLoadPath, {
          name: query
        }, function(data) {
          return process(data);
        });
      }
    });    
    $('#trip_id').change(function() {
      var current = $(this).typeahead("getActive");
      if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("input[name='vehicle_number']").val(current.vehicle_no);
              $("input[name='vehicle_id']").val(current.vehicle_id);
              
            } else {
              $("input[name='vehicle_number']").val('');
              $("input[name='vehicle_id']").val('');
              $(this).val('');
              $(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
            }
          } else {
            // Nothing is active so it is a new value (or maybe empty value)
          }
        });      
    function updateTime() {

      var fromDate = document.getElementById('min').value;
      var toDate = document.getElementById('max').value;
      var returnArray = new Array();
      returnArray[0] = fromDate;
      returnArray[1] = toDate;
      return returnArray;
    }
    function format ( d ) {
      return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
      '<tr>'+
      '<td>Site Type:</td>'+
      '<td>'+d.site_type+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Maintenance Point:</td>'+
      '<td>'+d.mp_zone+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Technician Name:</td>'+
      '<td>'+d.technician_name+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Tech Mob No.:</td>'+
      '<td>'+d.technician_contact1+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Route Name:</td>'+
      '<td>'+d.route_name+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>RO Name/Petrol Pump Name :</td>'+
      '<td>'+d.pumpname+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Latitude:</td>'+
      '<td>'+d.latitude+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Longitude:</td>'+
      '<td>'+d.longitude+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Driver Name:</td>'+
      '<td>'+d.driver_name+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Driver Mobile:</td>'+
      '<td>'+d.driver_mobile+'</td>'+
      '</tr>'+
      '<td>Filler Name:</td>'+
      '<td>'+d.filler_name+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Filler Mobile:</td>'+
      '<td>'+d.filler_mobile+'</td>'+
      '</tr>'+
      '<tr>'+
      '<td>Vehicle No.:</td>'+
      '<td>'+d.vehicle_no+'</td>'+
      '</tr>'+
      '</table>';
    }
    $(document).ready(function() {
      var table = $('#collection-tbl').DataTable({
       "processing": true,
       "serverSide": true,
       "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       "ajax": {
        "url": "{{route('collection-serverside')}}",
        "data" : function ( d ) {
          d.startdate = $('#min').val(),
          d.enddate = $('#max').val()
        }
      },
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Enter site id"
      },
      dom: 'Blfrtip',
      buttons: [
      {
        extend: 'excelHtml5',
        exportOptions: {
          orthogonal:null,
          format: {
            body: function ( data, row, column, node ) {
              return (column === 15 || column === 17 || column === 18 || column === 20 || column === 27 || column === 31) && data != null ? '{{ URL::to("/public/images/")}}/'+data : data;
            }
          },
          columns: "thead th:not(.noExport)"
        }
      },
      {
        extend: 'pdfHtml5',
        exportOptions: {
          orthogonal:null,
          format: {
            body: function ( data, row, column, node ) {
              return (column === 15 || column === 17 || column === 18 || column === 20|| column === 27 || column === 31) && data != null ? '{{ URL::to("/public/images/")}}/'+data : data;
            }
          },
          columns: "thead th:not(.noExport)"
        },
        orientation: 'landscape',
        pageSize: 'A2'
      }
      ],
      "columns": [
            // {
            //     "className":      'details-control',
            //     "orderable":      true,
            //     "data":           null,
            //     "defaultContent": '',
            // },
            {
              "data": "id",
              "data1": null,
              "render": function(data,type,data1){
                let verified_load_id = data1.verified_load_id;
                let anchor_tag = verified_load_id ? '<a href="{{url("edit-collection")}}/'+data+'" class="btn btn-primary btn-sm btn-icon"><i class="tim-icons icon-pencil"></i></a>' : '<a href="{{url("create-collection")}}/'+data+'" class="btn btn-success btn-sm btn-icon"><i class="tim-icons icon-simple-add"></i></a>'
                return anchor_tag;
              }
            },
            { 
              "orderable": false,
              "data": "effective_date"
            },
            { "data": "site_id" },
            { "data": "site_name" },
            { "data": "site_category" },
            { "data": "technician_name" },
            { "data": "route_name" },
            { "data": "quantity" },
            { "data": "loadingPointName" },
            { "data": "loading_start" },
            { 
              "data": "loading_start",
              "render": function(data,type){
                let dt = '';
                if(data){
                  dt = new Date(data);
                  return dt.getHours()+':'+dt.getMinutes(); 
                }else{
                  return dt;
                }
              }
            },
            { 
              "data": "loading_finish",
              "render": function(data,type){
                let dt = '';
                if(data){
                  dt = new Date(data);
                  return dt.getHours()+':'+dt.getMinutes(); 
                }else{
                  return dt;
                }
              }
            },
            { "data": "selling_date" },
            { "data": "site_in" },
            { "data": "site_out" },
            { "data": "kwh_reading" },
            { 
              "data": "kwh_reading_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { "data": "hmr_reading" },
            { 
              "data": "hmr_reading_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { 
              "data": "gcu_bef_fill_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { "data": "fuel_stock_bef_fill" },
            { 
              "data": "gcu_aft_fill_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { "data": "fuel_stock_aft_fill" },
            { 
              "data": "fuel_guage_bef_fill_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { 
              "data": "fuel_guage_aft_fill_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { 
              "data": "dip_stick_bef_fill_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { 
              "data": "dip_stick_aft_fill_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { "data": "eb_meter_reading" },
            { 
              "data": "eb_meter_reading_img",
              "render": function(data,type){
                let imgtag = data ? '<img style="height: 30px; width: 20px; cursor: pointer;" onclick="zoomImage(this);" class="myImg" src="{{ URL::to("/public/images/")}}/'+data+'">' : data;
                return imgtag;
              }
            },
            { "data": "filling_qty" },
            { "data": "filling_date" },
            { "data": "remark" },
            { 
              "data": "handbook_img",
              "render": function(data,type){
                let imgtag = data ? '<a href="{{ URL::to("/public/images/")}}/'+data+'" download><img style="height: 30px; width: 20px; cursor: pointer;" class="myImg" src="{{ URL::to("/images/")}}/'+data+'"></a>' : data;
                return imgtag;
              }
            },
            {
              "data" : "diverFromSiteid",
              "render" : function(data,type,row) {
                let str = data ? 'Diverted From: '+data+' Quantity: '+row.divert_qty : row.divertTositeid ? 'Diverted To: '+row.divertTositeid+' Qantity: '+row.divert_qty : 'Not Diverted';
                return str
              }
            }
            ],
            "order": [[1, 'desc']]
          });
var date = new Date();
$('.input-daterange').datepicker({
  todayBtn: 'linked',
  format: 'dd-M-yy',
  autoclose: true
});
$('#filter-btn').click(function(){
  table.draw();
});
$('#collection-tbl tbody').on('click', 'td.details-control', function () {
  var tr = $(this).closest('tr');
  var row = table.row( tr );

  if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                      }
                      else {
                        // Open this row
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                      }
                    } );
$().ready(function() {
  $sidebar = $('.sidebar');
  $navbar = $('.navbar');
  $main_panel = $('.main-panel');

  $full_page = $('.full-page');

  $sidebar_responsive = $('body > .navbar-collapse');
  sidebar_mini_active = true;
  white_color = false;

  window_width = $(window).width();

  fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

  $('.fixed-plugin a').click(function(event) {
    if ($(this).hasClass('switch-trigger')) {
      if (event.stopPropagation) {
        event.stopPropagation();
      } else if (window.event) {
        window.event.cancelBubble = true;
      }
    }
  });

  $('.fixed-plugin .background-color span').click(function() {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');

    var new_color = $(this).data('color');

    if ($sidebar.length != 0) {
      $sidebar.attr('data', new_color);
    }

    if ($main_panel.length != 0) {
      $main_panel.attr('data', new_color);
    }

    if ($full_page.length != 0) {
      $full_page.attr('filter-color', new_color);
    }

    if ($sidebar_responsive.length != 0) {
      $sidebar_responsive.attr('data', new_color);
    }
  });

  $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
    var $btn = $(this);

    if (sidebar_mini_active == true) {
      $('body').removeClass('sidebar-mini');
      sidebar_mini_active = false;
      blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
    } else {
      $('body').addClass('sidebar-mini');
      sidebar_mini_active = true;
      blackDashboard.showSidebarMessage('Sidebar mini activated...');
    }

                        // we simulate the window Resize so the charts will get updated in realtime.
                        var simulateWindowResize = setInterval(function() {
                          window.dispatchEvent(new Event('resize'));
                        }, 180);

                        // we stop the simulation of Window Resize after the animations are completed
                        setTimeout(function() {
                          clearInterval(simulateWindowResize);
                        }, 1000);
                      });

  $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
    var $btn = $(this);

    if (white_color == true) {
      $('body').addClass('change-background');
      setTimeout(function() {
        $('body').removeClass('change-background');
        $('body').removeClass('white-content');
      }, 900);
      white_color = false;
    } else {
      $('body').addClass('change-background');
      setTimeout(function() {
        $('body').removeClass('change-background');
        $('body').addClass('white-content');
      }, 900);

      white_color = true;
    }
  });
});
});
var siteMasterTable = $('#site-tbl').DataTable({
  "processing": true,
  "serverSide": true,
  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
  "ajax": {
    "url": "{{route('site-serverside')}}"
  }, 
  dom: 'Blfrtip',
  buttons: [
  'excel',
  {
    extend: 'pdfHtml5',
    orientation: 'landscape',
    pageSize: 'LEGAL'
  }
  ],
  "columns": [
  {
    "data": "id",
    "render": function(data,type){
      let anchor_tag = '<a href="{{url("site.edit")}}/'+data+'" rel="tooltip" class="btn btn-success btn-sm btn-icon"><i class="tim-icons icon-pencil"></i></a><a href="{{url("delete-site")}}/'+data+'" onclick="" rel="tooltip" class="btn btn-danger btn-sm btn-icon"><i class="tim-icons icon-simple-remove"></i></a>';
      return anchor_tag;
    }
  },
  { "data": "site_id" },
  { "data": "unique_site_id" },
  { "data": "site_name" },
  { "data": "cluster_jc" },
  { "data": "district" },
  { "data": "mp_zone" },
  { "data": "site_address" },
  { "data": "latitude" },
  { "data": "longitude" },
  { "data": "site_type" },
  { "data": "bts" },
  { "data": "site_category" },
  { "data": "battery_bank_ah" },
  { "data": "cph" },
  { "data": "indoor_bts" },
  { "data": "outdoor_bts" },
  { "data": "dg1_make" },
  { "data": "dg2_make" },
  { "data": "dg1_rating_in_kva" },
  { "data": "dg2_rating_in_kva" },
  { "data": "eb_status" },
  { "data": "eb_type" },
  { "data": "eb_load_kw" },
  { "data": "technician_name" },
  { "data": "dg2_make" },
  { "data": "cluster_incharge_name" },
  { "data": "dg2_make" },
  { "data": "cluster_incharge_email" },
  { "data": "zom_name" },
  { "data": "zom_contact" },
  { "data": "zom_email" },
  { "data": "energy_man_name" },
  { "data": "energy_man_contact" },
  { "data": "energy_man_email" },
  { "data": "circle_facility_head_name" },
  { "data": "circle_facility_head_contact" },
  { "data": "circle_facility_head_email" },
  { "data": "client_name" },
  { "data": "billing_address" },
  { "data": "gst_no" },
  {
    "data": "created_at",
    "render": function(data,type){
      let date = new Date(data);
      let created_at = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
      return created_at;
    }
  }
  ],
  "order": [[1, 'desc']]
});
$(document).ready(function() {
  var beatPlantable = $('#beat-plan-tbl').DataTable({
   "processing": true,
   "serverSide": true,
   "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
   "ajax": {
    "url": "{{route('beat-plan-serverside')}}"
  },
  dom: 'Blfrtip',
  buttons: [
  'excel',
  {
    extend: 'pdfHtml5',
    orientation: 'landscape',
    pageSize: 'LEGAL'
  }
  ],
  @if(auth() && auth()->user() && auth()->user()->type !== 'admin')
  columnDefs: [
  { targets: [0], visible: false},
  ],
  @endif
  "columns": [
  {
    "data": "id",
    "render": function(data,type){
      let anchor_tag = '<a href="{{url("edit-beat-plan")}}/'+data+'" rel="tooltip" class="btn btn-success btn-sm btn-icon"><i class="tim-icons icon-pencil"></i></a><a href="{{url("delete-beat-plan")}}/'+data+'" onclick="" rel="tooltip" class="btn btn-danger btn-sm btn-icon"><i class="tim-icons icon-simple-remove"></i></a>';
      return anchor_tag;
    }
  },
  { "data": "name" },
  { "data": "plan_date" },
  { "data": "maintenance_point" },
  { "data": "site_id" },
  { "data": "site_name" },
  { "data": "site_type" },
  { "data": "beat_plan_ltr" },
  { "data": "technician_name" },
  { "data": "technician_mobile" },
  { "data": "route_plan" },
  { "data": "ro_name" },
  { "data": "latitude" },
  { "data": "longitude" },
  { "data": "driver_name" },
  { "data": "driver_mobile" },
  { "data": "filler_name" },
  { "data": "filler_mobile" },
  { "data": "vehicle_no" },
  {
    "data": "created_at",
    "render": function(data,type){
      let date = new Date(data);
      let created_at = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
      return created_at;
    }
  }
  ],
  "order": [[1, 'desc']]
});
  $('#beat-plan-tbl tbody').on( 'click', 'tr', function () {
    $(this).toggleClass('selected');
  } );
  $('#beat-plan-del-btn').click( function () {
    var ids = $.map(beatPlantable.rows('.selected').data(), function (item) {
      return item.id;
    });
    if(beatPlantable.rows('.selected').data().length !== 0){
      $.post( "{{route('delete-plan-row')}}", { planids: ids, "_token": $('meta[name="csrf-token"]').attr('content'), })
      .done(function(result){  
       beatPlantable.rows( '.selected' ).remove().draw();
     });
    }else{
      alert("Please select row to delete.")
    }
  } );
  $('#site-id-table').DataTable();
  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true
  });
});
function siteIdAppend(e) {
  if($(e).prop('checked') == true){
    $("#site-id-serched").append('<td id="td-site-id-'+$(e).val()+'"><label class="form-check-label"><input class="form-check-input" name="ids[]" type="checkbox" value="'+$(e).val()+'" checked="true"><span class="form-check-sign"></span><b>'+$(e).attr('site-id')+'</b></label></td>');
  }else
  {
    $('td#td-site-id-'+$(e).val()).remove();
  }
}
function validatePreviousReading(e) {
  $.post( "{{route('get-previous-reading')}}", {
   field_name: $(e).attr('name'),
   input_value: $(e).val(),
   "_token": $('meta[name="csrf-token"]').attr('content'),
   'site_id':$("#exampleInputSiteId").val(), 
   'plan_id': $("input[name=beat_plans_id]").val()
 })
  .done(function(response){  
    if(response.result == 0){
      $(e).val('');
      $(e).siblings('.invalid-feedback').html(response.message).show();
    }else{
      $(e).siblings('.invalid-feedback').html('').hide();
    }
  });
}

</script>
<script>

  var $fileInput = $(".file-input");
  var $droparea = $(".file-drop-area");

// highlight drag area
$fileInput.on("dragenter focus click", function () {
  $droparea.addClass("is-active");
});

// back to normal state
$fileInput.on("dragleave blur drop", function () {
  $droparea.removeClass("is-active");
});

// change inner text
$fileInput.on("change", function () {
  var filesCount = $(this)[0].files.length;
  var $textContainer = $(this).prev();

  if (filesCount === 1) {
    // if single file is selected, show file name
    var fileName = $(this).val().split("\\").pop();
    $textContainer.text(fileName);
  } else {
    // otherwise show number of files
    $textContainer.text(filesCount + " files selected");
  }
});

</script> 
@stack('js')
</body>
</html>
