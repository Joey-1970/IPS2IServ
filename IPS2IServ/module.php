<?
// Klassendefinition
class IPS2IServ extends IPSModule 
{
	// Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
		$this->RegisterPropertyBoolean("Open", false);
		
	
	}
 	
	public function GetConfigurationForm() 
	{ 
		$arrayStatus = array(); 
		$arrayStatus[] = array("code" => 101, "icon" => "inactive", "caption" => "Instanz wird erstellt"); 
		$arrayStatus[] = array("code" => 102, "icon" => "active", "caption" => "Instanz ist aktiv");
		$arrayStatus[] = array("code" => 104, "icon" => "inactive", "caption" => "Instanz ist inaktiv");
		$arrayStatus[] = array("code" => 202, "icon" => "error", "caption" => "Kommunikationsfehler!");
				
		$arrayElements = array(); 		
		$arrayElements[] = array("name" => "Open", "type" => "CheckBox",  "caption" => "Aktiv");
		$arrayElements[] = array("type" => "Label", "caption" => "_____________________________________________________________________________________________________");
            	
		
 		$arrayActions = array(); 
		$arrayActions[] = array("type" => "Label", "label" => "Test Center"); 
		$arrayActions[] = array("type" => "TestCenter", "name" => "TestCenter");
		
 		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements, "actions" => $arrayActions)); 	
 	}       
	   
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() 
        {
            	// Diese Zeile nicht löschen
            	parent::ApplyChanges();
		
		
		
		
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SetStatus(102);
		}
		else {
			$this->SetStatus(104);
			
		}	
	}       
	
	
	
	// Beginn der Funktionen
	private function Connect()
	{
		set_include_path(__DIR__.'/../libs');
		require_once (__DIR__ . '/../libs/OpenIDConnectClient.php');
		
		//require "vendor/autoload.php";

		//use Jumbojett\OpenIDConnectClient;

		$server = 'https://mein-iserv.de';
		$clientID = 'client id aus der Verwaltung';
		$clientSecret = 'client secret aus der Verwaltung';

		$oidc = new OpenIDConnectClient($server, $clientID, $clientSecret);
		$oidc->addScope('openid');
		$oidc->addScope('profile');
		$oidc->addScope('email');

		$oidc->authenticate();

		$name = $oidc->requestUserInfo('name');
		$email = $oidc->requestUserInfo('email');
		$info = $oidc->requestUserInfo(); // more info, such as groups according to OAuth scopes

		printf("Hallo %s (%s)", $name, $email);
	}
	
	
}
?>
