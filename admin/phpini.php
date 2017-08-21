<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_adm_adm_phpini.tpl";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/
//
function phpini()
{
    global $xoopsDB, $xoopsConfig, $xoopsTpl;

    include_once "../language/{$xoopsConfig['language']}/ini_arr.php";

    $php_ini_path = php_ini_loaded_file();
    $xoopsTpl->assign('php_ini_path', $php_ini_path);

    $show_ini = array('allow_url_fopen', 'date.timezone', 'display_errors', 'file_uploads', 'max_execution_time', 'max_file_uploads', 'max_input_time', 'max_input_vars', 'memory_limit', 'post_max_size', 'upload_max_filesize');

    $adv_val = array(
        'max_execution_time'  => '150', //380
        'max_input_time'      => '120', //390
        'max_input_vars'      => '5000', //397
        'memory_limit'        => '240M', //401
        'display_errors'      => '1', //474
        'post_max_size'       => '220M', //668
        'file_uploads'        => '1', //810
        'upload_max_filesize' => '200M', //821
        'max_file_uploads'    => '300', //824
        'allow_url_fopen'     => '1', //832
        'date.timezone'       => 'Asia/Taipei', //940
    );

    $allini = ini_get_all();
    //die(var_export(ini_get_all()));

    $i    = 0;
    $main = array();
    foreach ($allini as $k => $v) {

        if (!in_array($k, $show_ini)) {
            continue;
        }

        $global_value = str_replace(',', ' , ', $v['global_value']);

        $main[$i]['k']            = $k;
        $main[$i]['global_value'] = $global_value;
        $main[$i]['ini']          = isset($ini[$k]) ? $ini[$k] : "";
        $main[$i]['adv']          = $adv_val[$k];
        if ($adv_val[$k] == $global_value) {
            $color = "#000000";
        } elseif ($global_value > $adv_val[$k]) {
            $color = "#3B5E7F";
        } else {
            $color = "red";
        }

        $main[$i]['color'] = $color;
        $i++;
    }

    $xoopsTpl->assign('main', $main);
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op  = system_CleanVars($_REQUEST, 'op', '', 'string');
$g2p = system_CleanVars($_REQUEST, 'g2p', 0, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    default:
        phpini($op);
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap3/css/bootstrap.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
include_once 'footer.php';
