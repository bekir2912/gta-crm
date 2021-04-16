<?php
/**
 * Created by PhpStorm.
 * User: lexcorp
 * Date: 17.11.2018
 * Time: 21:25
 */
namespace common\components;

class SmsService
{
    protected $url;

    protected $login;

    protected $password;

    public function __construct()
    {
        $this->url = 'http://91.204.239.44/broker-api/send';
//        $this->login = 'wayitstrategy';
//        $this->password = 'NEtgn4rs';

        $this->url = 'http://91.204.239.44/broker-api/send';
        $this->login = 'wayitstrategy';
        $this->password = 'NEtgn4rs';
    }

    /**
     * РњР°РєСЃРёРјР°Р»СЊРЅРѕРµ РєРѕР»-РІРѕ СЃРѕРѕР±С‰РµРЅРёР№ РІ РѕРґРЅРѕРј Р·Р°РїСЂРѕСЃРµ.
     *
     * @var int
     */
    protected $maxMessages = 500;

    /**
     * РЎРѕРѕР±С‰РµРЅРёСЏ РґР»СЏ РјР°СЃСЃРѕРІРѕР№ СЂР°СЃСЃС‹Р»РєРё.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Р”РѕР±Р°РІРёС‚СЊ СЃРѕРѕР±С‰РµРЅРёРµ РґР»СЏ РјР°СЃСЃРѕРІРѕР№ СЂР°СЃСЃС‹Р»РєРё.
     *
     * @param $phone
     * @param $message
     */
    public function add($phone, $message) {
        $this->messages[] = ['phone' => $phone, 'message' => $message];
    }

    /**
     * РћС‚РїСЂР°Р»СЏРµС‚ РѕРґРЅРѕ sms СЃРѕРѕР±С‰РµРЅРёРµ.
     *
     * @param $phone
     * @param $message
     * @return mixed
     */
    public function send($phone, $message)
    {
        return $this->request(['phone' => $phone, 'text' => $message]);
        $request = $this->makeRequest([['phone' => $phone, 'message' => $message]]);
        return $this->request($request);
    }

    /**
     * РћС‚РїСЂР°РІРёС‚СЊ РІСЃРµ СЃРѕРѕР±С‰РµРЅРёСЏ РёР· РјР°СЃСЃРѕРІРѕР№ СЂР°СЃСЃС‹Р»РєРё.
     */
    public function sendAll()
    {
        $chunks = array_chunk($this->messages, $this->maxMessages);

        foreach ($chunks as $messages) {
            $request = $this->makeRequest($messages);
            $this->request($request);
        }
    }

    /**
     * РћС‚РїСЂР°РІРёС‚СЊ Р·Р°РїСЂРѕСЃ.
     *
     * @param $data
     * @return mixed
     */
    protected function request($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8083",
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_USERPWD => $this->login.":".$this->password,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n \"messages\":\r\n [\r\n {\r\n  \"recipient\":\"".$data['phone']."\",\r\n  \"message-id\":\"vroom".uniqid()."\",\r\n\r\n     \"sms\":{\r\n\r\n       \"originator\": \"3700\",\r\n     \"content\": {\r\n      \"text\": \"".$data['text']."\"\r\n      }\r\n      }\r\n         }\r\n     ]\r\n}\r\n\r\n",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }

    /**
     * РЎС„РѕСЂРјРёСЂРѕРІР°С‚СЊ Р·Р°РїСЂРѕСЃ.
     *
     * @param array $messages
     * @return string
     */
    protected function makeRequest(array $messages)
    {
        $request ='<bulk-request
            login="'.$this->login.'"
            password="'.$this->password.'"
            ref-id="'.date('Y-m-d H:i:s').'"
            delivery-notification-requested="true"
            version="1.0">';

        foreach ($messages as $index => $message) {
            $request .= '<message id="'.($index + 1).'"
                msisdn="'.$message['phone'].'"
                service-number="3700"
                validity-period="3"
                priority="1">
                <content type="text/plain">'.$message['message'].'</content>
            </message>';
        }

        $request .= '</bulk-request>';

        return $request;
    }

    /**
     * РЈРґР°Р»СЏРµС‚ РёР· РЅРѕРјРµСЂР° С‚РµР»РµС„РѕРЅР° РІСЃРµ СЃРёРјРІРѕР»С‹ РєСЂРѕРјРµ С†РёС„СЂ.
     *
     * @param string $phone
     * @return string
     */
    public function clearPhone($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * РџСЂРѕРІРµСЂСЏРµС‚ СЏРІР»СЏРµС‚СЃСЏ Р»Рё РЅРѕРјРµСЂ СѓР·Р±РµРєСЃРєРёРј.
     *
     * @param string $phone
     * @return bool
     */
    public function isUzPhone($phone)
    {
        return preg_match('/^9989[01345789]{1}[0-9]{7}$/', $phone) == 1 ? true : false;
    }
}