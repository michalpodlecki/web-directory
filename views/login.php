<h1>Logowanie</h1>
<div id="message" style="border: 1px solid red; background: lightpink; padding: 20px; font: 12px Tahoma; color: darkred; display: none"></div>
<form id="login-form" action="index.php?a=login" method="post">
    <label for="username">Nazwa użytkownika:</label><input id="username" name="username" type="text" autocomplete="off" />
    <label for="password">Hasło:</label><input id="password" name="password" type="password"  />
    <input id="login-form-submit" type="submit" value="Zaloguj się" disabled="disabled" />
</form>
<div>
    <a href="?a=register">Zarejestruj się</a>
</div>
<script type="text/javascript" src="js/login.js"></script>