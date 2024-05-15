<?php

declare(strict_types=1);

namespace App\Admin\Controllers\Evaluations;

use App\Models\Evaluation\Evaluation;
use App\Models\Evaluation\Measure;
use App\Models\Evaluation\Norm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use InvalidArgumentException;

class MeasureController extends Controller
{
    protected $title = 'Measures';

    protected function grid(): Grid
    {
        $grid = new Grid(new Measure());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('created_at', __('CreatedAt'));

        return $grid;
    }

    protected function form(): Form
    {
        $form = new Form(new Norm());
        $form->disableViewCheck();

        $form->select('evaluation_id', '所属测评类别')->options(function () {
            return Evaluation::query()->pluck('name','id')->all();
        })->required();
        $form->text('name', __('Name'))->required();
        $form->textarea('description', __('Description'));
        $form->text('note', '备注')->rules();
        $form->table('suggestions', '配置', function ($table) {
            $table->number('min', '分数区间最小值');
            $table->number('max', '分数区间最大值');
            $table->textarea('description', '区间说明');
            $table->textarea('text', '文案');
        });
        $form->saving(function (Form $form) {
            $model = $form->model();
            if (!$model->exists) {
                $model->code = 'T'.date('YmdHis');
            }
            try {
                $this->validateSuggestions($form->input('suggestions'));
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException($e->getMessage());
            }
        });

        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(Norm::findOrFail($id));

        $show->field('evaluation_id', '所属测评类别')->options(function () {
            return Evaluation::query()->pluck('name','id')->all();
        });
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('note', __('Note'));

        return $show;
    }
}
