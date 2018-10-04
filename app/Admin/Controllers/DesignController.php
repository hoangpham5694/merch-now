<?php

namespace App\Admin\Controllers;

use App\Models\Design;
use App\Models\User;
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
        $grid->filter(function($filter){
            $filter->scope('my', 'Your Designs')->where('user_id', Admin::user()->id);
            $filter->scope('haventbeenup', 'Havent been uploaded')->where('account_id', null);
            
            $filter->where(function ($query) {

                $query->where('title', 'like', "%{$this->input}%")
                    ->orWhere('brand', 'like', "%{$this->input}%")
                    ->orWhere('key_product_1', 'like', "%{$this->input}%")
                    ->orWhere('key_product_2', 'like', "%{$this->input}%");
            
            }, 'Keyword');
            $filter->equal('account_id','Account')->select(Account::all()->pluck('name', 'id'));
            $filter->equal('user_id','Designer')->select(User::all()->pluck('name', 'id'));
            $filter->equal('mode','Mode')->select(DESIGN_MODES);
            $filter->equal('status')->select(
               DESIGN_STATUSES
            );
            $filter->between('created_at', 'Day Create')->date();
        });



        $grid->model()->orderBy('id','DESC');
      //  $grid->model()->where('account_id', '=', null);
        $grid->id('ID');
        $grid->image()->gallery(['zooming' => true]);
        $grid->brand()->editable();
        $grid->title()->editable();
        $grid->account()->name("Account");
        // $grid->key_product_1()->editable();
        // $grid->key_product_2()->editable();

     
        $grid->user()->name('Designer');
        $grid->mode()->editable('select', DESIGN_MODES);
        // $grid->column('image1')->display(function ($image1) {
        //
        //       return "<a href=".asset('uploads')."/".$image1." target='_blank' download=".$image1.">Download</a>";
        //
        //   });
        $grid->status()->select(DESIGN_STATUSES);
        $grid->note('Note')->editable();
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
        $show = new Show($design = Design::findOrFail($id));

        //  dd($design->account_id);
        //  exit();

        
        $show->image()->image(null,400,400);
        $show->divider();
        $show->id('id');
        $show->brand();
        $show->title();
        $show->key_product_1();
        $show->key_product_2();
        $show->account()->name('Account')->link(env('APP_URL').'/admin/account/'.$design->account_id);
        $show->user()->name('Designer')->link(env('APP_URL').'/admin/auth/users/'.$design->user_id);
        $show->note('Note');
        // $show->account('Account information', function ($account) {

        //     $account->setResource('/admin/account');
        
        //     $account->id();
        //     $account->name();
        //     $account->username();
        // });
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
      //      $form->display('status');
            $form->hidden('user_id');
            $form->image('image')->uniqueName()->move('designs');
            $form->radio('mode')->options(DESIGN_MODES)->default('trend');

        })->tab('Info', function ($form) {

            $form->text('brand');
            $form->text('title');
            $form->text('key_product_1');
            $form->text('key_product_2');
            $form->number("price","Price (x,99 dollar)")->min(10)->max(25)->default(19);
            $form->select('account_id','Account')->options(Account::all()->pluck('name', 'id'));
            $form->textarea('note','Note')->rows(3);
            $form->select('status')->options(DESIGN_STATUSES)->default('trend');
            $form->display('Created at');
            $form->display('Updated at');
        });






        $form->saving(function (Form $form) {
            $form->user_id= Admin::user()->id;
            if($form->status ==null)
                 $form->status="pending";
        });
        return $form;
    }
}
