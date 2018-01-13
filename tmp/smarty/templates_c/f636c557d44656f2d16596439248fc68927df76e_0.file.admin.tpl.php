<?php
/* Smarty version 3.1.30, created on 2018-01-13 13:30:05
  from "D:\programming\open_server_5_2_6_basic\OS526\OpenServer\domains\ss_shop_cms\views\admin\admin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a59dfad2baf95_06548123',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f636c557d44656f2d16596439248fc68927df76e' => 
    array (
      0 => 'D:\\programming\\open_server_5_2_6_basic\\OS526\\OpenServer\\domains\\ss_shop_cms\\views\\admin\\admin.tpl',
      1 => 1515839370,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a59dfad2baf95_06548123 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="blockNewCategory">
    Новая категория:
    <input name="newCategoryName" id="newCategoryName" type="text" value="" />
    <br />
    
    Является подкатегорией для:
    <select name="generalCatId">
        <option value="0">Главная Категория
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsCategories']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
            <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        
    </select>
    <br />
    <input type='button' onclick="newCategory();" value='Добавить категорию' />
    
    
</div><?php }
}
