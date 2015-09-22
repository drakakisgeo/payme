<?php

namespace Lollypop\Services;

use App\User;
use App\Userservice;
use Curl\Curl;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Session\Store as Session;

class Clef
{

    private $memberarea = '/mypayments';

    private $appid;
    private $appsecret;
    private $user;
    private $auth;
    private $session;
    private $userInfo;
    private $curl;


    public function __construct(User $user, AuthManager $auth, Session $session, Curl $curl)
    {
        $this->user = $user;
        $this->auth = $auth;
        $this->session = $session;
        $this->curl = $curl;
        $this->appid = getenv('CLEF_APPID');
        $this->appsecret = getenv('CLEF_APPSECRET');
    }

    public function generateStateNonce()
    {
        return $this->generate_state_parameter();
    }

    /**
     * @param $state
     * Validate if $state variable is a valid one
     *
     * @return bool
     */
    public function validate_state($state)
    {
        $is_valid = (null !== $this->session->get('state')) &&
          strlen($this->session->get('state')) > 0 &&
          $this->session->get('state') == $state;

        // Immediately flush session so only one request is allowed
        //$this->session->flush();

        if (!$is_valid) {
            abort(403, 'Unauthorized action.');
        }

        return $is_valid;
    }

    public function makeHandShake(Request $request)
    {
        $state = $request->get('state') ?: null;
        $code = $request->get('code') ?: "";

        if (isset($state) && $code != "") {
            $this->validate_state($state);

            $postdata = [
              'code'       => $code,
              'app_id'     => $this->appid,
              'app_secret' => $this->appsecret,
              'method'     => 'POST'
            ];

            // get oauth code for the handshake
            $response = $this->makeRequest("https://clef.io/api/v1/authorize", $postdata);

            if ($response) {
                $response = json_decode($response, true);
                if (isset($response['success']) && $response['success']) {

                    $url = "https://clef.io/api/v1/info?access_token=" . $response['access_token'];

                    // Get the user behind the Token
                    $response = $this->makeRequest($url);

                    if ($response) {
                        $response = json_decode($response, true);

                        if (isset($response['success'])) {
                            $info = $response['info'];

                            $this->resetUserSession($info);
                            // reset the user's session

                            // Set userinfo data
                            $this->userInfo = $info;

                        }
                    }
                }else{
                    \Log::info('CLEF problem '.json_encode($response));
                }
            }
        }

    }



    /**
     * @return mixed
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    public function logout($logout_token)
    {

        if (isset($logout_token)) {
            $url = "https://clef.io/api/v1/logout";

            $postdata = [
              'logout_token' => $logout_token,
              'app_id'       => $this->appid,
              'app_secret'   => $this->appsecret,
              'method'       => 'POST'
            ];

            $response = $this->makeRequest($url, $postdata);
            $response = json_decode($response, true);

            if ($response['success']) {
                $userservice = Userservice::where('clef', $response['clef_id'])->first();
                $user = $userservice->user;
                $user->logout_at = date('Y-m-d G:i:s');
                $user->save();
            }else {
                echo $response['error'];
            }
        }
    }

    private function generate_state_parameter()
    {
        $state = $this->base64url_encode(openssl_random_pseudo_bytes(32));
        $this->session->set('state', $state);

        return $state;
    }

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }


    private function makeRequest($url, $data=[])
    {

        $method = isset($data['method']) ? $data['method'] : 'GET';

        return json_encode($this->curl->$method($url, $data));

    }

    private function resetUserSession($info)
    {
        if (isset($info['id']) && ($info['id'] != '')) {
            //remove all the variables in the session
            $this->session->flush();
        }
    }

}