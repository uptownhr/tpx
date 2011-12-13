<?php

// created by some guy on the web, ugly code but atleast it works
// will have to re-factor this from the ground up

class UserController extends My_Controller {

    public function init() {
    	parent::init();
    }

    public function indexAction() {
        // action body
    }

    public function loginAction() {

        // check if a user is already logged
        if ($this->auth->hasIdentity()) {
            $this->flash('It seems you are already logged into the system ');
            $this->redir('/');
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

        // defaults
        $ext = false;

        // do the first query to an authentication provider
        if ($openid_identifier) {

            if ('https://www.twitter.com' == $openid_identifier) {
                $adapter = $this->_getTwitterAdapter();
            } else if ('https://www.facebook.com' == $openid_identifier) {
                $adapter = $this->_getFacebookAdapter();
            }

            // here a user is redirect to the provider for loging
            $result = $this->auth->authenticate($adapter);

            // the following two lines should never be executed unless the redirection faild.
            $this->flash('Redirection failed');
            $this->redir('/');

        } else if ($openid_mode || $code || $oauth_token) {
            // this will be exectued after provider redirected the user back to us

            if ($code) {
                // for facebook
                $adapter = $this->_getFacebookAdapter();
            } else if ($oauth_token) {
                // for twitter
                $adapter = $this->_getTwitterAdapter()->setQueryData($_GET);
            }

            $result = $this->auth->authenticate($adapter);

            if ($result->isValid()) {

                $toStore = array('identity' => $this->auth->getIdentity());

                if ($code) {

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

                } else if ($oauth_token) {

                	// for twitter
                    $identity = $result->getIdentity();
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


                }

                // sets $this->view->user that can be accessed via view
                $this->setUser($user);
				
                $this->auth->getStorage()->write($toStore);
                $this->flash('Successful authentication');
                
                $role = Jien::model('Role')->getByName('member')->get()->row();
                
                if($role['role_id'] > 1 ){
                	$this->redir('/');
                }else{
                	$this->redir('/user/profile');
                }         

            } else {

                $this->flash('Failed authentication');
                $this->redir('/');

            }
        }
    }
	
    public function profileAction(){
    	if($this->_request->getMethod() == "POST"){
    		if( $this->params('user_profile_update') == "Save Profile"){
    			if($this->params('role_id') == 2 || $this->params('role_id') == 3 ){
					try{
						$new_user = array_merge($this->user,$_POST);
						unset($new_user['role']);
						unset($new_user['redir']);
						unset($new_user['user_profile_update']);
						$this->setUser($new_user);
						$this->redir('/');
					}catch(Exception $e){
						$this->redir('/user/profile');
					}
    			}
    		}
    	}
    	
    	$this->view->username = $this->user['username'];
    	$this->view->email = $this->user['email'];    
			
    	if( file_exists('images/user/' . $this->user['user_id']) ){
    		$this->view->profile_image_url = '/images/user/' . $this->user['user_id'];
    	}else{
    		$this->view->profile_image_url = '/images/layout/battle/battle_10.jpg';
    	}
    	
    }
    
    public function logoutAction() {
        $this->auth->clearIdentity();
        $_SESSION = array();
        $this->flash('You were logged out');
        $this->redir('/');
    }
	
    public function completeAction(){
    	if($this->isPost()){
    		$user['user_id'] = $this->user['user_id'];
    		$user['screenname'] = $this->params('screenanme');
    		$user['role_id'] = $this->params('role_id');
    		$user['email'] = $this->params('email');
    		$this->setUser($user);
    	}
    	if($this->user['role'] == 'member'){
			$this->redir('/');
		}else if($this->user['role'] == 'vip member'){
			$this->redir('/user/profile');
		}
    	
    }
    
    /**
     * Get My_Auth_Adapter_Facebook adapter
     *
     * @return My_Auth_Adapter_Facebook
     */
    protected function _getFacebookAdapter() {
        return new My_Auth_Adapter_Facebook(FACEBOOK_APPID, FACEBOOK_SECRET, FACEBOOK_REDIRECTURI, FACEBOOK_SCOPE);
    }

    /**
     * Get My_Auth_Adapter_Oauth_Twitter adapter
     *
     * @return My_Auth_Adapter_Oauth_Twitter
     */
    protected function _getTwitterAdapter() {
        return new My_Auth_Adapter_Oauth_Twitter(array(), TWITTER_APPID, TWITTER_SECRET, TWITTER_REDIRECTURI);
    }

    public function testAction(){
    	$mail = Jien::send_mail( array('uptownhr@gmail.com'), "Testing Subject", "Testing Body");
    	if($mail){
    		$this->json(1);
    	}else{
    		Jien::debug($mail);
    		$this->json(0);
    	}
    }
}

