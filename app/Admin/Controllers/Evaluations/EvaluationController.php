<?php

declare(strict_types=1);

namespace App\Admin\Controllers\Evaluations;

use App\Models\Evaluation\Evaluation;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class EvaluationController extends Controller
{
    protected $title = 'Evaluations';

    protected function grid(): Grid
    {
        $grid = new Grid(new Evaluation());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('setting->generate_reports_when_finished', '是否完成后就生成报告')->switch();

        return $grid;
    }

    protected function form(): Form
    {
        $form = new Form(new Evaluation());

        $form->text('name', __('Name'));
        $form->switch('setting.generate_reports_when_finished', '是否直接看报告');
        $form->saving(function (Form $form) {
            $model = $form->model();
            if (!$model->exists) {
                $model->code = 'E'.date('YmdHis');
            }
            $generate_reports_when_finished = $form->input('setting.generate_reports_when_finished');
            if ($generate_reports_when_finished === 'on') {
                $setting['generate_reports_when_finished'] = true;
            } else {
                $setting['generate_reports_when_finished'] = false;
            }
            $model->setting = $setting;
        });

        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}
