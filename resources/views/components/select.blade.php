<div class="card">
    <div class="body">
        <div class="form-group form-float">
            <label for="{{$name}}">{{$label ?? ''}}</label>
            <select id="{{$name}}" dir="auto" name="{{$name}}{{isset($multiple) && $multiple ? '[]' : ''}}" class="form-control show-tick {{$classes ?? ''}}" {{isset($multiple) && $multiple ? 'multiple="multiple"' : ''}}>
                {!! $options !!}
            </select>
        </div>
    </div>
</div>
