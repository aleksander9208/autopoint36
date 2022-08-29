<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?PRauto::EndMainWrap();?>
<?PRauto::site_dir();?>
<footer class="main-footer dark">
    <div class="main-footer__top">
        <div class="container">
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <section class="widget widget-about">
                        <?//=PRauto::DisplayFooterLogo();?>
						<div class="logo">
							<a href="/">
						<svg id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.9 29" width="48.2831mm" height="10.2299mm">
  <defs>
    <style>
      .cls-1, .cls-4 {
        fill: #eb1b24;
      }

      .cls-1, .cls-2, .cls-3 {
        fill-rule: evenodd;
      }

      .cls-2 {
        fill: #fefefe;
      }

      .cls-3 {
        fill: #fff;
      }
    </style>
  </defs>
  <title>3Монтажная область 1</title>
  <path class="cls-1" d="M65.1,4,0,0V28.9s36.9-1.7,51.1-2.2c5.8-.2,11.5-.7,17.3-.4l34.3,1.3,25.7,1.1c1.4,0,7.7.4,8.5.3V0L134,1.3V8.7h-2.9v-5l-4.5,2.3V8.7h-2.8V12h2.8a32.6,32.6,0,0,0-.1,4.5c0,2.8.3,5.1,3.4,6a12.4,12.4,0,0,0,4.1-.1,1.4,1.4,0,0,1,.2.6v2l-11.5-.3c-5.3-.2-49.8-.9-50.1-1.2s-.2-2.8-.2-3.2,1.3,1.8,2.8,2.2c4.1,1,7.3-1.9,7.2-7.2s-3.5-8.1-7.5-6.6a9.9,9.9,0,0,0-2.9,2V8.7H67.7c-.2,1,0,12.6-.1,14.9H64.9Zm66.2,11.5V12h3s0,4.9-.1,6.6-2.3.5-2.7-.1a28.5,28.5,0,0,1-.2-3.1ZM74.6,12.4c3.2-.9,3.6,5.8,1,6.4s-2.7-1.2-2.8-2.7S73.1,12.8,74.6,12.4ZM42.3,6.5h0"/>
  <path class="cls-2" d="M10.9,15.3l2.3-6.8,1,3.2.9,3.4ZM3.3,22.8H8.4l1.2-4.1h6.7l1.6,4.1h5.3L16,4.5H10.3Z"/>
  <path class="cls-1" d="M113.6,10.8v-2h-4.7V22.8H114V16.6c0-1.9,0-3.9,1.9-4s1.9,2,1.9,3.9v6.3H123c.1-2.1,0-4.7,0-6.8s.2-4.1-.8-5.7-2.3-2-4.4-1.8-3.3,1.8-4.2,2.3Z"/>
  <path class="cls-2" d="M32.8,20.7v2.1h4.8V9.3H32.8v2.5c0,4.3,0,6.1-1,6.8a2.6,2.6,0,0,1-1.3.4,2,2,0,0,1-1-.3c-.7-.4-.8-1.7-.8-3.5V9.3h-5v7.1c0,3.1,0,3.9.7,4.8s3.9,1.9,5.9,1.2A5.1,5.1,0,0,0,32.8,20.7Z"/>
  <path class="cls-1" d="M90.8,12.1c4.3-.7,4.6,6.7,1,7.1S87.1,12.8,90.8,12.1Zm-.4-3.6c-4.3.5-7.2,3.2-6.8,8.1s4.1,6.5,8.8,6.1C102.1,21.8,101.1,7.3,90.4,8.5Z"/>
  <path class="cls-2" d="M46.8,9.3V4.2L42.3,6.5h0V9.3H39.5v3.4h2.8v7.1a3.1,3.1,0,0,0,3,3h4.2V19.6H47.8a.9.9,0,0,1-1-1V12.7h2.7V9.3"/>
  <path class="cls-1" d="M13.2,8.5a54.4,54.4,0,0,0-2.3,6.8h4.4Z"/>
  <path class="cls-3" d="M58.3,12.1c4.4-.7,4.7,6.7,1.1,7.1S54.6,12.8,58.3,12.1ZM58,8.5c-4.3.5-7.2,3.2-6.8,8.1s4.1,6.5,8.7,6.1C69.7,21.8,68.7,7.3,58,8.5Z"/>
  <rect class="cls-4" x="101.1" y="8.8" width="5.1" height="13.97"/>
  <rect class="cls-4" x="101.1" y="3.5" width="5.1" height="3.73"/>
</svg>
							</a>
							
							
							
						</div>
						

						
                        <p><?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/footer_info.php"),Array(),Array("MODE"=>"php"));?></p>
                        <a href="<?=SITE_DIR?>form/?FORM_ID=CALLBACK" class="ajax-form fancybox.ajax adp-btn adp-btn--primary"
                           title="<?= GetMessage('CALLBACK'); ?>"><?= GetMessage('CALLBACK'); ?></a>
                    </section>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <section class="widget widget-list">
                        <div class="title">
                            <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/bottomMenu_title.php"),Array(),Array("MODE"=>"php"));?>
                        </div>
                        <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "bottom",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "360000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "bottom"
	),
	false
);?>
                    </section>
                </div>
                <div class="col-xs-12 col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <section class="widget widget-list">
                        <div class="title">
                            <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/bottomMenu2_title.php"),Array(),Array("MODE"=>"php"));?>
                        </div>
                        <div class="d-flex list-group 1">
                            <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "catalog",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "catalog",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"TWO_COL" => "Y",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "360000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "bottom"
	),
	false
);?>
                        </div>
                    </section>
                </div>
                <div class="col-xs-10 col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                    <section class="widget widget-contacts">
                        <div class="title">
                            <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/footer_contact_title.php"),Array(),Array("MODE"=>"php"));?>
                        </div>
                        <?=PRauto::DisplayPhone();?>
                        <p><?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/footer_contact_address.php"),Array(),Array("MODE"=>"php"));?></p>
                    </section>
                    <div class="copyright">
                        <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH . "/include_areas/ru/footer_copyright.php"),Array(),Array("MODE"=>"php"));?>
                    </div>
                </div>
                <div class="col-auto col-sm-6 col-md-6 col-lg-3 col-xl-3 social-extra">
                    <?=PRauto::DisplaySocialFooter();?>
                </div>
            </div>
        </div>
    </div>
    <div class="main-footer__bottom">
        <div class="container">
            <div class="row justify-content-center justify-content-sm-between align-items-end">
                <div class="col-12 col-sm-4 col-md-6 col-lg-auto col-xl-auto">
                    <?=PRauto::DisplaySocialMobile();?>
                </div>
                <div class="col-12 col-sm-8 col-md-6 col-lg-auto col-xl-auto">
                    <ul class="payments d-flex justify-content-center justify-contend-md-end">
                        <li><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/payments/visa.png" alt="visa"></li>
                        <li><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/payments/mastercard.png" alt="mastercard"></li>
                        <li><img src="<?=SITE_TEMPLATE_PATH?>/assets/img/payments/mir.png" alt="mir"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(86000265, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/86000265" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>