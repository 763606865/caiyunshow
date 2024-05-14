<?php

declare(strict_types=1);

namespace App\Admin\Controllers\Evaluations;

use App\Models\Evaluation\Evaluation;
use App\Models\Evaluation\Indicator;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use InvalidArgumentException;

class IndicatorController extends Controller
{
    protected $title = 'Indicators';

    protected function grid(): Grid
    {
        $grid = new Grid(new Indicator());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'))->limit();
        $grid->column('weight', '权重')->text();
        $grid->column('note', '备注')->text();

        return $grid;
    }

    protected function form(): Form
    {
        $form = new Form(new Indicator());
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
        $show = new Show(Indicator::findOrFail($id));

        $show->field('evaluation_id', '所属测评类别')->options(function () {
            return Evaluation::query()->pluck('name','id')->all();
        });
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('note', __('Note'));

        return $show;
    }

    /**
     * @throws \Exception
     */
    protected function validateSuggestions(array $suggestions): array
    {
        $suggestions = array_values($suggestions);
        $count = count($suggestions);
        $index = 0;
        if ($count > 1) {
            // 判断连续性
            while ($index < $count-1) {
                if ((double)$suggestions[$index]['max'] !== (double)$suggestions[$index+1]['min']) {
                    throw new InvalidArgumentException('区间并不连续。');
                }
                $index++;
            }
        }
        // 规定起点终点
        if ((double)$suggestions[0]['min'] !== 0.00) {
            throw new InvalidArgumentException('必须从0开始。');
        }
        // 规定起点终点
        if ((double)$suggestions[$count-1]['max'] !== 100.00) {
            throw new InvalidArgumentException('必须截止到100。');
        }
        return $suggestions;
    }
}
