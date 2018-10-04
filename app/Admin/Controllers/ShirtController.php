<?php

namespace App\Admin\Controllers;

use App\Models\Shirt;
use App\Models\Account;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Design;
use App\Models\User;

use Encore\Admin\Facades\Admin;

class ShirtController extends Controller
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
    public function create(Content $content )
    {
  //    $params = $request->toArray();
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
        $grid = new Grid(new Shirt);
        $grid->filter(function($filter){
            $filter->scope('my', 'Your Shirts')->where('user_id', Admin::user()->id);
        //    $filter->scope('haventbeenup', 'Havent been uploaded')->where('account_id', null);

            $filter->where(function ($query) {

                $query->where('title', 'like', "%{$this->input}%")
                    ->orWhere('note', 'like', "%{$this->input}%");


            }, 'Keyword');
            $filter->equal('account_id','Account')->select(Account::all()->pluck('name', 'id'));
            $filter->equal('user_id','Designer')->select(User::all()->pluck('name', 'id'));
            $filter->equal('mode','Mode')->select(SHIRT_TYPES);
            $filter->equal('status')->select(
               SHIRT_STATUSES
            );
            $filter->between('created_at', 'Day Create')->date();
        });
        // $grid->rows(function (Grid\Row $row) {
        //   $color='';
        //   dd($row->status);
        //   switch($row->status){
        //     case 'review': $color='';
        //     case 'wait': $color='yellow';
        //   }
        //
        //                 $row->setAttributes(['style' => 'color:'.$color.';']);
        //
        //  });

      //  dd($grid);
        $grid->model()->orderBy('id','DESC');
        $grid->id('Id shirt');
        $grid->design()->id('Id Design');
        $grid->design()->image()->gallery(['zooming' => true]);
        $grid->brand()->editable();
        $grid->title()->editable();
        $grid->account()->name("Account");
        $grid->user()->name('Uploader');
        $grid->note()->editable();
        $grid->type()->using(SHIRT_TYPES);
        $grid->status()->editable('select', SHIRT_STATUSES);

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
        $show = new Show(Shirt::findOrFail($id));

        $show->id('ID');
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
        //dd();
        $form = new Form(new Shirt);

        $form->display('ID');
        $form->hidden('user_id');
        $form->number('design_id')->min(0)->value(request('design_id'));
        $form->divide();
    //    ->default( isset($params['design_id'])? $params['design_id'] : '' )
        $form->text('brand')->rules('required');
        $form->text('title')->rules('required|min:3');
        $form->text('key_product_1')->rules('required|min:3');
        $form->text('key_product_2');
        $form->number("price","Price (x,99 dollar)")->min(10)->max(25)->default(19);
        $form->divide();
        $form->select('account_id', 'Account')->options(Account::all()->pluck('name', 'id'))->rules('required');
        $form->select('status')->options(SHIRT_STATUSES)->default('wait')->rules('required');
        $form->select('type')->options(SHIRT_TYPES)->default('standard')->rules('required');
        $form->divide();
        $form->textarea('note','Note')->rows(3);
        $form->divide();
        $form->display('Created at');
        $form->display('Updated at');

        $form->saving(function (Form $form) {
            $form->user_id= Admin::user()->id;
            if($form->status ==null)
                 $form->status="wait";
        });

        return $form;
    }
}
