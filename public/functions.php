<?php

if (!function_exists('tree')) {
    function tree(array $data = [], string $parent_column = 'parent_id'): array
    {
        return collect($data)->where($parent_column,0)->map(function ($item) use($parent_column, $data) {
            $item['children'] = collect($data)->where($parent_column, $item['id'])->toArray();
            return $item;
        })->toArray();
    }
}

if (!function_exists('tree')) {
    function generation(array $data = [])
    {
        foreach ($data as $value) {
            yield $value;
        }
    }
}
