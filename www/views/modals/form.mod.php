<?php

$inputData = $GLOBALS["_".strtoupper($data["config"]["method"])];

?>

<form method="<?= $data["config"]["method"]?>"
action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>"
class="<?= $data["config"]["class"]?>">

<?php foreach ($data["fields"] as $name => $configField):?>
    <div class="row">
            <?php if(!empty($configField["label"])):?>
            <div class="col-sm-6">
                <div class="col-inner  col-left">
                    <label for="<?= $configField["id"]??'' ?>">
                        <?= $configField["label"] ?>
                    </label>
                </div>
            </div>
            <?php endif;?>
            <div class="col-sm-6">
                <div class="col-inner col-right">
                    <?php if(!empty($configField["type"]) && $configField["type"] != "select"):?>
                    <input
                        value="<?= (isset($inputData[$name]) && $configField["type"]!="password")?$inputData[$name]:'' ?>"
                        type="<?= $configField["type"]??'' ?>"
                        name="<?= $name??'' ?>"
                        placeholder="<?= $configField["placeholder"]??'' ?>"
                        class="<?= $configField["class"]??'' ?>"
                        id="<?= $configField["id"]??'' ?>"
                        <?php
                        $required ="";
                        if (isset($configField["required"]) && $configField["required"] == true):
                            $required = "*"?>
                            required="required"
                        <?php endif;?> >
                    <?= $required ?>
                <?php elseif (!empty($configField["type"]) && $configField["type"] == "select"):
                    $this->addModal("select",$configField["config"], $configField["value"]);
                endif;?>
                </div>
              <?php if($configField["type"] == "captcha"): ?>
                <div class="col-inner col-right">
                  <img id="captcha" src="script/captcha.php" width="300px">
                </div>
              <?php endif;?>
            </div>
      </div>
      <?php endforeach;?>



  <button class="btn btn-primary buttonDisabled"><?= $data["config"]["submit"];?></button>
</form>
