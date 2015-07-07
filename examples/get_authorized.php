<?php

require '../vendor/autoload.php';

use EuMatheusGomes\Komerci\KomerciClient;
use EuMatheusGomes\Komerci\Method\GetAuthorized;

if (isset($_POST) && count($_POST) == 10) {

    $komerciClient = new KomerciClient($_POST['mode'], $_POST['filiacao']);
    $soapClient = new SoapClient($komerciClient->getUrl());

    $parcelas = (int) $_POST['parcelas'] == 1
        ? '00'
        : str_pad((int) $_POST['parcelas'], 2, 0, STR_PAD_LEFT);

    $transacao = $parcelas == '00'
        ? KomerciClient::TRANSACAO_AVISTA
        : KomerciClient::TRANSACAO_PARCELADO_EMISSOR;

    $getAuthorized = new GetAuthorized($komerciClient, $soapClient);
    $getAuthorized->setTotal($_POST['total'])
        ->setTransacao($transacao)
        ->setParcelas($parcelas)
        ->setNumPedido($_POST['num_pedido'])
        ->setNrcartao($_POST['nrcartao'])
        ->setCVC2($_POST['cvc2'])
        ->setMes($_POST['mes'])
        ->setAno($_POST['ano'])
        ->setPortador($_POST['portador'])
        ->setConfTxn('S');

    $response = $getAuthorized->call();
    $approved = $getAuthorized->approved($response);
}

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
      <div class="alert alert-warning" role="alert">
        <strong>Attention:</strong> It only works in production mode (prod) in a server with HTTPS, whose IP
        address is registered in the Komerci's database.
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <form method="post">
            <div class="form-group">
              <label for="mode">Webservice Mode:</label>
              <?php $value = isset($_POST['mode']) ? $_POST['mode'] : '' ?>
              <select name="mode" id="mode" class="form-control">
                <?php foreach (['dev', 'prod'] as $option): ?>
                <option value="<?= $option ?>" <?= $option == $_POST['mode'] ? 'selected' : '' ?>>
                    <?= $option ?>
                </option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="form-group">
              <label for="filiacao">Affiliation number:</label>
              <?php $value = isset($_POST['filiacao']) ? $_POST['filiacao'] : '999999999' ?>
              <input type="text" name="filiacao" id="filiacao" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="total">Transaction value (must be 0.01 in dev mode):</label>
              <?php $value = isset($_POST['total']) ? $_POST['total'] : '0.01' ?>
              <input type="text" name="total" id="total" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="parcelas">Installments:</label>
              <?php $value = isset($_POST['parcelas']) ? $_POST['parcelas'] : '1' ?>
              <input type="text" name="parcelas" id="parcelas" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="num_pedido">Order Number:</label>
              <?php $value = isset($_POST['num_pedido']) ? $_POST['num_pedido'] : '00000000' ?>
              <input type="text" name="num_pedido" id="num_pedido" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="nrcartao">Credit Card Number:</label>
              <?php $value = isset($_POST['nrcartao']) ? $_POST['nrcartao'] : '' ?>
              <input type="text" name="nrcartao" id="nrcartao" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="cvc2">CID/CVV:</label>
              <?php $value = isset($_POST['cvc2']) ? $_POST['cvc2'] : '' ?>
              <input type="text" name="cvc2" id="cvc2" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="mes">CC Expiration Date (Month: mm):</label>
              <?php $value = isset($_POST['mes']) ? $_POST['mes'] : '' ?>
              <input type="text" name="mes" id="mes" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="ano">CC Expiration Date (Year: yy):</label>
              <?php $value = isset($_POST['ano']) ? $_POST['ano'] : '' ?>
              <input type="text" name="ano" id="ano" value="<?= $value ?>" class="form-control">
            </div>

            <div class="form-group">
              <label for="portador">Credit Card Owner Name:</label>
              <?php $value = isset($_POST['portador']) ? $_POST['portador'] : '' ?>
              <input type="text" name="portador" id="portador" value="<?= $value ?>" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>

      <?php if (isset($_POST) && count($_POST) == 10): ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Usage:</h4>
<pre>
$komerciClient = new KomerciClient($_POST['mode'], $_POST['filiacao']);
$soapClient = new SoapClient($komerciClient->getUrl());

$parcelas = (int) $_POST['parcelas'] == 1
    ? '00'
    : str_pad((int) $_POST['parcelas'], 2, 0, STR_PAD_LEFT);

$transacao = $parcelas == '00'
    ? KomerciClient::TRANSACAO_AVISTA
    : KomerciClient::TRANSACAO_PARCELADO_EMISSOR;

$getAuthorized = new GetAuthorized($komerciClient, $soapClient);
$getAuthorized->setTotal($_POST['total'])
    ->setTransacao($transacao)
    ->setParcelas($parcelas)
    ->setNumPedido($_POST['num_pedido'])
    ->setNrcartao($_POST['nrcartao'])
    ->setCVC2($_POST['cvc2'])
    ->setMes($_POST['mes'])
    ->setAno($_POST['ano'])
    ->setPortador($_POST['portador'])
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
<?= $approved ? 'true' : 'false' ?>
</pre>
        </div>
      </div>
      <?php endif ?>

    </div>
  </body>
</html>
