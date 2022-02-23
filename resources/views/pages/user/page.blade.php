@extends('layouts.app')
@section('content')
<div id ="main">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h2><strong>User</strong></h2>
                    <p class="text-subtitle text-muted">For user to check user list</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <input type="text" class="form-control" id="keyword" name="keyword" style="width:60%"placeholder="Enter keyword">
                </div>
            </div>
            <div class="col-md-2 text-center">
                <button class="btn btn-info" id="btn-search" onclick="btn_action(this);" data-action="search"><b>SEARCH</b></button>
                <button class="btn btn-primary" id="btn-add" onclick="btn_action(this);" data-action="add"><b>ADD</b></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <div class="table-responsive" id="content-table">
                    @include('pages.user.table')
                    </div>
            </div>
        </div>
    </div>
</div>
@include('pages.user.modal')
@section('plugin')
    <script src="{{ asset('js/pages/user.js') }}" type="text/javascript"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

@endsection
