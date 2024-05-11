<?php

declare(strict_types=1);

namespace App\Admin\Fields\Form;

use Encore\Admin\Form\Field;
use Illuminate\View\View;

class CustomField extends Field
{
    public function name(): string
    {
        return 'custom';
    }

    public function render(): View
    {
        return view($this->getView(), $this->variables());
    }
}
