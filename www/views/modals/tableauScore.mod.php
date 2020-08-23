<table>
    <tr>
        <th>Round</th>
        <pre>
            <?php print_r($data)?>
        </pre>
        <?php foreach ($data as $value):?>
            <th><?php $value["nomMission"]?></th>
        <?php endforeach;?>

    </tr>



</table>