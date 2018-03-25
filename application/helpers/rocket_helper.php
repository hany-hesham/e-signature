<?php

    include(APPPATH . 'third_party/RocketChat/autoload.php');

    class rocket_helper{
    	
		function onclick($message){
			$client = new RocketChat\Client($this->config->item('send_url'));
			$token = $client->api('user')->login($this->config->item('user_access'),$this->config->item('pass_access'));
			$client->setToken($token);
			$channel_result = $client->api('channel')->sendMessage($this->config->item('page_to_send'),$message);
		}

	}

?>