<?php
// pdgt-esercitazione-heroku

//per gestire corpo richiesta, si legge il contenuto della richiesta
$content = file_get_contents("php://input");

if(!$content) {
	error_log("No input");
	die("Nessun input");
}

$update = json_decode($content, false);//si ottiene oggetto php

error_log("Input: " . print_r($update, true));

$message = $update->message; //update è tutto il blocco, message il pezzo

$message_id = $message->message_id;
$text = $message->text;
$chat_id = $message->chat->id;

			//graffe, dollaro e variabile, variabili php dentro stringa
error_log("Message ID {$message_id} from {$chat_id}: {$text}\n");  //usa php per logare errori di sistema
//il bot invia mess, viene decodificato e scompattato

//$token = "qui si metterebbe il token telegram ma non è sicuro";
//il runtime ci da il codice token, lo otteniamo da fuori, getenv sono variabili che eseguono il nostro codice
$token = getenv("BOTTOKEN");


////////////////////////

//aggiunto da controllare funzionamento
	$ora = date('H:i');
	$giorno = date('d/m/Y');	
$message = "\nBenvenuto!, sono le: $ora, del giorno: $giorno"; 
echo $message; 

///////////////////////////////

$url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text=" . urlencode("$message \nMi hai scritto questo: {$text}");
//stringa convertita per inserire nell'url per essere compattibile



error_log("URL: " . $url);

$handle = curl_init($url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_POST, true);
$response = curl_exec($handle);

error_log("sendMessage: " . $response);
