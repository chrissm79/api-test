<?php

namespace App\Auth;

use GuzzleHttp\Client;
use League\OAuth2\Server\Exception\OAuthServerException;

class Proxy
{

    private static $DEFAULT_WYW_CLIENT = "wu";

    public function attemptLogin($credentials)
    {
        return $this->proxy('password', $credentials);
    }

    public function attemptRefresh($token)
    {
        return $this->proxy('refresh_token', [ 'refresh_token' => $token ]);
    }

    private function proxy($grantType, array $data = [])
    {

        if (!isset($data['response']) || !is_array($data['response'])) {
            $data['response'] = [
                'accessToken' => 'access_token',
                'accessTokenExpiration'  => 'expires_in',
                'refreshToken' => 'refresh_token'
            ];
        }

        try {

            app()->configure('secrets');
            $config = app()->make('config');
            $crypt = app()->make('encrypter');
            /* @var $crypt \Illuminate\Encryption\Encrypter*/
            $client = false;

            $url = env('APP_' . strtoupper(env('APP_ENV', '')) . '_URL', env('APP_URL')) . '/oauth/token';

            $clients = $config->get('secrets.clients');

            if ($grantType === 'refresh_token') {

                // decrypt 2nd encryption
                $token = $crypt->decrypt($data['refresh_token']);

                // replace data array with bin2hex token
                $data['refresh_token'] = bin2hex($token['refresh_token']);

                // find client
                foreach ($clients as $values) {
                    if ($values['id'] == $token['client_id']) {
                        $client = $values;
                        break;
                    }
                }


            } else {

                // retrieve client info from users config
                $users = $config->get('secrets.users');
                $user = $users[$data['username']] ?: false;

                if (empty($user) || empty($user['client_id'])) {

                    // in case a WYW user tries to login, his username will not be found in the secrets config file
                    // allow this kind of requests if length of username and password > 15
                    if (strlen($data['username'] . $data['password']) > 15) {

                        $client = $clients[self::$DEFAULT_WYW_CLIENT] ?: false;

                    } else {

                        throw OAuthServerException::invalidCredentials();
                    }

                } else {

                    $client = $clients[$user['client_id']] ?: false;

                }

            }


            if (!$client || !array_key_exists('secret', $client) || empty($client['secret'])
                || !array_key_exists('scopes', $client) || empty($client['scopes'])
            ) {
                throw OAuthServerException::invalidClient();
            }

            $data = array_merge([
                'client_id'     => $client['id'],
                'client_secret' => $client['secret'],
                'grant_type'    => $grantType,
                'scope'         => $client['scopes']
            ], $data);

            $httpRequest = new Client(strpos($url, 'https') === false ? array() : array('verify' => '/etc/ssl/certs/ca-bundle.crt'));

//            error_log("\n" . __FILE__ . ': ' . __LINE__ . " [" . env('APP_PLATFORM') . "][" . env('APP_ENV')
//                . "] Posting to $url with form data: \n"
//                . print_r($data, 1), 3, '/tmp/debug.txt');
            $guzzleResponse = $httpRequest->post($url, [
                'form_params' => $data
            ]);

        } catch(\GuzzleHttp\Exception\BadResponseException $e) {
            $guzzleResponse = $e->getResponse();
            error_log("\n".__FILE__.': '.__LINE__." [".env('APP_PLATFORM')."][".env('APP_ENV')."] BAD RESPONSE: \n" . print_r($guzzleResponse, 1), 3, '/tmp/debug.txt');
        }

        $response = json_decode($guzzleResponse->getBody());

        if ($response instanceof \stdClass && property_exists($response, "access_token")) {

            $responseData = [];

            foreach ($data['response'] as $key => $value) {
                if ($key == 'refreshToken') {

                    $responseData[$key] = $crypt->encrypt([
                        'client_id' => $client['id'],
                        'refresh_token' => hex2bin($response->$value)
                    ]);

                } else {
                    $responseData[$key] = $response->$value;
                }
            }

            $response = response()->json($responseData);
            $response->setStatusCode($guzzleResponse->getStatusCode());

            $headers = $guzzleResponse->getHeaders();
            foreach($headers as $headerType => $headerValue) {
                $response->header($headerType, $headerValue);
            }

            error_log("Valid response sent with data: " . print_r($responseData, 1), 3, '/tmp/debug.txt');

            return $response;

        }

        $response = response()->json(['error' => true, 'message' => 'Unauthorized.']);
        $response->setStatusCode($guzzleResponse->getStatusCode());

        $headers = $guzzleResponse->getHeaders();
        foreach($headers as $headerType => $headerValue) {
            $response->header($headerType, $headerValue);
        }

        return $response;


    }

}
