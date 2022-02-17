<!DOCTYPE html>
<html lang="en-US" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        .logo{
            text-align: center;
            margin-bottom: 20px;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>

<div class="logo">
    <img src="{{$message->embed('https://api.app.readtolead.info/assets/images/logo.png')}}" alt="LIMO APP">
</div>
    <p class="text-right"><span>({{$data['name'] ?? ''}})</span> مرحباً </p>
    <p class="text-center">،<span>LIMO APP</span> نتشرف بوجودكم للانضمام إلينا في تطبيق</p>
    <p class="text-center">
    ونتمنى لكم الاستمتاع بأفضل الملخصات العربية .والأجنبية المترجمة، نأمل أن نكون عند حُسن توقعاتكم
    </p>

    <div class="text-right" dir="rtl">
        <p>مزايا تطبيق ريد تو ليد: </p>
        <ul dir="rtl">
            <li>ملخصات لأهم الكتب العالمية والعربية.</li>
            <li>ملخصات كتب أجنبية مترجمة للغة العربية.</li>
            <li>تطبيق يضم أكثر من 1000 كتاب في مجالات عديدة.</li>
            <li>ملخصات تستطيع قراءتها في 15 دقيقة فقط.</li>
            <li>تستطيع تحميل وقراءة كافة الكتب فيما بعد بدون إنترنت.</li>
        </ul>
    </div>
</body>
</html>

