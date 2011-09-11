<?php
/*
 * @package         PHP-CLI
 * @subpackage      ScanDirXml
 * @author          Emerson Rocha Luiz ( emerson@webdesign.eng.br - @fititnt -  http://fititnt.org )
 * @copyright       Copyright (C) 2005 - 2011 Webdesign Assessoria em Tecnologia da Informacao.
 * @license         GPL3
 * @version
 */
//defined('_JEXEC') or die; // no direct access

// open the current directory by opendir

$jCmsPath = "C:/xampp/htdocs/bancada26/templates/beez5/html";

//Shows files and folders inside directory $jCmsPath
/*
$handle=opendir( $jCmsPath );
while (($file = readdir($handle))!==false) {
    echo "$file \n";
}
closedir($handle);
*/
/*
function getFilesFromDir($dir) {

  $files = array();
  if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            if(is_dir($dir.'/'.$file)) {
                $dir2 = $dir.'/'.$file;
                $files[] = getFilesFromDir($dir2);
            }
            else {
              $files[] = $dir.'/'.$file;
            }
        }
    }
    closedir($handle);
  }

  return array_flat($files);
}

function array_flat($array) {

    $tmp = array();
  
    foreach($array as $a) {
    if(is_array($a)) {
      $tmp = array_merge($tmp, array_flat($a));
    }
    else {
      $tmp[] = $a;
    }
  }

  return $tmp;
}

// Usage
$foo = getFilesFromDir($jCmsPath);

print_r($foo);
*/

function scan_directory_recursively($directory, $filter=FALSE)
{
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}
	if(!file_exists($directory) || !is_dir($directory))
	{
		return FALSE;
	}elseif(is_readable($directory))
	{
		$directory_tree = array();
		$directory_list = opendir($directory);
		while (FALSE !== ($file = readdir($directory_list)))
		{
			if($file != '.' && $file != '..')
			{
				$path = $directory.'/'.$file;
				if(is_readable($path))
				{
					$subdirectories = explode('/',$path);
					if(is_dir($path))
					{
						$directory_tree[] = array(
							'path'    => $path,
							'name'    => end($subdirectories),
							'kind'    => 'directory',
							'content' => scan_directory_recursively($path, $filter));
					}elseif(is_file($path))
					{
						$extension = end(explode('.',end($subdirectories)));
						if($filter === FALSE || $filter == $extension)
						{
							$directory_tree[] = array(
								'path'      => $path,
								'name'      => end($subdirectories),
								'extension' => $extension,
								'size'      => filesize($path),
								'kind'      => 'file',
                                'md5'      => md5_file($path),
                            );
						}
					}
				}
			}
		}
		closedir($directory_list);
		return $directory_tree;
	}else{
		// ... we return false
		return FALSE;
	}
}
// ------------------------------------------------------------

print_r(scan_directory_recursively($jCmsPath));