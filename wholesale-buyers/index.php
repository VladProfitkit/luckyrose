<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оптовикам");
?>
    <div class="SOME_FORM">
        <form id="distr_form" method="post" action="/ajax/ajax_form_for_distributor.php">
            <input type="hidden" name="IS_AJAX" value="N">
            <label>Страна:*</label>
            <input type="text" name="country" required placeholder="Страна">
            <label>Город:*</label>
            <input type="text" name="city" required placeholder="Город">
            <label>Имя:*</label>
            <input type="text" name="user_name" placeholder="Имя">
            <label>Фамилия:*</label>
            <input type="text" name="user_surname" required placeholder="Фамилия">
            <label>Номер телефона:*</label>
            <input type="tel" name="user_number" required placeholder="Номер телефона">
            <label>E-mail:*</label>
            <input type="email" name="user_email" required placeholder="E-mail">
            <label>Магазин/Школа/Студия(название):*</label>
            <input type="text" name="user_shop" required placeholder="Магазин/Школа/Студия(название)">
            <label>Ссылки в социальных сетях/сайт:*</label>
            <input type="text" name="user_links" required placeholder="Ссылки в социальных сетях/сайт">
            <input type="submit" value="Отправить">
            <br>
        </form>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>