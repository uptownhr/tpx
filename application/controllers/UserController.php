<?php

// created by some guy on the web, ugly code but atleast it works
// will have to re-factor this from the ground up

class UserController extends My_Controller {

    public function init() {
    	parent::init();
    	$data = $this->params();
    	
    	if( isset($this->data['user_id']) ){
    		$user_id = $this->data['user_id'];
    		
    		if($user_id == $this->user['user_id']){
    			$this->view->me = true;
    			$this->user_id = $this->user['user_id'];
    		}else{
    			$this->view->me = false;
    			$this->user_id = $this->data['user_id'];
    		}
    	}else{
    		$this->view->me = true;
    		$this->user_id = $this->user['user_id'];
    	}
    }

    public function indexAction() {
        
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
    	if( $this->isPost() ){
    		if( $this->params('user_profile_update') == "Save Profile"){
    			$data = $this->params();
    			$data['user_id'] = $this->user['user_id'];
    			$save = Jien::model('User')->save($data);
    			if($save){
    				$this->view->updated = true; // if not-ajax
    				$this->json( array(1, 'updated'));
    			}
    		}
    	}
    	
    	if($this->user_id == ''){
        	$this->view->error = true;
        }else{
        	$User = Jien::model('User')->select("user_id, uid, role_id, username, gender, first_name, last_name, birthday, city, state, zip, country, quote, twitter_name, religion, hair_color, relationship_status, education, outlook, social, meat_lover, panty_choice")->get($this->user_id)->row();
        	$this->view->User = $User;
        	Jien::debug($User);
        }    
			
    	if( file_exists('images/user/' . $this->user_id ) ){
    		$this->view->profile_image_url = '/images/user/' . $this->user_id;
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
    		$this->json(0);
    	}
    }
    
    public function forgotAction(){
    	if( $this->isPost() ){
    		$this->view->post = true;
    		$email = $this->params('email');
    		if( $email != ''  ){
    			$user = Jien::model('User')->where("email = '$email'")->get()->row();
    			if($user){
    				$time = time();
    				$id = Jien::model('ForgotPassword')->save( array(
    					'user_id' => $user['user_id'],
    					'key' => $time
    				));
    				
    				Jien::send_mail( array($email), "<a href='http://udl.local/user/reset?id=$id&key=$time'>Click to Reset</a>");
    			}
    		}
    	}
    }
    
    public function resetAction(){
    	$data = $this->params();
    	if( !empty($data['id']) && !empty($data['key']) ){
    		$id = $data['id'];
    		$key = $data['key'];
    		$check = Jien::model('ForgotPassword')->where("`key`='$key'")->andWhere("id=$id")->get()->row();
    		
    		if($check){
    			$this->view->reset = true;
    			
    			if( $this->isPost() ){
    				if( strlen($data['password']) > 3 ){
    					$user['user_id'] = $check['user_id'];
    					$user['password'] = $data['password'];
    					
    					try{$changed = Jien::model('User')->save($user);}catch(exception $e){ echo $e->getMessage(); }
    					
    					if($changed){
    						Jien::model('ForgotPassword')->delete("user_id = {$check['user_id']}");
    						$this->redir('/user/login');
    					}
    				}
    			}
    		}
    	}
    }
}

