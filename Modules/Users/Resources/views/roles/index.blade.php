@extends('layouts.master', ['title' => 'Roles'])
@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Roles</h2>
                <ul class="breadcrumb padding-0">
                    <li class="breadcrumb-item active">Roles list</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Basic Table -->
    @can('roles.create')
        <a href="{{route('roles.create')}}" class="btn btn-round">
            <i class="zmdi zmdi-favorite-outline6"></i> Add new Role
        </a>
    @endcan
    <div class="roles-list">
        @include('users::roles.table')
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
                        $('.roles-list').css("opacity",".3");
                    }
                }).done(function (data) {
                    $('.roles-list').css("opacity","").html(data);
                }).fail(function () {
                    alert('Pages could not be loaded.');
                });
            }
        });
    </script>
@endpush

