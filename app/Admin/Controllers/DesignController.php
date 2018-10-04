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
        if(!Admin::user()->isAdministrator()){
            $grid->model()->where('status','<>','close');
         //   $grid->disableActions();
            $grid->disableRowSelector();
        }

        $grid->filter(function($filter){

            $filter->scope('my', 'Your Designs')->where('user_id', Admin::user()->id);
            if(Admin::user()->isAdministrator()){
              $filter->scope('trashed', 'Soft deleted data')->where('status','=','close');
              $filter->scope('except-trashed', 'Except deleted')->where('status','<>','close');
            }

            $filter->where(function ($query) {

                $query->where('title', 'like', "%{$this->input}%")
                    ->orWhere('note', 'like', "%{$this->input}%");


            }, 'Keyword');

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

        $grid->title()->editable();
        $grid->note('Note')->editable();
        $grid->shirts('Total Shirts')->display(function ($shirts) {
             $count = count($shirts);
             return "<span >{$count}</span>";
         });
         $grid->column('Shirts Alive')->display(function () {
              $count = $this->shirts()->where('status','=','live')->count();
              return "<span >{$count}</span>";
          });
          $grid->column('Shirts Die')->display(function () {
               $count = $this->shirts()->where('status','=','reject')->count();
               return "<span >{$count}</span>";
           });
        $grid->user()->name('Designer');
        $grid->mode()->editable('select', DESIGN_MODES);
        $grid->status()->select(DESIGN_STATUSES);

        $grid->created_at('Created at');

        $grid->actions(function ($actions) {
            $actions->disableDelete();
          // // the array of data for the current row
            $row=  $actions->row;
          //
          // // gets the current row primary key value
          // $actions->getKey();
            // append an action.
        //    $actions->append('<a href=""><i class="fa fa-eye"></i></a>');
            $urlDownload= asset('uploads')."/".$row->image;
            $urlAddShirt = asset('admin/shirt/create')."?design_id=".$row->id;
          //  dd($urlDownload);
            // prepend an action.
            $actions->prepend('<a href="'.$urlAddShirt.'" target="_blank" ><i class="fa fa-plus"></i></a>');
            $actions->prepend('<a href="'.$urlDownload.'" target="_blank" download="'.$row->image.'"><i class="fa fa-download"></i></a>');
        });
        // $grid->column('image1')->display(function ($image1) {
        //
        //       return "<a href=".asset('uploads')."/".$image1." target='_blank' download=".$image1.">Download</a>";
        //
        //   });



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
        $show->panel()
          ->tools(function ($tools) {
            if(!Admin::user()->isAdministrator()){
                $tools->disableDelete();
            }

          });
        $urlDownload= asset('uploads')."/".$design->image;
        $show->image()->image(null,400,400)->link($urlDownload);
      //  $show->download()->link($urlDownload,'_blank');

      //  $show->image()->file();
        $show->divider();
        $show->id('id');
        $show->user()->name('Designer')->link(env('APP_URL').'/admin/auth/users/'.$design->user_id);
        $show->title();
        $show->note('Note');

        $show->created_at('Created at');
        $show->updated_at('Updated at');

        $show->shirts('Shirts of this design', function ($shirts) {

            $shirts->resource('/admin/shirt');

            $shirts->id();
            $shirts->brand()->editable();
            $shirts->title()->editable();
            $shirts->account()->name("Account");
            $shirts->user()->name('Uploader');
            $shirts->type()->using(SHIRT_TYPES);
            $shirts->note()->editable();
            $shirts->created_at();


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
        $form = new Form(new Design);
        $form->tools(function (Form\Tools $tools) {

            // Disable back btn.
            $tools->disableDelete();
        

        });

        $form->display('id');
  //      $form->display('status');
        $form->hidden('user_id');
        $form->text('title')->rules('required');
        $form->image('image')->uniqueName()->move('designs');
        $form->radio('mode')->options(DESIGN_MODES)->default('trend')->rules('required');
        $form->textarea('note','Note')->rows(3);
        $form->select('status')->options(DESIGN_STATUSES)->default('ok')->rules('required');
        $form->saving(function (Form $form) {
            $form->user_id= Admin::user()->id;
            if($form->status ==null)
                 $form->status="pending";
        });
        return $form;
    }
}
