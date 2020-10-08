@extends('layouts.app', ['page' => __('collections'), 'pageSlug' => 'collections'])
@section('content')
<style type="text/css">
  /* Style the Image Used to Trigger the Modal */
  .myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .myImg:hover {opacity: 0.7;}

  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
  }

  /* Modal Content (Image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 60%;
    max-width: 500px;
  }

  /* Caption of Modal Image (Image Text) - Same Width as the Image */
  #caption {
    margin: auto;
    display: block;
    width: 50%;
    max-width: 500px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 80px;
  }

  /* Add Animation - Zoom in the Modal */
  .modal-content, #caption {
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
  }

  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 350px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close:hover,
  .close:focus {
    text-decoration: none;
    cursor: pointer;
  }

  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 500px){
    .modal-content {
      width: 80%;
    }
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h4 class="card-title"> Collection Table</h4></div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
         <div class="row dates">
          <div class="col">
            <div class="input-group input-daterange">
              <input type="text" id="min" class="form-control" placeholder="From">
              <div class="input-group-addon">to</div>
              <input type="text" id="max" class="form-control" placeholder="To">
            </div>
          </div>
          <div class="col"><button type="button" name="filter" id="filter-btn" class="btn btn-fill btn-primary">Filter</button></div>
        </div>
        <table id="collection-tbl" class="display" style="width:100%">
          <thead>
            <tr>
             <th class="noExport">Beat Plans</th>
             <th class="noExport">Action</th>
             <th>
              Beat Plan date
            </th>
             <th>
              Site Id
            </th>
             <th>
              Site Name
            </th>
             <th>
              Beat Plan(Ltr):
            </th>
            <th>
              Lifting date
            </th>
            <th>
              Delivery date
            </th>
            <th>
              KWH Reading
            </th>
            <th>
              KWH Reading Photo
            </th>
            <th>
              HMR Reading
            </th>
            <th>
              HMR Reading Photo
            </th>
            <th>
              GCU Before Filling Photo
            </th>
            <th>
              Fuel Stock Before Filling
            </th>
            <th>
              GCU After Filling Photo
            </th>
            <th>
              Fuel Stock After Filling
            </th>
            <th>
              Fuel Gauge Before Filling
            </th>
            <th>
              Fuel Gauge After Filling
            </th>
            <th>
              Dip Stick Before Filling
            </th>
            <th>
              Dip Stick After Filling
            </th>
            <th>
              EB Meter Reading
            </th>
            <th>
              EB Meter Reading Photo
            </th>
            <th>
              Filling Qty
            </th>
            <th>
              Entry Date
            </th>
            <th>
              Remark
            </th>
            <th>
              Handbook Photo
            </th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span id="closeModal" class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>
<script type="text/javascript">
  var modal = document.getElementById("myModal");
  var modalImg = document.getElementById("img01");
  var captionText = document.getElementById("caption");
  zoomImage = function(e){
    modal.style.display = "block";
    modalImg.src = e.src;
    captionText.innerHTML = e.alt;
  }

// Get the <span> element that closes the modal
var span = document.getElementById("closeModal");

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
</script>
@endsection