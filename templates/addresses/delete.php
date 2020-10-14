<div class="container">
    <h2 class="container__header">Удаление адреса</h2>
    <form class="container__form" method="POST">
        <div class="form-group">
            <label class="container__formlabel" for=""> Название: </label>
            <input readonly class="form-control form-control-plaintext container__input" type="text" name="address_name" value="<?= $address['address_name']; ?>" required><br>
        </div>
        <input type="submit" class="btn btn-outline-primary btn-lg container__actionbutton" value="Удалить">
    </form>
</div>