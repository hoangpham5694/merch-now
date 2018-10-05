<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;
use App\Models\Design;
use App\Models\Shirt;
use App\Models\Account;
class HomeController extends Controller
{
    public function index(Content $content)
    {
        $content->header('Dashboard');
        $content->description('Welcome to Merch-now!');
        $content->row(function ($row) {
            $countDesignAll = Design::where('status','<>','close')->count();
            // $countDesignPending = Design::where('status','=','pending')->count();
            // $countDesignAlive = Design::where('status','=','alive')->count();
            // $countDesignDie = Design::where('status','=','die')->count();
            // $countDesignReview = Design::where('status','=','review')->count();
            // $countDesignWait = Design::where('status','=','wait')->count();
         //   dd($countDesignAlive);
            $row->column(3, new InfoBox('Total Designs', 'picture-o', 'aqua', '', $countDesignAll));
            // $row->column(3, new InfoBox('Designs Pending', 'picture-o', 'yellow', '', $countDesignPending));
            // $row->column(3, new InfoBox('Designs under review', 'picture-o', 'maroon', '/demo/files', $countDesignReview));
            // $row->column(3, new InfoBox('Designs waiting Merch approve', 'picture-o', 'fuchsia', '/demo/files', $countDesignWait));

            // $row->column(3, new InfoBox('Designs Alive', 'picture-o', 'green', '/demo/orders', $countDesignAlive));
            // $row->column(3, new InfoBox('Designs Die', 'picture-o', 'red', '/demo/files', $countDesignDie));

        });
        $content->row(function ($row) {
            $countShirtAll = Shirt::where('status','<>','close')->count();
            $countShirtWait = Shirt::where('status','=','wait')->count();
            $countShirtAlive = Shirt::where('status','=','live')->count();
            $countShirtReject = Shirt::where('status','=','reject')->count();
            $row->column(3, new InfoBox('Total Shirts', 'file-picture-o', 'aqua', '', $countShirtAll));
            $row->column(3, new InfoBox('Shirts waiting Merch approve', 'file-picture-o', 'fuchsia', '/demo/files', $countShirtWait));
            $row->column(3, new InfoBox('Shirts Alive', 'file-picture-o', 'green', '/demo/orders', $countShirtAlive));
            $row->column(3, new InfoBox('Shirts Reject', 'file-picture-o', 'red', '/demo/files', $countShirtReject));
        });
        $content->row(function ($row) {
            $countAccountAll = Account::count();
            $countAccountAlive = Account::where('status','=','alive')->count();
            $countAccountDie = Account::where('status','=','die')->count();
            $row->column(3, new InfoBox('Total Accounts', 'user', 'aqua', '', $countAccountAll));
            $row->column(3, new InfoBox('Accounts Alive', 'user', 'green', '/demo/orders', $countAccountAlive));
            $row->column(3, new InfoBox('Accounts Die', 'user', 'red', '/demo/files', $countAccountDie));
        });
        return $content;
    }
}
