<?php
/**
 * Panada Twitter Library
 *
 * @author Azhari Harahap <azhari@harahap.us>
 * @link http://github.com/back2arie/PanadaTwitter
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
namespace Libraries;
use Resources, twitterAsync;
use twitterAsync\EpiTwitterException as EpiTwitterException;

class Twitter {
	
	private $panadaConfig;
	private $connection;
	private $consumerKey;
	private $consumerSecret;
	private $oauthToken;
	private $oauthSecret;
	
	public function __construct($consumerKey = NULL, $consumerSecret = NULL, $oauthToken = NULL, $oauthSecret = NULL){
		
		$this->panadaConfig = Resources\Config::main();
		include_once $this->panadaConfig['vendor']['path'].'/twitterAsync/EpiCurl.php';
		include_once $this->panadaConfig['vendor']['path'].'/twitterAsync/EpiOAuth.php';
		include_once $this->panadaConfig['vendor']['path'].'/twitterAsync/EpiTwitter.php';
		$this->consumerKey = $consumerKey;
		$this->consumerSecret = $consumerSecret;
		$this->oauthToken = $oauthToken;
		$this->oauthSecret = $oauthSecret;
		
		try{
			$this->connection = new twitterAsync\EpiTwitter($this->consumerKey, $this->consumerSecret, $this->oauthToken, $this->oauthSecret);
		}
		catch (EpiTwitterException $e){
			return $e->getMessage();
		}
		catch (Exception $e){
			return $e->getMessage();
		}
	}
	
	public function connect(){
		
		if ($this->oauthToken === NULL && $this->oauthSecret === NULL && !isset($_GET['oauth_token'])){
			$url = $this->connection->getAuthorizationUrl();
			header('Location: '.$url);
		}
		elseif ($this->oauthToken === NULL && $this->oauthSecret === NULL && isset($_GET['oauth_token'])){
			$access_token = $_GET['oauth_token'];
			$this->connection->setToken($access_token);
			$info = $this->connection->getAccessToken();
			
			if (is_object($info)){
				$response = array(
								'access_token' => $info->oauth_token,
								'access_token_secret' => $info->oauth_token_secret
							);
				$this->connection->setToken($response['access_token'], $response['access_token_secret']);
				return $response;
			}
		}
		else{
			// Nothing to do
			// ...
		}
	}
	
	public function callback($callback = NULL){
		
		$this->connection->setCallback($callback);
	}
	
	public function get($resource = NULL, $params = NULL){
		
		try{
			$res = $this->connection->get($resource, $params);
			$res = $res->response;
		}
		catch (EpiTwitterException $e){
			$res = $e->getMessage();
		}
		catch (Exception $e){
			$res = $e->getMessage();
		}
		return $res;
	}
	
	public function post($resource = NULL, $params = NULL){
		
		try{
			$res = $this->connection->post($resource, $params);
			$res = $res->response;
		}
		catch (EpiTwitterException $e){
			$res = $e->getMessage();
		}
		catch (Exception $e){
			$res = $e->getMessage();
		}
		return $res;
	}
	
	public function __call($name, $params = NULL){
		
		try{
			$res = $this->connection->$name($params);
			$res = $res->response;
		}
		catch (EpiTwitterException $e){
			$res = $e->getMessage();
		}
		catch (Exception $e){
			$res = $e->getMessage();
		}
		return $res;
	}
}
