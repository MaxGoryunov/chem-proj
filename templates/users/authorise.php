<div class="container">
	<h3 class="container__header">Авторизация</h3>
	<form class="container__form" method="POST">
        <div class="form-group">
            <label for="" class="container__formlabel"> Email: </label>
            <input class="form-control container__input" type="email" name="user_email">
        </div>
        <div class="form-group">
            <label for="" class="container__formlabel"> Пароль: </label>
            <input class="form-control container__input" type="password" name="user_password">
        </div>
        <input type="submit" class="btn btn-outline-primary btn-lg container__actionbutton" value="Войти в систему">
        <p class="container__registration-redirect"> Нет учетной записи? <a href='../users/registration' class="btn btn-link" role="button">Регистрация</a></p>
	</form>
</div>