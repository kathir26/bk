<?php
        $host = "http://103.238.229.36/magento_lat/index.php/api/soap/?wsdl";
        $client = new SoapClient($host);
        $apiuser= "kathir";
        $apikey = "test@123";
        $action = "tabapi.listapi";
        try { 
			$sess_id	= $client->login($apiuser, $apikey);
			print_r($client->call($sess_id, $action));
        }
        catch (Exception $e) {
            echo "==> Error: ".$e->getMessage();
            exit();
        }
?>