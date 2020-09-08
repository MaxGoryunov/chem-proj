<div class="container">
    <h2 class="container__header">Адреса</h2>
    <a href="./add" class="btn btn-outline-primary btn-lg container__addbutton" role="button">Добавить</a>
    <table class="table table-striped">
        <thead class="thead-light">
            <tr>
                <th scope="col"> ID </th>
                <th scope="col"> Название адреса</th>
                <th scope="col" colspan="2"> Действия </th>
            </tr>
        </thead>
        <tbody>
            <? foreach($addressesList as $address): ?>
            <tr>
                <td scope="row"> <?= $address['address_id'] ?> </td>
                <td> <?= $address['address_name'] ?> </td>
                <? if ($is_admin == true): ?>
                <td> <a href="./edit/<?= $address['address_id']; ?>" class="btn btn-outline-info"
                        role="button">Редактировать</a> </td>
                <td><a href="" onclick="delete_item(event)" data-id="<?= $address['address_id']; ?>" class="btn btn-outline-danger"
                    role="button"> Удалить </a></td>
                <? endif; ?>
            </tr>
            <? endforeach; ?>
        </tbody>
</div>