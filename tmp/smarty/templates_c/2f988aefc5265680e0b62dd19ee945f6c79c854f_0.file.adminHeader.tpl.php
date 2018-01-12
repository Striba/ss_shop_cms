<?php
/* Smarty version 3.1.30, created on 2018-01-11 23:08:47
  from "D:\programming\open_server_5_2_6_basic\OS526\OpenServer\domains\ss_shop_cms\views\admin\adminHeader.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a57c44f1cd464_44908740',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2f988aefc5265680e0b62dd19ee945f6c79c854f' => 
    array (
      0 => 'D:\\programming\\open_server_5_2_6_basic\\OS526\\OpenServer\\domains\\ss_shop_cms\\views\\admin\\adminHeader.tpl',
      1 => 1515700600,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:adminLeftColumn.tpl' => 1,
  ),
),false)) {
function content_5a57c44f1cd464_44908740 (Smarty_Internal_Template $_smarty_tpl) {
?>

<html>
    <head>
        <title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</title>
        <link rel='stylesheet' href='<?php echo $_smarty_tpl->tpl_vars['templateWebPath']->value;?>
css/main.css' type="text/css"/>
        <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"><?php echo '</script'; ?>
>
    </head>
    
    <body>
        <div id="header">
            <h1>Управление сайтом</h1>
        </div>
<?php $_smarty_tpl->_subTemplateRender("file:adminLeftColumn.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div id="centerColumn"><?php }
}
