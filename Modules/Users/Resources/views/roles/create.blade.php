@extends('layouts.master', ['title' => 'roles'])

@section('content')
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Roles</h2>
                <ul class="breadcrumb padding-0">
                    <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles list</a></li>
                    <li class="breadcrumb-item active">Add new role</li>
                </ul>
            </div>
        </div>
    </div>
    <form action="{{route('roles.store')}}" id="form_advanced_validation" method="post">
        @csrf
        @component('components.input',['label' => 'Name', 'type'  => 'text','name'  => 'name'])@endcomponent
        <!-- permissions -->
        <div class="form-group">
        <label id="permissions"> choose permissions <span class="text-danger">*</span></label>
        @if ($errors->has("permissions"))
            <span class="form-text text-danger">{{$errors->first("permissions")}}</span>
        @endif
        <div class="checkbox-list">
            <div class="row">
                @foreach($permissions as $key => $permission)
                <div class="col-sm-3">
                    <div class="card">
                        <div class="body p-0">
                            <div class="mb-2">
                                <div class="card-header">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkAll" data-group="{{$key}}"
                                                value="{{$key}}" id="permission-{{$key}}"  />
                                        <label class="custom-control-label" for="permission-{{$key}}">{{$key}}</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($permission as $method)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input {{$key}}"
                                                   name="permissions[]" {{in_array($key . '.' . $method, (old('permissions') ? old('permissions') : [])) ? 'checked="checked"' :''}} value="{{$key . '.' . $method}}" id="permission-{{$key . '_' .$method}}"  />
                                            <label class="custom-control-label" for="permission-{{$key . '_' .$method}}">{{$method}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
        <div class="container text-center">
            <button type="submit" class="btn btn-primary mr-2 special_button" id="submit-all">save</button>
        </div>
    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', '.checkAll', function () {
                var group = $(this).data('group');
                $('.' + group).prop('checked', this.checked);
            });
            // Submit form data via Ajax
            $("#form_advanced_validation").on('submit', function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function(){
                            $('.submitBtn').attr("disabled","disabled");
                            $('#form_advanced_validation').css("opacity",".5");
                        },
                        success: function(response){ //console.log(response);
                            $('#form_advanced_validation').css("opacity","");
                            $(".submitBtn").removeAttr("disabled");
                            $(".has-error").text("");

                            if(response.errors){
                                $.each(response.errors, function( index, value ) {
                                    $('#' + index).after(`<span class="has-error text-danger mt-1">${value}</span>`);
                                });
                            }
                            if(response.success){
                                location.href = response.url
                            }
                        }
                    });
                });
        });
        </script>
@endpush
