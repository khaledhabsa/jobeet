@extends('layouts.master', ['title' => 'Admins'])
@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Admins</h2>
                <ul class="breadcrumb padding-0">
                    <li class="breadcrumb-item active">Admins list</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Basic Table -->
    @can('admins.create')
        <a href="{{route('admins.create')}}" class="btn btn-round">
            <i class="zmdi zmdi-favorite-outline6"></i> Add new Admin
        </a>
    @endcan
    <div class="card">
        <div class="body">
            <form class="filters-form">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group mb-2">
                            <input type="text" name="filter_keyword" class="form-control" id="filter_keyword" placeholder="Filter by name, email">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group mb-2">
                            <button type="submit" class="btn btn-primary mb-2 mt-0 btn-round">Filter</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="admins-list">
        @include('users::admins.table')
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('body').on('click', '.pagination .page-item a.page-link', function(e) {
                var url = $(this).attr('href');
                getPagess(url);
                window.history.pushState("", "", url);
                return false;
            });

            function getPagess(url) {
                $.ajax({
                    url : url,
                    beforeSend: function(){
                        $('.admins-list').css("opacity",".3");
                    }
                }).done(function (data) {
                    $('.admins-list').css("opacity","").html(data);
                }).fail(function () {
                    alert('Pages could not be loaded.');
                });
            }
        });

        $('body').on('submit', '.filters-form', function(e) {
            $.ajax({
                url : $(this).attr('action'),
                data : {filter_keyword:$('#filter_keyword').val()},
                beforeSend: function(){
                    $('.admins-list').css("opacity",".3");
                }
            }).done(function (data) {
                $('.admins-list').css("opacity","");
                $('.admins-list').html(data);
            }).fail(function () {
                alert('Admins could not be loaded.');
            });

            return false;
        });
    </script>
@endpush

