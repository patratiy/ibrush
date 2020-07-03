<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$cacheId = $request->getPost("cid");

if (isset($cacheId))
{
    $cache = Bitrix\Main\Data\Cache::createInstance();
    
    $cache->clean($cacheId, '/custom');
    
    echo json_encode(['status' => 'ok']);
}
else
{
    echo json_encode(['status' => 'bad']);
}

