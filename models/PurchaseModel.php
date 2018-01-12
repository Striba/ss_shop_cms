<?php

/* 
 * Модель для таблицы продукции(purchase)
 * 
 */

/**
 * Внесение в БД данных продуктов с привязкой к заказу
 * 
 * @param integer $orderId ID заказа
 * @param array $cart массив корзины
 * @return boolean TRUE в случае успешного добавления в БД
 */
function setPurchaseForOrder($orderId, $cart){
    
    $sql = "INSERT INTO purchase "
            . "(order_id, product_id, price, amount)"
            . " VALUES ";
    
    $values = array();
    //Формируем массив строк для запроса для каждого товара:
    foreach ($cart as $item){
        $values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['cnt']}')";
    }
    
    //преобразовываем массив в строку
    $sql .= implode($values, ', ');
    $rs = mysql_query($sql);
    
    return $rs;
}

/**
 * Получить данные покупки юзера привязанной к айди заказа
 * 
 * @param integer $orderId
 * @return array
 */
function getPurchaseForOrder($orderId){
    
    $sql = "SELECT `pe`.*, `ps`.`name` "
            . "FROM purchase as `pe` JOIN products as `ps` "
            . "ON `pe`.product_id = `ps`.id "
            . "WHERE `pe`.order_id = '{$orderId}'";//получаем объединенную
            // таблицу по принцыпу, чтобы поле product_id таблицы purchase
            //  соответвтовало полю id тблицы products
    
    $rs = mysql_query($sql);
    return createSmartyRsArray($rs);
    
}