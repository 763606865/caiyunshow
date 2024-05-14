<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Suggestion extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'suggestions';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {

        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->number('min')->rules('required');
        $this->number('max')->rules('required');
        $this->textarea('description', '区间说明');
        $this->textarea('text', '文案');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'min'       => $this->form,
            'max'      => 'John.Doe@gmail.com',
            'description' => now(),
            'text' => now(),
        ];
    }
}
