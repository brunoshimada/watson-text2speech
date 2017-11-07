<?php

/**
 * [Função que envia uma string para a API de voz do Watson que responde como um arquivp de áudio]
 * @param String $input  Texto a ser decodado
 * @param string $output Nome do arquivo de saída
 */
function TextToVoice($input, $output)
{
	$curl = curl_init();

	/**
	 * Configs
	 * @outputExtension Formato de saída
	 * @languageVoice 	Idioma de saída 
	 * @url 			URL do serviço
	 */
	$outputExtension = "audio/ogg;codec=opus";
	$languageVoice = "pt-BR_IsabelaVoice";
	// $languageVoice = "en-US_LisaVoice";
	$l_input = urlencode($input);
	$url = "https://watson-api-explorer.mybluemix.net/text-to-speech/api/v1/synthesize?accept=$outputExtension&voice=$languageVoice&text=$l_input";

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
		)
	));

	$info = curl_getinfo($curl);
	print_r($info);

	$response = curl_exec($curl);

	print_r("reponse here\n");
	$resp = curl_getinfo($curl);
    print_r ($resp);

	if (curl_error($curl)) {
		print_r("Error ".curl_error($curl)."\n");
	} else {
		curl_close($curl);
	}

	$outputFile = fopen("$output.ogg", "w") or die("Unable to open file!");
	fwrite($outputFile, $response);
	fclose($outputFile);
}
