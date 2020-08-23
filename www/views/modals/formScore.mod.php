 <?php foreach ($data["fields"] as $name => $configField):?>
            <?php if (!empty($configField["type"]) && $configField["type"] == "label"):?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-inner">
                                <label for="<?= $configField["for"]??'' ?>">
                                    <?= $configField["text"]??''?>
                                </label>
                            </div>
                        </div>
            <?php elseif (!empty($configField["type"]) && $configField["type"] != "label" && $configField["type"] != "hidden"):?>
                        <div class="col-sm-6">
                            <div class="col-inner">
                                <input
                                value="<?= $configField["value"]??'' ?>"
                                type="<?= $configField["type"]??'' ?>"
                                name="<?= $configField["name"]??'' ?>"
                                placeholder="<?= $configField["placeholder"]??'' ?>"
                                class="<?= $configField["class"]??'' ?>"
                                id="<?= $configField["id"]??'' ?>"
                                <?=(!empty($configField["required"]))?"required='required'":""?> >
                            </div>
                        </div>
                    </div>

            <?php endif;?>
        <?php if (!empty($configField["type"]) && $configField["type"] == "hidden"):?>
        <input
            value="<?= $configField["value"]??'' ?>"
            type="<?= $configField["type"]??'' ?>"
            name="<?= $configField["name"]??'' ?>"
        >
        <?php endif;?>
    <?php endforeach;?>

