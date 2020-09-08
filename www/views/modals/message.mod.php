<div>
    <h2><?= $data["title"]?></h2>
    <p>
    <?php foreach($data["body"] as $sentence):?>
        <?= $sentence?><br/>
        <?php endforeach;?>
    </p>
</div>