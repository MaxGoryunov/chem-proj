<?php 
    $inputs = [
        [
            "type"  => "text",
            "label" => "Название",
            "name"  => "name"
        ],
        [
            "type"  => "text",
            "label" => "Краткое название",
            "name"  => "short_name"
        ]
    ];
?>
<div class="container">
    <h2 class="container__header">Редактирование <?= $clause; ?></h2>
    <form class="container__form" method="POST">
        <? foreach($inputs as $input): ?>
            <div class="form-group">
                <label class="container__formlabel" for=""> <?= $input["label"] ?>: </label>
                <input class="form-control container__input" type="<?= $input["type"]; ?> name="<?= $input["name"]; ?>" required>
            </div>
        <? endforeach; ?>
        <input type="submit" class="btn btn-outline-primary btn-lg container__action-button" value="Сохранить">
    </form>
</div>
