<div class="container">
    <h2 class="header">Редактирование адреса</h2>
    <form class="container__form" method="POST">
        <div class="form-group">
            <label  class="container__formlabel" for=""> Название: </label>
            <input class="form-control container__input" type="text" name="address_name" value="<?= $address['address_name']; ?>"> <br>
        </div>
        <input type="submit" class="btn btn-outline-primary btn-lg container__actionbutton" value="Сохранить">
    </form>
</div>
