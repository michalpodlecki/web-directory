<h1>Rejestracja</h1>
<form id="login-form" name="formularz" action="?a=register" method="post">
    <label for="username">Nazwa użytkownika:</label><input id="username" name="username" type="text" autocomplete="off" />
    <label for="password">Hasło:</label><input id="password" name="password" type="password" />
    <label for="repassword">Powtórz hasło:</label><input id="repassword" name="repassword" type="password" />
    <label for="email">Adres email:</label><input id="email" name="email" type="text" />
    <input id="submit" type="submit" value="Rejestruj się" />
</form>
<div>
    <a href="/web-directory/">Powrót</a>
</div>
<script type="text/javascript">
var delay; //= null;
document.getElementById('username').onkeyup = function() {
    if (delay !== undefined) { window.clearTimeout(delay); }
    delay = window.setTimeout(function() {
        var input = document.getElementById('username');
        ajax.ajax('GET', 'ajax.php?username=' + input.value, function() {
            if(ajax.XHR.readyState == 4 && ajax.XHR.status == 200) {
                //console.log(ajax.XHR);
                if (ajax.XHR.responseText === 'error') {
                    input.style.borderColor = 'red';
                    input.style.backgroundColor = 'pink';
                    document.getElementById('submit').disabled = 'disabled';
                }
                else {
                    input.style.borderColor = '';
                    input.style.backgroundColor = '';
                    document.getElementById('submit').disabled = '';
                }
            }
        });
    }, 200);
};
</script>