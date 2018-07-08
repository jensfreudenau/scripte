<?php
function reziser($dir) {
	#$dir = ".";
	$exts = array('jpg', 'jpeg', 'png', 'gif');
	$max_size = 2000;
	$morgify = "mogrify -verbose -scale \"${max_size}x${max_size}>\" -quality 85";
	$identify = "identify -format \"%wx%h\"";

	$dh = opendir($dir);
	while (($file = readdir($dh)) !== false) {
	    $path = "$dir/$file";
	    // skip no images
	    $dot = strrpos($file, '.');
	    $ext = strtolower(substr($file, $dot + 1));
	    if (!in_array($ext, $exts)) continue;
	    // large size?
	    $size = exec("$identify \"$path\"");
	    list($width, $height) = explode('x', trim($size));
	    if (max($width, $height) > $max_size) {
	        // scale!
	        print "scale $file ${width}x${height}";
	        exec("$morgify \"$path\"");
	        print "\n";
	    }
	}
	closedir($dh);
}
function scd($path) {
    $di = new RecursiveDirectoryIterator($path);
    $iterator = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);

    $files = [];
    foreach ($iterator as $file) {
    	$fileinfo = pathinfo($file);
    	if(substr_count($fileinfo['dirname'], '/') == 2) {
    		$files[] = $fileinfo['dirname'];
    	}
        
    }
    asort($files);
    return array_unique($files);
     
}
 
$pathes = scd('./');
foreach ($pathes as $key => $path) {
	reziser($path);
}
?>