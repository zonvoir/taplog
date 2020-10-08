@extends('layouts.app', ['page' => __('Beat Plans'), 'pageSlug' => 'beatplan'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header">
        <div class="row">
          <div class="col-md-4"><h4 class="card-title"> Beat Plan Table</h4></div>
          <div class="col-md-4"><button type="button" class="btn btn-fill btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleModal">Import CSV</button></div>
        </div>
      </div>
      <div class="card-body">
        <button id="beat-plan-del-btn">Delete</button>
        <div class="table-responsive">
          <table class="display" style="width:100%" id="beat-plan-tbl">
            <thead>
              <tr>
                <th>
                  Action
                </th>
                <th>
                  User Name
                </th>
                <th>
                  Date
                </th>
                 <th>
                  Maintenance Point
                </th>
                <th>
                  Site Id
                </th>
                <th>
                  Site Name
                </th>
                <th class="text-center">
                  Site Type
                </th>
                <th class="text-center">
                  Beat Plan(Ltr)
                </th>
                <th class="text-center">
                  Technician Name
                </th>
                <th class="text-center">
                  Tech Mob No.
                </th>
                <th class="text-center">
                  Route Plan
                </th>
                <th class="text-center">
                  RO Name
                </th>
                <th class="text-center">
                  Latitude
                </th>
                <th class="text-center">
                  Longitude
                </th>
                 <th class="text-center">
                  Driver Name
                </th>
                <th class="text-center">
                  Driver Mobile
                </th>
                <th class="text-center">
                  Filler Name
                </th>
                <th class="text-center">
                  Filler Mobile
                </th>
                <th class="text-center">
                  Vehicle No.
                <th class="text-center">
                  Created at
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
<div class="modal modal-black fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="exampleInputCSV">Choose file</label>
            <input type="file" name="file" class="form-control" id="exampleInputCSV" aria-describedby="CSVHelp" placeholder="" required="">
            <small id="CSVHelp" class="form-text text-muted">Click any where here for choose file.</small>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection