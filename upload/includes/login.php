<?php

/***************************************************************
* paFileDB 3.6                                                 *
*                                                              *
* Author: PHP Arena <http://www.phparena.net>                  *
* File Version 3.6                                             *
* Copyright ©2005-2007 PHP Arena. All Rights Reserved.         *
*                                                              *
* THIS FILE MAY NOT BE REDISTRIBUTED.                          *
* For more information, please see the PHP Arena license at:   *
* http://www.phparena.net/license.html                         *
***************************************************************/

//If the user wants to logout, delete the cookies
if (isset($_GET['logout'])) { 
    setcookie('pafiledb_user', '', time()-31536000);
    setcookie('pafiledb_pass', '', time()-31536000);
    smarty_redirect(lang('logout_redir'));
}

//Assign the Smarty navbar
$smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('login'), 'url' => '?act=login')));
$smarty->assign('title', $settings[0]['dbname'].' &raquo; '.lang('login'));

//Defaults so the template never reads an unset variable
$smarty->assign('logact', 'login');
$smarty->assign('qs', '?act=main');

//Process the login
if (isset($_GET['process'])) {
    $smarty->assign('logact', 'process');
    
    //Check the username and password to make sure they're correct
    $a = array();
    $_login_user = isset($_POST['username']) ? (string)($_POST['username'] ?? '') : '';
    $_login_pass = isset($_POST['password']) ? (string)($_POST['password'] ?? '') : '';
    if (checkpass(xhtml_convert($_login_user), md5($_login_pass), $a)) {
        if ($a[0]['user_status'] == 2) {
        	smarty_error(lang('please_validate'));
        }
        //Set the cookies and redirect to the main page
        setcookie('pafiledb_user', $_login_user, time()+31536000);
        setcookie('pafiledb_pass', md5($_login_pass), time()+31536000);
        smarty_redirect(lang('acp_login_redir').' '.$_login_user, 'index.php'.(isset($_POST['qs']) ? ($_POST['qs'] ?? '') : ''));
    } else {
        
        //Password is wrong, give them an error.
        smarty_error(lang('loginerr'));
        $adminloggedin = false;
    }
} else {
    /*if (!empty($_SERVER['QUERY_STRING'])) {
    	if (strcmp($_SERVER['QUERY_STRING'], "?act=login") != 0) {
        	$smarty->assign('qs', '?act=main');
        } else {
        	$smarty->assign('qs', "?".$_SERVER['QUERY_STRING']);
        }
    } else {
        $smarty->assign('qs', '?act=main');
    }*/
    if (isset($_GET['qs'])) {
    	$smarty->assign('qs', '?'.urldecode(($_GET['qs'] ?? '')));
    }
}

?>