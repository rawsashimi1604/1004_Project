var checkpw = function () {
    if (document.getElementById('pwd').value === document.getElementById('cfm_pwd').value) {
        document.getElementById('errMsg').style.color = 'green';
        document.getElementById('errMsg').innerHTML = 'Password match';
    } else {
        document.getElementById('errMsg').style.color = 'red';
        document.getElementById('errMsg').innerHTML = 'Password does not match';
    }
};

function checkpassword(password) {
    var strength = 0;
    if (password.match(/[a-z]+/)) {
        strength += 1;
    }
    if (password.match(/[A-Z]+/)) {
        strength += 1;
    }
    if (password.match(/[0-9]+/)) {
        strength += 1;
    }
    if (password.match(/[$@#&!]+/)) {
        strength += 1;
    }

    switch (strength) {
        case 0:
            strengthbar.value = 0;
            break;

        case 1:
            strengthbar.value = 25;
            break;

        case 2:
            strengthbar.value = 50;
            break;

        case 3:
            strengthbar.value = 75;
            break;

        case 4:
            strengthbar.value = 100;
            break;
    }
}

var code = document.getElementById("pwd");
var strengthbar = document.getElementById("meter");
console.log("triggered");
code.addEventListener("keyup", function () {
    checkpassword(code.value);
});