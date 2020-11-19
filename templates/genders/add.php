<div class="container">
    <h2 class="container__header">Добавление гендера</h2>
    <form class="container__form" method="POST">
        <div class="form-group">
            <label class="container__formlabel" for=""> Название: </label>
            <input class="form-control container__input" type="text" name="gender_name" required>
        </div>
        <div class="form-group">
            <label class="container__formlabel" for=""> Краткое название: </label>
            <input class="form-control container__input" type="text" name="gender_short_name" required>
        </div>
        <input type="submit" class="btn btn-outline-primary btn-lg container__actionbutton" value="Добавить">
    </form>
</div>