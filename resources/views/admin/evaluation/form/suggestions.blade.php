{{-- number_range.blade.php --}}
<div class="form-group" id="evaluation_suggestion">
    <label for="note" class="col-sm-2 control-label">{{ $label }}</label>
    <div class="col-sm-8">
        <table>
            <thead>
                <tr class="row">
                    <td class="col-sm-4">分值区间</td>
                    <td class="col-sm-4">区间说明</td>
                    <td class="col-sm-4">文案</td>
                </tr>
            </thead>
            <tr class="row">
                <td class="col-sm-4">
                    <div class="input-group row">
                        <label class="col-md-4">
                            <input type="number" class="form-control" name="min" value="{{ old($column, $value['min'] ?? null) }}" {!! $attributes !!}>
                        </label>
                        <div class="input-group-prepend col-md-1">
                            <span class="input-group-text">-</span>
                        </div>
                        <label class="col-md-4">
                            <input type="number" class="form-control" name="max" value="{{ old($column, $value['max'] ?? null) }}" {!! $attributes !!}>
                        </label>
                    </div>
                </td>
                <td class="col-sm-4">
                    <div class="input-group row">
                        <label class="col-md-4">
                            <textarea class="form-control" name="description">{{ old($column, $value['description'] ?? null) }}</textarea>
                        </label>
                    </div>
                </td>
                <td class="col-sm-4">
                    <div class="input-group row">
                        <label class="col-md-4">
                            <textarea class="form-control" name="text">{{ old($column, $value['text'] ?? null) }}</textarea>
                        </label>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<style>
    #evaluation_suggestion thead td{
        font-weight: 700;
    }
    #evaluation_suggestion td {
        padding-top: 7px;
    }
</style>
