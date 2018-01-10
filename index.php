<?php

session_start(); //стартуем сессию

// если в сессии нет массива корзины, то создаем его
if (! isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

include_once 'config/config.php';        //инициализация настроек
include_once 'config/db.php';        //инициализация базы данных
include_once 'library/mainFunctions.php';//основные функции

//определяем с каким контроллером будем работать:
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';
//echo 'Current controllerName is: '.$controllerName.'<br />';

//определяем с какой функцией будем раотать
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';
//echo 'Current actionName is: '.$actionName.'<br />';

//подключаем контроллер
//include_once 'controllers/' . $controllerName . 'Controller.php' ;

//формируем название функции:
//$function = $actionName . 'Action';

//echo 'Полное название вызываемой функции:  ' . $function . '<br />';
//echo 'Full name of the function:  ' . $function . '<br />';

//$function();//будет вызвана не переменная а уже функция

//Константы для обращения к контроллерам:
//define('PathPrefix', 'controllers/');
//define('PathPostfix', 'Controller.php');

//function loadPage($controllerName, $actionName = 'index'){//если $actionName не 
////передается, то по умолчанию будет передаваться: 'index'
//    include_once PathPrefix . $controllerName . PathPostfix;
//    
//    $function =  $actionName . 'Action';
//    $function();
//}

//если в сессии есть данные об авторизованно пользователе,
// то передаем их в шаблон
if(isset($_SESSION['user'])){
    $smarty->assign('arUser', $_SESSION['user']);
}

//инициализируем переменную шаблонизатора колличества переменных в корзине
$smarty->assign('cartCntItems', count($_SESSION['cart']));

//Вызываем функцию:
loadPage($smarty, $controllerName, $actionName);

