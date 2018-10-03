<?php

namespace App\Admin\Controllers;

use App\Models\Design;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Models\Account;
class DesignController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Design);
        $grid->model()->orderBy('id','DESC');
        $grid->id('ID');
        $grid->image()->gallery(['zooming' => true]);



        $grid->created_at('Created at');


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
        $show = new Show(Design::findOrFail($id));

        $show->id('id');

        $show->created_at('Created at');
        $show->updated_at('Updated at');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Design);
        $form->tab('Design', function ($form) {
            $form->display('id');
            $form->hidden('user_id');
            $form->image('image')->uniqueName()->move('designs/');
            $form->radio('mode')->options(['trend' => 'Trend', 'niche'=> 'Niche','tm'=>'TM'])->default('trend');

        })->tab('Info', function ($form) {

            $form->text('brand');
            $form->text('title');
            $form->text('key_product_1');
            $form->text('key_product_2');
            $form->number("price","Price (x,99 dollar)")->min(10)->max(25)->default(19);
            $form->select('account_id','Account')->options(Account::all()->pluck('name', 'id'));
            $form->textarea('note','Note')->rows(3);
            $form->display('Created at');
            $form->display('Updated at');
        });






        $form->saving(function (Form $form) {
            $form->user_id= Admin::user()->id;
        });
        return $form;
    }
}
