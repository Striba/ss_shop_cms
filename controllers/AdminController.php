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
    
    $rsCategories = getAllMainCategories(); 
    
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('pageTitle', 'Управление сайтом');
    
    loadTemplate($smarty, 'adminHeader');
    loadTemplate($smarty, 'admin');
    loadTemplate($smarty, 'adminFooter');
}


function addnewcatAction (){
    
    $catName = $_POST['newCategoryName'];
    $catParentId = $_POST['generalCatId'];
    
    $res = insertCat($catName, $catParentId);
    if($res){
        $resData['success'] = 1;
        $resData['message'] = 'Категория добавлена';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка добавления категории';
    }
    
    echo json_encode($resData);
    
    return;
}

/**
 * Страница управления категориями
 * 
 * @param type $smarty
 */
function categoryAction($smarty){
    $rsCategories = getAllCategories();
    $rsMainCategories = getAllMainCategories();
    //d($rsCategories);
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsMainCategories', $rsMainCategories);
    $smarty->assign('pageTitle', 'Управление сайтом');
    
    loadTemplate($smarty, 'adminHeader');
    loadTemplate($smarty, 'adminCategory');
    loadTemplate($smarty, 'adminFooter');
    
}

function updatecategoryAction(){
    
    $itemId = $_POST['itemId'];
    $parentId = $_POST['parentId'];
    $newName = $_POST['newName'];
    //d($newName);
    $res = updateCategoryData($itemId, $parentId, $newName);
    
    if($res){
        $resData['success'] = 1;
        $resData['message'] = 'Категория обновлена';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка изменения данных категории';
    }
    
    echo json_encode($resData);
    return;
}

/**
 * Страница управления товарами
 * 
 * 
 * @param type $smarty 
 */
function productsAction($smarty){
    
    $rsCategories = getAllCategories();
    $rsProducts = getProducts();
    //d($rsCategories);
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);
    
    $smarty->assign('pageTitle', 'Управление сайтом');
    
    loadTemplate($smarty, 'adminHeader');
    loadTemplate($smarty, 'adminProducts');
    loadTemplate($smarty, 'adminFooter');
}

/**
 * 
 * 
 */
function addproductAction(){
  
    $itemName = $_POST['itemName'];
    $itemPrice = $_POST['itemPrice'];
    $itemDesc = $_POST['itemDesc'];
    $itemCat = $_POST['itemCatId'];
    
    $res = insertProduct($itemName, $itemPrice, $itemDesc, $itemCat);
    
    if($res){
        $resData['success'] = 1;
        $resData['message'] = 'Изменения внесены успешно';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка изменения данных';
    }
    
    echo json_encode($resData);
    return;
}

function updateproductAction(){
    //echo 'HIHIHIH';
    $itemId = $_POST['itemId'];
    $itemName = $_POST['itemName'];
    $itemPrice = $_POST['itemPrice'];
    $itemCat = $_POST['itenCatId'];
    $itemStatus = $_POST['itemStatus'];
    $itemDesc = $_POST['itemDesc'];
    
    $res = updateProduct($itemId, $itemName, $itemPrice, $itemStatus, $itemDesc,
                        $itemCat);
    //d($res);
    if($res){
        $resData['success'] = 1;
        $resData['message'] = 'Изменения успешно внесены';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка изменения данных';
    }
    
    echo json_encode($resData);
    return;
}


function uploadAction(){
    //Максимальный размер файла 2Мб:
    $maxSize = 2 * 1024 * 1024;
    
    $itemId = $_POST['itemId'];
    //Получаем расширение загружаемого файла:
    $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
    //создаем имя файла:
    $newFileName = $itemId . '.' . $ext;
    
    if($_FILES['filename']['size'] > $maxSize){
        echo 'Размер файла привышает 2 мегабайта';
        return;
    }
    
    //Загружен ли файл(http методом post)
    if(is_uploaded_file($_FILES['filename']['tmp_name'])){
        
        //Если файл загружен, то перемещаем его из временной директории в конечную
        $res = move_uploaded_file($_FILES['filename']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/images/products/' . $newFileName);
        if($res){
            $res = updatePruductImage($itemId, $newFileName);
            if($res){
                redirect("/admin/products/");
            }
        }
    } else {
        echo 'Ошибка загрузки файла';
    }
   
}function ordersAction($smarty){
    
    $rsOrders = getOrders();
    //d($rsOrders);
    $smarty->assign('rsOrders', $rsOrders);
    $smarty->assign('pageTitle', 'Заказы');
    
    loadTemplate($smarty, 'adminHeader');
    loadTemplate($smarty, 'adminOrders');
    loadTemplate($smarty, 'adminFooter');
    
}

function setorderstatusAction(){
    
    $itemId = $_POST['itemId'];
    $status = $_POST['status'];       
    
    $res = updateOrderStatus($itemId, $status);
    
    if($res){
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка установки статуса';
    }
    
    echo json_encode($resData);
    return;
}

function setorderdatepaymentAction(){
    
    $itemId = $_POST['itemId'];
    $datePayment = $_POST['datePayment'];       

    $res = updateOrderDatePayment($itemId, $datePayment);
    
    if($res){
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка установки статуса';
    }
    
    //echo json_encode($resData);
    return;
    
    
}