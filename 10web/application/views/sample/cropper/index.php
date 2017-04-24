<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>WebUploader演示 - 带裁剪功能 </title>
    <link rel="stylesheet" type="text/css" href="/assets/css/webuploader/webuploader.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/webuploader/cropper.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/webuploader/style.css" />
</head>
<body>
    <div id="wrapper">
        <div class="uploader-container">
            <div id="filePicker">选择文件</div>
        </div>

        <!-- Croper container -->
        <div class="cropper-wraper webuploader-element-invisible">
            <div class="img-container">
                <img src="" alt="" />
            </div>

            <div class="upload-btn">上传所选区域</div>

            <div class="img-preview"></div>
        </div>


    </div>
    <script type="text/javascript" src="/assets/js/cropper/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/webuploader/webuploader.js"></script>
    <script type="text/javascript" src="/assets/js/cropper/cropper.js"></script>
    <script type="text/javascript" src="/assets/js/cropper/uploader.js"></script>
</body>
</html>
