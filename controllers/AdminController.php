<?php

/* 
 * AdminController.php
 * 
 * Контроллер бэкэнда сайта (/admin/)
 * 
 */

//подключаем модели:
include_once 'models/CategoriesModel.php';
include_once 'models/ProductsModel.php';
include_once 'models/OrdersModel.php';
include_once 'models/PurchaseModel.php';

//переобозначим пути для отображения админки в SMARTY:
$smarty->setTemplateDir(TemplaxteAdminPrefix);
$smarty->assign('templateWebPath', TemplateAdminWebPath);

function indexAction($smarty){
    
    $smarty->assign('pageTitle', 'Управление сайтом');
    
    loadTemplate($smarty, 'adminHeader');
    loadTemplate($smarty, 'admin');
    loadTemplate($smarty, 'adminFooter');
}