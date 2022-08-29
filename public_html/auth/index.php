<?
define("NEED_AUTH", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");

LocalRedirect(SITE_DIR.'personal/');
?>
	<div class="container page_simple">
		<div class="form__registration">
			<p>Вы зарегистрированы и успешно авторизовались.</p>
			<p><a href="<?=SITE_DIR?>" title="Вернуться на главную страницу">Вернуться на главную страницу</a></p>
		</div>
	</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>