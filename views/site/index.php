<?php
/* @var $this yii\web\View */

use common\assets\QuaggaAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Agen nKing';

$pendapatanBasis = $thisMonthSale * (20.0 / 100.0);
$pendapatanBonus = $thisMonthSale * ($bonus / 100.0);

$totalPendapatan = $pendapatanBasis + $pendapatanBonus + $bonusAdjustment;
$totalDisetor = $thisMonthSale - $totalPendapatan;
?>

<style>
    table.mytable{
        width: 100%;
        border: 1px solid gray;
        border-collapse: collapse;
    }
    table.mytable th, table.mytable td {
        border: 1px solid gray;
        padding: 4px;
    }
    .form.filter .selection.dropdown {
        min-width: 50px;
    }
</style>
<div class="ui vertical segment" style="padding: 1em;">
    <div class="ui form filter">
        <div class="fields">
            <div class="field" style="width: 40%">
                <label>Agen</label>
                <div class="ui selection dropdown agenCode">
                    <input type="hidden" name="agencode" value="PBR">
                    <i class="dropdown icon"></i>
                    <div class="default text">Agen</div>
                    <div class="menu">
                        <div class="item" data-value="PBR">PBR</div>
                        <div class="item" data-value="MDR">MDR</div>
                        <div class="item" data-value="BKN">BKN</div>
                        <div class="item" data-value="HRD">HRD</div>
                    </div>
                </div>
                <script>$('.dropdown.agenCode').dropdown();</script>
            </div>
            <div class="field" style="width: 30%">
                <label>Tahun</label>
                <div class="ui selection dropdown tahun">
                    <input type="hidden" name="tahun" value="2019">
                    <i class="dropdown icon"></i>
                    <div class="default text">Tahun</div>
                    <div class="menu">
                        <div class="item" data-value="2019">2019</div>
                    </div>
                </div>
                <script>$('.dropdown.tahun').dropdown();</script>
            </div>
            <div class="field" style="width: 30%">
                <label>Bulan</label>
                <div class="ui selection dropdown bulan">
                    <input type="hidden" name="bulan" value="JUN">
                    <i class="dropdown icon"></i>
                    <div class="default text">Bulan</div>
                    <div class="menu">
                        <div class="item" data-value="JAN">Januari</div>
                        <div class="item" data-value="FEB">Febfuari</div>
                        <div class="item" data-value="MAR">Maret</div>
                        <div class="item" data-value="APR">April</div>
                        <div class="item" data-value="MAY">Mei</div>
                        <div class="item" data-value="JUN">Juni</div>
                        <div class="item" data-value="JUL">Juli</div>
                        <div class="item" data-value="AUG">Agustus</div>
                        <div class="item" data-value="SEP">September</div>
                        <div class="item" data-value="OCT">Oktober</div>
                        <div class="item" data-value="NOV">November</div>
                        <div class="item" data-value="DES">Desember</div>
                    </div>
                </div>
                <script>$('.dropdown.bulan').dropdown();</script>
            </div>
        </div>
    </div>
</div>
<div class="ui vertical segment" style="padding: 1em;">
    <div class="ui medium header">PENJUALAN</div>
    <div class="ui two tiny statistics">
        <div class="blue statistic">
            <div class="value">
                <i class="chart line icon"></i> <?= $thisDaySaleCount ?> vcr
            </div>
            <div class="label">
                Hari Ini, Rp. <?= floatToDecimal($thisDaySale) ?>
            </div>
        </div>
        <div class="red statistic">
            <div class="value">
                <i class="calendar alternate outline icon"></i> <?= $thisMonthSaleCount ?> vcr
            </div>
            <div class="label">
                Bulan Ini, Rp. <?= floatToDecimal($thisMonthSale) ?>
            </div>
        </div>
    </div>
</div>
<div class="ui vertical segment" style="padding: 1em;">
    <div class="ui medium header">PENDAPATAN</div>
    <table class="mytable">
        <thead>
            <tr>
                <th colspan="3">Tabel Kalkulasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Penjualan</td>
                <td><?= $thisMonthSaleCount ?> vcr</td>
                <td style="text-align: right;"><?= floatToDecimal($thisMonthSale) ?></td>
            </tr>
            <tr>
                <td>Pendapatan Basis</td>
                <td>20%</td>
                <td style="text-align: right;"><?= floatToDecimal($pendapatanBasis) ?></td>
            </tr>
            <tr>
                <td>Pendapatan Bonus</td>
                <td><?= $bonus ?>%</td> <!-- 8, 10, 15 -->
                <td style="text-align: right;"><?= floatToDecimal($pendapatanBonus) ?></td>
            </tr>
            <tr>
                <td>Bonus Adjustment</td>
                <td></td> <!-- 8, 10, 15 -->
                <td style="text-align: right;"><?= floatToDecimal($bonusAdjustment) ?></td>
            </tr>
            <tr>
                <td>Total Yang Didapat</td>
                <td><?= round((100 / $thisMonthSale) * $totalPendapatan, 2) ?>%</td> <!-- 8, 10, 15 -->
                <td style="text-align: right;"><?= floatToDecimal($totalPendapatan) ?></td>
            </tr>
            <tr>
                <td>Total Yang Disetor</td>
                <td><?= round((100 / $thisMonthSale) * $totalDisetor, 2) ?>%</td> <!-- 8, 10, 15 -->
                <td style="text-align: right;"><?= floatToDecimal($totalDisetor) ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="ui vertical segment" style="padding: 1em;">
    <div class="ui medium header">PENGGUNA AKTIF</div>
    <div class="ui middle aligned divided list">
        <div class="item">
            <div class="right floated content">
                <div class="circular ui red mini icon button"><i class="icon minus"></i></div>
            </div>
            <i class="large middle aligned icon">VC3</i>
            <div class="content">
                <a class="header">skuw1389</a>
                <div class="description">Uptime 01:30</div>
            </div>
        </div>
        <div class="item">
            <div class="right floated content">
                <div class="circular ui red mini icon button"><i class="icon minus"></i></div>
            </div>
            <i class="large middle aligned icon">VC5</i>
            <div class="content">
                <a class="header">abcd1234</a>
                <div class="description">Uptime 01:30</div>
            </div>
        </div>
    </div>
</div>
<div class="ui vertical segment">
    <p></p>
</div>
<div class="ui vertical segment">
    <p></p>
</div>
<script>
    
</script>