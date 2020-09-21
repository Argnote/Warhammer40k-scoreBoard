<?php

$inputData = $GLOBALS["_".strtoupper($data["config"]["method"])];

?>

<form method="<?= $data["config"]["method"]?>"
action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>"
class="<?= $data["config"]["class"]?>">
    <div class="row">
<?php foreach ($data["fields"] as $name => $configField):?>
            <?php if(!empty($configField["label"])):?>
            <div class="<?= $configField["classGrill"]??'' ?>">
                <div class="col-inner  col-left">
                    <label for="<?= $configField["id"]??'' ?>">
                        <?= $configField["label"] ?>
                    </label>
                </div>
            </div>
            <?php endif;?>
            <div class="<?= $configField["classGrill"]??'' ?>">
                <div class="col-inner col-right">
                    <?php if(!empty($configField["type"]) && $configField["type"] != "select"):?>
                        <?php if($configField["type"] == "textarea"):?>
                    <textarea
                        <?php else:?>
                    <input
                        <?php endif;?>
                        value="<?= $configField["value"]??'' ?>"
                        <?php if($configField["type"] == "number"):?>
                        min="<?= $configField["min"]??'' ?>"
                        max="<?= $configField["max"]??'' ?>"
                        <?php endif;?>
                        value="<?= $configField["value"]??'' ?>"
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
                        <?php endif;?>

                        <?php if($configField["type"] == "textarea"):?>
                            rows="<?= $configField["rows"]??'' ?>"
                            cols="<?= $configField["cols"]??'' ?>"
                            ><?= $configField["value"]??'Non renseigné' ?></textarea>
                        <?php else:?>
                        >
                        <?php endif;?>
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

      <?php endforeach;?>
    </div>


  <button class="btn btn-primary buttonDisabled"><?= $data["config"]["submit"];?></button>
</form>
