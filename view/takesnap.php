<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Camagru : time to shine !!</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['id_user'])) {
        header('Location: /Tempest/index.php');
        exit(0);
    }
    ?>

    <p>Prends ta photo !!</p>
    <div class="video-wrap">
        <video id="video" playsinline autoplay></video>
    </div>

    <form method="post" action="" onsubmit="prepareImg();">
        <input type="radio" id="huey" name="drone" value="huey" onclick="enableButton();">
        <label for="huey">Huey</label>
        <input type="radio" id="dewey" name="drone" value="dewey" onclick="enableButton();">
        <label for="dewey">Dewey</label>
        <input id="inp_img" name="img" type="hidden" value="">
        <input id="bt_upload" type="submit" value="Upload" disabled>
    </form>

    <script>
        function enableButton() {
            var selectelem = document.getElementById('huey');
            var btnelem = document.getElementById('bt_upload');
            btnelem.disabled = false;
        }
    </script>

    <canvas id="canvas" width="600" height="400"></canvas>


    <script>
        'use strict';
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const errorMsgElement = document.getElementById('span#ErrorMsg');

        const constraints = {
            audio: false,
            video: {
                width: 600,
                height: 400
            }
        };
        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            } catch (e) {
                errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
            }
        }

        function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
        }
        init();

        var context = canvas.getContext('2d');
        canvas.style.display = "none";

        function prepareImg() {
            context.drawImage(video, 0, 0, 640, 480);
            //video.style = "display:none";

            document.getElementById('inp_img').value = canvas.toDataURL();
        }
    </script>

    <?php
    if (count($_POST) && (strpos($_POST['img'], 'data:image/png;base64') === 0)) {

        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file_path = 'uploads/camagru/';

        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        $file = $file_path . uniqid() . '.png';

        if (file_put_contents($file, $data)) {
            echo "<p>The canvas was saved as $file.</p>";
        } else {
            echo "<p>The canvas could not be saved.</p>";
        }
        require('../model/model.php');
        $db = dbConnect();
        $req = $db->prepare('INSERT INTO images(`image`, author, `date`) VALUES(?, ?, NOW())');
        $req->execute(array($file, $_SESSION['id_user']));
        $req->closeCursor();
    }
    ?>
</body>

</html>