<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LIMO APP | add new account</title>
    <!-- Bootstrap -->
    <link href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <style>
        .share-card {
            box-shadow: 0 0 4px -2px #000;
            padding: 10px;
            text-align: center;
            margin-top: 80px;
        }

        span#ref_code {
            display: inline-block;
            padding: 5px 10px;
            background: #eee;
            color: #555;
            font-weight: bold;
        }

        button.copy-btn {
            border: 0;
            padding: 5px 10px;
            background: #F1F6F7;
        }

        .link{
            width: 50%;
            margin: 10px auto 0;
            background: #cbffaa;
            padding: 10px;
            border-radius: 10px;
        }
        .link a{
            color:#555;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-lg-6 offset-md-3 offset-lg-3">
            <div class="share-card">
                <p>قم بالتسجيل الأن واضافة كود المشاركة للحصول على نقاط مجانية</p>
                <div class="code">
                    <span id="ref_code">{{$code}}</span>
                    <button class="copy-btn" onclick="copyToClipboard('#ref_code')">نسخ</button>
                </div>
                <div class="link"><a href="{{$link}}">حمل التطبيق</a></div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="{{asset('assets/vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
</body>
</html>
