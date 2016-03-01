
<?php

//define('_JEXEC', 1) or die;
require 'Requests_library.php';

	class Structure{
		public $home_club;
		public $away_club;
		public $home_club_score;
		public $away_club_score;
		public function __constructor($home, $away, $homeScore, $awayScore){
			$this->home_club = $home;
			$this->away_club = $away;
			$this->home_club_score = $homeScore;
			$this->away_club_score = $awayScore;
		}
	}

	class Program {
		public $request;
		public $program;
		public $parsedArray;

		public function __constructor() {
			$this->request = new getApi();
			$this->program = new Program();
			$this->parsedArray = array();
		}

		public function startPoint($season, $championship, $clubID){
			$this->getData($season, $championship, $clubID);
		}

		private function getData($season, $championship, $clubID) {
			/*club match list request*/
			$recievedData = array();
			$recievedData = (new getApi())->matchList(15, "asc", 0, '2012-02-13', 'current', $season, $championship, 'gclub_club', $clubID, 1);
			$this->parseData($recievedData);
		}
	
		private function parseData($recievedData){
			/*parsing needless data to $parsedArray*/
			$parsedArray = array();
			foreach($recievedData as $data){
				$structure = new Structure($data['home_club']['title'], $data['away_club']['title'], $data['score']['home'], $data['score']['away']);
				$parsedArray[] = $structure;
			}

			$this->printOutList($parsedArray);
		}

		private function printOutList($parsedArray) {
			/*form and print data here*/
			echo "
				<style>
					th{text-align: center;border=\"1px\";}
					td{text-align: center;border=\"1px\";}
					table{box-shadow:inset 0 0 10px rgba(0,0,0,0.9); border: 1px solid black; bgcolor=\"#FBF0DB\" width: 100%;}
				</style>";
		
			echo "<table>";

			foreach($parsedArray as $data){
				echo "
					<tr><th>{$data->home_club}</th><th>{$data->home_club_score}</th><th>:</th><th>{$data->away_club_score}</th><th>{$data->away_club}</th></tr>
					<br>";
			}
			echo "</table>";
		}
	}

	$program = new Program();
	$program->startPoint(0, 0, 0);

?>

