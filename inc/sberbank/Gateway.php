<?php

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