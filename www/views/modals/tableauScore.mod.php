<table>
    <tr>
        <th>Round</th>

        <?php $nomMission = array();
        foreach ($data as $value):?>
            <?php $nomMission = array_merge($nomMission,[$value["nomMission"]]);

        endforeach;
        $nomMission = array_unique($nomMission);
        foreach ($nomMission as $nom):?>
             <th><?= $nom?></th>
        <?php endforeach;?>

    </tr>
        <?php
        $points = array();
        $tour = 0;
        $max = 0;

        foreach ($data as $point):
        if(empty($total[$point["idMission"]]))
            $total[$point["idMission"]] = 0;

         $total[$point["idMission"]] += $point["nombrePoint"];
         $points["total{$point["idMission"]}"] = $total[$point["idMission"]]." / ".$point["nombrePointPossiblePartie"];
            if($tour != $point["numeroTour"]):?>
                <tr>
                    <?php if($point["numeroTour"] == 6): ?>
                        <td>Fin partie</td>
                    <?php else: ?>
                        <td><?= $point["numeroTour"]?></td>
                    <?php endif; ?>
            <?php endif;
            $tour = $point["numeroTour"];
            ?>
            <td><?= $point["nombrePoint"]??"0"?></td>
        <?php if($tour != $point["numeroTour"]):?>
        <?php endif;
        ?>

        <?php
        endforeach;?>
                </tr>
    <tr>
        <td>Total</td>
        <?php foreach ($points as $total):?>
            <td><?= $total?></td>
        <?php endforeach;?>
    </tr>
        <tr>
            <td><?= array_sum($points)." / 100"?></td>
        </tr>




</table>