<?php
  $cURL = curl_init('http://http://www.meugerente.esy.es/teste');
  curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
  // Seguir qualquer redirecionamento que houver na URL
  //curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
  $resultado = curl_exec($cURL);
  // Pega o código de resposta HTTP
  $resposta = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
  curl_close($cURL);
  if ($resposta == '404') {
    echo 'O site está fora do ar (ERRO 404)!';
  } else {
    echo 'Parece que está tudo bem...';
  }