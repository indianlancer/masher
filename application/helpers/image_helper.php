<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('imageresize'))
{
	function imageresize($filename,$filetempname,$sizeconstant,$curr_upload_path,$hdnImage=false,$thumbmark=false,$maintain_ratio=true,$newthumb_path=false,$set_height=true)
	{
            $CI =& get_instance();
            // Move uploaded file into User's directory & rename
            $fileImageA="";
            // clean the file
            $nameparts = explode('.', $filename);
            $file_ext = $nameparts[count($nameparts) - 1];
            $newname = str_replace('.' . $file_ext, '', $filename);
            $timestamp=time();
            $newname = rand(0,999999).$timestamp . '.' . $file_ext;
            $filetempname;
            if (move_file($filetempname, $curr_upload_path. $newname))
            {
                    // Populate arrays
                    $fname = $curr_upload_path. $newname;
                    if($newthumb_path)
                    $newthumb_path=$curr_upload_path.$newthumb_path.$newname;
                    $pro_size=explode(",",$sizeconstant);
                    $photoLib = new Photoslibrary();
                    foreach($pro_size as $sizes)
                    {
                        $newsize=explode("x",$sizes);
                        $is_create_false=$photoLib->create_thumb($fname,$newsize[0],$newsize[1],$maintain_ratio,$thumbmark,$newthumb_path,$set_height); 
                        if($is_create_false)
                        {
                            $data['error'] = $is_create_false;
                        }
                    }
                    $fileImageA=$newname;
                    if($hdnImage)
                    {
                        $unlink_img=$CI->input->post($hdnImage);
                        $unlink_img=$curr_upload_path.$unlink_img;
                        @unlink($unlink_img);
                    }
            }
            return $fileImageA;
	}
}

if ( ! function_exists('getallimages'))
{

        function getallimages($folder="",$thumb=false,$sizeconstant,$thumbindex=0,$thumbbig=0)
	{
		$pict_url_plain['thumb'] =array();
                $pict_url_plain['real'] =array();
                $pict_url_plain['delreal']=array();
                $filefold=IMG_ROOT_PATH. $folder;
                $filefoldreal=IMG_ROOT_PATH. $folder;
                $fileret=IMG_PATH. $folder;
                $fileretreal=IMG_PATH. $folder;
                
                if(is_dir($filefold))
		{
                    	$dirs = scandir($filefold);
			foreach($dirs as $dir)
			{
                            if ($dir === '.' || $dir === '..' ){continue;}
                            $pro_size=explode(",",$sizeconstant);
                            
                            {
                                $newsize=explode("x",$pro_size[$thumbindex]);
                                $bigsize=explode("x",$pro_size[$thumbbig]);
                                if($thumb)
                                {
                                    $filefoldget = $filefold. 'thumb/'.$newsize[0]."_";
                                    $fileretset = $fileret.'thumb/'.$newsize[0]."_";
                                    $fileretrealset=$fileretreal.'thumb/'.$bigsize[0]."_";
                                }
                                else
                                {
                                    $filefoldget = $filefold;
                                    $fileretset = $fileret;
                                }
                                if(is_file( $filefoldget. $dir) && is_file( $filefoldreal. $dir))
				{
                                    array_push($pict_url_plain['thumb'], $fileretset . $dir);
				    array_push($pict_url_plain['real'], $fileretrealset . $dir);
                                    array_push($pict_url_plain['delreal'], encode_id($dir));
                                }
                            }
			}
		}
		
		
		return $pict_url_plain;
	}
}

if ( ! function_exists('bytesToSize1024'))
{

        function bytesToSize1024($bytes, $precision = 2) {
            $unit = array('B','KB','MB');
            return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
        }
}

/* End of file Image_helper.php */
/* Location: /helpers/Image_helper.php */
