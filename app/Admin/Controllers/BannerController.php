<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use \App\Models\Banner;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Banner';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('image', __('Image'))->image(env('APP_URL'),150,100);
        $grid->column('link', __('Link'))->link();
        $grid->column('sort', __('Sort'));
        $grid->column('background_color', __('Background Color'))->background_color();
        $grid->column('web_weight', __('Web Weight'));
        $grid->column('web_height', __('Web Height'));
        $grid->column('h5_weight', __('H5 Weight'));
        $grid->column('h5_height', __('H5 Height'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Banner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));
        $show->field('link', __('Link'));
        $show->field('sort', __('Sort'));
        $show->field('background_color', __('Background Color'));
        $show->field('web_weight', __('Web Weight'));
        $show->field('web_height', __('Web Height'));
        $show->field('h5_weight', __('H5 Weight'));
        $show->field('h5_height', __('H5 Height'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner());

        $form->text('name', __('Name'));
        $form->image('image', __('Image'));
        $form->url('link', __('Link'));
        $form->number('sort', __('Sort'));
        $form->color('background_color', __('Background Color'));
        $form->number('web_weight', __('Web Weight'));
        $form->number('web_height', __('Web Height'));
        $form->number('h5_weight', __('H5 Weight'));
        $form->number('h5_height', __('H5 Height'));
        return $form;
    }
}
