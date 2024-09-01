<?php
	require_once('../../../../wp-load.php');require_once('../../../../wp-includes/media.php');$uploadType=$_REQUEST['uploadType'];$post_id=$_REQUEST['post_ID'];
	//
	if(current_user_can('upload_files')==1 && $_REQUEST['set']==='3GhaOsT7' && $uploadType!==null){
		$path=null;$fileOK=false;$upload_dir=wp_upload_dir();
		//
		$modelURL=$upload_dir['path']; $imgURL=$upload_dir['path']; $thumbnailURL=$upload_dir['path'];
		//
		$time=current_time('mysql',1);
		//
		foreach ($_FILES as $key ) {
			$name=$key['name'];$fileType=pathinfo($name,PATHINFO_EXTENSION);
			if($fileType=='fbx' || $fileType=='gltf' || $fileType=='glb' || $fileType=='mtl' || $fileType=='obj' || $fileType=='zip' || $fileType=='stl' || $key['size'] < 70000000){$fileOK=true; break;}
		}
		//
		if (!$fileOK){print_r('Wrong file or file size more than 70MB'); exit();}
		//
		$filename = $key['name'];$source = $key['tmp_name'];$type = $key['type'];$path = $modelURL.'/'.$filename;
		//
		if(move_uploaded_file($source, $path)){
			$ok=false;
			$zip=new ZipArchive();
			$x=$zip->open($path);
			if ($x === true){
				for ($i=0; $i<$zip->numFiles;$i++) {
					$name=$zip->statIndex($i)['name'];
					$fileType=pathinfo($name,PATHINFO_EXTENSION);
					//
					if($fileType=='fbx' || $fileType=='glb' || $fileType=='gltf' || $fileType=='obj' || $fileType=='stl'){
						$name=str_replace(' ','_',$name); $ok=true; ca_update($name,$post_id);
					}
				}
				if($ok){$zip->extractTo($modelURL);}else{print_r('NoTypeMatch');}; $zip->close();
				//
				if($ok){
					//
					$files=scandir($modelURL);
					foreach ($files as $str){
						$pos=strpos($str, " "); if($pos>0){$re=str_replace(' ','_',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
						$pos=strpos($str, ".STL"); if($pos>0){$re=str_replace('.STL','.stl',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
						$pos=strpos($str, ".MTL"); if($pos>0){$re=str_replace('.MTL','.mtl',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
						$pos=strpos($str, ".OBJ"); if($pos>0){$re=str_replace('.OBJ','.obj',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
						$pos=strpos($str, ".FBX"); if($pos>0){$re=str_replace('.FBX','.fbx',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
						$pos=strpos($str, ".GLB"); if($pos>0){$re=str_replace('.GLB','.glb',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
						$pos=strpos($str, ".GLTF"); if($pos>0){$re=str_replace('.GLTF','.gltf',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
						$pos=strpos($str, ".glTF"); if($pos>0){$re=str_replace('.glTF','.gltf',$str); rename($modelURL.'/'.$str,$modelURL.'/'.$re);}
					}
				}
				//
				unlink($path);
				//
			}else{
				$name=str_replace(' ','_',$filename); print_r($name.'|#|'); ca_update($name,$post_id);
			}
		} else {
			echo 'false'; return 2;
		}
	}else{
		echo('upload denied'); exit();
	}
	//
	function ca_update($filename,$post_id){
		require_once(ABSPATH.'wp-admin/includes/post.php' );$upload_dir=wp_upload_dir();$file_path=$upload_dir['path'].'/'.$filename;
		//
		$args=array(
			'guid'           => $file_path,
			'post_mime_type' => 'mesh/plain',
			'post_title'     => 'Canvasio3D Model',
			'post_content'   => $filename,
			'post_status'    => 'inherit'
		);
		//
		if(!post_exists('Canvasio3D Model',$filename)){
			wp_insert_attachment($args,$file_path);
		}else{
			wp_update_attachment_metadata($post_id, $args);
		}
	}
	//
?>
