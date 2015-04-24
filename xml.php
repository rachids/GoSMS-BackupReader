<?php
date_default_timezone_set('America/Montreal');
?>
<html>
	<head>
		<title>goSMS Backup Reader</title>
		<meta charset="utf8">
		<style>
			body{
				background-color: #796144;
			}

			#xml{
				width:75%;
				margin:auto;
			}

			div{
				border: 1px solid #000000;
			    border-radius: 25px 25px 25px 25px;
			    margin-top: 5px;
			    padding: 5px;
			    width: 50%;
			}
			.her{
				background-color:#E2B439;
			}

			.me{
				background-color: #328EA3;
				margin-left:50%;
			}

			.infos{
				text-align: right;
				font-size:x-small;
				font-style: italic;
			}
		</style>
	</head>
	<body>
<section id="xml">
<?php

	$file = 'c:/backup/sms.xml'; #Path to backup file

	$xml = simplexml_load_file($file);

	foreach($xml->SMS as $SMS) {
		#GoSMS save the date as UNIX Timestamp which is in milliseconds, so we divide it by 1000 to get it to work with Date function.
		#On divise le chiffre par 1 000 car GoSMS enregistre les dates en timestamp UNIX (en millisecondes : 1 sec = 1000 ms)
		$date = (string) $SMS->date;
		$date /= 1000;

		#If SMS->type == 2, then its a sent SMS, otherwise its a received text message.
		#Si le type vaut 2, c'est un SMS envoyé, sinon c'est un texto reçu.
		$who = ($SMS->type == 2) ? 'me' : 'her';

		#Show time !
		echo '<div class="'.$who.'">';
		echo '<p>'.$SMS->body.'</p>';
		echo '<p class="infos">'.date('l d/m/Y - H:i:s', $date).'</p>';
		echo '</div>';
		
	}
?>
</section>
	</body>
</html>