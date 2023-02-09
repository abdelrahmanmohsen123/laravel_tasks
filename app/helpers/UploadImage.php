<?php




 function uploadImage($image,$folder){
     $imageName = $folder .'/'. time().'.'.$image->extension();

     $image->move(storage_path('app/public/'.$folder), $imageName);
     return $imageName;
 }


 ?>