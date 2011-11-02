<?php

class UserController extends My_Controller {

    /**
     * Application keys from appkeys.ini
     *
     * @var Zend_Config
     */
    protected $_keys;

    public function init() {
    	parent::init();
        $this->_keys = Zend_Registry::get('keys');
    }

    public function indexAction() {
        // action body
    }

    public function loginAction() {

        // check if a user is already logged
        if ($this->auth->hasIdentity()) {
            $this->flash('It seems you are already logged into the system ');
            return $this->redir('/');
        }

        // if the user is not logged, the do the logging
        // $openid_identifier will be set when users 'clicks' on the account provider
        $openid_identifier = $this->getRequest()->getParam('openid_identifier', null);

        // $openid_mode will be set after first query to the openid provider
        $openid_mode = $this->getRequest()->getParam('openid_mode', null);

        // this one will be set by facebook connect
        $code = $this->getRequest()->getParam('code', null);

        // while this one will be set by twitter
        $oauth_token = $this->getRequest()->getParam('oauth_token', null);


        // do the first query to an authentication provider
        if ($openid_identifier) {

            if ('https://www.twitter.com' == $openid_identifier) {
                $adapter = $this->_getTwitterAdapter();
            } else if ('https://www.facebook.com' == $openid_identifier) {
                $adapter = $this->_getFacebookAdapter();
            } else {
                // for openid
                $adapter = $this->_getOpenIdAdapter($openid_identifier);

                // specify what to grab from the provider and what extension to use
                // for this purpose
                $toFetch = $this->_keys->openid->tofetch->toArray();

                // for google and yahoo use AtributeExchange Extension
                if ('https://www.google.com/accounts/o8/id' == $openid_identifier || 'http://me.yahoo.com/' == $openid_identifier) {
                    $ext = $this->_getOpenIdExt('ax', $toFetch);
                } else {
                    $ext = $this->_getOpenIdExt('sreg', $toFetch);
                }

                $adapter->setExtensions($ext);
            }

            // here a user is redirect to the provider for loging
            $result = $this->auth->authenticate($adapter);

            // the following two lines should never be executed unless the redirection faild.
            $this->flash('Redirection failed');
            return $this->redir('/');

        } else if ($openid_mode || $code || $oauth_token) {
            // this will be exectued after provider redirected the user back to us

            if ($code) {
                // for facebook
                $adapter = $this->_getFacebookAdapter();
            } else if ($oauth_token) {
                // for twitter
                $adapter = $this->_getTwitterAdapter()->setQueryData($_GET);
            } else {
                // for openid
                $adapter = $this->_getOpenIdAdapter(null);

                // specify what to grab from the provider and what extension to use
                // for this purpose
                $ext = null;

                $toFetch = $this->_keys->openid->tofetch->toArray();

                // for google and yahoo use AtributeExchange Extension
                if (isset($_GET['openid_ns_ext1']) || isset($_GET['openid_ns_ax'])) {
                    $ext = $this->_getOpenIdExt('ax', $toFetch);
                } else if (isset($_GET['openid_ns_sreg'])) {
                    $ext = $this->_getOpenIdExt('sreg', $toFetch);
                }

                if ($ext) {
                    $ext->parseResponse($_GET);
                    $adapter->setExtensions($ext);
                }
            }

            $result = $this->auth->authenticate($adapter);

            if ($result->isValid()) {
                $toStore = array('identity' => $this->auth->getIdentity());

                if ($ext) {
                    // for openId
                    $toStore['properties'] = $ext->getProperties();
                } else if ($code) {
                    // for facebook
                    $msgs = $result->getMessages();
                    $toStore['properties'] = (array) $msgs['user'];

                    // save it to our db if new, else update
                    $user = array(
                    	"uid"	=>	$msgs['user']->id,
                    	"email"	=>	$msgs['user']->email,
                    	"username"	=>	$msgs['user']->username,
                    	"gender"	=>	$msgs['user']->gender,
                    	"first_name"	=>	$msgs['user']->first_name,
                    	"last_name"	=>	$msgs['user']->last_name,
                    	"provider_id"	=>	2,
                    	"country"	=>	$msgs['user']->locale,
                    );
					$condi = "provider_id = {$user['provider_id']} AND uid = '{$user['uid']}'";
                    $data = Jien::model("User")->where($condi)->get()->row();
                    if(!$data){
                    	$user_id = Jien::model("User")->save($user);
                    }else{
                    	$user['accessed'] = new Zend_Db_Expr('NOW()');
                    	$user_id = Jien::model("User")->update($user, $condi);
                    }


                } else if ($oauth_token) {
                    // for twitter
                    $identity = $result->getIdentity();
                    // get user info
                    $twitterUserData = (array) $adapter->verifyCredentials();
                    $toStore = array('identity' => $identity['user_id']);
                    if (isset($twitterUserData['status'])) {
                        $twitterUserData['status'] = (array) $twitterUserData['status'];
                    }
                    $toStore['properties'] = $twitterUserData;


                    // save it to our db if new, else update
                    $name = explode(" ", $twitterUserData['name']);
                    $user = array(
                    	"uid"	=>	$twitterUserData['id'],
                    	//"email"	=>	$msgs['user']->email,
                    	"username"	=>	$twitterUserData['screen_name'],
                    	//"gender"	=>	$msgs['user']->gender,
                    	"first_name"	=>	$name[0],
                    	"last_name"	=>	$name[count($name)-1],
                    	"provider_id"	=>	3,
                    	"country"	=>	$twitterUserData['lang'],
                    );
					$condi = "provider_id = {$user['provider_id']} AND uid = '{$user['uid']}'";
                    $data = Jien::model("User")->where($condi)->get()->row();
                    if(!$data){
                    	$user_id = Jien::model("User")->save($user);
                    }else{
                    	$user['accessed'] = new Zend_Db_Expr('NOW()');
                    	$user_id = Jien::model("User")->update($user, $condi);
                    }

                }

                $this->auth->getStorage()->write($toStore);




                $this->flash('Successful authentication');
                return $this->redir('/');
            } else {
                $this->flash('Failed authentication');
                $this->flash($result->getMessages());
                return $this->redir('/');
            }
        }
    }

    public function logoutAction() {
        $this->auth->clearIdentity();
        $this->flash('You were logged out');
        return $this->redir('/');
    }

    /**
     * Get My_Auth_Adapter_Facebook adapter
     *
     * @return My_Auth_Adapter_Facebook
     */
    protected function _getFacebookAdapter() {
        extract($this->_keys->facebook->toArray());
        return new My_Auth_Adapter_Facebook($appid, $secret, $redirecturi, $scope);
    }

    /**
     * Get My_Auth_Adapter_Oauth_Twitter adapter
     *
     * @return My_Auth_Adapter_Oauth_Twitter
     */
    protected function _getTwitterAdapter() {
        extract($this->_keys->twitter->toArray());
        return new My_Auth_Adapter_Oauth_Twitter(array(), $appid, $secret, $redirecturi);
    }

    /**
     * Get Zend_Auth_Adapter_OpenId adapter
     *
     * @param string $openid_identifier
     * @return Zend_Auth_Adapter_OpenId
     */
    protected function _getOpenIdAdapter($openid_identifier = null) {
        $adapter = new Zend_Auth_Adapter_OpenId($openid_identifier);
        $dir = APPLICATION_PATH . '/../tmp';

        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                throw new Zend_Exception("Cannot create $dir to store tmp auth data.");
            }
        }
        $adapter->setStorage(new Zend_OpenId_Consumer_Storage_File($dir));

        return $adapter;
    }

    /**
     * Get Zend_OpenId_Extension. Sreg or Ax.
     *
     * @param string $extType Possible values: 'sreg' or 'ax'
     * @param array $propertiesToRequest
     * @return Zend_OpenId_Extension|null
     */
    protected function _getOpenIdExt($extType, array $propertiesToRequest) {

        $ext = null;

        if ('ax' == $extType) {
            $ext = new My_OpenId_Extension_AttributeExchange($propertiesToRequest);
        } elseif ('sreg' == $extType) {
            $ext = new Zend_OpenId_Extension_Sreg($propertiesToRequest);
        }

        return $ext;
    }

}

