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
            $filter->equal('status')->select(['alive'=>'Alive','die'=>'Die']);

        });
        $grid->id('ID');
        $grid->name()->editable();
        $grid->username();
        $grid->password()->editable();
        $grid->vps()->name('Vps Name');
      
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
        $show->designs('Designs of this account', function ($designs) {

            $designs->resource('/admin/design');
        
            $designs->id();
            $designs->image()->gallery(['zooming' => true]);
            $designs->brand()->editable();
            $designs->title()->editable();
            $designs->user()->name('Designer');
            $designs->mode()->editable('select', ['trend' => 'Trend', 'niche' => 'Niche','tm' => 'TM']);
            $designs->status()->select([
                'pending' => 'Pending',
                'review' => 'Under Review',
                'wait' => 'Wait merch approve',
                'live' => 'Live',
                'die' => 'Die',
            ]);
            $designs->note('Note')->editable();
            $designs->created_at('Created at');
        

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
        $form->select('browser','Browser')->options([
            'chrome'=>'Chrome',
            'firefox'=>'FireFox',
            'edge'=>'Edge',
            'coccoc'=>'Coc Coc',
            'ie'=>'Interner Explorer'
            ]);
        $form->select('status')->options(['alive'=>'Alive','die'=>'Die']);
        $form->textarea('note','Note')->rows(3);



        return $form;
    }
}
