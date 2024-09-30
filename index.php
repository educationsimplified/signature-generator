<?php
  // PHP section to download the YouTube video thumbnail
  if(isset($_POST['button']) && !empty($_POST['imgurl'])){
    $imgUrl = filter_var($_POST['imgurl'], FILTER_SANITIZE_URL);
    $ch = curl_init($imgUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $downloadImg = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment;filename="thumbnail.jpg"');
    echo $downloadImg;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouTube Video Downloader | By Uzair Ahmed</title>
  <!-- External CSS -->
  <link rel="stylesheet" href="style.css">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <!-- Main Form Section -->
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <header>YouTube Video Downloader by Uzair Ahmed</header>
    <div class="url-input">
      <span class="title">Paste video URL:</span>
      <div class="field">
        <input type="text" name="urlField" placeholder="https://www.youtube.com/watch?v=lqwdD2ivIbM" required>
        <input class="hidden-input" type="hidden" name="imgurl">
        <span class="bottom-line"></span>
      </div>
    </div>
    <!-- Thumbnail Preview Area -->
    <div class="preview-area">
      <img class="thumbnail" src="" alt="">
      <i class="icon fas fa-cloud-download-alt"></i>
      <span>Paste video URL to see preview</span>
    </div>
    <!-- Download Button -->
    <button class="download-btn" type="submit" name="button">Download Thumbnail</button>
  </form>

  <!-- Footer Section -->
  <footer>
    &copy; Uzair Ahmed 2024 - 
    <a href="https://www.instagram.com/uzairvibes?igsh=MXEwczdtd290aXl0Zw==" target="_blank">Visit my Instagram</a>
  </footer>

  <!-- Script for Handling Video URL -->
  <script>
    const urlField = document.querySelector(".field input"),
    previewArea = document.querySelector(".preview-area"),
    imgTag = previewArea.querySelector(".thumbnail"),
    hiddenInput = document.querySelector(".hidden-input"),
    button = document.querySelector(".download-btn");

    urlField.onkeyup = () => {
      let imgUrl = urlField.value.trim();
      previewArea.classList.add("active");
      button.style.pointerEvents = "auto";
      
      if (imgUrl.includes("https://www.youtube.com/watch?v=")) {
        let vidId = imgUrl.split('v=')[1].substring(0, 11);
        let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
        imgTag.src = ytImgUrl;
      } else if (imgUrl.includes("https://youtu.be/")) {
        let vidId = imgUrl.split('be/')[1].substring(0, 11);
        let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
        imgTag.src = ytImgUrl;
      } else if (imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)) {
        imgTag.src = imgUrl;
      } else {
        imgTag.src = "";
        button.style.pointerEvents = "none";
        previewArea.classList.remove("active");
      }
      hiddenInput.value = imgTag.src;
    }
  </script>
</body>
</html>
