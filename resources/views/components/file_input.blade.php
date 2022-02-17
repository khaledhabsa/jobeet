<div class="card">
    <div class="body">
        <div class="form-group">
            <label for="{{$name}}">{{$label ?? ''}}</label>
            <input type="file" name="{{$name}}" class="form-control-file" id="{{$name}}" {{isset($multiple) && $multiple ? 'multiple' : ''}} {{$accept ?? ''}} aria-describedby="fileHelp">
        </div>
    </div>
</div>
