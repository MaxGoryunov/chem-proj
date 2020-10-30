<div class="container">
    <h2 class="container__header"><?= $header; ?></h2>
    <a href="./add" class="btn btn-outline-primary btn-lg container__action-button" role="button">Добавить</a>
    <table class="table container__table">
        <thead class="thead-light">
            <tr>
                <? foreach($columns as $column): ?>
                <th scope="col"> <?= $column; ?> </th>
                <? endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <? foreach($recordsList as $record): ?>
            <tr>
                <? foreach ($actions as $action): ?>
                <td <? if ($action == "getId"): ?> scope="row" <? endif; ?>> <?= $record->$action(); ?> </td>
                <? endforeach; ?>
                <td> 
                    <a href="./edit/<?= $record->getId(); ?>" class="btn btn-outline-info" role="button"> Редактировать</a> 
                </td>
                <td>
                    <a href="" onclick="delete_item(event)" data-id="<?= $record->getId(); ?>" class="btn btn-outline-danger" role="button"> Удалить </a>
                </td>
            </tr>
            <?endforeach; ?>
            <tr>
                <td scope="row">1</td>
                <td>Санкт-Петербург</td>
                <td>Изменить</td>
            </tr>
            <tr>
                <td scope="row">2</td>
                <td>Москва</td>
                <td>Изменить</td>
            </tr>
            <tr>
                <td scope="row">3</td>
                <td>Казань</td>
                <td>Изменить</td>
            </tr>
        </tbody>
    </table>
</div>