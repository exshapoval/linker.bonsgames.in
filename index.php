<?php
ini_set('display_errors', 0);
include_once 'config.php';
if (count($_POST) > 1) {
    //var_dump($_POST);
    $old = $_POST['oldurl'];
    $new = $_POST['newurl'];

    $sql = "SELECT oldlink FROM links WHERE newlink='$new'" . ((isset($_POST['id']) && (int) $_POST['id'] > 0) ? (' AND linkid != ' . $_POST['id']) : '');
    $res = $conn->query($sql);

    if ($res->num_rows > 0)
        echo "<script>alert('such url is already present, change new url, pls')</script>";
    else {
        if (isset($_POST['id']) && (int) $_POST['id'] > 0)
            $sql2 = "UPDATE links SET oldlink = '".$old."', newlink = '".$new."', edited = '".date('Y-m-d H:i:s')."' WHERE linkid = " . $_POST['id'];
        else
            $sql2 = "INSERT INTO links (linkid, oldlink, newlink, created) VALUES (NULL, '$old', '$new', '".date('Y-m-d H:i:s')."')";
        $conn->query($sql2);
    }
}
if (isset($_GET['id']) && (int) $_GET['id'] > 0) {
    $link = "SELECT * FROM links WHERE linkid = " . $_GET['id'];
    $resLink = $conn->query($link)->fetch_object();
}
include_once 'header.php';
?>
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <?php include 'menu.php'; ?>

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
                        <form action="index.php<?=(isset($resLink->linkid) ? ('?id='.$resLink->linkid) : '')?>" id="banner-form" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="id" value="<?=$resLink->linkid?>">
                            <label>Old Url
                                <input type="url" name="oldurl" required placeholder="old url" value="<?=$resLink->oldlink?>">
                            </label>
                            <label>New Url
                                <input type="text" class="newurl" name="newurl" required placeholder="New url" value="<?=$resLink->newlink?>">
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
<?php include 'footer.php';?>