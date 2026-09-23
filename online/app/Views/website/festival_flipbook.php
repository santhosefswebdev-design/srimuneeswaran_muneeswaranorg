<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>ARULMIGU RAJAMARIAMMAN DEVASTHANAM JOHOR BAHRU SINCE 1911</title>
		<meta http-equiv = "X-UA-Compatible" content = "IE=edge" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="icon" href="<?php echo base_url(); ?>/assets/website/img/logo_2.png" type="image/png" sizes="16x16">
		<meta property="og:image" content="<?php echo base_url(); ?>/assets/website/img/logo_2.png">

		<meta name="description" content="">
		<meta name="keywords" content="">

		<meta name="robots" content="all">
	</head>
	<body>
		<style type="text/css">

			.fbToolBar .bottomBarTitle .button
			{
				display: none!important;
			}
			.flip_button_left
			{
				display: none!important;
			}
			.flip_button_right
			{
				display: none!important;
			}
			.flip_button_first
			{
				display: none!important;
			}
			.flip_button_last
			{
				display: none!important;
			}
		</style>
		<link rel='stylesheet' href='<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/template/Neat/style/phoneTemplate.css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/template/Neat/style/style.css' />
		<script src="<?php echo base_url(); ?>/assets/website/flipbook/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/js/LoadingJS.js"></script>
		<script src='<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/template/Neat/javascript/main.js'></script>
		<!--script src="files/search/book_config.js"></script-->
		<script type="text/javascript">
		var textForPages = [];
		var positionForPages = [];
		</script>
		<link rel='stylesheet' href='<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/template/Neat/style/template.css' />
		<script type="text/javascript">

			var sendvisitinfo = function(type,page){};
			$(document).ready(function(){
				var visit_info = document.createElement("script");
					visit_info.src = "<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/js/visitinfo.js";
					$("body").append(visit_info);
			});
		</script>
		<?php 
		$img_count = explode(',', trim($festivals['multi_images'], ','));
		$count = "";
		foreach($img_count as $rowimg_count)
		{
			$count = count($img_count);
		}
		?>
		<script>
			var bookConfig= {
			"OpenWindow": "Blank", "FlipStyle":"Flip", "language":"English", "FullscreenButtonIcon":"", "visibleAreaTop":"0%", "borderColor":"#572F0D", "adSenseLeft":50, "pageBackgroundColor":"#FFFFFF", "haveAdSense":"No", "maxWidthToSmallMode":"320", "DownloadButtonVisible":"Hide", "AutoPlayButtonVisible":"Hide", "QRCode":"Hide", "autoPlayAutoStart":"Hide", "RightShadowAlpha":0.6, "ThumbnailsButtonVisible":"Hide", "loadingCaption":"Loading", "toolbarColor":"#111111", "BackgroundSoundButtonVisible":"Hide", "adSenseHeight":200, "leastSearchChar":3, "pageHeight":1116, "Html5Template":"Neat", "CompanyLogoFile":"files\/logo.png", "coverTexture":"none", "AboutAddress":"GuangZhou,GuangDong,China", "largePageWidth":792, "PrintButtonVisible":"Show", "SearchButtonVisible":"Hide", "SlideshowButtonIcon":"", "HomeButtonVisible":"Hide", "AboutAuthor":"", "leftMarginOnMobile":0, "visibleAreaLeft":"0%", "ZoomOutButtonIcon":"", "rightMargin":10, "rightMarginOnMobile":0, "logoHeight":40, "ZoomInButtonIcon":"", "printWatermarkFile":"", "bgMRotation":90, "backgroundScene":"None", "bottomMarginOnMobile":0, "BackgroundSoundLoop":-1, "showLinkHint":"No", "OriginPageIndex":1, "ShareButtonIcon":"", "AnnotationButtonIcon":"", "BackgroundSoundButtonOnIcon":"", "SearchButtonIcon":"", "cornerRound":8, "BookMarkButtonVisible":"Hide", "QRPath":"files\/extfile\/QRURL.png", "largePageHeight":1116, "SlideshowButtonVisible":"Hide", "PrintButtonIcon":"", "macBookVersion":" ", "helpWidth":"400", "bottomMargin":10, "appLogoOpenWindow":"Blank", "LeftShadowAlpha":1, "VideoButtonVisible":"Hide", "AutoPlayStartButtonIcon":"Hide", "backgroundOpacity":100, "ShareButtonVisible":"Show", "autoPlayDuration":3, "logoTop":8, "adSenseWidth":200, "thumbPath":"files\/thumb\/", "BindingType":"side", "pageNumColor":"#111111", "HelpButtonVisible":"Hide", "RightShadowWidth":40, "appLogoIcon":"files\/extfile\/appLogoIcon.png", "CurlingPageCorner":"Yes", "RightToLeft":"No", "TableOfContentButtonVisible":"Hide", "logoPadding":10, "DownloadURL":"", "BackgroundSoundURL":"", "showHelpContentAtFirst":"No", "FullscreenButtonVisible":"Show", "AboutEmail":"test@gmail.com", "LeftShadowWidth":100, "outerCoverBorder":"Yes", "visibleAreaBottom":"100%", "maxHeightToSmallMode":"300", "topMargin":10, "adSenseTop":50, "flipshortcutbutton":"Show", "AutoPlayStopButtonIcon":"Hide", "helpContentFileURL":"", "autoDoublePage":"Yes", "TableOfContentButtonIcon":"", "HardPageEnable":"No", "AboutButtonIcon":"", "retainBookCenter":"Yes", "ThumbnailButtonIcon":"", "topMarginOnMobile":0, "mouseWheelFlip":"Yes", "helpHeight":450, "normalPath":"files\/large\/", "minZoomHeight":518, "searchKeywordFontColor":"#FFB000", "loadingCaptionColor":"#DDDDDD", "AnnotationButtonVisible":"Hide", "BackgroundSoundButtonOffIcon":"", "loadingBackground":"#323232", "bgBeginColor":"#1F2232", "hardCoverBorderWidth":8, "pageWidth":792, "largePath":"files\/large\/", "iconFontColor":"#EEEEEE", "autoPlayLoopCount":1, "AboutDescription":"Flip", "backGroundImgURL":"files\/extfile\/backGroundImgURL.jpg", "aboutButtonVisible":"Hide", "visibleAreaRight":"100%", "loadingPicture":"", "FlipSound":"Yes", "HomeButtonIcon":"", "bgEndColor":"#1F2232", "AboutWebsite":"", "flippingTime":0.6, "HelpButtonIcon":"", "formBackgroundColor":"#111111", "thumbnailAlpha":100, "totalPageCount":<?php echo $count; ?>, "DownloadButtonIcon":"", "ZoomButtonVisible":"Show", "iconColor":"#EEEEEE", "AboutMobile":"", "BookmarkButtonIcon":"", "updateURLForPage":"Yes", "VideoButtonIcon":"", "leftMargin":10, "ExitFullscreenButtonIcon":"", "minZoomWidth":403, "formFontColor":"#EEEEEE", "UIBaseURL":"https:\/\/rajamariamman.grasp.com.my\/online\/assets\/website\/flipbook\/static.fliphtml5.com\/book\/template\/Neat\/", "searchTextJS":"", "searchPositionJS":""
		}

		;
		var fliphtml5_pages=[ 
		<?php 
		$img = explode(',', trim($festivals['multi_images'], ','));
		foreach($img as $rowimg)
		{
		?>
		{
			"l": "<?php echo base_url(); ?>/uploads/flipbook/<?php echo $rowimg; ?>"
		},
		<?php 
		}
		?>

		];
		var language=[ {
			"language": "English", "btnFirstPage":"First", "btnNextPage":"Next", "btnLastPage":"Last", "btnPrePage":"Previous", "btnGoToHome":"Home", "btnDownload":"Download", "btnSoundOn":"Sound On", "btnSoundOff":"Sound Off", "btnPrint":"Print", "btnThumb":"Thumbnails", "btnBookMark":"Bookmark", "frmBookMark":"Bookmark", "btnZoomIn":"Zoom In", "btnZoomOut":"Zoom Out", "btnAutoFlip":"Auto Flip", "btnStopAutoFlip":"Stop Auto Flip", "btnSocialShare":"Share", "btnHelp":"Help", "btnAbout":"About", "btnSearch":"Search", "btnFullscreen":"Fullscreen", "btnExitFullscreen":"Exit Fullscreen", "btnMore":"More", "frmPrintCaption":"Print", "frmPrintall":"Print All Pages", "frmPrintcurrent":"Print Current Page", "frmPrintRange":"Print Range", "frmPrintexample":"Example: 2,3,5-10", "frmPrintbtn":"Print", "frmShareCaption":"Share", "frmShareLabel":"Share", "frmShareInfo":"You can easily share this publication to social networks.Just click the appropriate button below", "frminsertLabel":"Insert to Site", "frminsertInfo":"Use the code below to embed this publication to your website.", "frmaboutcaption":"Contact", "frmaboutcontactinformation":"Contact Information", "frmaboutADDRESS":"Address", "frmaboutEMAIL":"Email", "frmaboutWEBSITE":"Website", "frmaboutMOBILE":"Mobile", "frmaboutAUTHOR":"Author", "frmaboutDESCRIPTION":"Description", "frmSearch":"Search", "frmToc":"Table Of Contents", "btnTableOfContent":"Table Of Contents", "btnNote":"Annotation", "lblLast":"This is the last page.", "lblFirst":"This is the first page.", "lblFullscreen":"Click to view in fullscreen", "lblName":"Name", "lblPassword":"Password", "lblLogin":"Login", "lblCancel":"Cancel", "lblNoName":"User name can not be empty.", "lblNoPassword":"Password can not be empty.", "lblNoCorrectLogin":"Please enter the correct user name and password.", "btnVideo":"Video Gallery", "btnSlideShow":"Slideshow", "pnlSearchInputInvalid":"The search text is too short.", "btnDragToMove":"Move by mouse drag", "btnPositionToMove":"Move by mouse position", "lblHelp1":"Drag the page corner to view", "lblHelp2":"Double click to zoom in, out", "lblCopy":"Copy", "lblAddToPage":"Add To Page", "lblPage":"Page", "lblTitle":"Title", "lblEdit":"Edit", "lblDelete":"Delete", "lblRemoveAll":"Remove All", "tltCursor":"Cursor", "tltAddHighlight":"Add highlight", "tltAddTexts":"Add texts", "tltAddShapes":"Add shapes", "tltAddNotes":"Add notes", "tltAddImageFile":"Add image file", "tltAddSignature":"Add signature", "tltAddLine":"Add line", "tltAddArrow":"Add arrow", "tltAddRect":"Add rect", "tltAddEllipse":"Add ellipse", "lblDoubleClickToZoomIn":"Double click to zoom in.", "lblPages":"Pages", "infCopyToClipboard":"Your browser dose not support clipboard, please do it yourself.", "lblDescription":"Title", "frmLinkLabel":"Link", "infNotSupportHtml5":"Your browser does not support HTML5.", "frmHowToUse":"How To Use", "lblHelpPage1":"Move your finger to flip the book page.", "lblHelpPage2":"Zoom in by using gesture or double click on the page.", "lblHelpPage3":"Click to view the table of content, bookmarks and share your books via social networks.", "lblHelpPage4":"Add bookmarks, use search function and auto flip the book.", "lblHelpPage5":"Open the thumbnails to overview all book pages.", "frmQrcodeCaption":"Scan the bottom two-dimensional code to view with mobile phone.", "btnPageBack":"Backward", "btnPageForward":"Forward", "btnLanguage":"Change Language", "msgConfigMissing":"Configuration file is missing, unable to open the book."
		}

		];
		;
			var pageEditor=[];
			var ols=[];
			var slideshow=[];
			var videoList=[];
			var bmtConfig=[];
			var staticAd= {}

			;
			var flipByAudio= {}

			;
			var bookPlugin= {}

			;
			var phoneNumber=[];
			bookConfig.language="English";
		</script>
		<script src="<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/js/FlipBookPlugins.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/flipbook/static.fliphtml5.com/book/css/FlipBookPlugins.min.css" />
	</body>
</html>