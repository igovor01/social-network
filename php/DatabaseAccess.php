<?php
function getDbAccess(){
    return new DatabaseAccess("GovorusicI", "GovorusicI", "GovorusicI_2022");
}

//async funkcije - asinkrono (sikrono se odma izvrsi) koristi se kad se treba nesto cekat, slat cemo zahtjev na nas server, slat ce se query u bazu i moramo cekat da vidimo je li uspjelo, koji je rezultat
//keyword async i await, await se koristi ispred naredbi/necega sta bi tribalo trajat

class DatabaseAccess {
	private $_username;
	private $_password;
	private $_db;
	private $_connection;

	//ova funkcija ispod sluzi kao konstruktor
	public function DatabaseAccess($db, $username, $password){
		$this->_db = $db;
		$this->_username = $username;
		$this->_password = $password;
	}


	//funkcija koja izvrsava nas sql query koji cemo mi napisat i koji ce se izvrsavat
	public function executeQuery($query){
		// open a connection
		$mysqli = new mysqli("localhost", $this->_username, $this->_password, $this->_db);

		if ($mysqli) {
			$mysqli->query('SET character_set_results=utf8');
			$mysqli->query('SET character_set_client=utf8');
			$mysqli->query('SET names utf8');

			// varijable uvik imaju $ isprid sebe, i objektu se pristupa strelicom a ne tockom
			// execute the passed in query
			$queryResponse = $mysqli->query($query);

			// check if error occured
			if(!$queryResponse){
				$message  = 'Invalid query: ' . $mysqli->error . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}

			$resultItems = array();

			// some queries like delete return a bool that represents if the query was successful or not
			// skip the loop if response is boolean
		   	while(!is_bool($queryResponse) && $item = $queryResponse->fetch_row()){
		   		$resultItems[] = $item;
		   	}

			return  $resultItems;
		}
		else {
			die("Connection could not be established");
		}
	}

	public function executeInsertQuery($query){

		$mysqli = new mysqli("localhost", $this->_username, $this->_password, $this->_db);

		if($mysqli){
			$mysqli->query('SET character_set_results=utf8');
			$mysqli->query('SET character_set_client=utf8');
			$mysqli->query('SET names utf8');

			$queryResponse = $mysqli->query($query);

			if(!$queryResponse){
				$message  = 'Invalid query: ' . $mysqli->error . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}

			return $mysqli->insert_id;
		}
		else {
			die("Connection to DB could not be established");
		}
	}
}
