<?php

require '../vendor/autoload.php';

use EuMatheusGomes\Komerci\KomerciClient;
use EuMatheusGomes\Komerci\Method\GetAuthorized;

$komerciClient = new KomerciClient();
$soapClient = new SoapClient($komerciClient->getUrl());

$getAuthorized = new GetAuthorized($komerciClient, $soapClient);
$getAuthorized->setTotal('0.01')
    ->setTransacao(KomerciClient::TRANSACAO_AVISTA)
    ->setParcelas('00')
    ->setNumPedido('00000000')
    ->setNrcartao('1234123412341234')
    ->setCVC2('123')
    ->setMes('01')
    ->setAno('20')
    ->setPortador('Credit Card Owner Name')
    ->setConfTxn('S');

$response = $getAuthorized->call();
$approved = $getAuthorized->approved($response);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Komerci - GetAuthorized</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <br>
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Usage:</h4>
<pre>
$komerciClient = new KomerciClient();
$soapClient = new SoapClient($komerciClient->getUrl());

$getAuthorized = new GetAuthorized($komerciClient, $soapClient);
$getAuthorized->setTotal('0.01')
    ->setTransacao(KomerciClient::TRANSACAO_AVISTA)
    ->setParcelas('00')
    ->setNumPedido('00000000')
    ->setNrcartao('1234123412341234')
    ->setCVC2('123')
    ->setMes('01')
    ->setAno('20')
    ->setPortador('Credit Card Owner Name')
    ->setConfTxn('S');

$response = $getAuthorized->call();
$approved = $getAuthorized->approved($response);
</pre>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Results:</h4>
<pre>
// $response
object(<?= get_class($response) ?>)
{
<?php foreach ($response as $key => $value): ?>
    ["<?= $key ?>"] => "<?= $value ?>"
<?php endforeach ?>
}

// $approved
<?= true ? 'true' : 'false' ?>
</pre>
        </div>
      </div>
    </div>
  </body>
</html>
