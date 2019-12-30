<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест");
?>


<?

if (CModule::IncludeModule("sale"))
{
global $USER;
    if ($USER->IsAuthorized()
      && ($user_info = \Bitrix\Main\UserTable::getList([
        'filter' => [
          '=ID' => $USER->GetID(),
        ],
        'select' => [
          'EMAIL',
          'NAME',
          'LAST_NAME',
          'SECOND_NAME',
          'PERSONAL_PHONE',
        ],
      ])->fetch())
    ) {
      
      ?> <pre><? print_r($user_info ) ?></pre> <?    
      }
}

?>




<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>