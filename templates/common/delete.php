<?php 
    $inputs = [
        [
            "type"  => "text",
            "label" => "Название",
            "name"  => "name",
            "value" => "Значение"
        ],
        [
            "type"  => "text",
            "label" => "Краткое название",
            "name"  => "short_name",
            "value" => "Знач"
        ]
    ];
?>
<div class="container">
    <h2 class="container__header">Удаление <?= $clause; ?></h2>
    <form class="container__form" method="POST">
        <? foreach ($inputs as $input): ?>
            <div class="form-group">
                <label class="container__formlabel" for=""> <?= $input["label"]?>: </label>
                <input readonly class="form-control form-control-plaintext container__input" type="<?= $input["type"]?>" name="<?= $input["name"] ?> value="<?= $input["value"] ?>" required>
            </div>
        <? endforeach; ?>
        <input type="submit" class="btn btn-outline-primary btn-lg container__action-button" value="Удалить">
    </form>
</div>