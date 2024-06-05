<!DOCTYPE html>
<html>
<head>
    <title>Registreerimine</title>
    <link rel="stylesheet" type="text/css" href="stiilid/style.css">
</head>
<body>
<div class="register-form">
<div class="ring2">
    <i style="--clr:#00ff0a;"></i>
    <i style="--clr:#ff0057;"></i>
    <i style="--clr:#fffd44;"></i>
    <i style="--clr:#581b98;"></i>
    <i style="--clr:#22d1ee;"></i>
    <div class="container">

            <h2>Registreerimine</h2>
            <form action="register_handler.php" method="post">
                <div class="inputBx">
                    <label for="firstName" style="user-select: none">Eesnimi</label>
                </div>
                <div class="inputBx">
                    <input type="text" name="firstName" required>
                </div>
                <div class="inputBx">
                    <label for="lastName" style="user-select: none">Perenimi</label>
                </div>
                <div class="inputBx">
                    <input type="text" id="lastName" name="lastName" required>
                </div>
                <div class="inputBx">
                    <label for="email" style="user-select: none">Email</label>
                </div>
                <div class="inputBx">
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="inputBx">
                    <label for="pass" style="user-select: none">Salasõna:</label>
                </div>
                <div class="inputBx">
                    <input type="password" id="pass" name="pass" required>
                </div>
                <div class="inputBx">
                    <label for="confirmPass" style="user-select: none">Kinnitage salasõna:</label>
                </div>
                <div class="inputBx">
                    <input type="password" id="confirmPass" name="confirmPass" required>
                </div>
                <div class="inputBx">
                    <input type="checkbox" id="showPass" onchange="togglePasswordVisibility()"> Näita salasõna
                </div>
                <div class="inputBx">
                    <input type="submit" value="Registreerimine">
                </div>
            </form>
        </form>
        <form action="login.php" method="post">
            <div class="inputBx">
                <input type="submit" value="Logi sisse">
            </div>
        </form>
        <form action="logout.php" method="post">
            <div class="inputBx">
                <input type="submit" value="Tagasi">
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var passInput = document.getElementById('pass');
        var confirmPassInput = document.getElementById('confirmPass');
        var showPassCheckbox = document.getElementById('showPass');

        passInput.type = showPassCheckbox.checked ? 'text' : 'password';
        confirmPassInput.type = showPassCheckbox.checked ? 'text' : 'password';
    }
</script>
</body>
</html>