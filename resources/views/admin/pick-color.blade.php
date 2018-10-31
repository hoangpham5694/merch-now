<form action="" method="post" accept-charset="UTF-8" class="form-horizontal" >
   <div class="box-body">
      <div class="fields-group">
         <div class="form-group ">
            <label class="col-sm-2  control-label">ID</label>
            <div class="col-sm-8">
               <div class="box box-solid box-default no-margin">
                  <!-- /.box-header -->
                  <div class="box-body">
                     {{$shirt->id}}
                  </div>
                  <!-- /.box-body -->
               </div>
            </div>
         </div>
         <div class="form-group  ">
            <label for="name" class="col-sm-2  control-label">Image</label>
            <div class="col-sm-8">
               <div class="input-group">
                   <div id="img-background-test">
                     <img src="{!! asset('uploads/thumbs') !!}/{{$shirt->design_id}}.png" alt="">
                   </div>

               </div>
            </div>
         </div>
         <div class="form-group  ">
            <label for="code" class="col-sm-2  control-label">Color</label>
            <div class="col-sm-8">
                @foreach($colors as $color)
                  <div class="form-check">
                     <input class="form-check-input position-static" type="checkbox" name="colors[]"  value="{{$color->id}}" aria-label="...">
                     <span style='display:inline-block; width: 20px; height: 20px; background-color:{{$color->code}}' onmouseover="changeColor('{{$color->code}}');"></span>
                     {{$color->name}}
                 </div>
                @endforeach


            </div>
         </div>




      </div>
   </div>
   <!-- /.box-body -->
   <div class="box-footer">
      	{!! csrf_field() !!}
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
         <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary">Submit</button>
         </div>
         <label class="pull-right" style="margin: 5px 10px 0 0;">
            <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
            Continue editing
         </label>
         <label class="pull-right" style="margin: 5px 10px 0 0;">
            <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" class="after-submit" name="after-save" value="2" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
            View
         </label>
         <div class="btn-group pull-left">
            <button type="reset" class="btn btn-warning">Reset</button>
         </div>
      </div>
   </div>

</form>
<script>
  function changeColor(color){
    var background = document.getElementById("img-background-test");
    background.style.backgroundColor = color;
  }
//  changeColor('red');
</script>
