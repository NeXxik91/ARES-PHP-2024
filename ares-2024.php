<?
function callAresApi($ico) {
	$apiUrl = 'https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/' . $ico; // Example URL

	// Initialize cURL session
	$ch = curl_init($apiUrl);

	// Set cURL options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPGET, true);

	// Execute cURL session and get the response
	$response = curl_exec($ch);

	// Check for errors
	if (curl_errno($ch)) {
		echo 'Error: ' . curl_error($ch);
	}

	// Close cURL session
	curl_close($ch);

	// Process the response
	$responseData = json_decode($response, true);

	return $responseData;
}




$ares_ico_fin = "";
$ares_dic_fin = "";
$ares_firma_fin = "";
$ares_ulice_fin = "";
$ares_cp1_fin = "";
$ares_cp2_fin = "";
$ares_mesto_fin = "";
$ares_psc_fin = "";
$ares_stav_fin = "";

$ico=//VASE ICO//;
$result = callAresApi($ico);
$apiResponse=$result;

 // Map the array to your variables
 if (!empty($apiResponse)) {
   $ares_stav_fin=1;  
	if(isset($apiResponse['kod']) and $apiResponse['kod']=="NENALEZENO") {
	  $ares_stav_fin=2;   
	}
	
	if(isset($apiResponse['kod']) and $apiResponse['kod']=="CHYBA_VSTUPU") {
	  $ares_stav_fin=2;   
	}
	
	if(isset($apiResponse['kod']) and $apiResponse['kod']=="NENI_IMPLEMENTOVANO") {
	  $ares_stav_fin=3;   
	}
	
	if(isset($apiResponse['kod']) and $apiResponse['kod']=="NEPRIHLASENY_UZIVATEL") {
	  $ares_stav_fin=3;   
	}
	
	if(isset($apiResponse['kod']) and $apiResponse['kod']=="NENI_OPRAVNENI") {
	  $ares_stav_fin=3;   
	}
	
	 // Extract data and map to variables
	 $ares_ico_fin = $apiResponse['ico'] ?? "";
	 $ares_dic_fin = $apiResponse['dic'] ?? "";
	 $ares_firma_fin = $apiResponse['obchodniJmeno'] ?? "";
	 
	 $ares_ulice_fin = $apiResponse['sidlo']['nazevUlice'] ?? "";
	 $ares_cp1_fin = $apiResponse['sidlo']['cisloDomovni'] ?? "";
	 $ares_cp2_fin = $apiResponse['sidlo']['cisloOrientacni'] ?? "";
	 $ares_mesto_fin = $apiResponse['sidlo']['nazevObce'] ?? "";
	 $ares_psc_fin = $apiResponse['sidlo']['psc'] ?? "";
	 
	 // Assuming 'stav' is based on some condition, for example, if the 'dic' is present
	 $ares_dic_fin = isset($apiResponse['dic']) ? $apiResponse['dic'] : null;
	 if ( $ares_cp2_fin != "" ) {
	   $ares_cp_fin = $ares_cp1_fin . "/" . $ares_cp2_fin;
	 } else {
	   $ares_cp_fin = $ares_cp1_fin;
	 }
 }
 
 // Display the mapped variables
 echo "ICO: $ares_ico_fin\n";
 echo "DIC: $ares_dic_fin\n";
 echo "Firma: $ares_firma_fin\n";
 echo "Ulice: $ares_ulice_fin\n";
 echo "CP: $ares_cp_fin\n";
 echo "Mesto: $ares_mesto_fin\n";
 echo "PSC: $ares_psc_fin\n";
 echo "Stav: $ares_stav_fin\n";
 
 ?>