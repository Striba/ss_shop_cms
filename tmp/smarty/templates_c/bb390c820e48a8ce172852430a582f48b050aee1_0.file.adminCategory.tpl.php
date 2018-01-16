<?php
/* Smarty version 3.1.30, created on 2018-01-16 11:49:49
  from "D:\programming\open_server_5_2_6_basic\OS526\OpenServer\domains\ss_shop_cms\views\admin\adminCategory.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a5dbcad7e9186_52324568',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bb390c820e48a8ce172852430a582f48b050aee1' => 
    array (
      0 => 'D:\\programming\\open_server_5_2_6_basic\\OS526\\OpenServer\\domains\\ss_shop_cms\\views\\admin\\adminCategory.tpl',
      1 => 1516092576,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5dbcad7e9186_52324568 (Smarty_Internal_Template $_smarty_tpl) {
?>
<h2>Категории</h2>
<table border="1" callpadding="1" cellspacing="1">
    <tr>
        <th>№</th>
        <th>ID</th>
        <th>Название</th>
        <th>Родительская категория</th>
        <th>Действие</th>
    </tr>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsCategories']->value, 'item', false, NULL, 'categories', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['iteration']++;
?>
        <tr>
            <td><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['iteration'] : null);?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
            <td>
                <input type='edit' id='itemName_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' value="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" />
            </td>
            <td>
                <select id="parentId_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
}">
                    <option value="0">Главная категория
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsMainCategories']->value, 'mainItem');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mainItem']->value) {
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['mainItem']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value['parent_id'] == $_smarty_tpl->tpl_vars['mainItem']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['mainItem']->value['name'];?>

                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </select>
            </td>
            <td>
                <input type="button" value='Сохранить' onclick="updateCat(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
);" />
            </td>
        </tr>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</table><?php }
}
