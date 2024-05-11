<?php

declare(strict_types=1);

namespace App\Admin\Fields\Form;

use Encore\Admin\Form\Field;
use Illuminate\View\View;

class NumberRangeField extends Field
{
    protected $view = 'admin.form.number_range';

    public function name(): string
    {
        return 'numberRange';
    }

    public function render(): View
    {
        return view($this->getView(), $this->variables());
    }
}
