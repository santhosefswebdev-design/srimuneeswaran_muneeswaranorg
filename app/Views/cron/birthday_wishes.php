<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <title>Birthday Card</title>
  <style>
h2{
	font-size: 5rem;
}
body {
	font-size: 3rem;
	line-height: 2.1;
}
.demo-wrap {
  position: relative;
  justify-content: center;
  align-items: center;
}

.demo-bg {
  opacity: 0.2;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: auto;
}

.demo-content {
  position: relative;
}
.god-image{
    height: 250px;
    width: 250px;
}
.footer{
	margin-top: 3rem;
    justify-content: center;
    align-items: center;
}
.clr-blue{
   color:  rgb(26 32 156);
   font-weight: 600;
   font-style: italic;
    
}
.clr-blue-h{
   color:  rgb(26 32 156);
   font-weight: 600;
   
    
}
.clr-double{
    font-weight: 800;
    font-style: italic;
    color: rgba(246,226,87,255);
  -webkit-text-fill-color: rgb(188 22 19); /* Will override color (regardless of order) */
  -webkit-text-stroke: 1px rgba(246,226,87,255);

}
.h-bday{
    font-style: italic;
    font-family: cursive;
    font-weight: 800;
    color: rgb(15 14 14);
  -webkit-text-fill-color: rgb(218 238 7); /* Will override color (regardless of order) */
  -webkit-text-stroke: 1px rgb(15 14 14);
}
#birthday_wishes{
	color: #000;
	background: #fff;
	padding: 5px;
	width: 2280px;
	overflow: hidden;
}
</style>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.1/vconsole.min.js"></script>
</head>
<body>

<div id="birthday_wishes">
<div class="demo-wrap text-center mt-3">
    <img class="demo-bg" src="<?= base_url(); ?>/assets/images/bgtemple.jpeg" >
  <div class="demo-content row">
    <div class="col">
        <P class="clr-blue">உ</P>
        <p class="clr-blue">ஓம் சக்தி
        </p>
        <div>
            <h2 style="color: rgb(214 46 10);; font-weight: 800 font-style: italic">அருள்மிகு இராஜமாரியம்மன் தேவஸ்தானம் </h2>
      <h2 class="clr-blue-h" >ARULMIGU RAJAMARIAMMAN DEVASTHANAM</h2>
      
      <p class="clr-blue">Johor Bahru Since 1911</p>
      </div>
      <div>
     <p class="clr-blue" style="margin-right:45rem ;"></p>
     <h2 class="clr-double">இனிய பிறந்தநாள் நல்வாழ்த்துக்கள்</h2>
     <p class="clr-blue">வாழ்க்கையில் சகல செளபாக்கியங்களையும் பெற்று</p>
     <p class="clr-blue">நீண்ட ஆயுளுடன் வாழ்வாங்கு வாழ,</p>
     <p class="clr-blue">அருள்மிகு இராஜமாரியம்மன் அருள்புரிவாராக!</p>
     </div>
     <div>
        <h2 class="h-bday">Happy Birthday</h2>
        <p class="clr-blue">May the blessings of Arulmigu Rajamariamman be upon you</p>
     </div>
     <div class="row footer">
        <div class="">
        <img class="god-image" src="<?= base_url(); ?>/assets/images/th.png">
        </div>
        <div class="text-center ms-2 clr-blue">
            <p>Wishes From
            <br>President & Management
            <br>Committee</p>
        </div>
     </div>
    </div>
  </div>
</div>
</div>
<img src="" id="test_img" />
<script>
$(document).ready(function(){
	var node = document.getElementById('birthday_wishes');
	domtoimage.toJpeg(node).then(function (dataUrl) {
		$('#test_img').attr('src', dataUrl);
	});
});
</script>
</body>
</html>
