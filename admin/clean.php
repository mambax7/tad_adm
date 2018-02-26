<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_adm_adm_clean.tpl";
include_once "header.php";
include_once "../function.php";
$isWin = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? true : false;
/*-----------function區--------------*/
//
function view_file()
{
    global $xoopsTpl, $isWin, $xoopsConfig;

    $theme_name = $xoopsConfig['theme_set'];
    $all_dir    = $all_files    = array();
    $dir        = XOOPS_ROOT_PATH . "/themes/{$theme_name}/modules/";
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {

                //刪除之前的備份
                // if (strpos($file, 'user_bak_2') !== false) {
                //     unlink($dir . $file);
                // }

                if (substr($file, 0, 1) == '.' or $file == 'system' or $file == 'pm' or $file == 'profile') {
                    continue;
                }
                if (is_dir($dir . $file)) {
                    $all_dir[$i]['dir_path'] = $isWin ? iconv("Big5", "UTF-8", $dir . $file) : $dir . $file;
                    $all_dir[$i]['dir_name'] = $isWin ? iconv("Big5", "UTF-8", $file) : $file;
                    $dir_size                = GetDirectorySize($dir . $file);
                    $total_size += $dir_size;
                    $all_dir[$i]['dir_size'] = format_size($dir_size);
                    $all_dir[$i]['size']     = $dir_size;
                } else {
                    continue;
                    // $all_files[$i]['file_path'] = $isWin ? iconv("Big5", "UTF-8", $dir . $file) : $dir . $file;
                    // $all_files[$i]['file_name'] = $isWin ? iconv("Big5", "UTF-8", $file) : $file;
                    // $file_size                  = filesize($dir . $file);
                    // $total_size += $file_size;
                    // $all_files[$i]['file_size'] = format_size($file_size);
                    // $all_files[$i]['size']      = $file_size;
                }
                $i++;
            }
            closedir($dh);
        }
    }

    $xoopsTpl->assign('theme_name', $theme_name);
    $xoopsTpl->assign('dir', $dir);
    $xoopsTpl->assign('total_size', format_size($total_size));
    $xoopsTpl->assign('all_dir', $all_dir);
    $xoopsTpl->assign('all_files', $all_files);
    // $xoopsTpl->assign('free_space', format_size($free_space));
}

function GetDirectorySize($path)
{
    global $isWin;
    if ($isWin) {
        $bytestotal = 0;
        $obj        = new COM('scripting.filesystemobject');
        if (is_object($obj)) {
            $ref = $obj->getfolder($path);
            return $ref->size;
            $obj = null;
        } else {
            die('can not create object');
        }
    } else {
        $io   = popen('/usr/bin/du -sk ' . $path, 'r');
        $size = fgets($io, 4096);
        $size = substr($size, 0, strpos($size, "\t"));
        pclose($io);
        $size = $size * 1024;
        return $size;
    }

}

//
function format_size($bytes = "")
{
    $si_prefix = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $base      = 1024;
    $class     = min((int) log($bytes, $base), count($si_prefix) - 1);
    $space     = sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $si_prefix[$class];
    return $space;
}

function foldersize($path)
{
    $total_size = 0;
    $files      = scandir($path);
    $cleanPath  = rtrim($path, '/') . '/';

    foreach ($files as $t) {
        if ($t != "." && $t != "..") {
            $currentFile = $cleanPath . $t;
            if (is_dir($currentFile)) {
                $size = foldersize($currentFile);
                $total_size += $size;
            } else {
                $size = filesize($currentFile);
                $total_size += $size;
            }
        }
    }

    return $total_size;
}

function del_templates($dirs = array(), $files = array())
{
    if (is_array($dirs)) {
        foreach ($dirs as $dir) {
            delete_directory($dir);
        }
    }
    if (is_array($files)) {
        foreach ($files as $file) {
            unlink($file);
        }
    }
}

function delete_directory($dirname)
{
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    }

    if (!$dir_handle) {
        return false;
    }

    while ($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname . "/" . $file)) {
                unlink($dirname . "/" . $file);
            } else {
                delete_directory($dirname . '/' . $file);
            }
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op    = system_CleanVars($_REQUEST, 'op', '', 'string');
$g2p   = system_CleanVars($_REQUEST, 'g2p', 0, 'int');
$dirs  = system_CleanVars($_REQUEST, 'dirs', '', 'array');
$files = system_CleanVars($_REQUEST, 'files', '', 'array');

switch ($op) {
    case "del_templates":
        del_templates($dirs, $files);
        header("location:clean.php");
        exit;

    default:
        view_file();
        $op = 'view_file';
        break;

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap3/css/bootstrap.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
include_once 'footer.php';