<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?>
<?
$APPLICATION->IncludeComponent(
    "iweb:statistic",
    "",
    array(
        'CACHE_TIME' => 3600,
        'EMAIL_PROP_CODE' => 'EMAIL',
    ),
    false
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
