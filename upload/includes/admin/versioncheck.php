<?php

/***************************************************************
* paFileDB 3.6                                                 *
*                                                              *
* Author: PHP Arena <http://www.phparena.net>                  *
* File Version 3.6                                             *
* Copyright �2005-2007 PHP Arena. All Rights Reserved.         *
*                                                              *
* THIS FILE MAY NOT BE REDISTRIBUTED.                          *
* For more information, please see the PHP Arena license at:   *
* http://www.phparena.net/license.html                         *
***************************************************************/

$new_version = @file('http://www.phparena.net/versioncheck.php?s=pafiledb');
$smarty->assign('new_version', (is_array($new_version) && isset($new_version[0])) ? trim($new_version[0]) : '');
?>