<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	if(
		!empty($_GET["USER_PASSWORD"]) ||
		!empty($_GET["USER_PASSWORD_CONFIRM"]) ||
		!empty($_GET["USER_STREET"]) ||
		!empty($_GET["USER_MOBILE"]) ||
		!empty($_GET["USER_CITY"]) ||
		!empty($_GET["USER_ZIP"]) ||
		!empty($_GET["EMAIL"]) ||
		!empty($_GET["NAME"]) ||
		!empty($_GET["LAST_NAME"])
	){
		global $USER;
		$userID = $USER->GetID();
		if($userID){



//			$NAME            = explode(" ", htmlspecialchars($_GET["NAME"]));
			$LAST_NAME            = explode(" ", htmlspecialchars($_GET["LAST_NAME"]));
//			$NAME            = explode(" ", htmlspecialchars($_GET["FIO"]));
			$EMAIL           = htmlspecialchars($_GET["EMAIL"]);
			$PASSWORD        = addslashes($_GET["USER_PASSWORD"]);
			$REPASSWORD      = addslashes($_GET["USER_PASSWORD_CONFIRM"]);
			$PERSONAL_STREET = htmlspecialchars($_GET["USER_STREET"]);
			$PERSONAL_MOBILE = htmlspecialchars($_GET["USER_MOBILE"]);
			$PERSONAL_CITY   = htmlspecialchars($_GET["USER_CITY"]);
			$PERSONAL_ZIP    = htmlspecialchars($_GET["USER_ZIP"]);

			$fields = array();

			if(!empty($_GET["NAME"]))
				$fields['NAME'] = BX_UTF === true ? $_GET["NAME"] : iconv("UTF-8","windows-1251//IGNORE", $_GET["NAME"]);

			if(!empty($_GET["LAST_NAME"]))
				$fields['LAST_NAME'] = BX_UTF === true ? $_GET["LAST_NAME"] : iconv("UTF-8","windows-1251//IGNORE", $_GET["LAST_NAME"]);

			if(!empty($_GET["USER_STREET"]))
				$fields['PERSONAL_STREET'] = BX_UTF === true ? $_GET["USER_STREET"] : iconv("UTF-8","windows-1251//IGNORE", $_GET["USER_STREET"]);

			if(!empty($_GET["USER_CITY"]))
				$fields['PERSONAL_CITY'] = BX_UTF === true ? $_GET["USER_CITY"] : iconv("UTF-8","windows-1251//IGNORE", $_GET["USER_CITY"]);

			if(!empty($_GET["USER_ZIP"]))
				$fields['PERSONAL_ZIP'] = BX_UTF === true ? $_GET["USER_ZIP"] : iconv("UTF-8","windows-1251//IGNORE", $_GET["USER_ZIP"]);

			if(!empty($_GET["USER_MOBILE"]))
				$fields['PERSONAL_MOBILE'] = BX_UTF === true ? $_GET["USER_MOBILE"] : iconv("UTF-8","windows-1251//IGNORE", $_GET["USER_MOBILE"]);

			if(!empty($_GET["USER_PASSWORD"]) && !empty($_GET["USER_PASSWORD_CONFIRM"])){
				$fields['PASSWORD'] = $_GET["USER_PASSWORD"];
				$fields['CONFIRM_PASSWORD'] = $_GET["USER_PASSWORD_CONFIRM"];
			}

			$user = new CUser;
//			$fields = Array(
//			  "NAME"              => BX_UTF === true ? $NAME : iconv("UTF-8","windows-1251//IGNORE", $NAME),
//			  "LAST_NAME"         => BX_UTF === true ? $LAST_NAME : iconv("UTF-8","windows-1251//IGNORE", $LAST_NAME),
////			  "SECOND_NAME"       => BX_UTF === true ? $NAME[2] : iconv("UTF-8","windows-1251//IGNORE", $NAME[2]),
//			  "PERSONAL_STREET"   => BX_UTF === true ? $PERSONAL_STREET : iconv("UTF-8","windows-1251//IGNORE", $PERSONAL_STREET),
//			  "PERSONAL_CITY"	  => BX_UTF === true ? $PERSONAL_CITY : iconv("UTF-8","windows-1251//IGNORE", $PERSONAL_CITY),
//			  "PERSONAL_ZIP"      => BX_UTF === true ? $PERSONAL_ZIP : iconv("UTF-8","windows-1251//IGNORE", $PERSONAL_ZIP),
//			  "PERSONAL_MOBILE"   => BX_UTF === true ? $PERSONAL_MOBILE : iconv("UTF-8","windows-1251//IGNORE", $PERSONAL_MOBILE),
//			  "EMAIL"             => $EMAIL,
//			  "PASSWORD"          => $PASSWORD,
//			  "CONFIRM_PASSWORD"  => $REPASSWORD
//			);

//			if(empty($PASSWORD)){
//				unset($fields["PASSWORD"]);
//				unset($fields["REPASSWORD"]);
//			}

			if(!$user->Update($userID, $fields)){
				$result = array(
					"message" => strip_tags($user->LAST_ERROR),
					"heading" => "Error",
					"reload" => false
				);
			}else{
				$result = array(
					"message" => "Information saved successfully",
					"heading" => "Saved",
					"reload" => true
				);
			}
		}else{
			$result = array(
				"message" => "Требуется авторизация",
				"heading" => "Error",
				"reload" => false
			);
		}
	
	}else{
		$result = array(
			"message" => "Form transfer error",
			"heading" => "Error",
			"reload" => false
		);
	}

	echo jsonEn($result);

	function jsonEn($data){
		foreach ($data as $index => $arValue) {
			$arJsn[] = '"'.$index.'" : "'.addslashes($arValue).'"';
		}
		return  "{".implode($arJsn, ",")."}";
	}

?>

