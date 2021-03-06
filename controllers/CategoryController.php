<?php

/* 
 * 
 * Контроллер страницы категории (/category/1)
 * 
 */

//подключаем модели
include_once 'models/CategoriesModel.php';
include_once 'models/ProductsModel.php';

/**
 * формирование страницы категории
 * 
 * 
 * @param object $smarty шаблонизатор
 */
function indexAction ($smarty){
    $catId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($catId == null) exit();
    
    //Инициализируем наши переменные:
    $rsCategory = null;
    $rsProducts = null;
            
    $rsCategory = getCatById($catId);
    //d($rsCategory);
    //если главная категория, то показываем дочернюю категорию,
    //иначе показывает товар
    if($rsCategory['parent_id'] == 0){
        //d('WE ARE');
         $rsChildCats = getChildrenForCat($catId);
    } else {
        //d('WE NOT');
         $rsProducts = getProductsByCat($catId);
    }
    //d($rsProducts);
    $rsCategories = getAllMainCatsWithChildren();

    $smarty->assign('pageTitle', 'Товары категории '.$rsCategory['name']);
    
    $smarty->assign('rsCategory', $rsCategory);
    $smarty->assign('rsProducts', $rsProducts);
    $smarty->assign('rsChildCats', $rsChildCats);

    $smarty->assign('rsCategories', $rsCategories);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'category');
    loadTemplate($smarty, 'footer');
    
}