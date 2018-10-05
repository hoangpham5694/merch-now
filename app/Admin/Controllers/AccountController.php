<?php

namespace App\Admin\Controllers;

use App\Models\Account;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Vps;
class AccountController extends Controller
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
        $grid = new Grid(new Account);
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add a column filter
            $filter->like('name', 'name');
            $filter->equal('vps_id','Vps')->select(Vps::all()->pluck('name', 'id'));
            $filter->equal('status')->select(ACCOUNT_STATUSES);

        });
        $grid->id('ID');
        $grid->name()->editable();
        $grid->username();
        $grid->password()->editable();
        $grid->vps()->name('Vps Name');
        $grid->column('Total Shirts')->display(function () {
             $count = $this->shirts()->count();
             return "<span >{$count}</span>";
         });
        $grid->column('Shirts Alive')->display(function () {
             $count = $this->shirts()->where('status','=','live')->count();
             return "<span >{$count}</span>";
         });
         $grid->column('Shirts Reject')->display(function () {
              $count = $this->shirts()->where('status','=','reject')->count();
              return "<span >{$count}</span>";
          });

        $grid->status()->editable('select', ['alive' => 'Alive', 'die' => 'Die']);
        // $states = [
        //     'on'  => ['value' => 'alive', 'text' => 'Alive', 'color' => 'primary'],
        //     'off' => ['value' => 'die', 'text' => 'Die', 'color' => 'danger'],
        // ];
        // $grid->status()->switch($states);
        $grid->browser();
        $grid->note()->editable('textarea');

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
        $show = new Show(Account::findOrFail($id));

        $show->id('ID');
        $show->name();
        $show->username();
        $show->password();
        $show->passmail();
        $show->vps()->name('Vps Name');
        $show->note();
        // $show->note()->as(function ($note) {
        //     return "<pre>{$note}</pre>";
        // });
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->divider();
        $show->shirts('Shirt of this account', function ($shirts) {

            $shirts->resource('/admin/shirt');

            $shirts->id();
            $shirts->design()->image()->gallery(['zooming' => true]);
            $shirts->brand()->editable();
            $shirts->title()->editable();
          //  $shirts->design()->user()->name('Designer');
            $shirts->user()->name('Uploader');
            $shirts->mode()->editable('select', ACCOUNT_MODES);
            $shirts->status()->select(SHIRT_STATUSES);
            $shirts->note('Note')->editable();
            $shirts->created_at('Created at');


        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Account);

        $form->display('id');
        $form->text('name','Name')->rules('required');
        $form->text('username','Email')->rules('required');
        $form->text('password','Password')->rules('required');
        $form->text('passmail','Pass Mail')->rules('required');
        $form->select('vps_id','VPS')->options(Vps::all()->pluck('name', 'id'));
        $form->select('browser','Browser')->options(LIST_BROWSERS);
        $form->select('status')->options(ACCOUNT_STATUSES);
        $form->textarea('note','Note')->rows(3);



        return $form;
    }
}
