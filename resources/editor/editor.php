<?php
if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	include_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
	include_once plugin_dir_path( dirname(__DIR__) ).'includes/settings.php';
	global $wpdb;
	$product_editor = $wpdb->get_results( "SELECT * FROM zalemto_editor_img WHERE cmpidtipimg = 6 OR cmpidprdct = ".$_GET["producto"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" /> <meta name="apple-mobile-web-app-capable" content="yes" /> <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
	<title>Editor</title>
	<link type="text/css" href="https://uicdn.toast.com/tui-color-picker/v2.2.0/tui-color-picker.css" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/tui-image-editor.css'; ?>" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/fontselect-alternate.css'; ?>" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/driver.min.css'; ?>" rel="stylesheet">
	<script>
		var clr_frn=[];
		var clr_tsr=[];
	</script>
	<?php
		$clr_frn = array();
		$clr_tsr = array();
		$ctm_icon = array();
		foreach ($product_editor as $key) {
			switch ($key->cmpidtipimg) {
				case 0:
					$alph_frn = $key->cmpurlimg;
					break;
				case 1:
					$alph_tsr = $key->cmpurlimg;
					break;
				case 2:
					array_push($clr_frn, $key->cmpurlimg);
					?> <script>clr_frn.push("<?php echo $key->cmpurlimg; ?>")</script> <?php
					break;
				case 3:
					array_push($clr_tsr, $key->cmpurlimg);
					?> <script>clr_tsr.push("<?php echo $key->cmpurlimg; ?>")</script> <?php
					break;
				case 6:
					array_push($ctm_icon, $key->cmpurlimg);
					break;
			}
		} 
	?>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/jquery.min.js'; ?>"></script>
	<script>
		var activeFrn;var activeTsr;
		function changeColor(colorFrn, colorTsr){
			activeFrn = colorFrn;activeTsr = colorTsr;
			var cssFrontal = {'background':'url(<?php echo EDIT_URL_PB; ?>/'+colorFrn+')'}
			jQuery('#tui-image-editor-container .tui-image-editor .tui-image-editor-canvas-container').css(cssFrontal);
			jQuery('.imgPrdFrn').html('<img src="<?php echo EDIT_URL_PB; ?>/'+colorFrn+'">');
			var cssTrasero = {'background':'url(<?php echo EDIT_URL_PB; ?>/'+colorTsr+')'}
			jQuery('#tui-image-editor-container-2 .tui-image-editor .tui-image-editor-canvas-container').css(cssTrasero);
			jQuery('.imgPrdTsr').html('<img src="<?php echo EDIT_URL_PB; ?>/'+colorTsr+'">');
		}
	</script>
	<style>
		@import url(https://fonts.googleapis.com/css?family=Noto+Sans);
		div #tui-image-editor-container{
			height: 100%;margin: 0;
		}
		#tui-image-editor-container .tui-image-editor .tui-image-editor-canvas-container{
			background-size:contain !important;background-repeat:no-repeat !important;
		}
		#tui-image-editor-container .tui-image-editor .tui-image-editor-canvas-container::before {
			background: url('<?php echo EDIT_URL_PB; ?>/<?php echo $alph_frn; ?>');
			background-size: contain;
			background-repeat: no-repeat;
			filter: drop-shadow(0 0 1px red);
			mix-blend-mode: multiply;
		}
		#tui-image-editor-container .lower-canvas {
			-webkit-mask-image: url('<?php echo EDIT_URL_PB; ?>/<?php echo $alph_frn; ?>');
			mask-image: url('<?php echo EDIT_URL_PB; ?>/<?php echo $alph_frn; ?>');
			-webkit-mask-size: contain;
			mask-size: contain;
			-webkit-mask-mode: luminance;
			mask-mode: luminance;
			-webkit-mask-repeat: no-repeat;
			mask-repeat: no-repeat;
		}
	<?php if (isset($alph_tsr)) : ?>
		#tui-image-editor-container-2 .tui-image-editor .tui-image-editor-canvas-container{
			background-size:contain !important;background-repeat:no-repeat !important;
		}
		#tui-image-editor-container-2 .tui-image-editor .tui-image-editor-canvas-container::before {
			background: url('<?php echo EDIT_URL_PB; ?>/<?php echo $alph_tsr; ?>');
			background-size: contain;
			background-repeat: no-repeat;
			filter: drop-shadow(0 0 5px red);
			mix-blend-mode: multiply;
		}
		#tui-image-editor-container-2 .lower-canvas {
			-webkit-mask-image: url('<?php echo EDIT_URL_PB; ?>/<?php echo $alph_tsr; ?>');
			mask-image: url('<?php echo EDIT_URL_PB; ?>/<?php echo $alph_tsr; ?>');
			-webkit-mask-size: contain;
			mask-size: contain;
			-webkit-mask-mode: luminance;
			mask-mode: luminance;
			-webkit-mask-repeat: no-repeat;
			mask-repeat: no-repeat;
		}
	<?php endif; ?>

	</style>
</head>
<body onresize="setMenu()" onchange="setArrows()">
	<span class="closeModal" onclick="closeModal('popContainer')">X</span>
	
	<div id="fb-root"></div>
	<script>
		window.fbAsyncInit = function() {
			FB.init({
				appId	: '303269393938393',
				cookie	: true,
				xfbml	: true,
				version	: 'v3.3'
			});
			FB.AppEvents.logPageView();
		};
		FB.login(function (response) {
			if (response.status === "connected") {
				var uID = response.authResponse.userID;
				console.log(uID);
				FB.api('/me', function (response) {
					var name = response.name;
					var locationName = ' ';
					if (response.location) {
						locationName = response.location.name;
						console.log(locationName);
					} else {
						alert("Debes configurar tu ciudad en tu perfil de Facebook para que sea público");
					}
				});//closes fb.api
			} else if (response.status === "not_authorized") {
				console.log("No conectado");
				//authCancelled. redirect
			}
		},
			{
				scope: 'user_location,user_likes'
			}
		);
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "https://connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.3&appId=303269393938393&autoLogAppEvents=1"></script>
	<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/jquery.fontselect.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/fabric.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/customiseControls.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-code-snipped.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/FileSaver.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-color-picker.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-image-editor.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/theme/black-theme.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/driver.min.js'; ?>"></script>

	<section class="variationProd">
		<div class="chooseSelect">Variaciones<span class="addCartLabel"> de producto</span> <span class="dashicons dashicons-arrow-down"></span>
			<ul>
				<?php foreach ($clr_frn as $key) { 
					foreach ($clr_tsr as $value) {
						if(explode("-",$key)[4] == explode("-",$value)[4]){$key2=$value;}
					}
				?>
					<div onclick="changeColor('<?php echo $key; ?>','<?php echo $key2; ?>')">
						<img src="<?php echo EDIT_URL_PB; ?>/<?php echo $key; ?>">
					</div>
				<?php } ?>
			</ul>
		</div>
	</section>

	<section class="changeProd">
		<span style="display: block;width: 100%;text-align: center;font-size: 11px;line-height: 10px;margin-bottom: 3px;">Cambiar<br>vista</span>
		<a onclick="openEditor('tui-image-editor-container',imageEditor)" class="imgPrdFrn"></a>
	<?php if (isset($alph_tsr)) : ?>
		<a onclick="openEditor('tui-image-editor-container-2',imageEditor2)" class="imgPrdTsr"><img src="<?php echo EDIT_URL_PB; ?>/<?php echo $clr_tsr[0]; ?>"></a>
	<?php endif; ?>
	</section>

	<section class="choseAction">
		<ul>
			<li id="btn-undo" class="tui-image-editor-item tui-editor-svg-icon" title="Deshacer">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-undo" class="normal"></use>
				</svg>
				<span>Deshacer</span>
			</li>
			<li id="btn-redo" class="tui-image-editor-item tui-editor-svg-icon" title="Rehacer">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-redo" class="normal"></use>
				</svg>
				<span>Rehacer</span>
			</li>
			<li id="delete-object" class="tui-image-editor-item tui-editor-svg-icon" title="Eliminar">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-delete" class="normal"></use>
				</svg>
				<span>Eliminar</span>
			</li>
			<li id="btn-delete-all" class="tui-image-editor-item tui-editor-svg-icon" title="Eliminar-todos">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-delete-all" class="normal"></use>
				</svg>
				<span>Eliminar<br>todo</span>
			</li>
		</ul>
	</section>

	<div class="tui-image-editor-menu-addImage" style="display:none">
		<div class="ctmIconLayer ctmImageLayer" onclick="closeImage()"></div>
		<div class="ctm-icons imageEditMenu">
			<li>
				<label>Cambiar Tamaño
					<input type="range" id="sizeRange" onchange="imageEdition(this, 'size')" min="0" max="3000" value="0"></label><br>
			</li><br><br>
			<li>
				<label>Mover horizontal
					<input type="range" id="moveXRange" onchange="imageEdition(this, 'left')" min="0" max="1800" value="0"></label><br>
			</li><br><br>
			<li>
				<label>Mover vertical
					<input type="range" id="moveYRange" onchange="imageEdition(this, 'top')" min="0" max="1800" value="0"></label><br>
			</li>
			<!--li id="tie-retate-button" onclick="imageEdition('', 'backfilt')" >
				<i style="font-size:25px" class="fa fa-image"></i><br>
				<span>Eliminar fondo</span>
			</li-->
		</div>
	</div>

	<div id="tui-image-editor-container"></div>
	<div id="tui-image-editor-container-2" style="display:none;"></div>

	<section class="ctmfile-label" id="iconContainer" style="display:none">
		<div class="ctmIconLayer" onclick="openIcons()"></div>
		<div class="ctm-icons carrusel-prods">
			<div class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-auto-logout-link="true" data-use-continue-as="true"></div><br>
			<?php foreach ($ctm_icon as $key) { ?>
				<div class="variationGallery" onclick="putIcon('<?php echo EDIT_URL_PB; ?>/<?php echo $key; ?>')"><img style="height:80px;max-width:100px;object-fit:contain;cursor:pointer;" src="<?php echo EDIT_URL_PB; ?>/<?php echo $key; ?>"></div>
			<?php } ?>
		</div>
	</section>
	
		<i class="naveright naveArrow fa fa-arrow-right"></i>
		<i class="naveleft naveArrow fa fa-arrow-left"></i>

	<script id="script1">


		function setActive(editorVar){
			editorActive = editorVar;
		}

		function openEditor(editorId, editorVar){
			document.getElementById("tui-image-editor-container").style.display = "none";
			document.getElementById("tui-image-editor-container-2").style.display = "none";
			document.getElementById("script1").style.display = "none";
			if(document.getElementById(editorId).style.display == "none"){
				document.getElementById(editorId).style.display = "block";
				setActive(editorVar);
			}else{
				document.getElementById(editorId).style.display = "none";
			}
		}

		 // Image editor
		 var locale_es_ES = {
			'Crop': 'Recortar',
			'Flip': 'Girar',
			'Rotate': 'Rotar',
			'Draw': 'Dibujar',
			'Shape': 'Forma',
			'Icon': 'Ícono',
			'Text': 'Texto'
		};

		window.addEventListener("resize", setMenu);
		var menuPosition;
		function setMenu() {
			if (document.body.scrollWidth < 560){ menuPosition = 'bottom'; }
			else{ menuPosition = 'left'; }
		};
		setMenu();

		var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
			includeUI: {
				loadImage: {
					path: '<?php echo EDIT_URL_PB; ?>/assets/img/background.png',
					name: 'SampleImage'
				},
				locale: locale_es_ES,
				theme: blackTheme,
				menuBarPosition: menuPosition
			},
			cssMaxWidth: '100%',
			cssMaxHeight: '100%',
			selectionStyle: {
				rotatingPointOffset: 100
			}
		});
		var imageEditor2 = new tui.ImageEditor('#tui-image-editor-container-2', {
			includeUI: {
				loadImage: {
					path: '<?php echo EDIT_URL_PB; ?>/assets/img/background.png',
					name: 'SampleImage'
				},
				locale: locale_es_ES,
				theme: blackTheme,
				menuBarPosition: menuPosition
			},
			cssMaxWidth: '100%',
			cssMaxHeight: '100%'
		});

		var editorActive = imageEditor;

		fabric.Canvas.prototype.customiseControls({
			tl: {
				action: 'rotate',
				cursor: '<?php echo plugin_dir_url( __FILE__ )."img/rotate.png"; ?>'
			},
			tr: {
				action: 'scale'
			},
			bl: {
				action: 'remove',
				cursor: 'pointer'
			},
			 mtr: {
				action: 'rotate',
				cursor: '<?php echo plugin_dir_url( __FILE__ ); ?>img/rotate.png'
			 },
		});
		fabric.Object.prototype.customiseCornerIcons({
			settings: {
				borderColor: '#009acf',
				cornerSize: 25,
				cornerShape: 'rect',
				cornerBackgroundColor: 'black',
				cornerPadding: 10
			},
			tl: { icon: '<?php echo EDIT_URL_PB; ?>/resources/editor/img/rotate.png' },
			tr: { icon: '<?php echo EDIT_URL_PB; ?>/resources/editor/img/scale.png' },
			bl: { icon:  '<?php echo EDIT_URL_PB; ?>/resources/editor/img/remove.png' },
			mtr: { icon: '<?php echo EDIT_URL_PB; ?>/resources/editor/img/rotate.png' },
		});

		
		jQuery('#btn-redo').click(function(){
			editorActive.redo();
		});
		jQuery('#btn-undo').click(function(){
			editorActive.undo();
		});
		jQuery('#delete-object').click(function(){
			editorActive.removeActiveObject();
		});
		jQuery('#btn-delete-all').click(function(){
			editorActive.clearObjects();
		});

		jQuery('.tui-image-editor-item.normal.crop').
		replaceWith('<label for="tie-icon-image-upload">\n	<li id="tie-btn-icon" title="Imagen" class="imageMenIcon tui-image-editor-item normal">\n	<svg class="svg_ic-submenu">\n	<style type="text/css"> .st0{fill:#0D7F9E;} .st1{fill:#009ACF;} .st2{fill:#2ED573;} .st3{fill:#7BED9F;} .st4{fill:#FFA502;} .st5{fill:#ECCC68;} .st6{fill:#5352ED;} .st7{fill:#2F2FA8;} .st8{fill:#8686F2;} </style>\n	<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon-load" class="normal"></use>\n	<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon-load" class="active"></use>\n	</svg>\n	</li>\n	</label>\n	<input onchange="loadImage(event)" style="display:none;" type="file" accept="image/*" id="tie-icon-image-upload" class="tie-icon-image-file">');
		jQuery('.tui-image-editor-item.normal.filter').
		replaceWith('<a onclick="openIcons()">\n	<li id="tie-btn-icon" title="Ícono" class="tui-image-editor-item normal">\n	<svg class="svg_ic-menu">\n	<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon" class="normal active">\n	</use>\n	<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-b.svg#icon-b-ic-icon" class="active">\n	</use>\n	<use xlink:href="<?php echo EDIT_URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon" class="hover">\n	</use></svg>\n	</li>\n	</a>');
		jQuery('#tie-text-range').
		replaceWith('<input type="range" id="textRange" onchange="textSize(this)" min="10" max="240" value="120">');
		jQuery('#tie-draw-range').
		replaceWith('<input type="range" id="drawRange" onchange="drawSize(this)" min="10" max="240" value="120">');
		jQuery('#tie-rotate-range').
		replaceWith('<input type="range" id="rotateRange" onchange="rotateSize(this)" min="-360" max="360" value="0">');
		jQuery('.textInput').
		replaceWith('<form class="addTxtForm" onsubmit="agregarTexto()" style="display:block;margin-bottom:10px;"><label style="color:#fff;clear:left;">Agregar Texto</label><br>\n	<textarea type="text" id="inputText" placeholder="Agregar Texto" style="padding:5px;width:calc(100% - 60px);height:35px;"></textarea>\n	<button type="button" onclick="agregarTexto()"><i class="fa fa-paper-plane"></i></button></form>');

		window.onresize = function() {
			editorActive.ui.resizeEditor();
		}

		function openIcons(){
			jQuery('.tui-image-editor-item').removeClass('active');
			var iconContainer = document.getElementById("iconContainer"); 
				jQuery('.tui-image-editor-main').attr('class','tui-image-editor-main');
			if(iconContainer.style.display == "none"){
				iconContainer.style.display = "block";
			}else{
				iconContainer.style.display = "none";
			}
		}

		function imageEdition(valor, parametro){
			jQuery('.tui-image-editor-item').removeClass('active');
			if(parametro == 'size'){
				var actWid = editorActive.getObjectProperties(editorActive.activeObjectId, 'width');
				var actHei = editorActive.getObjectProperties(editorActive.activeObjectId, 'height');
				editorActive.setObjectProperties(editorActive.activeObjectId, {
					width: (parseInt(valor.value)),
					height: (parseInt(valor.value))
				});
			}else if(parametro == 'left'){
				editorActive.setObjectProperties(editorActive.activeObjectId, {
					left: parseInt(valor.value)
				});
			}else if(parametro == 'top'){
				editorActive.setObjectProperties(editorActive.activeObjectId, {
					top: parseInt(valor.value)
				});
			}
		}
		
		function setArrows(){
			if(document.body.scrollWidth < 560){
				if(jQuery(".naveArrow").css("display") == "none"){
					jQuery(".naveArrow").show();
				}else{
					jQuery(".naveArrow").hide();
				}
			}
		}

		function closeImage(){
			editorActive.deactivateAll();
			jQuery(".tui-image-editor-menu-addImage").hide();
		}

		jQuery(".tui-image-editor-item").click(function(){
			setArrows();
		});

		 function loadImage(event){
			jQuery('.tui-image-editor-item').removeClass('active');
			jQuery('.tui-image-editor-main').attr('class','tui-image-editor-main');
			jQuery(".tui-image-editor-menu-addImage").show();
			editorActive.stopDrawingMode();
			var imgUrl = void 0;

			var _event$target$files = event.target.files,
				file = _event$target$files[0];

			if (file) {
				imgUrl = URL.createObjectURL(file);
				//this.actions.registCustomIcon(imgUrl, file);
				editorActive.addImageObject(imgUrl).
				then(objectProps => {
					if(objectProps.width < 220){
						var objWidth = objectProps.width + 200;
						var objHeight = objectProps.height + 200;
					}else{
						var objWidth = objectProps.width * 0.30;
						var objHeight = objectProps.height * 0.30;
					}
					editorActive.setObjectProperties(objectProps.id, {
						width: objWidth,
						height: objHeight
					});
					document.getElementById('sizeRange').value = objWidth;
					document.getElementById('moveXRange').value = objectProps.left;
					document.getElementById('moveYRange').value = objectProps.top;
				});
			}
		}

		editorActive.on('objectActivated', function(props) {
			jQuery(".tui-image-editor-menu-addImage").hide();
			if(props.type == 'i-text'){
				jQuery('#inputText').val(props.text);
			}else if(props.type == 'image'){
				jQuery('.tui-image-editor-item').removeClass('active');
				jQuery('.tui-image-editor-main').attr('class','tui-image-editor-main');
				jQuery(".tui-image-editor-menu-addImage").show();
			}
		});

		jQuery('.tui-image-editor-button.flipX').click(function(e) {
			editorActive.flipX();
		});

		jQuery('.tui-image-editor-button.flipY').click(function(e) {
			editorActive.flipY();
		});

		function putIcon(url){
			editorActive.stopDrawingMode();
			editorActive.addImageObject(
				url
			).then(objectProps => {
				if(objectProps.width < 220){
					var objWidth = objectProps.width + 200;
					var objHeight = objectProps.height + 200;
					console.log(objWidth);
				}else{
					var objWidth = objectProps.width * 0.30;
					var objHeight = objectProps.height * 0.30;
					console.log(objWidth);
				}
				editorActive.setObjectProperties(objectProps.id, {
					width: objWidth,
					height: objHeight
				});
				document.getElementById('sizeRange').value = objWidth;
				document.getElementById('moveXRange').value = objectProps.left;
				document.getElementById('moveYRange').value = objectProps.top;
				jQuery("#iconContainer").hide();
			});
		}

		function textSize(parametro){
			jQuery('#tie-text-range-value').val(parametro.value);
			editorActive.changeTextStyle(editorActive.activeObjectId, {
				fontSize: parseInt(parametro.value, 10)
			});
		};

		function drawSize(parametro){
			jQuery('#tie-draw-range-value').val(parametro.value);
			editorActive.setBrush({
				width: parseInt(parametro.value, 10)
			});
		};

		function rotateSize(parametro){
			jQuery('#tie-ratate-range-value').val(parametro.value);
			editorActive.rotate(parseInt(parametro.value, 10));
		};

		function agregarTexto(){
			if(editorActive.activeObjectId == null){
				editorActive.addText(jQuery('#inputText').val(), {
					styles: { fill: '#000', fontSize: 90
					}
				});
			}else{
				editorActive.changeText(editorActive.activeObjectId, jQuery('#inputText').val());
			}
		}
		
		jQuery(function(){
			jQuery('.font').fontselect().change(function(){
				var font = jQuery(this).val().replace(/\+/g, ' ');
				font = font.split(':');
				editorActive.changeTextStyle(editorActive.activeObjectId, {
					fontFamily: font[0]
				});
			
			});
		});

		const driver = new Driver({
			allowClose: false,
			animate: true,
			doneBtnText: 'Finalizado',
			closeBtnText: 'Cerrar',
			nextBtnText: 'Siguiente',
			prevBtnText: 'Anterior',
			keyboardControl: true,
		});
		driver.defineSteps([
			{
				element: '.tui-image-editor-header',
				popover: {
					className: 'first-step-popover-class',
					title: 'Bienvenido al <strong>editor de productos</strong>',
					description: 'Aquí puedes personalizar tus productos antes de la compra<br>¡Vamos a dar un tour!',
					position: 'bottom'
				}
			}, {
				element: '.choseAction',
				popover: {
					title: 'Opciones rápidas',
					description: 'Aquí puedes eliminar, rehacer o deshacer tus cambios...',
					position: 'left-bottom'
				}
			}, {
				element: '.changeProd',
				popover: {
					title: 'Cambiar de vista',
					description: 'Cambia entre la vista frontal o trasera del producto',
					position: 'top-right'
				}
			}, {
				element: '.variationProd',
				popover: {
					title: 'Elige tu favorito',
					description: 'Elige la variación del producto que quieras',
					position: 'bottom-right'
				}
			}, {
				element: '.tui-image-editor-menu',
				popover: {
					title: 'Navega entre las herramientas',
					description: 'Tienes múltiples herramientas para crear el mejor diseño',
					position: 'top'
				}
			}, {
				element: '.imageMenIcon',
				popover: {
					title: 'Creemos algo nuevo...',
					description: '<code>Empieza agregando una imagen</code>',
					position: 'top-left'
				},
				onNext: () => {
					// Prevent moving to the next step
					driver.preventMove();
					jQuery('#tie-icon-image-upload').trigger('click');
					$('#tie-icon-image-upload').on('change',function(){
					    driver.moveNext();
					});
				}
			}, {
				element: '.ctm-icons.imageEditMenu',
				popover: {
					title: 'Cambia los valores',
					description: 'Tienes disponible esta barra de herramientas para cambiar los valores a tu antojo<br><span style="text-align:center;display: block;width: 100%;"><img src="<?php echo EDIT_URL_PB; ?>/resources/editor/img/cursorScroll.png" width="20px"><br><code>¡No dudes en hacer scroll!</code></span>',
					position: 'bottom-right'
				}
			}, {
				element: '#tui-image-editor-next-btn',
				popover: {
					title: 'Para finalizar...',
					description: 'Agrega tu producto al carrito de compra',
					position: 'bottom'
				}
			}, {
				element: '.closeModal',
				popover: {
					title: 'Si deseas salir del editor...',
					description: 'Presiona la X y confirma que deseas salir...<br>pero espero que vuelvas pronto',
					position: 'bottom-right'
				}
			}
		]);
		

		jQuery(document).ready(function(){
			console.log(document.cookie);

			if ($( document ).width() < 560){ driver.start(); }
			else{ driver.start(); }

			changeColor(clr_frn[0], clr_tsr[0]);

			jQuery('#tui-image-editor-next-btn').click(function(e){
				e.preventDefault();
				var image = editorActive.toDataURL('image/png');
				  jQuery.post("<?php echo EDIT_URL_PB; ?>/includes/saveImage.php",
				  {
					post: 	"<?php echo $_GET["producto"]; ?>",
					imgfrn: image
				  },
				  function(data, status){
					alert("Se ha guardado la imagen correctamente");
					closeModal('popContainer');
				  });
			});
		});
	</script>
	
</body>
</body>
</html>
