<div class="container">
    <h2 class="container__header">Редактирование гендера</h2>
    <form class="container__form" method="POST">
        <div class="form-group">
            <label  class="container__formlabel" for=""> Название: </label>
            <input class="form-control container__input" type="text" name="gender_name" value="<?= $gender['gender_name']; ?>">
        </div>
        <div class="form-group">
            <label  class="container__formlabel" for=""> Краткое название: </label>
            <input class="form-control container__input" type="text" name="gender_short_name" value="<?= $gender['gender_short_name']; ?>">
        </div>
        <input type="submit" class="btn btn-outline-primary btn-lg container__actionbutton" value="Сохранить">
    </form>
</div>
