<?php 
$data_hora = explode(' ',$banca["data_realizacao"]);
$timestamp = strtotime($data_hora[0]);
 
// Creating new date format from that timestamp
$data_defesa = date("d/m/Y", $timestamp);
?>
<p><?= $content ?></p>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
  </style>
</head>
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td align="center" style="padding:40px 0 30px 0;background:#70bbd9;">
              <img src="../web/resources/img/instituto_de_computacao.png" alt="" width="300" style="height:auto;display:block;" />
            </td>
          </tr>
          <tr>
            <td style="padding:36px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td style="padding:0 0 36px 0;color:#153643;">
                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;"><?= $banca["titulo_trabalho"] ?></h1>
                    <h3 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Palavras chave:</h3>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><?= $banca["palavras_chave"] ?></p>
                    <h3 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Resumo:</h3>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><?= $banca["resumo"] ?></p>
                  </td>
                </tr>
                <tr>
                  <td style="padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                    	  <h3 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Aluno Responsável:</h3>
                          <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="../web/resources/img/aluno.png" alt="" width="150" style="height:150;display:block;" /></p>
                          <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><?= $banca["autor"] ?></p>
                        </td>
                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                    	  <h3 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Data, hora e local:</h3>
                          <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="../web/resources/img/relogio.gif" alt="" width="260" style="height:auto;display:block;" /></p>
                          <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Data e hora: <?= $data_defesa ?>, <?= $data_hora[1]?></p>
                          <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Local: <?= $banca['tipo_banca'] == "remoto" ? "Virtual - " : ""?><?= $banca["local"] ?></p>
                        </td>
                      </tr>
                      <tr>
                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                    	  <h3 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Orientador:</h3>
                          <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="../web/resources/img/orientador.png" alt="" width="150" style="height:200;display:block;" /></p>
                          <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><?= $orientador ?></p>
                        </td>
                        <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>
                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                    	  <h3 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Banca avaliadora:</h3>
                          <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="../web/resources/img/banca.jpg" alt="" width="230" height="150" style="display:block;" /></p>
                          <?php foreach($avaliadores as $avaliador):?>
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><?php echo $avaliador; ?></p>
                          <?php endforeach; ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="max-width:540px;padding:0;vertical-align:top;color:#153643; text-align:center;" colspan="3">
                          <div>
	                    	  <h3 style="font-size:24px;margin:16px 0 20px 0;font-family:Arial,sans-serif;">Adicionar ao google agenda:</h3>
	                          <p style="font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img style="margin-left:auto; margin-right:auto;" src="../web/resources/img/google_agenda.png" alt="" width="300" style="height:auto;display:block;" /></p>
	                          <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><a href="http://www.example.com">google agenda link</a></p>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>