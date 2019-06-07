<?php
if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	include_once $_SERVER['DOCUMENT_ROOT'].'/wordpress/wp-load.php';
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
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" /> <meta name="apple-mobile-web-app-capable" content="yes" /> <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
	<title>Editor</title>
	<link type="text/css" href="https://uicdn.toast.com/tui-color-picker/v2.2.0/tui-color-picker.css" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/tui-image-editor.css'; ?>" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/fontselect-alternate.css'; ?>" rel="stylesheet">
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
			var cssFrontal = {'background':'url(<?php echo URL_PB; ?>/'+colorFrn+')'}
			jQuery('#tui-image-editor-container .tui-image-editor .tui-image-editor-canvas-container').css(cssFrontal);
			jQuery('.imgPrdFrn').html('<img src="<?php echo URL_PB; ?>/'+colorFrn+'">');
			var cssTrasero = {'background':'url(<?php echo URL_PB; ?>/'+colorTsr+')'}
			jQuery('#tui-image-editor-container-2 .tui-image-editor .tui-image-editor-canvas-container').css(cssTrasero);
			jQuery('.imgPrdTsr').html('<img src="<?php echo URL_PB; ?>/'+colorTsr+'">');
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
			background: url('<?php echo URL_PB; ?>/<?php echo $alph_frn; ?>');
			background-size: contain;
			background-repeat: no-repeat;
			filter: drop-shadow(0 0 1px red);
			mix-blend-mode: multiply;
		}
		#tui-image-editor-container .lower-canvas {
			-webkit-mask-image: url('<?php echo URL_PB; ?>/<?php echo $alph_frn; ?>');
			mask-image: url('<?php echo URL_PB; ?>/<?php echo $alph_frn; ?>');
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
			background: url('<?php echo URL_PB; ?>/<?php echo $alph_tsr; ?>');
			background-size: contain;
			background-repeat: no-repeat;
			filter: drop-shadow(0 0 5px red);
			mix-blend-mode: multiply;
		}
		#tui-image-editor-container-2 .lower-canvas {
			-webkit-mask-image: url('<?php echo URL_PB; ?>/<?php echo $alph_tsr; ?>');
			mask-image: url('<?php echo URL_PB; ?>/<?php echo $alph_tsr; ?>');
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
<body onresize="changeSize()">
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
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "https://connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div id="fb-root"></div>
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

	<section class="variationProd">
		<div class="chooseSelect">Cambiar de color <span class="dashicons dashicons-arrow-down"></span>
			<ul>
				<?php foreach ($clr_frn as $key) { 
					foreach ($clr_tsr as $value) {
						if(explode("-",$key)[4] == explode("-",$value)[4]){$key2=$value;}
					}
				?>
					<div onclick="changeColor('<?php echo $key; ?>','<?php echo $key2; ?>')">
						<img src="<?php echo URL_PB; ?>/<?php echo $key; ?>">
					</div>
				<?php } ?>
			</ul>
		</div>
	</section>

	<section class="changeProd">
		<div class="fb-login-button" data-width="100" data-size="small" data-button-type="continue_with" data-auto-logout-link="true" data-use-continue-as="true"></div>
		<a onclick="openEditor('tui-image-editor-container',imageEditor)" class="imgPrdFrn"></a>
	<?php if (isset($alph_tsr)) : ?>
		<a onclick="openEditor('tui-image-editor-container-2',imageEditor2)" class="imgPrdTsr"><img src="<?php echo URL_PB; ?>/<?php echo $clr_tsr[0]; ?>"></a>
	<?php endif; ?>
	</section>

	<section class="choseAction">
		<ul>
			<li id="btn-undo" class="tui-image-editor-item" title="Deshacer">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-undo" class="normal"></use>
				</svg>
			</li>
			<li id="btn-redo" class="tui-image-editor-item" title="Rehacer">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-redo" class="normal"></use>
				</svg>
			</li>
			<li id="delete-object" class="tui-image-editor-item" title="Eliminar">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-delete" class="normal"></use>
				</svg>
			</li>
			<li id="btn-delete-all" class="tui-image-editor-item" title="Eliminar-todos">
				<svg class="svg_ic-menu">
					<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-delete-all" class="normal"></use>
				</svg>
			</li>
		</ul>
	</section>

	<div id="tui-image-editor-container"></div>
	<div id="tui-image-editor-container-2" style="display:none;"></div>

	<section class="custom-file-label" id="iconContainer" style="display:none">
		<div class="ctm-icons carrusel-prods">
			<?php foreach ($ctm_icon as $key) { ?>
				<div class="variationGallery" onclick="putIcon('<?php echo URL_PB; ?>/<?php echo $key; ?>')"><img style="height:80px;max-width:100px;object-fit:contain;cursor:pointer;" src="<?php echo URL_PB; ?>/<?php echo $key; ?>"></div>
			<?php } ?>
		</div>
	</section>

	<script id="script1">


		function setActive(editorVar){
			editorActive = editorVar;
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
			if (document.body.scrollWidth < 800){menuPosition = 'bottom';}
			else{menuPosition = 'left';}
		};
		setMenu();

		var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
			includeUI: {
				loadImage: {
					path: '<?php echo URL_PB; ?>/assets/img/background.png',
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
					path: '<?php echo URL_PB; ?>/assets/img/background.png',
					name: 'SampleImage'
				},
				locale: locale_es_ES,
				theme: blackTheme,
				menuBarPosition: menuPosition
			},
			cssMaxWidth: '100%',
			cssMaxHeight: '100%'
		});

		fabric.Object.prototype.drawControls = function (ctx) {
			if (!this.hasControls) { return this; }
			var wh = this._calculateCurrentDimensions(),
					width = wh.x,
					height = wh.y,
					scaleOffset = this.cornerSize,
					left = -(width + scaleOffset) / 2,
					top = -(height + scaleOffset) / 2,
					methodName = this.transparentCorners ? 'stroke' : 'fill';
			ctx.save();
			ctx.strokeStyle = ctx.fillStyle = this.cornerColor;
			if (!this.transparentCorners) {
				ctx.strokeStyle = this.cornerStrokeColor;
			}
			this._setLineDash(ctx, this.cornerDashArray, null);
			this._drawControl('tl', ctx, methodName, left, top);
			this._drawControl('tr', ctx, methodName, left + width, top);
			this._drawControl('bl', ctx, methodName, left, top + height);
			this._drawControl('br', ctx, methodName, left + width, top + height);

			if (!this.get('lockUniScaling')) {
				this._drawControl('mt', ctx, methodName, left + width / 2, top);
				this._drawControl('mb', ctx, methodName, left + width / 2, top + height);
				this._drawControl('mr', ctx, methodName, left + width, top + height / 2);
				this._drawControl('ml', ctx, methodName, left, top + height / 2);
			}
			if (this.hasRotatingPoint) {
				var rotate = new Image(), rotateLeft, rotateTop;
				rotate.src = '<?php echo plugin_dir_url( __FILE__ )."img/rotate.png"; ?>';
				rotateLeft = left - 20 + width / 2;
				rotateTop = top - 20 - this.rotatingPointOffset;
				ctx.drawImage(rotate, rotateLeft, rotateTop, 70, 70);
			}
			ctx.restore();
			return this;
		}
		
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
			imageEditor.clearObjects();
		});

		jQuery('.tui-image-editor-item.normal.filter').
		replaceWith('<label for="tie-icon-image-upload">\n	<li id="tie-btn-icon" title="Subir Imagen" class="tui-image-editor-item normal">\n	<svg class="svg_ic-submenu">\n	<style type="text/css"> .st0{fill:#0D7F9E;} .st1{fill:#009ACF;} .st2{fill:#2ED573;} .st3{fill:#7BED9F;} .st4{fill:#FFA502;} .st5{fill:#ECCC68;} .st6{fill:#5352ED;} .st7{fill:#2F2FA8;} .st8{fill:#8686F2;} </style>\n	<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon-load" class="normal"></use>\n	<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon-load" class="active"></use>\n	</svg>\n	</li>\n	</label>\n	<input onchange="loadImage(event)" style="display:none;" type="file" accept="image/*" id="tie-icon-image-upload" class="tie-icon-image-file">');
		jQuery('.tui-image-editor-item.normal.crop').
		replaceWith('<a onclick="openIcons()">\n	<li id="tie-btn-icon" title="Ícono" class="tui-image-editor-item normal">\n	<svg class="svg_ic-menu">\n	<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon" class="normal active">\n	</use>\n	<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-b.svg#icon-b-ic-icon" class="active">\n	</use>\n	<use xlink:href="<?php echo URL_PB; ?>/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon" class="hover">\n	</use></svg>\n	</li>\n	</a>');
		jQuery('#tie-text-range').
		replaceWith('<input type="range" id="textRange" onchange="textSize(this)" min="10" max="240" value="120">');
		jQuery('#tie-draw-range').
		replaceWith('<input type="range" id="drawRange" onchange="drawSize(this)" min="10" max="240" value="120">');
		jQuery('#tie-rotate-range').
		replaceWith('<input type="range" id="rotateRange" onchange="rotateSize(this)" min="-360" max="360" value="0">');
		jQuery('#textInput').
		replaceWith('<form style="display:block;margin-bottom:10px;"><label style="color:#fff;clear:left;">Agregar Texto</label><br>\n	<input type="text" id="inputText" placeholder="Agregar Texto" style="padding:5px;width:calc(100% - 60px);">\n	<button type="button" onclick="agregarTexto()"><i class="fa fa-paper-plane"></i></button></form>');

		var editorActive = imageEditor;

		window.onresize = function() {
			editorActive.ui.resizeEditor();
		}

		 function loadImage(event){
			var imgUrl = void 0;

			var _event$target$files = event.target.files,
				file = _event$target$files[0];

			if (file) {
				imgUrl = URL.createObjectURL(file);
				//this.actions.registCustomIcon(imgUrl, file);
				editorActive.addImageObject(imgUrl).
				then(objectProps => {
					console.log(objectProps);
					editorActive.setObjectProperties(objectProps.id, {
						width: (objectProps.width * 0.10),
						height: (objectProps.height * 0.10)
					});
				});
			}
		}

		editorActive.on('object:selected', function (e) {
			e.target.transparentCorners = false;
			e.target.borderColor = '#cccccc';
			e.target.cornerColor = '#0CB7F0';
			e.target.minScaleLimit = 1;
			e.target.cornerStrokeColor = '#0CB7F0';
			e.target.cornerStyle = 'circle';
			e.target.minScaleLimit = 0;
			e.target.lockScalingFlip = true;
			e.target.padding = 70;
			e.target.selectionDashArray = [10, 5];
			e.target.borderDashArray = [10, 5];
			e.target.cornerDashArray = [10, 5];
		});

		imageEditor.on('objectActivated', function(props) {
			jQuery('#inputText').val(props.text);
		});

		jQuery('.tui-image-editor-button.flipX').click(function(e) {
			editorActive.flipX().then(status => {
				console.log('flipX: ', status.flipX);
			});
		});

		jQuery('.tui-image-editor-button.flipY').click(function(e) {
			editorActive.flipY().then(status => {
				console.log('flipY: ', status.flipY);
			});
		});

		function putIcon(url){
			editorActive.addImageObject(
				url
			).then(objectProps => {
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
					styles: { fill: '#000', fontSize: 80
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


		jQuery(document).ready(function(){

			changeColor(clr_frn[0], clr_tsr[0]);

			jQuery('#tui-image-editor-next-btn').click(function(e){
				e.preventDefault();
				var image = imageEditor.toDataURL('image/png');
				  $.post("<?php echo URL_PB; ?>/includes/saveImage.php",
				  {
					post: 	"<?php echo $_GET["producto"]; ?>",
					imgfrn: image
				  },
				  function(data, status){
					alert("Se ha guardado la imagen correctamente");
				  });
			});
		});
	</script>
	
</body>
</body>
</html>
