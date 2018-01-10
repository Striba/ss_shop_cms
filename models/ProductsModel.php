<?php

/**
 * Модель для таблицы продукции (products)
 * 
 * 
 * 
 * 
 * 
 */



/**
 * Получаем последние добавленные товары
 * 
 * @param integer $limit лимит товаров
 * @return array Массив товаров
 */
function getLastProducts($limit = null){
    
    $sql = "SELECT * FROM `products` ORDER BY id DESC";
    if($limit){
        $sql .= " LIMIT {$limit}";//конкатенируем еще добавку к выражению 
    }
    
    $rs = mysql_query($sql);
    
    return createSmartyRsArray($rs);
}

/**
 * Получить продукты для категории $itemId
 * 
 * @param integer $itemId ID категории
 * @return array массив продуктов
 */
function getProductsByCat($itemId) {
    
    $itemId = intval($itemId);
    $sql = "SELECT * FROM products WHERE category_id = '{$itemId}'";
    
    $rs = mysql_query($sql);
    
    return createSmartyRsArray($rs);
    
}

/**
 * Получить данные продукта по id
 * 
 * @param integer $itemId ID продукта
 * @return array массив данных продукта
 */
function getProductById($itemId) {
    
    $itemId = intval($itemId);//что бы не пришло, превращаем в интеджер SQL 
    //ingection protection
    $sql = "SELECT * "
            . "FROM `products` "
            . "WHERE id='{$itemId}'";//'' - ковычки поставленны тоже с целью
//            безопасности, т.к. если бы не было проверки предидущей на
//            интеджер, то при пустом значении бы сайт повис
    
    $rs = mysql_query($sql);
    
    return mysql_fetch_assoc($rs);
    
}

/**
 * Получить список продуктов из массива идентификаторов (ID's)
 * 
 * @param array $itemIds массив идентификаторов продуктов
 * @return array массив данных продуктов
 */
function getProductsFromArray($itemIds){

    $strIds = implode($itemIds, ', ');
    $sql = "SELECT * FROM products WHERE id in ({$strIds})";

    $rs = mysql_query($sql);
    
    return createSmartyRsArray($rs);
}