<?php
/**
 * Create the directory structure for a new project. The directories
 * will be created under the current working directory.
 *
 * Eg: php phrank/bin/newproject.php
 */

function makedir($path)
{
	$fullpath = realpath('.') . '/' . $path;
	if(file_exists($path)) {
		echo "already exists: $fullpath\n";
		return;
	}
	echo "new dir:  $fullpath\n";
	mkdir($path);
}

function copyfile($src, $dst)
{
	$fullpath = realpath('.') . '/' . $dst;
	if(file_exists($dst)) {
		echo "already exists: $fullpath\n";
		return;
	}
	echo "new file: $fullpath\n";
	$src = dirname(__FILE__) . '/app_files/' . $src;
	copy($src, $dst);
}

/*
 * App
 */
makedir('app');

$app_dirs = [
	'bin', 'config', 'controllers', 'middleware',
	'models', 'schemas', 'templates'
];
foreach($app_dirs as $dir) {
	makedir('app/' . $dir);
}

// additional subdirs
makedir('app/templates/home');

// files
copyfile('config.php', 'app/config/config.php');
copyfile('routes.php', 'app/config/routes.php');
copyfile('middleware.php', 'app/config/middleware.php');
copyfile('c_home.php', 'app/controllers/home.php');
copyfile('t_layout.html', 'app/templates/layout.html');
copyfile('t_index.html', 'app/templates/home/index.html');

/*
 * Public
 */
makedir('public');
copyfile('index.php', 'public/index.php');

?>
