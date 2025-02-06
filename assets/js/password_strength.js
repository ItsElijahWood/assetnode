$(document).ready(function () {
    $('.password-strength').css({
        "font-family": "Public Sans", 
        "font-size": "18px",
        "color": "white",
        "font-weight": "600"
    });
    $('#password').on('input', function () {
        const password = $('#password').val(); 
        const strength = checkPasswordStrength(password);
        $('#password-strength').text(strength); 
    });

    function checkPasswordStrength(password) {
        let strength = '🔴 Weak';
        const lengthCriteria = /.{8,}/;  // Minimum 8 characters
        const upperCaseCriteria = /[A-Z]/;  // At least one uppercase letter
        const numberCriteria = /[0-9]/;  // At least one number
        const specialCharCriteria = /[!@#$%^&*(),.?":{}|<>]/;  // Special characters

        if (lengthCriteria.test(password) && upperCaseCriteria.test(password) && numberCriteria.test(password) && specialCharCriteria.test(password)) {
            strength = '🟢 Strong';
        } else if (lengthCriteria.test(password) && (upperCaseCriteria.test(password) || numberCriteria.test(password))) {
            strength = '🟠 Medium';
        }

        return strength;
    }
});
