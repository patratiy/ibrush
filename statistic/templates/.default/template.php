<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if ($arResult['IS_ADMIN']):

?>

<section class="table-place">

    <div class="alert-info alert-info_warning">Информация обновляется каждый час</div>
    <form class="form-clear" action="<?=$arResult['AJAX'];?>" type="POST">
        <input type="hidden" value="<?=$arResult['CACHE_ID'];?>" id="cache_id" />
        <button id="revalidate">Обновить</button>
    </form>
    
    <!--BEM-->
    <table class="simple-tab">
        <tbody>
            <tr class="simple-tab__row">
                <td class="simple-tab__cell-domen simple-tab__cell-domen_font-weight_bold">
                    Домен
                </td>
                <td class="simple-tab__cell-count simple-tab__cell-count_font-weight_bold">
                    Кол-во заказов
                </td>
            </tr>
            <?
            foreach ($arResult['LIST_GROUP_ORDER'] as $key => $item):
            ?>
            <tr class="simple-tab__row">
                <td class="simple-tab__cell-domen simple-tab__cell-domen_font-weight_bold">
                    <?=$key;?>
                </td>
                <td class="simple-tab__cell-count">
                    [<?=$item;?>]
                </td>
            </tr>
            <? endforeach; ?>
        </tbody>
    </table>

</section>

<?
else:
?>

<h2>Информация доступна только для администраторов</h2>

<?
endif;