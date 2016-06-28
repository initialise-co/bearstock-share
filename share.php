<?php

	require_once "dropbox-sdk/Dropbox/autoload.php";
	use \Dropbox as dbx;

	class Share {

		private $token  =  '*removed*';
		private $bearstock_token = '*removed*';
		private $client;
		private $path;

		private $app_key = '*removed*';
		private $app_secret = '*removed*';

		public function __construct(){
    		$this->client = new dbx\Client($this->bearstock_token, "PHP-Example/1.0");
    		$this->path = new dbx\Path();
  		}

		function is_shared($file){
			return $this->client->searchFileNames('/BearStock_Shared', $file);
		}

		function is_file($folder, $file){
			$path = '/BearStock_Shared/'.$folder;
			return $this->client->searchFileNames($path, $file);
		}

		function is_path($folder){
			$url = '/BearStock_Shared/'.$folder;
			return $this->path->isValid($url);
		}

		function get_preview($file){
			$path = "/bearstock/".$file;
			return $this->client->getThumbnail($path, 'jpeg', 'l');
		}

		
		function getFolderFiles($folder){
			$url = '/BearStock_Shared/'.$folder;
			return $this->client->getMetadataWithChildren($url);
		}

		function get_file($folder, $file){
			$url = '/BearStock_Shared/'.$folder.'/'.$file;
			return $this->client->getMetadata($url);
		}

		function create_share($path){
			return $this->client->createShareableLink($path);
		}

		function create_download($path){
			return $this->client->createTemporaryDirectLink($path);
		}

		function download($path, $file){
			return $this->client->getFile($path, $file);
		}

		function Oauth_start(){
			$appInfo = dbx\AppInfo::loadFromJsonFile("app.json");
			$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");
			return $webAuth;
		}

		function get_name($path){
			return $this->path->getName($path);
		}

		function formatBytes($size, $precision = 1){
		    $base = log($size) / log(1024);
		    $suffixes = array('', ' kb', ' Mb', ' Gb', ' Tb');   

		    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
		}

	}

?>