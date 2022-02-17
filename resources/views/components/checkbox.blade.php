<div class="card">
    <div class="body">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" id="{{$name}}" name="{{$name}}" class="custom-control-input" {{(isset($value) && $value) ? 'checked="checked"' : ''}}>
            <label class="custom-control-label" for="{{$name}}">{{$label}}</label>
        </div>
    </div>
</div>
