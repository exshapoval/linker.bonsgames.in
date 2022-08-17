<?php
include_once 'config.php';
if (count($_POST) > 1) {
    //var_dump($_POST);
    $old = $_POST['oldurl'];
    $new = $_POST['newurl'];

    $sql = "SELECT oldlink FROM links WHERE newlink='$new'";
    $res = $conn->query($sql);

    if ($res->num_rows > 0)
        echo "<script>alert('such url is already present, change new url, pls')</script>";
    else {
        $sql2 = "INSERT INTO links (linkid, oldlink, newlink, created) VALUES (NULL, '$old', '$new', '".date('Y-m-d H:i:s')."')";
        $conn->query($sql2);
    }

    $conn->close();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <div class="off-canvas position-left reveal-for-large" id="my-info" data-off-canvas data-position="left">
                <div class="row column">
                    <ul class="list-group">
                        <li class="list-group-item active">Шортер линков</li>
                        <li class="list-group-item active"><a href="links.php">Список линков</a></li>
                    </ul>
                </div>
            </div>

            <div class="off-canvas-content" data-off-canvas-content>
                <div class="callout primary">
                    <div class="row column">
                        <h1>Страница сокращения ссылок</h1>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="medium-6 columns">
                        <h3>Инструкция:</h3>
                        <ol>
                            <li>Вставьте урл который хотите сократить</li>
                            <li>укажите урл который хотите получить</li>
                            <li>Забирайте результат</li>
                        </ol>
                        <h3>Важно для создаваемого урла указываем:</h3>
                        <ol>
                            <li>латиницу [a-z] </li>
                            <li>Нижний регистр (без больших букв)</li>
                            <li>цифры</li>
                            <li>никаких символов типа $%^&*()#@!/\ в целях безопасности</li>
                        </ol>
                    </div>
                    <div class="medium-6 columns">
                        <form action="index.php" id="banner-form" enctype="multipart/form-data" method="post">
                            <label>Old Url
                                <input type="url" name="oldurl" required placeholder="old url">
                            </label>
                            <label>New Url
                                <input type="text" class="newurl" name="newurl" required placeholder="New url">
                            </label>
                            <input type="submit" class="button expanded"  value="Начать">
                        </form>
                    </div>

                    <script type="application/javascript">
                        function validateLatinText(text) {
                            let latinRegex = /[^a-z0-9]/gi;
                            return latinRegex.test(text);
                        }

                        let submitForm = document.getElementById("banner-form")
                            submitForm.addEventListener("submit", function (e){

                            let newurl=document.querySelector(".newurl")
                            //console.log("validateLatinText(newurl.value)", validateLatinText(newurl.value))

                            if(!validateLatinText(newurl.value)) {
                                e.currentTarget.submit()
                            } else {
                                e.preventDefault();
                                alert("check new url symbols")
                            }
                        })

                    </script>
                </div>
                <div class="row">
                    <div class="code-preview">
                        <code id="code-prev" >
                            <?php
                            if ($_POST["newurl"]) echo "https://bonsgames.in/".$_POST["newurl"];
                            ?>
                        </code>
                    </div>
                    <div class="preview">
                        <div class="bannerHolder_dsz"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>