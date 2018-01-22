<?php
/**
 * 
 * файл настроек
 * 
 * 
 */
//>Константы для обращения к контроллерам:
define('PathPrefix', 'controllers/');
define('PathPostfix', 'Controller.php');
//<

//>исспользуемый шаблон
$template = 'default';
$templateAdmin = 'admin';

//Пути к файлам шаблонов (*.tpl)
define('TemplaxtePrefix', "views/{$template}/");
define('TemplaxteAdminPrefix', "views/{$templateAdmin}/");
define('TemplatePostfix', '.tpl');

//Пути к файлам шаблонов в вебпространстве
define ('TemplateWebPath', "templates/{$template}/");
define ('TemplateAdminWebPath', "templates/{$templateAdmin}/");
//<

//>Инициализация шаблонизатора Smarty:
//put full path to Smarty.class.php
require 'library/Smarty/libs/Smarty.class.php';
$smarty = new Smarty();

$smarty->setTemplateDir(TemplaxtePrefix);
$smarty->setCompileDir('tmp/smarty/templates_c');
$smarty->setCacheDir('tmp/smarty/cache');
$smarty->setConfigDir('library/Smarty/configs');

$smarty->assign('templateWebPath', TemplateWebPath);


//<