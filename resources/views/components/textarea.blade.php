<div class="card">
    <div class="body">
        <div class="form-group form-float">
            <label for="{{$name}}">{{$label ?? ''}}</label>
            <textarea id="{{$name}}" name="{{$name}}" cols="60" rows="10" class="form-control {{$classes ?? ''}}" {{isset($required) && $required ? 'required': ''}}>{{ $value ?? old($name) }}</textarea>
        </div>
    </div>
</div>

@push('scripts')
<script>
    tinymce.init({
        selector: "#{{$name}}",
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help emoticons',
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | ltr rtl | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image imagetools table',
        content_style: "@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap'); * { font-family:'Tajawal', sans-serif; 14pt }",
        directionality :`{{$dir == 'rtl' ? 'rtl' : 'ltr'}}`,
        language:'en',
        paste_enable_default_filters: false,
        paste_filter_drop: false,
        paste_webkit_styles:'font-size font-family font-weight white-space',
        paste_auto_cleanup_on_paste: true,
        protect: [
            /\<!\[if !supportLists\]\>/g,     // Protect <![endif]>
            /\<!\[endif\]\>/g,     // Protect <![endif]>
        ]
    });
</script>
@endpush
