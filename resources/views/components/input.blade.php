<div class="card">
    <div class="body">
        <div class="form-group form-float">
            <label for="{{$name}}">{{$label ?? ''}}</label>
            <input type="{{$type}}" class="form-control {{$classes ?? ''}}" {{isset($required) ? 'required': ''}}
                id="{{$name}}" name="{{$name}}" value="{{$value ?? old($name)}}" dir="auto">
        </div>
    </div>
</div>
