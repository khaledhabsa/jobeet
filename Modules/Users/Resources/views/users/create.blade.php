<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LIMO APP | add new account</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet">
    <style>
        body{
            background: #141414;
            padding-top: 50px;
        }
        .label{
            color:#fff;
        }
        .panel-body {
            box-shadow: 0 0 15px -5px #686868;
            background: #242424;
            padding: 35px 15px 25px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-6 offset-md-3 offset-lg-3">
                <div class="panel panel-primary">
                    <div class="panel-heading label text-center">Enter Your Details Here
                    </div>
                    <div class="panel-body">
                        <form action="{{route('users.storeSubAccount')}}" name="register" method="post" id="register-form">
                           @csrf
                            <input type="hidden" name="invitation_token" value="{{$reference}}">
                            <div class="form-group">
                                <label for="name" class="label">Full Name *</label>
                                <input id="name" name="name" class="form-control" type="text">
                                <span id="error_name" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="label">password *</label>
                                <input id="password" name="password" class="form-control" type="password" data-validation="email">
                                <span id="error_password" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="label">password confirmation*</label>
                                <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" data-validation="email">
                                <span id="error_password_confirmation" class="text-danger"></span>
                            </div>
                            <button id="submit" type="submit" value="submit" class="btn btn-primary text-center">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jquery Core Js -->
    <script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
    <script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->

    <script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>
    <script src="{{asset('assets/js/toastr.min.js')}}"></script>
    <script>
        $( "#submit" ).click(function() {
            $.ajax({
                url:`{{route('users.storeSubAccount')}}`,
                type:'POST',
                data:$('#register-form').serialize(),
                success:function(res){
                    if ('errors' in res){
                        $.each(res.errors, function(key,val){
                            $($(`#${key}`)).css("border-color", "#FF0000");
                            $(`#error_${key}`).text(val[0]);
                        })
                    }else if('fails' in res){
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.error(res.fails);
                    }

                    if ('redirectUrl' in res){
                        console.log(res.redirectUrl)
                        window.location.href = res.redirectUrl

                    }
                }
            })
            return false;
        });
    </script>
</body>
</html>
