{{-- number_range.blade.php --}}
<div class="form-group">
    <div class="input-group row">
        <label class="col-md-4">
            <input type="number" class="form-control" name="{{ $name }}[min]" value="{{ old($column, $value['min'] ?? null) }}" {!! $attributes !!}>
        </label>
        <div class="input-group-prepend col-md-2">
            <span class="input-group-text">-</span>
        </div>
        <label class="col-md-4">
            <input type="number" class="form-control" name="{{ $name }}[max]" value="{{ old($column, $value['max'] ?? null) }}" {!! $attributes !!}>
        </label>
    </div>
</div>
