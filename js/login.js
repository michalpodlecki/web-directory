var elements = {};
elements.username = d.getElementById('username');
elements.password = d.getElementById('password');
elements.message = d.getElementById('message');
var makeDisplayed = function () {
    if (elements.message.style.display === 'none') {
        elements.message.style['display'] = 'block';
    }
};

d.getElementById('login-form-submit').onclick = function () {
    if (elements.username.value.length < 1) {
        var txt = d.createTextNode('Nazwa użytkownika nie może być pusta!');
        makeDisplayed();
        elements.message.appendChild(txt);
    }
    if (elements.password.value.length < 1) {
        var txt = d.createTextNode('Hasło nie może być puste!');
        makeDisplayed();
        elements.message.appendChild(txt);
    }
};

elements.username.onblur = function () {
    if (this.value.length < 1) {
        this.style.borderColor = 'red';
        this.style.backgroundColor = 'pink';
    }
    else {
        this.style.borderColor = '';
        this.style.backgroundColor = '';
    }
};

elements.password.onblur = function () {
    if (this.value.length < 1) {
        this.style.borderColor = 'red';
        this.style.backgroundColor = 'lightpink';
    }
    else {
        this.style.borderColor = '';
        this.style.backgroundColor = '';
    }
};

setInterval(function () {
    if (elements.username.value.length > 0 && elements.password.value.length > 0) {
        //d.getElementById('login-form-submit').style.backgroundColor = '';
        d.getElementById('login-form-submit').disabled = '';
    }
}, 200);