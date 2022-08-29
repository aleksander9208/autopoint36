<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
PRauto::UpdateCompare();
PRauto::UpdateDelayProduct();

use Bitrix\Main\Page\Asset;
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/productItem.js");
?>