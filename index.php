<?php
$payload = trim(file_get_contents("https://discord.com/invite/YfXspgWdDA"));
$payload = preg_replace('/:\s*(\-?\d+(\.\d+)?([e|E][\-|\+]\d+)?)/', ': "$1"', $payload);

$webhook = json_decode($payload);

$invoked = $webhook->invoked;
$secret = "AiC2+0UZTn49H3d+1tWmi33MaPhK3OcLLXqqFJweaKw="; // SIGNATURE

$signature = hash('sha256',  $invoked.":".$secret);

if(strcmp($signature, $webhook->signature) == 0) {
        http_response_code(200);
	echo "OK";	
	*
		Send Killmessage to Discord
	*
	if($webhook->event == "player_kill") {
		$messageContent = ':skull: **' . $webhook->payload->names->murderer . '**' . ' killed ' . '**' . $webhook->payload->names->victim . '**' . ' with ' . '**' . $webhook->payload->weapon . '**' . ' (' . round($webhook->payload->distance, 2) . 'm)';
		postToDiscord($messageContent);
	}
        return "OK";
} else {
        echo "BAD";
        return "BAD";
}

function postToDiscord($message)
{
    $json_data = json_encode(["content" => $message, "username" => "kill_feed"]); //CHANGE NAME OF BOT
	$ch = curl_init("https://discord.com/api/webhooks/814092301265141790/omrthANi1iWH5d2ONZ922Bu4Z8y73-mvfg9ZGcWjoHbCuf3Cfb-i_qvuMxxJVE95vQNo"); //DISCORD URL
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	echo curl_exec( $ch );
	curl_close( $ch );
}
?>
