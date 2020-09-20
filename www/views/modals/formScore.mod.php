 <?php foreach ($data["fields"] as $name => $configField):?>
            <?php if (!empty($configField["type"]) && $configField["type"] == "label"):?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-inner col-left">
                                <label for="<?= $configField["for"]??'' ?>">
                                    <?= $configField["text"]??''?>
                                </label>
                            </div>
                        </div>
            <?php elseif (!empty($configField["type"]) && $configField["type"] != "label" && $configField["type"] != "hidden"):?>
                        <div class="col-sm-6">
                            <div class="col-inner col-right">
                                <input
                                        type="<?= $configField["type"]??'' ?>"
                                        name="<?= $configField["name"]??'' ?>"
                                        class="<?= $configField["class"]??'' ?>"
                                        id="<?= $configField["id"]??'' ?>"
                                    <?=(!empty($configField["required"]))?"required='required'":""?>
                                    <?php if($data["config"]["finTour"] != $configField["marquageFinPartie"] && $configField["marquageFinPartie"] != 3):?>
                                        placeholder="Point Bloqué"
                                        disabled="disabled"
                                    <?php else:?>
                                        value="<?= $configField["value"]??'' ?>"
                                        min="0"
                                        max="<?= $configField["nombrePointPossibleTour"]??'' ?>"
                                    <?php endif;?>>

                            </div>
                        </div>
                    </div>
<!--     <pre>-->
<!--         --><?php //print_r($configField);?>
<!--     </pre>-->


            <?php endif;?>
        <?php if (!empty($configField["type"]) && $configField["type"] == "hidden"):?>
        <input
            value="<?= $configField["value"]??'' ?>"
            type="<?= $configField["type"]??'' ?>"
            name="<?= $configField["name"]??'' ?>"
        >
        <?php endif;?>
    <?php endforeach;?>

