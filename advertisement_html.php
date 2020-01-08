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
    <script src="https://cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/advertisement_photo.css">
</head>
<body>
<div class="box">
    <form enctype="multipart/form-data">
        <table>
            <tr>
                <th></th>
                <th>
                    <select class="sel">
                        <option>第一張</option>
                        <option>第二張</option>
                        <option>第三張</option>
                    </select>
                </th>
                <th>要求比率</th>
                <th>是否必填</th>
                <th>縮略圖</th>
                <th>文件名</th>
                <th>分辨率</th>
                <th>是否合格</th>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_1" onchange="setThumbnail(this)"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>640*960 (2:3)</td>
                <td>是</td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_2" onchange="setThumbnail(this)"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1440*2560 (9:16)</td>
                <td>是</td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1080*2160 (1:2)</td>
                <td>是</td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1242*2688 (5:11)</td>
                <td>是</td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>1080*1776 (3:5)</td>
                <td>否</td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
            <tr>
                <td>
                    <img class='img' src="images/advertisementPhoto.png">
                    <input type="file" class="file-input" name="img_3" onchange="setThumbnail(this)"/>
                    <p>點擊選取圖片</p>
                </td>
                <td>第一張</td>
                <td>2040*1080 (17:9)</td>
                <td>否</td>
                <td><img src="" class="thumbnail"></td>
                <td></td>
                <td></td>
                <td class="ev"></td>
            </tr>
        </table>
        <div class="box">
            <button type="button" onclick="fileUpload()">上传</button>
            <button type="button">重置</button>
        </div>
    </form>
</div>
<script src="js/advertisement_photo.js"></script>
</body>
</html>

