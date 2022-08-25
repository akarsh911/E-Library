var loader = document.getElementById("preloader");
window.addEventListener("load", function () { loader.classList.add("inv"); });
document.getElementById("mail").textContent = "'" + localStorage.getItem('email') + "'";

document.getElementById("resend").addEventListener('click', function () {
    document.getElementById("resend").style.cursor = "pointer";



});
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    var refreshId = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            var loader = document.getElementById("preloader");
            window.addEventListener("load", function () { loader.classList.remove("inv"); });
            document.getElementById("resend").classList.remove('disabled');
            display.style.visibility = "hidden";
            document.getElementById("mail2").style.textAlign = "center";
            display.textContent = "";
            clearInterval(refreshId);
            var resp = send_verification_mail();
            if (resp == "1") {
                alert("verification mail send successfully!");
            }
            window.addEventListener("load", function () { loader.classList.add("inv"); });

        }
    }, 1000);

}

window.onload = function () {
    var fiveMinutes = 60 * 2,
        display = document.querySelector('#time');
    startTimer(fiveMinutes, display);

};
