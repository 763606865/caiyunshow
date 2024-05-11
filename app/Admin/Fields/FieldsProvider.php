<?php

declare(strict_types=1);

namespace App\Admin\Fields;

use App\Admin\Fields\Form\CustomField;
use App\Admin\Fields\Form\NumberRangeField;
use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

class FieldsProvider extends ServiceProvider
{
    public function boot()
    {
        Admin::booting(static function () {
            Form::extend('numberRange', NumberRangeField::class);
            Form::extend('custom', CustomField::class);
        });
    }
}
