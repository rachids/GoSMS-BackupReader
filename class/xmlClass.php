<?php

class xmlClass{
	private $xmlFile;
	private $msgArray = array(); #Contains array of processed SMSs
	private $oSMS; #Current SMS Object

	public function __construct($file){
		$this->xmlFile = simplexml_load_file($file);
	}

	public function showTime(){
		$this->processMessages();
		return $this->msgArray;
	}

	private function processMessages(){
		foreach($this->xmlFile->SMS as $SMS) {

			$this->oSMS = $SMS;

			$author = (string) $this->oSMS->contactName;

			$this->msgArray[$author][] = array(
					'type'	=>	$this->checkType(),
					'date'	=>	$this->renderDate(),
					'content'	=>	(string) $this->oSMS->body
			);
		}

		return $this->msgArray;
	}

	private function checkType(){
		#If SMS->type == 2, then its a sent SMS, otherwise its a received message.
		#Si le type vaut 2, c'est un SMS envoyé, sinon c'est un texto reçu.
		$who = ($this->oSMS->type == 2) ? 'sent' : 'received';

		return $who;
	}
	private function renderDate(){
		#GoSMS save the date as UNIX Timestamp which is in milliseconds, so we divide it by 1000 to get it to work with Date function.
		#On divise le chiffre par 1 000 car GoSMS enregistre les dates en timestamp UNIX (en millisecondes : 1 sec = 1000 ms)
		$iDate = (string) $this->oSMS->date;
		$iDate /= 1000;

		$sDate = date('l d/m/Y - H:i:s', $iDate);

		return $sDate;
	}
}