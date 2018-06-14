<?php
class Alfabank {
	private $username = 'ideatravelrussia-api';
	private $password = 'ideatravelrussia';
	private $gateway_url = 'https://test.paymentgate.ru/testpayment/rest/';
	private $return_url = 'http://ideatravelrussia.com/wp-admin/admin-ajax.php?action=alfabank_return_url';

	/**
	 * ФУНКЦИЯ ДЛЯ ВЗАИМОДЕЙСТВИЯ С ПЛАТЕЖНЫМ ШЛЮЗОМ
	 *
	 * Для отправки POST запросов на платежный шлюз используется
	 * стандартная библиотека cURL.
	 *
	 * ПАРАМЕТРЫ
	 *		method		Метод из API.
	 * 		data		Массив данных.
	 *
	 * ОТВЕТ
	 *		response	Ответ.
	 */
	private function gateway($method, $data) {
		$curl = curl_init(); // Инициализируем запрос
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->gateway_url.$method, // Полный адрес метода
			CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
			CURLOPT_POST => true, // Метод POST
			CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
		));
		$response = curl_exec($curl); // Выполненяем запрос

		$response = json_decode($response, true); // Декодируем из JSON в массив
		curl_close($curl); // Закрываем соединение
		return $response; // Возвращаем ответ
	}


	/**
	 * ОБРАБОТКА ДАННЫХ ИЗ ФОРМЫ
	 */
	public function dataform( $orderNumber, $amount, $email = '' ){

		$data = array(
			'userName' 		=> $this->username,
			'password' 		=> $this->password,
			'orderNumber' 	=> urlencode( $orderNumber ),
			'amount' 		=> urlencode( $amount ),
			'currency'		=> 978,
			'returnUrl'	 	=> $this->return_url,
			'jsonParams' => json_encode([
				'mail'=> $email
			]),
		);

		//var_dump( http_build_query($data) );
		//die();

		/**
		 * ЗАПРОС РЕГИСТРАЦИИ ОДНОСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
		 *		register.do
		 *
		 * ПАРАМЕТРЫ
		 *		userName			Логин магазина.
		 *		password			Пароль магазина.
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
		 *		1			Заказ с таким номером уже зарегистрирован в системе.
		 *		3			Неизвестная (запрещенная) валюта.
		 *		4			Отсутствует обязательный параметр запроса.
		 *		5			Ошибка значения параметра запроса.
		 *		7			Системная ошибка.
		 */
		$response = $this->gateway('register.do', $data);

		/**
		 * ЗАПРОС РЕГИСТРАЦИИ ДВУХСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
		 *		registerPreAuth.do
		 *
		 * Параметры и ответ точно такие же, как и в предыдущем методе.
		 * Необходимо вызывать либо register.do, либо registerPreAuth.do.
		 */
		//	$response = gateway('registerPreAuth.do', $data);
		return $response;

	}

	/**
	 * ОБРАБОТКА ДАННЫХ ПОСЛЕ ПЛАТЕЖНОЙ ФОРМЫ
	 */
	public function afterpayment(){
		$data = array(
			'userName' => $this->username,
			'password' => $this->password,
			'orderId' => $_GET['orderId']
		);

		/**
		 * ЗАПРОС СОСТОЯНИЯ ЗАКАЗА
		 *        getOrderStatus
		 *
		 * ПАРАМЕТРЫ
		 *        userName            Логин магазина.
		 *        password            Пароль магазина.
		 *        orderId                Номер заказа в платежной системе. Уникален в пределах системы.
		 *
		 * ОТВЕТ
		 *        ErrorCode            Код ошибки. Список возможных значений приведен в таблице ниже.
		 *        OrderStatus            По значению этого параметра определяется состояние заказа в платежной системе.
		 *                            Список возможных значений приведен в таблице ниже. Отсутствует, если заказ не был найден.
		 *
		 *    Код ошибки        Описание
		 *        0            Обработка запроса прошла без системных ошибок.
		 *        2            Заказ отклонен по причине ошибки в реквизитах платежа.
		 *        5            Доступ запрещён;
		 *                    Пользователь должен сменить свой пароль;
		 *                    Номер заказа не указан.
		 *        6            Неизвестный номер заказа.
		 *        7            Системная ошибка.
		 *
		 *    Статус заказа    Описание
		 *        0            Заказ зарегистрирован, но не оплачен.
		 *        1            Предавторизованная сумма захолдирована (для двухстадийных платежей).
		 *        2            Проведена полная авторизация суммы заказа.
		 *        3            Авторизация отменена.
		 *        4            По транзакции была проведена операция возврата.
		 *        5            Инициирована авторизация через ACS банка-эмитента.
		 *        6            Авторизация отклонена.
		 */
		//$response = $this->gateway('getOrderStatus.do', $data);
		$response = $this->gateway('getOrderStatusExtended.do', $data);

		// Вывод кода ошибки и статус заказа
		return $response;
	}
}