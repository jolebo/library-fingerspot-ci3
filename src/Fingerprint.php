<?php
    	
class Fingerprint
{
	private $host;
	private $port;
	private $sn;
	private $url = [
		"get_users" => "user/all/paging",
		"delete_users"=> "user/delall",
		"delete_user"=>"user/del", 
		"get_allscanlog" => "scanlog/all/paging",
		"get_newscanlog" => "scanlog/new",
		"delete_scanlog" => "scanlog/del",
		"dev_info"=>"dev/info",
		"sync_datetime" => "dev/settime",
		"delete_admin" => "dev/deladmin",
		"clear_data" => "dev/init",
	];
	function __construct()
	{
		$this->host = $_ENV['FP_SERVER_HOST'];
		$this->port = $_ENV['FP_SERVER_PORT'];
		$this->sn = $_ENV['FP_SERIAL_NUMBER'];

	}

	/**
	 * Untuk mengambil info device
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @return object
	 **/

	function getDeviceInfo($data = []){
		$where = [
			"sn" => $this->sn
		];

		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}
		return $this->sendRequest($this->url["dev_info"],$where);
	}

	/**
	 * Untuk mengambil semua data user
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @param int $data["limit"] ingin menampilkan berapa banyak default 100
	 * @return object
	 **/

	function getUsers($data = []){
		$where = [
			"sn" => $this->sn
		];

		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}

		if(isset($data["limit"])){
			$where["limit"] = $data["limit"];
		}
		return $this->sendRequest($this->url["get_users"],$where);
	}

	/**
	 * Untuk menghapus semua data user
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @return bool
	**/
	function deleteUsers($data = []){
		$where = [
			"sn" => $this->sn
		];

		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}
		return $this->sendRequest($this->url["delete_users"],$where);
	}

	/**
	 * Untuk menghapus data user yang dipilih
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @param string $data["pin"] pin dari user yang dipilih
	 * @return bool
	**/
	function deleteUser($data = []){
		$where = [
			"sn" => $this->sn
		];
		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}

		if(isset($data["pin"])){
			$where["pin"] = $data["pin"];
		}
		return $this->sendRequest($this->url["delete_user"],$where);
	}

	/**
	 * Untuk mengambil semua data log scan yang ada
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @param int $data["limit"] ingin menampilkan berapa banyak default 100
	 * @return object
	 **/
	function getAllScanLog($data = []){
		$where = [
			"sn" => $this->sn
		];
		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}

		if(isset($data["limit"])){
			$where["limit"] = $data["limit"];
		}
		return $this->sendRequest($this->url["get_allscanlog"],$where);
	}

	/**
	 * Untuk mengambil semua data log scan yang belum pernah diambil sama sekali
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @param int $data["limit"] ingin menampilkan berapa banyak default 100
	 * @return object
	 **/
	function getNewScanLog($data = []){
		$where = [
			"sn" => $this->sn
		];

		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}
		return $this->sendRequest($this->url["get_newscanlog"],$where);
	}

	/**
	 * Untuk menghapus semua data log scan
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @return bool
	 **/
	function deleteScanLog($data = []){
		$where = [
			"sn" => $this->sn
		];

		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}
		return $this->sendRequest($this->url["delete_scanlog"],$where);
	}

	/**
	 * Untuk menyinkronkan jam di server dengan mesin fingerprint
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @return bool
	 **/
	function syncTime($data = []){
		$where = [
			"sn" => $this->sn
		];
		
		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}
		return $this->sendRequest($this->url["sync_datetime"],$where);
	}

	/**
	 * Untuk menghapus semua data admin di fingerprint
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @return bool
	 **/
	function deleteUserAdmin($data = []){
		$where = [
			"sn" => $this->sn
		];
		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}
		return $this->sendRequest($this->url["delete_admin"],$where);
	}

	/**
	 * Untuk menghapus semua data pada mesin fingerprint
	 * @param string $data["sn"] fingerspot serial number // jika tidak ada akan diambil dari env
	 * @return bool
	 **/
	function clearData($data = []){
		$where = [
			"sn" => $this->sn
		];
		if(isset($data["sn"])){
			$where["sn"] = $data["sn"];
		}
		return $this->sendRequest($this->url["clear_data"],$where);
	}

	function sendRequest($url="",$data = []){

		$where = "";
		if(count($data) > 0){
			foreach($data as $key => $row){
				$where .= "{$key}={$row}&";
			}

			$where = substr($where,0,-1);
		}
		$host = $this->host;
		$host .= $url;
		$curl = curl_init();
	    set_time_limit(0);
	    curl_setopt_array(
	        $curl,
	        array(
	            CURLOPT_PORT => $this->port,
	            CURLOPT_URL => $host,
	            CURLOPT_RETURNTRANSFER => true,
	            CURLOPT_ENCODING => "",
	            CURLOPT_MAXREDIRS => 10,
	            CURLOPT_TIMEOUT => 0,
	            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	            CURLOPT_CUSTOMREQUEST => "POST",
	            CURLOPT_SSL_VERIFYPEER => false,
	            CURLOPT_POSTFIELDS => $where,
	            CURLOPT_HTTPHEADER => array(
	                "cache-control: no-cache",
	                "content-type: application/x-www-form-urlencoded"
	            ),
	        )
	    );
	    $response = curl_exec($curl);
	    // $err = curl_error($curl);
	    curl_close($curl);

	    return json_decode($response, true);
	}

}