<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<div class="container page_simple">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="map">
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A9e3080076666c43352e107d79b56de26d90d88c21a7b61d106613e4020a3d7c0&amp;width=100%25&amp;height=390&amp;lang=ru_RU&amp;scroll=true"></script>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="contact__item d-flex">
                <div class="contact__thumb">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/location-black.png" alt=".">
                </div>
                <div class="contact__content letter-spacing-lg text-sm">
                    г. Россошь, ул. Пролетарская, 14
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="contact__item d-flex">
                <div class="contact__thumb">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/phone-black.png" alt=".">
                </div>
                <div class="contact__content letter-spacing-lg text-sm">
                    Контактный телефон<br>
                    <a href="callto:+79601111185" class="link--black">+7(960) 111-11-85</a><br>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="contact__item d-flex">
                <div class="contact__thumb">
                    <img src="<?=SITE_TEMPLATE_PATH?>/assets/img/icons/mail-black.png" alt=".">
                </div>
                <div class="contact__content letter-spacing-lg text-sm">
                    E-mail<br>
                    <a href="mailto:slavaf94@rambler.ru" class="link--black">slavaf94@rambler.ru</a><br>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="contact__item">
                <a href="<?=SITE_DIR?>form/?FORM_ID=ASK" class="ajax-form fancybox.ajax adp-btn adp-btn--primary">Задать вопрос</a>
            </div>
        </div>

		<div class="col-12">
            <div class="contact__item d-flex">
                <div class="contact__content letter-spacing-lg text-sm">
					<p><b>Название организации:</b> ИП Фоменко Вячеслав Сергеевич</p>
					<p><b>ИНН/КПП:</b> 362710370905 / -</p>
					<p><b>ОГРН:</b> 315366800061626</p>
					<p><b>Юридический адрес:</b> 396650 Воронежская обл. г.Россошь ул.Лизы Чайкиной д.3</p>
					<p><b>Фактический адрес:</b> 396650 Воронежская обл. г.Россошь ул.Пролетарская д.14</p>
					<p><b>Банковские реквизиты</b>
					р/с 40802810513000010055 в ЦЕНТРАЛЬНО-ЧЕРНОЗЕМНЫЙ БАНК СБЕРБАНКА РОССИИ, к/с 30101810600000000681, БИК 042007681</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>