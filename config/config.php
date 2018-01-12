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
define ('TemplateWebPath', "templates/{$template}/");//часть шаблонов будут
//находиться в вебпространстве, т.е. в папке www // но это в примере, а я
//по логике должен в корне это все разместить. Т.е. такая запись как раз и под
//ходит, т.к. все в одной папаке-корневой.
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