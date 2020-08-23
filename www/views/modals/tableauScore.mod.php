<table>
    <tr>
        <th>Round</th>
<!--        <pre>-->
<!--            --><?php //print_r($data)?>
<!--        </pre>-->

        <?php $nomMission = array();
        foreach ($data as $value):?>
            <?php $nomMission = array_merge($nomMission,[$value["nomMission"]]);
            //print_r($nomMission);
            ?>

<!--            <pre>-->
<!--            --><?php //print_r($value)?>
<!--        </pre>-->

        <?php endforeach;
        $nomMission = array_unique($nomMission);
        foreach ($nomMission as $nom):?>
             <th><?= $nom?></th>
        <?php endforeach;
        $tour = 0;

        foreach ($data as $point):
            if($tour != $point["numeroTour"]):?>
                <tr>
                <td><?= $point["numeroTour"]?></td>
            <?php endif;
            $tour = $point["numeroTour"];
            ?>
            <td><?= $point["nombrePoint"]??"0"?></td>
        <?php if($tour != $point["numeroTour"]):?>
            <tr>
        <?php endif;
        ?>





        <?php
        endforeach;?>


    </tr>



</table>