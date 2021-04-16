<?php
/**
 * Created by ru.lexcorp.
 * User: lexcorp
 * Date: 01.12.2017
 * Time: 6:52
 */

namespace frontend\components;

use yii\authclient\OAuth2;

class Ok extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://connect.ok.ru/oauth/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://api.ok.ru/oauth/token.do';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://api.ok.ru/api';

    /**
     * @var array list of attribute names, which should be requested from API to initialize user attributes.
     * @since 2.0.4
     */
    public $attributeNames = [
        'name',
        'email'
    ];



    /**
     * @inheritdoc
     */
//    public function init()
//    {
//        parent::init();
//        if ($this->scope === null) {
//            $this->scope = implode(' ', [
//                'profile',
//                'email',
//            ]);
//        }
//    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $secret_key = md5($this->getAccessToken()->getToken().$this->clientSecret);
        $sig = md5('application_key=CBAJCQAMEBABABABAfields=name,emailformat=json'.$secret_key);
        $response = $this->api('users/getCurrentUser', 'GET', [
            'application_key' => 'CBAJCQAMEBABABABA',
            'fields' => implode(',', $this->attributeNames),
            'format' => 'json',
            'sig' => $sig,
        ]);
        $attributes = ($response);

        $accessToken = $this->getAccessToken();
        if (is_object($accessToken)) {
            $accessTokenParams = $accessToken->getParams();
            unset($accessTokenParams['access_token']);
            unset($accessTokenParams['expires_in']);
            $attributes = array_merge($accessTokenParams, $attributes);
        }

        return $attributes;
    }

    /**
     * @inheritdoc
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $data = $request->getData();
        $data['uids'] = $accessToken->getParam('user_id');
        $data['access_token'] = $accessToken->getToken();
        $request->setData($data);
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'ok';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'Ok';
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'id' => 'uid'
        ];
    }
}
