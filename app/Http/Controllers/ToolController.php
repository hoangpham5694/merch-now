<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Design;
class ToolController extends Controller
{
    public function makeThumbs(){
      $designs = Design::all();
      foreach($designs as $design){
         echo $design->image.'<br>';
        $image = Image::make('uploads/'.$design->image)->resize(400, 480)->save('uploads/thumbs/'.$design->id.'.png');
    //    echo $image;
      //  exit();
      }
    }
}
