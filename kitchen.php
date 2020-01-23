<?php
// Вывод таблицы заказа на кухню
?>

    <span style="text-align: center;line-height: 50px; font-size: 20pt;">Заказ для кухни на <?=$Order[1]["DateRsrv"]->format("d.m.Y H-i")?></span> </br>
    <span style="font-size: 18pt;">Количество гостей - <?=$Order[1]["Seats"];?></span>

    <table cellspacing="0" width="800px" style="padding: 5px;">
        <tr>
            <td class="td1" style="border-left: solid 1px;">№</td>
            <td class="td1">Наименование</td>
            <td class="td1">Выход,г</td>
            <td class="td1">Кол-во</td>
            <td class="td1">Ед</td>
            <td class="td1">Итого вес</td>
            <td class="td1">Сумма з/п</td>

        </tr>
       <?php
        $zp_total=0;
        for ($i=1;$i<=count($Order_item);$i++) {

           
            if ($Order_item[$i]["Status"]<>3 and $Order_item[$i]["Type"]==3) {
                echo '  <tr>
                        <td class="tab2" style="border-left: solid 1px">' . $i . '</td>
                        <td class="tab2" style="text-align:left;">' . $Order_item[$i]["Name"] . '</td>
                        <td class="tab2">' . $Order_item[$i]["Output"] . '</td>
                        <td class="tab2" style="text-align: right; padding-left: 15px;">' . number_format($Order_item[$i]["Count"],1,"."," ") . '</td>
                        <td class="tab2">' . $Order_item[$i]["Unit"] . '</td>

                        <td class="tab2"  style="text-align: right;">' . number_format((float)$Order_item[$i]["Count"] * (float)$Order_item[$i]["Output"], 0, ".", " ") . ' </td>
                        <td class="tab2"  style="text-align: right;">' . number_format((float)$Order_item[$i]["TotalSum"]*0.1,2,"."," ") . ' </td>

                    </tr>';
                $zp_total=$zp_total+(float)$Order_item[$i]["TotalSum"]*0.1;
            }
        }
        ?>
    </table>
    Фонд заработной платы по заказу - <?=number_format((float)$zp_total,2,"."," ")?> руб. (Включая НДФЛ и РК)