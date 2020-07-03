<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule("sale");

global $USER;

if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 3600;
}

use \Bitrix\Sale\Internals\OrderTable;

$arResult['DATE_NOW'] = date('Y-m-d');
$arResult['IS_ADMIN'] = $USER->IsAdmin();
$arResult['AJAX'] = $componentPath . '/ajax/clear.php';

$arResult['LIST_GROUP_ORDER'] = [];

/*
$users = Bitrix\Main\UserTable::getList([
    'select' => ['ID', 'EMAIL'],
]);

$user_email = [];

while ($item = $users->fetch()) {
    $user_email[$item['ID']] = $item['EMAIL'];
}

Bitrix\Main\Diag\Debug::dump($user_email);
*/

$cache = Bitrix\Main\Data\Cache::createInstance();

$arResult['CACHE_ID'] = sha1('elements/order-domain-stat');

//Bitrix\Main\Diag\Debug::dump($arParams['CACHE_TIME']);
//Bitrix\Main\Diag\Debug::startTimeLabel("foo");

if ($cache->initCache($arParams['CACHE_TIME'], $arResult['CACHE_ID'], '/custom'))
{
    $arResult['LIST_GROUP_ORDER'] = $cache->getVars();
}
elseif ($cache->startDataCache())
{

    $runtime["PROPERTY_{$arParams['EMAIL_PROP_CODE']}"] = new \Bitrix\Main\Entity\ReferenceField(
        "PROPERTY_{$arParams['EMAIL_PROP_CODE']}",
        "\Bitrix\Sale\Internals\OrderPropsValueTable",
        [
            '=this.ID' => 'ref.ORDER_ID',
            '=ref.CODE' => new \Bitrix\Main\DB\SqlExpression('?', "{$arParams['EMAIL_PROP_CODE']}"),
        ]
    );
    
    $orders = OrderTable::getList([
        'select' => ['ID', 'USER_ID', "PROPERTY_{$arParams['EMAIL_PROP_CODE']}_VALUE" => "PROPERTY_{$arParams['EMAIL_PROP_CODE']}.VALUE"],
        'filter' => [],
        'order' => ['ID' => 'DESC'],
        'runtime' => $runtime,
    ]);
    
    while ($item = $orders->fetch()) {
        //Bitrix\Main\Diag\Debug::dump($item);
        $domain = preg_split('/@/', $item["PROPERTY_{$arParams['EMAIL_PROP_CODE']}_VALUE"])[1];
        if (!isset($arResult['LIST_GROUP_ORDER'][$domain])) {
            $arResult['LIST_GROUP_ORDER'][$domain] = 1;
        } else {
            $arResult['LIST_GROUP_ORDER'][$domain]++;
        }
    }
    
    $cache->endDataCache($arResult['LIST_GROUP_ORDER']);
}

//Bitrix\Main\Diag\Debug::endTimeLabel("foo");

//Bitrix\Main\Diag\Debug::dump(Bitrix\Main\Diag\Debug::getTimeLabels());

$arResult['LIST_GROUP_ORDER']['gmail.com']++;

$this->includeComponentTemplate();

?>