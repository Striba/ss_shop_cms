{* шаблон главной страницы *}  

{foreach $rsProducts as $item name=products}
    <div style="float: left; padding: 0px 30px 40px 0px;">
        <a href="/product/{$item['id']}/">
            <img src="/images/products/{$item['image']}" width="100"/>
        </a><br />
        <a href="/product/{$item['id']}/">{$item['name']}</a>
    </div>
    {if $smarty.foreach.products.iteration mod 3 == 0}{* Если при итеррации
        текущей делится без остатка на 3, то очищаем блок, т.е. 3 следующийх
        будут уже выводиться на нижнем уровне*}
        {* smarty.foreach.products.iteration smarty в данном случае выступает
        подобно псевдопеременной this.
        далее как в джаваскрипте идет обращение к объекту foreach, далее к его
        имени name=products и уже для него приеняется метод: iteration
        *}
        <div style="clear: both;"></div>
    {/if}
{/foreach}