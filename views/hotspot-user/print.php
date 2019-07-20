<?php

use yii\web\View;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this View */

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Voucher-<?= $hotspotName . "-" . $profile . "-" . $id; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="icon" href="../img/favicon.png" />
        
        <style>
            body {
              color: #000000;
              background-color: #FFFFFF;
              font-size: 14px;
              font-family:  'Helvetica', arial, sans-serif;
              margin: 0px;
              -webkit-print-color-adjust: exact;
            }
            table.voucher {
              display: inline-block;
              border: 2px solid black;
              margin: 2px;
            }
            @page
            {
              size: auto;
              margin-left: 7mm;
              margin-right: 3mm;
              margin-top: 9mm;
              margin-bottom: 3mm;
            }
            @media print
            {
              table { page-break-after:auto }
              tr    { page-break-inside:avoid; page-break-after:auto }
              td    { page-break-inside:avoid; page-break-after:auto }
              thead { display:table-header-group }
              tfoot { display:table-footer-group }
            }
            #num {
              float:right;
              display:inline-block;
            }
            .qrc {
              width:30px;
              height:30px;
              margin-top:1px;
            }
        </style>
    </head>
    <body onload="window.print()">
        <?php
        $num = 1;
        FOREACH ($users as $user)
        {
            $qrSize = "80x80";
            $qrUrl = urlencode("http://$dnsName/login?username=$user->userName&password=$user->password");
            $qrCode = 'https://chart.googleapis.com/chart?cht=qr&chs=' . $qrSize . '&chld=L|0&chl=' . $qrUrl . '&choe=utf-8';
            
            echo $this->renderPhpFile(Yii::getAlias("@app/web/templates/$template/index.php"), [
                'path' => Yii::getAlias("@web/templates/$template"),
                'userMode' => 'vc',
                'userName' => $user->userName,
                'password' => $user->password,
                'comment' => $user->comment,
                'profileId' => $user->profileId,
                'profileName' => $user->profileName,
                'profileAlias' => $user->profileAlias,
                'price' => $user->price,
                'uptime' => $user->uptime,
                'qrCode' => $qrCode,
                'num' => $num++,
            ]);
        } ?>
    </body>
</html>