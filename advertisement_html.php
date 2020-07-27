<?php

include_once("./includes/config.inc.php");

if (!UserLogin::IsLogin()) {
    header("Location:login.php");
    exit ();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>廣告圖上傳</title>

    <link rel="stylesheet" href="css/advertisement_photo.css">
    <script type="text/javascript" src="js/jquery2.0.js"></script>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="box">
    <form enctype="multipart/form-data">
        <table>
            <tr>
                <th></th>
                <th>
                    <select class="sel">
                        <option value="第一張">第一張</option>
                        <option value="第二張">第二張</option>
                        <option value="第三張">第三張</option>
                    </select>
                </th>
                <th>要求比率</th>
                <th>是否必須上傳</th>
                <th>現使用圖片</th>
                <th>縮略圖</th>
                <th>文件名</th>
                <th>分辨率</th>
                <th>是否合格</th>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_1" onchange="setThumbnail(this)" accept="image/jpeg,image/png,image/gif"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>640*960 (2:3)</td>
                <td>是</td>
                <td><img src="" class="former-img" alt="暂无缩略图"></td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_2" onchange="setThumbnail(this)" accept="image/jpeg,image/png,image/gif"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1440*2560 (9:16)</td>
                <td>是</td>
                <td><img src="" class="former-img" alt="暂无缩略图"></td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)" accept="image/jpeg,image/png,image/gif"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1080*2160 (1:2)</td>
                <td>是</td>
                <td><img src="" class="former-img" alt="暂无缩略图"></td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)" accept="image/jpeg,image/png,image/gif"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1240*2728 (5:11)</td>
                <td>是</td>
                <td><img src="" class="former-img" alt="暂无缩略图"></td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)" accept="image/jpeg,image/png,image/gif"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1080*1800 (3:5)</td>
                <td>否</td>
                <td><img src="" class="former-img" alt="暂无缩略图"></td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)" accept="image/jpeg,image/png,image/gif"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>2040*1080 (17:9)</td>
                <td>否</td>
                <td><img src="" class="former-img" alt="暂无缩略图"></td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
        </table>
        <div class="box">
            <div class="progress my-3">
                <span>進度條</span>
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="0">0%</div>
            </div>
            <div class="text-center">
                <span>上傳需要點時間哦，請勿重複點擊或者刷新頁面</span>
            </div>
            <button type="button" onclick="fileUpload()">上传</button>
            <button type="button" onclick="resetHTML()">重置</button>
        </div>
    </form>
</div>
<script src="js/advertisement_photo.js"></script>
</body>
</html>

