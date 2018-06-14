<?php
 
/**
 * ДАННЫЕ ДЛЯ ПОДКЛЮЧЕНИЯ К ПЛАТЕЖНОМУ ШЛЮЗУ
 *
 * USERNAME		Логин магазина, полученный при подключении.
 * PASSWORD		Пароль магазина, полученный при подключении.
 * WSDL			Адрес описания веб-сервиса.
 * RETURN_URL	Адрес, на который надо перенаправить пользователя 
 *				в случае успешной оплаты.
 */
define('USERNAME', 'ideatravelrussia-api');
define('PASSWORD', 'ideatravelrussia');
define('WSDL', 'https://3dsec.sberbank.ru/payment/webservices/merchant-ws?wsdl');
define('RETURN_URL', 'http://ideatravelrussia.com');
 
/**
 * КЛАСС ДЛЯ ВЗАИМОДЕЙСТВИЯ С ПЛАТЕЖНЫМ ШЛЮЗОМ
 * Класс наследуется от стандартного класса SoapClient.
 */
class Gateway extends SoapClient {
	
	/**
	 * АВТОРИЗАЦИЯ В ПЛАТЕЖНОМ ШЛЮЗЕ
	 * Генерация SOAP-заголовка для WS_Security.
	 *
	 * ОТВЕТ
	 *		SoapHeader		SOAP-заголовок для авторизации
	 */
	private function generateWSSecurityHeader() {
		$xml = '
			<wsse:Security SOAP-ENV:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				<wsse:UsernameToken>
					<wsse:Username>' . USERNAME . '</wsse:Username>
					<wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . PASSWORD . '</wsse:Password>
					<wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">' . sha1(mt_rand()) . '</wsse:Nonce>
				</wsse:UsernameToken>
			</wsse:Security>';
		
		return new SoapHeader('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'Security', new SoapVar($xml, XSD_ANYXML), true);
	}

	/**
	 * ВЫЗОВ МЕТОДА ПЛАТЕЖНОГО ШЛЮЗА
	 * Переопределение функции SoapClient::__cal().
	 *
	 * ПАРАМЕТРЫ
	 *		method		Метод из API.
	 * 		data		Массив данных.
	 *		
	 * ОТВЕТ
	 *		response	Ответ.
	 */	
	public function __call($method, $data) {
		$this->__setSoapHeaders($this->generateWSSecurityHeader());
		return parent::__call($method, $data); // Вызов метода SoapClient::__call()
	}
}

/*
* ВЫВОД ФОРМЫ НА ЭКРАН
*/
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['orderId'])) {
	echo '
		<form method="post" action="/ws.php">
			<label>Order number</label><br />
			<input type="text" name="orderNumber" /><br />
			<label>Amount</label><br />
			<input type="text" name="amount" /><br />
			<button type="submit">Submit</button>
		</form>
	';
}
/**
 * ОБРАБОТКА ДАННЫХ ИЗ ФОРМЫ
 */
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$client = new Gateway(WSDL);
	$data = array('orderParams' => array(
		'returnUrl' => RETURN_URL,
		'merchantOrderNumber' => urlencode($_POST['orderNumber']),
		'amount' => urlencode($_POST['amount'])
	));
	
	/**
	 * РЕГИСТРАЦИЯ ОДНОСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
	 * Регистрация заказа без предавторизацией.
	 * 
	 * ПАРАМЕТРЫ
	 *		orderNumber			Уникальный идентификатор заказа в магазине.
	 *		amount				Сумма заказа.
	 *		returnUrl			Адрес, на который надо перенаправить пользователя в случае успешной оплаты.
	 *
	 * ОТВЕТ
	 * 		В случае ошибки:
	 * 			errorCode		Код ошибки. Список возможных значений приведен в таблице ниже.
	 * 			errorMessage	Описание ошибки.
	 *
	 * 		В случае успешной регистрации:
	 * 			orderId			Номер заказа в платежной системе. Уникален в пределах системы.
	 * 			formUrl			URL платежной формы, на который надо перенаправить браузер клиента.
	 *
	 *	Код ошибки		Описание
	 *		0			Обработка запроса прошла без системных ошибок.
	 *		1			Заказ с таким номером уже зарегистрирован в системе;
	 *					Неверный номер заказа.
	 *		3			Неизвестная (запрещенная) валюта.
	 *		4			Отсутствует обязательный параметр запроса.
	 *		5			Ошибка значения параметра запроса.
	 *		7			Системная ошибка.
	 */
	$response = $client->__call('registerOrder', $data);

	/**
	 * РЕГИСТРАЦИЯ ДВУХСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
	 * Регистрация заказа с предавторизацией.
	 *
	 * Параметры и ответ точно такие же, как и в предыдущем методе.
	 * Необходимо вызывать либо registerOrder, либо registerOrderPreAuth.
	 */
//	$response = $client->__call('registerOrderPreAuth', $data);
	
	if ($response->errorCode != 0) { // В случае ошибки вывести ее
		echo 'Ошибка #' . $response->errorCode . ': ' . $response->errorMessage;
	} else { // В случае успеха перенаправить пользователя на плетжную форму
		header('Location: ' . $response->formUrl);
		die();
	}
	
} 
/**
 * ОБРАБОТКА ДАННЫХ ПОСЛЕ ПЛАТЕЖНОЙ ФОРМЫ
 */
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['orderId'])){
	$client = new Gateway(WSDL);
	$data = array('orderParams' => array('orderId' => $_GET['orderId']));
	
	/**
	 * ЗАПРОС СОСТОЯНИЯ ЗАКАЗА
	 *		getOrderStatus
	 *
	 * ПАРАМЕТРЫ
	 *		orderId				Номер заказа в платежной системе. Уникален в пределах системы.
	 * 
	 * ОТВЕТ
	 * 		ErrorCode			Код ошибки. Список возможных значений приведен в таблице ниже.
	 * 		OrderStatus			По значению этого параметра определяется состояние заказа в платежной системе. 
	 *							Список возможных значений приведен в таблице ниже. Отсутствует, если заказ не был найден.
	 *
	 *	Код ошибки		Описание
	 *		0			Обработка запроса прошла без системных ошибок.
	 *		2			Заказ отклонен по причине ошибки в реквизитах платежа.
	 *		5			Доступ запрещён;
	 *					Пользователь должен сменить свой пароль;
	 *					Номер заказа не указан.
	 *		6			Неизвестный номер заказа.
	 *		7			Системная ошибка.
	 *
	 *	Статус заказа	Описание
	 *		0			Заказ зарегистрирован, но не оплачен.
	 *		1			Предавторизованная сумма захолдирована (для двухстадийных платежей).
	 *		2			Проведена полная авторизация суммы заказа.
	 *		3			Авторизация отменена.
	 *		4			По транзакции была проведена операция возврата.
	 *		5			Инициирована авторизация через ACS банка-эмитента.
	 *		6			Авторизация отклонена.
	 */
	$response = $client->__call('getOrderStatus', $data);
	
	// Вывод кода ошибки и статус заказа
	echo '
		<b>Error code:</b> ' . $response->errorCode . '<br />
		<b>Order status:</b> ' . $response->orderStatus . '<br />
	';
}

?>
