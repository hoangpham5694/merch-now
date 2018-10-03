<?php

namespace App\Admin\Controllers;

use App\Models\Vps;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class VpsController extends Controller
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
        $grid = new Grid(new Vps);

        $grid->model()->orderBy('id','DESC');
        $grid->id('ID')->sortable();
        $grid->column('name');
        $grid->column('ip');
        $grid->column('username');
        $grid->column('password');
        $grid->service()->using(['aws' => 'Amazon', 'vultr' => 'Vultr','gcloud' => 'Google Cloud']);

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
        $show = new Show(Vps::findOrFail($id));
    
        $show->id('ID');
        
        $show->name('name');
        $show->ip('ip');
        $show->username('Username');
        $show->password('password');
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
        $form = new Form(new Vps);

        $form->display('id', 'ID');

        $form->text('name','Name')->rules('required');
        $form->text('ip','IP Address')->rules('required');
        $form->text('username','Username')->rules('required');
        $form->text('password','Password');

        $form->radio('service', 'Service')->options(['aws' => 'Amazon', 'vultr' => 'Vultr','gcloud' => 'Google Cloud'])->default('vultr');

 
        $form->textarea('note','Note')->rows(3);



        return $form;
    }
}
