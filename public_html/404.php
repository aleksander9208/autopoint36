<?
define("AUTH_404", "Y");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Запрошенная вами страница не существует");
?>
<div class="main-content">
    <div class="container page_simple">
        <div class="widget">
            <h1 class="title text-xl font-medium letter-spacing-md">Ошибка 404</h1>
        </div>
        <p>Ошибка могла произойти по нескольким причинам:</p>
        <ul>
            <li>Вы ввели неправильный адрес.</li>
            <li>Страница, на которую вы хотели зайти, устарела и была удалена.</li>
            <li>На сервере произошла ошибка. Если так, то мы уже знаем о ней и обязательно исправим.</li>
        </ul>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
