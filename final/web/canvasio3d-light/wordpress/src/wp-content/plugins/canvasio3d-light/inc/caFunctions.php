<?php
//
class arClass{
	static $path, $modus, $upPath, $ver, $subDir, $pluginsDir, $gst, $arID='0', $version='', $caURL='', $backSwitch='', $pluginName='Canvasio3D Light'; // NEW!
	//
	public static function run(){
		arClass::$caURL=$_SERVER['HTTP_HOST'];
		arClass::$path=plugins_url('/inc',dirname(__FILE__),false);
		arClass::$upPath=wp_upload_dir()['url'];
		arClass::$gst=$_SERVER['HTTP_HOST'];
		arClass::$version=$GLOBALS["caArVersion"];
		arClass::$pluginsDir=wp_normalize_path(WP_PLUGIN_DIR);
		arClass::load_plugin_textdomain('canvasio3d-light','caAR');
		arClass::$ver=arClass::$version;arClass::$ver=rand(0,10000);arClass::$modus='front';
		//
		add_action('wp_ajax_caARConnect', [new arClass,'caARConnect']);
		add_action('wp_ajax_nopriv_caARConnect', [new arClass,'caARConnect']);
		add_action('admin_enqueue_scripts', [new arClass,'register_CaScripts']);
		add_action('wp_enqueue_scripts', [new arClass,'register_caScripts']);
		add_action('plugins_loaded', [new arClass,'init']);
	}
	//
	function register_CaScripts(){
		wp_enqueue_script('jquery'); if(is_admin())wp_enqueue_media();
	}	
	//
	function init(){
		global $wpdb;
		if(is_admin()){
			arClass::$modus='back';arClass::DB_SetUp(false);$cu=wp_get_current_user(); // Database RESET: DB_SetUp(true);
			add_action('admin_menu', [new arClass,'register_admin_menu']);
			//add_action('add_meta_boxes', [new arClass,'register_meta_boxes']); // <- if you like can you active this line to enable page Edit of Canvasio3D
		}
		//
		add_shortcode('Canvasio3D', [new arClass, 'initShortCode']);
	}	
	//
	function register_meta_boxes(){
		if(!is_user_logged_in())return;
		add_meta_box('Canvasio3D_Options', 'Canvasio3D Options',[new arClass, 'Canvasio3D_Options'],null, 'normal', 'high',array('__block_editor_compatible_meta_box' => true,));
		add_shortcode('Canvasio3D', [new arClass, 'initShortCode']);
	}
	//
	function register_admin_menu(){
		if(!is_user_logged_in())return; add_menu_page(__('Canvasio_3D','textdomain'),__('Canvasio3D','textdomain'),'manage_options','Canvasio3D_Options',[new arClass,'Canvasio3D_Options'],arClass::$path.'/assets/icons/ca3D.png',6);	
	}
	//
	function msg($_id){
		$a=array();
		$a[0]=__('Hello World!','caAR');
		$a[1]=__('Window height:','caAR');
		$a[2]=__('Window width:','caAR');
		$a[3]=__('Color:','caAR');
		$a[4]=__('Image:','caAR');
		$a[5]=__('Color | Image:','caAR');
		$a[6]=__('New scene','caAR');
		$a[7]=__('Enter scene name here','caAR');
		$a[8]=__('Delete scene','caAR');
		$a[9]=__('Save scene','caAR');
		$a[10]=__('Scene select','caAR');
		$a[11]=__('Copy scene','caAR');
		$a[12]=__('Paste scene','caAR');
		$a[13]=__('Object Upload: fbx | glb | stl | zip','caAR');
		$a[14]=__('Size:','caAR');
		$a[15]=__('Down | Up:','caAR');
		$a[16]=__('3D-Object select','caAR');
		$a[17]=__('Fullscreen button:','caAR');
		$a[18]=__('Rotation button:','caAR');
		$a[19]=__('Scene Manager','caAR');
		$a[20]=__('Model Settings','caAR');
		$a[21]=__('Window Settings','caAR');
		$a[22]=__('Button Settings','caAR');
		$a[23]=__('Auto rotation:','caAR');
		$a[24]=__('File upload - Please wait!','caAR');
		$a[25]=__('Loading uploaded model','caAR');
		$a[26]=__('Error: File format not suported!','caAR');
		$a[27]=__('Loading model','caAR');
		$a[28]=__('Error in media library!','caAR');
		$a[29]=__('Scene data was updated','caAR');
		$a[30]=__('New scene data was saved','caAR');
		$a[31]=__('Error to save data!','caAR');
		$a[32]=__('If you have question to use your 3D-Models<br>or any problems with our Plugin, are we pleased about your email:','caAR');
		$a[33]=__('Contact us here','caAR');
		$a[34]=__('License Key','caAR');
		$a[35]=__('If you would like upgrade to <a href="https://www.canvasio3d.com/canvasio3d-pro/" target="_blank">Canvasio3D PRO</a> or <a href="https://www.canvasio3d.com/canvasio3d-woo/" target="_blank">Canvasio3D WOO</a><br>than enter your license key here:','caAR');
		$a[36]=__('Get upgrade version','caAR');
		if(arClass::$pluginName=='Canvasio3D Light'){
			$a[37]=__('Attention | After upgrade the plugin, the name of <i>canvasio3D Light</i> will changed <br> to <b>Canvasio3D</b> and must be activate manuell!','caAR');
		}else{
			$a[37]='';
		}
		$a[38]=__('Update is running ... please wait!','caAR');
		$a[39]=__('Wireframe button:','caAR');
		$a[40]=__('Camera Pan:','caAR');
		$a[41]=__('Camera Lock:','caAR');
		$a[42]=__('Camera Damping:','caAR');
		$a[61]=__('Brightness:','caAR');
		print_r($a[$_id]);
	}	
	//
	function Canvasio3D_Options($Post){
		$p=arClass::$path; global $pagenow; if(($pagenow=='post.php') || (get_post_type()=='post')){arClass::$backSwitch='pageEdit';}else{arClass::$backSwitch='dashboard';};?>
		<div id="caWrap" class="caWrap" style="position:relative"><?php  print_r(do_shortcode('[Canvasio3D name="Canvasio3D"]', false)); ?>
		<div id="supportPage" style="background-color:rgb(246, 246, 246);width:100%;height:640px;max-height:640px;overflow-y:auto;position:absolute;top:0px;z-index:777;display:none">
			<p style="text-align:center;font-size:18px;background-color:#2cb1f1;color:#f6f6f6;padding:4px;margin:0;margin-top:-2px;">Canvasio3D Support</p>
			<table style="width:100%;height:auto">
				<tBody style="margin-top:-16px;font-size:14px;">
					<tr>
						<td valign="top" style="width:50%;border:1px solid #ddd;padding:4px">
							<span style="font-size:18px;"><?php echo arClass::$pluginName; ?> | Version: <? print_r(arClass::$version); ?></span>
							<p><?php arClass::msg(32);?></p>
							<input type="btn" readonly="readonly" id="caContact" class="caMenuBtn" style="color:#f6f6f6;width:182px" value="<?php arClass::msg(33);?>" onClick="caOpt.settings(this);" />
						</td>
						<td valign="top" style="width:50%;border:1px solid #ddd;padding:4px;">
							<span style="font-size:18px;"><?php arClass::msg(34);?></span>
							<p><?php arClass::msg(35);?></p>
							<input type="text" id="caKey" class="caTxtKeyField" style="margin-bottom:4px;" /><br><input type="btn" readonly="readonly" id="caSendKey" class="caMenuBtn" style="color:#f6f6f6;width:182px" value="<?php arClass::msg(36);?>" onClick="caOpt.settings(this);" />
							<p id="lightInfo" style="font-size:11px;"><?php arClass::msg(37);?></p>
						</td>
					</tr>
					<tr>
						<td valign="top" style="width:50%;border:1px solid #ddd;padding:4px;">
							<span style="font-size:18px;width:100%">Documentation: <a href="https://www.canvasio3d.com/pub/doc/canvasio3d" target="_blank">Click here for the documentation</a></span>
						</td>
						<td valign="top" style="width:50%;border:1px solid #ddd;padding:4px;">
							<span><b>Change log:</b></span><br>
							<span>- Mayor Update to Version 2.5.0</span><br>
							<span>- Supported File format: FBX | glTF | glb | stl | obj & mtl</span><br>
							<span>- Better graphic quality and light shadow</span><br>
							<span>- Wire-frame look and button</span><br>
							<span>- Camera damping switch for smooth glide movement</span><br>
							<span>- Camera lock switch</span><br>
							<span>- Camera pan switch</span><br>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="caOptionsDiv" id="caOptionsDiv">
			<div class="caIconBox" id="iconBox">
				<img class="caMenuIcon" id="caDatSet" title="<?php arClass::msg(19);?>" src="<?php print_r($p.'/assets/icons/caData.png');?>" onClick="caOpt.menuSelect(this);" />
				<img class="caMenuIconOff" id="caModSet" title="<?php arClass::msg(20);?>" src="<?php print_r($p.'/assets/icons/caModel.png');?>" onClick="caOpt.menuSelect(this);" />
				<img class="caMenuIconOff" id="caWinSet" title="<?php arClass::msg(21);?>" src="<?php print_r($p.'/assets/icons/caWindow.png');?>" onClick="caOpt.menuSelect(this);" />
				<img class="caMenuIconOff" id="caButSet" title="<?php arClass::msg(22);?>" src="<?php print_r($p.'/assets/icons/caButtons.png');?>" onClick="caOpt.menuSelect(this);" />
			</div>		
			<div class="caOptions" id="caOptions">
				<div class="caMenuBox" id="caDatSetDiv">
					<input type="btn" readonly="readonly" id="newModelEntry" class="caMenuBtn"  style="width:100%;" value="<?php arClass::msg(6);?>" onClick="caOpt.settings(this);"/>
					<select id="dataList" class="caSelect" onInput="caOpt.settings(this)"><option value="-1" name="default"><?php arClass::msg(10);?></option></select>
					<input type="text" id="dataListVal" class="caSelectVal" onInput="caOpt.settings(this);" />
					<hr class="caHR" style="margin-top:8px">
					<textarea class="caTxtInputField" id="caShortCode" readonly rows="2" cols="1" placeholder="Short Code ..." style="position:absolute; width:182px; top:152px;"></textarea>
					<hr style="position:absolute; width:180px; top:204px;">
					<input type="btn" readonly="readonly" id="copyModelEntry" class="caMenuBtn"  style="position:absolute; width:180px; top:222px;" value="<?php arClass::msg(11);?>" onClick="caOpt.settings(this);" />
					<input type="btn" readonly="readonly" id="pasteModelEntry" class="caMenuBtn"  style="position:absolute; width:180px; top:252px;" value="<?php arClass::msg(12);?>" onClick="caOpt.settings(this);" />
					<hr style="position:absolute; width:180px; top:282px;">
					<div id="delBar" style="height:5px;margin-left:20px; width:0px;background-color:#ff0000;position:absolute; top:298px"></div>
					<input type="btn" readonly="readonly" id="deleteModelEntry" class="caMenuBtn"  style="margin-left:20px;position:absolute; width:140px; top:305px; color:#333" value="<?php arClass::msg(8);?>" />
				</div>
				<div class="caMenuBox" id="caModSetDiv">
					<form id="caUploadAdminForm" method="post" action="#" enctype="multipart/form-data">
						<input type="file" accept=".zip,.glb,.stl,.fbx" name="caAdminUpload" id="caAdminUpload"  style="display:none" />
					</form>
					<input type="btn" readonly="readonly" id="modelUpload" class="caMenuBtn"  style="width:100%;" value="<?php arClass::msg(13);?>" onClick="caOpt.settings(this);" />
					<div style="height:11px;width:182px;margin-top:-5px;margin-bottom:5px"><img id="uploadAnim" style="display:none" src="<?php print_r($p.'/assets/img/caUploadStripe.gif');?>" /></div>
					<input type="btn" readonly="readonly" id="modelMedia" class="caMenuBtn"  style="width:100%;" value="<?php arClass::msg(16);?>" onClick="caOpt.settings(this);" />
					<div class="caCol" style="width:280px">
						<label class="caLabel" id="caObjName" style="width:100%;background-color:#f1f1f1;text-align:center;color:#777777;overflow:hidden;font-size:12px"></label>
					</div>					
					<hr class="caHR">
					<div class="caCol">
						<label class="caLabel"><?php arClass::msg(14);?></label><input class="caTxtInputWin" id="modelSizeTxt" type="text" placeholder="..." onkeydown="return caOpt.numKey(event);" onInput="caOpt.settings(this);" />
					</div>
					<input type="range" id="modelSizeSlide" min="0" max="50" step="0.1" value="0" class="caRange" style="width:100%;" onInput="caOpt.settings(this);" />
					<hr class="caHR">
					<div class="caCol">
						<label class="caLabel"><?php arClass::msg(15);?></label><input class="caTxtInputWin" id="modelPosYTxt" type="text" placeholder="..." onkeydown="return caOpt.numKey(event);" onInput="caOpt.settings(this);" />
					</div>
					<input type="range" id="modelPosYSlide" min="-25" max="25" step="0.5" value="0" class="caRange" style="width:100%;" onInput="caOpt.settings(this);" />
					<hr class="caHR">
					<div class="caCol">
						<label class="caLabel"><?php arClass::msg(61);?></label><input value="0" class="caTxtInputWin" id="caBright_txt" type="text" placeholder="..." onkeydown="return caOpt.numKey(event);" onInput="caOpt.settings(this);" />
					</div>
					<input type="range" id="caBright" min="0" max="4" step="0.05" value="0" class="caRange" style="width:100%;" onInput="caOpt.settings(this);" />
					<hr class="caHR">
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(23);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="autoRotaionSwitch" onChange="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>
					</div>				
				</div>
				<div class="caMenuBox" id="caWinSetDiv">
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(2);?></label><input class="caTxtInputWin" id="caWindowWidth" type="text" placeholder="..." onkeydown="return caOpt.numKey(event);" onChange="caOpt.settings(this);" />
					</div>
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(1);?></label><input class="caTxtInputWin" id="caWindowHeight" type="text" placeholder="..." onkeydown="return caOpt.numKey(event);" onChange="caOpt.settings(this);" />
					</div>
					<hr class="caHR">
					<div class="caColBg">
						<label class="caLabel"><?php arClass::msg(3);?></label><div class="caInputBg"><input type="text" id="caBgmCol" /></div>
					</div>
					<hr class="caHR">
					<div class="caColBg">
						<label class="caLabel"><?php arClass::msg(4);?></label><img class="caInputBg" id="caBgmImg" onClick="caOpt.settings(this);" />
					</div>
					<hr class="caHR">
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(5);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="backSwitch" onChange="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>
					</div>
					<hr class="caHR">
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(40);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="caCamPan" onChange="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>
					</div>
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(41);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="caCamLock" onChange="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>
					</div>
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(42);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="dampingSwitch" onInput="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>
					</div>					
				</div>				
				<div class="caMenuBox" id="caButSetDiv">
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(17);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="btnSwitchFull" onChange="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>		
					</div>
					<hr class="caHR">
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(18);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="btnSwitchRotation" onChange="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>
					</div>
					<hr class="caHR">
					<div class="caColSm">
						<label class="caLabel"><?php arClass::msg(39);?></label>
						<div class="caTxtInputWin">
							<label class="switch">
							<input type="checkbox" id="btnSwitchWireframe" onChange="caOpt.settings(this);" />
							<span class="slider"></span>
							</label>
						</div>
					</div>							
				</div>
				<input type="btn" readonly="readonly" id="saveModelEntry" class="caMenuBtn"  style="position:absolute; width:182px; top:640px;left:6px;" value="<?php arClass::msg(9);?>" onClick="caOpt.settings(this);" />
			</div>
		</div>
		<div class="caBottom" style="width:100%;margin-top:4px;">
			<table style="width:100%">
				<tBody>
					<tr>
						<td style="width:38px;">
							<input type="btn" readonly="readonly" class="caMenuBtn" title="Support" style="height:34px; width:34px; font-size:27px; padding:3px; text-align:center;" id="caSupport" value="?" onClick="caOpt.settings(this);" />
						</td>
						<td id="tdUpdate">
							<input type="btn" readonly="readonly" class="caMenuBtn" title="An update is available!" style="height:34px; width:72px; font-size:17px; padding:3px; text-align:center; display:none" id="caGetUpdate" value="Update" onClick="caOpt.settings(this);" />
						</td>
						<td>
							<div class="caMsg" id="caMsg"></div>
						</td>
					</tr>
				</tBody>
			</table>
		</div>
		</div>
		<script>
			var caOpt = {
				lastMenuID:'',
				initFlag:false,
				caMedia:null,
				attachment:null,
				selectEntryID:-1,
				newEntryFlag:false,
				tempEntry:[],
				toggleMenuFlag:false,
				optionMenu:false,
				saveInfoFlag:false,
				tempCopy:undefined,
				selectName:'',
				supToggle:false,
				checkItFlag:false,
				caID:null
			}			
			//
			caOpt.numKey=function(_e){
				if (_e){
					var cC = (_e.which) ? _e.which : _e.numKeyCode; if(cC==13 || cC==16) return false;
					if (cC!=80 && cC!=88 && cC != 190 && cC != 173 && cC > 31 && (cC < 48 || cC > 57) && (cC < 96 || cC > 105) &&(cC < 37 || cC > 40) && cC != 110 && cC != 8 && cC != 46 && cC != 189 && cC != 109) {
						return false;
					} else {
						return true;
					}
				}
			}
			//
			jQuery(document).ready(function($){
				$(".caTxtInputWin").focus(function(){$(this).select();});
				$(".caTxtInputField").focus(function(){$(this).select();});
				$('.handlediv').click(function(){caAR.jQuery('resizeCanvas', 0);});
				$('#deleteModelEntry').mousedown(function(){var w=0;$('#delBar').css('width:0px');caOpt.delHold=setInterval(function(){w=w+3;$('#delBar').css('width',w+'px');if(w>=140){w=0;$('#delBar').css('width',w+'px');caAR.phpConnect('deleteEntry',null,caOpt.selectEntryID);clearInterval(caOpt.delHold);}},10);}).mouseup(function(){clearInterval(caOpt.delHold);$('#delBar').css('width','0px');});
				//
				if(caOpt.backSwitch!='pageEdit'){
					document.getElementById('caWrap').className="wrap";
				}				
				//
				$('input[type=file]').on('change', function(_e){
					var z='',fd=new FormData(),ty = '',tmp=[],uploadType='model',data='',i,t,ID="<?php get_the_ID();?>";
					z=$('#caAdminUpload')[0].files[0];fd.append('userfile', $('#caAdminUpload')[0].files[0]);
					//
					$('#modelUpload').prop("disabled", true); $("#caAdminUpload").val('');
					caAR.jQuery('sendMsg',0,'<?php arClass::msg(24);?>');$('#uploadAnim').css('display','inline-block');
					//
					$.ajax({
						url:caAR.path+'/caData.inc.php?set=3GhaOsT7&uploadType=model&post_ID='+ID,
						data: fd,
						processData:false,
						contentType:false,
						type:'POST',
						success:function (_data){
							$('#modelUpload').prop("disabled", false);data=_data.split('|#|');$('#uploadAnim').css('display','none');
							if(data!="NoTypeMatch"){
								i=caAR.upPath.length-1; t=caAR.upPath.charAt(i);
								if(t!='/'){
									caAR.entryData[0].modelURL=caAR.upPath+'/'+data[0];
									caOpt.tempEntry.modelURL=caAR.upPath+'/'+data[0];
								}else{
									caAR.entryData[0].modelURL=caAR.upPath+data[0];
									caOpt.tempEntry.modelURL=caAR.upPath+data[0];
								}
								caAR.jQuery('sendMsg',0,'<?php arClass::msg(25);?>');caAR.modelLoad(0);caOpt.saveInfoOn(true);
							}else{
								caAR.jQuery('sendMsg',0,'Upload Error! No 3D-Model Data found in: ' + z.name);
							}
						},error:function(_e){
							$('#modelUpload').prop("disabled", false);
							$('#uploadAnim').css('display','none');
							caAR.jQuery('sendMsg',0,'Upload Error: ' + _e);
						}
					});							
					//
				});				
				//
				caOpt.delteOption=function(){
					$("#dataList option[value='"+caOpt.selectEntryID+"']").remove(); caOpt.selectEntryID=-1;
					caAR.phpConnect('getListEntry',undefined,caOpt.selectEntryID,0); caOpt.menuToggle();
				}
				//
				caOpt.saveInfoOn=function(_flag){
					//
					if(!caOpt.saveInfoFlag && _flag){
						caOpt.saveInfoFlag=true; $("#caDatSet").toggleClass('caMenuIcon caMenuIconInfo');
						$("#saveModelEntry").toggleClass('caMenuBtn caMenuBtnInfo');
					}
					//
					if(caOpt.saveInfoFlag && !_flag){
						caOpt.saveInfoFlag=false; $("#caDatSet").toggleClass('caMenuIcon caMenuIconInfo'); 
						$("#saveModelEntry").toggleClass('caMenuBtn caMenuBtnInfo');
					}			
				}
				//
				caOpt.settings=function(_this,_val){
					var end='',val='',name='';
					//
					switch(_this.id){
						case 'caGetUpdate':
							val=caOpt.caID;
							if(val != '' && val.length == 19){
								caAR.phpConnect('requestKey',val);
							}						
						break;
						case 'caSendKey':
							val=$('#caKey').val();
							if(val != '' && val.length == 19){
								caAR.phpConnect('requestKey',val);
							}
						break;
						case 'caContact':
							window.open('https://www.canvasio3d.com/support/', '_blank');
						break;
						case 'caSupport':
							if(!caOpt.supToggle){
								$('#supportPage').css('display','block'); caOpt.supToggle=true;
								$('#caSupport').val('▼');
								$('#caSupport').css('color','#063250');
								$('#caOptionsDiv').css('display','none');
							}else{
								$('#supportPage').css('display','none'); caOpt.supToggle=false;
								$('#caSupport').val('?');
								$('#caSupport').css('color','#f6f6f6');
								$('#caOptionsDiv').css('display','block');
							}
						break;
						case 'dataListVal':
							caOpt.tempEntry.name=_this.value;
							//
							if(_this.value!=caOpt.selectName){
								caOpt.saveInfoOn(true);
							}
							//
							$("#dataList option[value='"+caOpt.selectEntryID+"']").attr('name',caOpt.tempEntry.name);
							$("#dataList option[value='"+caOpt.selectEntryID+"']").html(caOpt.tempEntry.name);
						break;
						case 'dataList':
							val=$(_this).children(':selected').attr('value');
							name=$(_this).children(':selected').attr('name');
							//
							caOpt.selectName=name; caOpt.saveInfoOn(false);
							//
							if(!caOpt.newEntryFlag)caOpt.newEntryFlag=true;
							//
							if(caOpt.selectEntryID != val){
								$('#dataListVal').val(name); caOpt.selectEntryID=val;
								caAR.phpConnect('getListEntry',undefined,caOpt.selectEntryID,0);					
							}
							//
							_this.getElementsByTagName('option')[0].selected='selected';
						break;
						case 'btnSwitchFull':
							caAR.setBtnFullscreen(0,_this.checked);
							caOpt.tempEntry.buttonOBJ.fullscreen=_this.checked;
							caOpt.saveInfoOn(true);
						break;
						case 'btnSwitchRotation':
							caAR.setBtnRotate(0,_this.checked);
							caOpt.tempEntry.buttonOBJ.rotate=_this.checked;
							caOpt.saveInfoOn(true);
						break;
						case 'btnSwitchWireframe':
							caAR.setBtnWireframe(0,_this.checked);
							caOpt.tempEntry.buttonOBJ.wireframe=_this.checked;
							caOpt.saveInfoOn(true);
						break;						
						case 'autoRotaionSwitch':
							caAR.setAutoRotate(0,_this.checked);
							caOpt.tempEntry.autoRotate=_this.checked;
							caOpt.saveInfoOn(true);
						break;
						case 'dampingSwitch':
							caAR.setDamping(0,_this.checked);
							caOpt.tempEntry.damping=_this.checked;
							caOpt.saveInfoOn(true);
						break;						
						case 'modelSizeTxt':
							caAR.setScale(0,_this.value); $('#modelSizeSlide').val(_this.value);
							caOpt.tempEntry.modelScale=_this.value;
							caOpt.saveInfoOn(true);
						break;
						case 'modelSizeSlide':
							caAR.setScale(0,_this.value); $('#modelSizeTxt').val(_this.value);
							caOpt.tempEntry.modelScale=_this.value;
							caOpt.saveInfoOn(true);
						break;						
						case 'modelPosYTxt':
							caAR.setPosY(0,_this.value); $('#modelPosYSlide').val(_this.value);
							caOpt.tempEntry.modelPosY=_this.value;
							caOpt.saveInfoOn(true);
						break;
						case 'modelPosYSlide':
							caAR.setPosY(0,_this.value); $('#modelPosYTxt').val(_this.value);
							caOpt.tempEntry.modelPosY=_this.value;
							caOpt.saveInfoOn(true);
						break;											
						case 'modelUpload':
							if($('#modelUpload').prop("disabled")==false){
								$('#caAdminUpload').trigger('click');
							}		
						break;
						case 'caBright_txt':
							$('#caBright').val(_this.value); caOpt.saveInfoOn(true);
							caAR.lightSettings(0,0,_this.value);
							caOpt.tempEntry.bright=_this.value;
						break;
						case 'caBright':
							$('#caBright_txt').val(_this.value); caOpt.saveInfoOn(true);
							caAR.lightSettings(0,0,_this.value);
							caOpt.tempEntry.bright=_this.value;
						break;										
						case 'modelMedia':
							if (typeof wp !== 'undefined' && wp.media && wp.media.editor){
								caOpt.caMedia=wp.media({library:{type:'mesh'}}).on('select', function(){
									caOpt.attachment=caOpt.caMedia.state().get('selection').first().toJSON();
									if(caOpt.attachment.url){
										caOpt.saveInfoOn(true);
										caOpt.tempEntry.modelURL=caOpt.attachment.url;
										caAR.entryData[0].modelURL=caOpt.attachment.url;
										name=caOpt.tempEntry.modelURL.split('/');$('#caObjName').html(name[name.length-1]);
										caAR.jQuery('sendMsg',0,'<?php arClass::msg(27);?>');caAR.modelLoad(0);								
									}
								}).open();
							}else{
								$('#caBgmImg').attr("src", undefined);
								caAR.jQuery('sendMsg',0,'<?php arClass::msg(28);?>');
							}							
						break;
						case 'pasteModelEntry':
							caOpt.tempEntry = caOpt.tempCopy;
							caOpt.setupEntry(JSON.stringify(caOpt.tempCopy)+'||'+caOpt.selectEntryID);
						break;						
						case 'copyModelEntry':
							caOpt.tempCopy = caOpt.tempEntry;
							caOpt.menuToggle();
						break;		
						case 'newModelEntry':
							caOpt.saveInfoOn(false);
							caOpt.newEntryFlag=false;
							caAR.phpConnect('getNewEntry');
						break;
						case 'deleteModelEntry':
							caAR.phpConnect('deleteEntry',null, caOpt.selectEntryID);
						break;
						case 'saveModelEntry':
							caOpt.saveInfoOn(false);
							//
							caOpt.tempEntry.threeOK=false;caOpt.tempEntry.active=false;caOpt.tempEntry.loaded=false;val=JSON.stringify(caOpt.tempEntry);
							caOpt.tempEntry.threeOK=true;caOpt.tempEntry.active=true;caOpt.tempEntry.loaded=true;
							caAR.phpConnect('saveEntry', unescape(val), caOpt.selectEntryID);
						break;
						case 'caWindowWidth':
							val=_this.value.search('px'); if(val==-1)val=_this.value.search('%'); if(val==-1)_this.value=_this.value+'px';
							caOpt.tempEntry.windowWidth=_this.value;
							caOpt.saveInfoOn(true);
						break;
						case 'caWindowHeight':
							val=_this.value.search('px'); if(val==-1)val=_this.value.search('%'); if(val==-1)_this.value=_this.value+'px';
							caOpt.tempEntry.windowHeight=_this.value;
							caOpt.saveInfoOn(true);
						break;							
						case 'caBgmImg':
							if (typeof wp !== 'undefined' && wp.media && wp.media.editor){
								caOpt.caMedia=wp.media({library:{type:'image'}}).on('select', function(){
									caOpt.attachment=caOpt.caMedia.state().get('selection').first().toJSON();
									if(caOpt.attachment.url){
										caAR.debug('DEBUG IMAGE: ' + caOpt.attachment.url);
										caOpt.saveInfoOn(true);
										$("#caBgmImg").attr("src", caOpt.attachment.url);caAR.newSizeOn[0]=true;
										caOpt.tempEntry.imageURL=caOpt.attachment.url;
										caAR.setBackground(caOpt.tempEntry.backGround,0,caOpt.tempEntry.imageURL,caOpt.tempEntry.backColor);
									}
								}).open();
							}else{
								$('#caBgmImg').attr("src", undefined);
								caOpt.tempEntry.imageURL='';
							}
						break;
						case 'backSwitch':
							caOpt.saveInfoOn(true);
							if(_this.checked){
								caOpt.tempEntry.backGround='img';
							}else{
								caOpt.tempEntry.backGround='col';
							}
							//
							caAR.setBackground(caOpt.tempEntry.backGround,0,caOpt.tempEntry.imageURL, caOpt.tempEntry.backColor);
						break;
						case 'caCamPan':
							caOpt.saveInfoOn(true);
							caOpt.tempEntry.caCamPan=_this.checked;
							caAR.cam('pan',0,_this.checked);
						break;
						case 'caCamLock':
							caOpt.saveInfoOn(true);
							caOpt.tempEntry.caCamLock=_this.checked;
							caAR.cam('lock',0,_this.checked);
						break;								
					}
				}
				//
				caOpt.menuToggle=function(){
					//
					if(!caOpt.tempCopy){
						$('#pasteModelEntry').prop("disabled", true);
						$('#pasteModelEntry').css('pointer-events','none');
					}else{
						$('#pasteModelEntry').prop("disabled", false);
						$('#pasteModelEntry').css('pointer-events','auto');
					}
					//
					if(!caOpt.selectEntryID || caOpt.selectEntryID==-1){
						if(caOpt.toggleMenuFlag){
							$("#caModSet").toggleClass('caMenuIcon caMenuIconOff');
							$("#caWinSet").toggleClass('caMenuIcon caMenuIconOff');
							$("#caButSet").toggleClass('caMenuIcon caMenuIconOff');
							caOpt.toggleMenuFlag=false;
						}
						//
						$('#caDatSetDiv').css('display','block'); $('#caDatSet').css('border-top','2px solid #000');
						$('#caModSetDiv').css('display','none');
						$('#caWinSetDiv').css('display','none');
						$('#caButSetDiv').css('display','none');
						//
						$('#caShortCode').prop("disabled", true); $('#caShortCode').css('pointer-events','none');
						$('#copyModelEntry').prop("disabled", true); $('#copyModelEntry').css('pointer-events','none');
						$('#deleteModelEntry').prop("disabled", true); $('#deleteModelEntry').css('pointer-events','none');
						$('#saveModelEntry').prop("disabled", true); $('#saveModelEntry').css('pointer-events','none');
						//
						$('#dataListVal').css('display','none');
						$('#caShortCode').html('');
						//
						caAR.phpConnect('getList');
					}else{
						if(!caOpt.toggleMenuFlag){
							$("#caModSet").toggleClass('caMenuIcon caMenuIconOff');
							$("#caWinSet").toggleClass('caMenuIcon caMenuIconOff');
							$("#caButSet").toggleClass('caMenuIcon caMenuIconOff');
							caOpt.toggleMenuFlag=true;
						}
						//
						$('#dataListVal').css('display','block');
						//
						$('#caShortCode').prop("disabled", false); $('#caShortCode').css('pointer-events','auto');
						$('#copyModelEntry').prop("disabled", false); $('#copyModelEntry').css('pointer-events','auto');
						$('#deleteModelEntry').prop("disabled", false); $('#deleteModelEntry').css('pointer-events','auto');
						$('#saveModelEntry').prop("disabled", false); $('#saveModelEntry').css('pointer-events','auto');	
					}
				}
				//
				caOpt.saveInfo=function(_back){
					var temp='';
					try{
						temp=JSON.parse(_back);
						//
						if(temp.info=='insert'){
							caAR.jQuery('sendMsg',0,'<?php arClass::msg(30);?>');
							temp = String($('#dataListVal').val());		
							$('#dataList').append(`<option value="${caOpt.selectEntryID}" name="${temp}">${temp}</option>`);
							$('#caShortCode').html('[Canvasio3D Scene='+caOpt.selectEntryID+']');
						}else if(temp.info=='update'){
							caAR.jQuery('sendMsg',0,'<?php arClass::msg(29);?>');
						}
					}catch(_e){
						caAR.jQuery('sendMsg',0,'<?php arClass::msg(31);?>' + ' - '+_e);
					}
				}
				//
				caOpt.setupEntry=function(_back){
					var temp = _back.split('||'),modURL='';
					caOpt.tempEntry=JSON.parse(temp[0]);modURL=caOpt.tempEntry.modelURL.split('/');$('#caObjName').html(modURL[modURL.length-1]);
					caAR.entryData[0]=caOpt.tempEntry; caOpt.selectEntryID=temp[1];
					//
					$('#caBright').val(caOpt.tempEntry.bright);
					$('#caBright_txt').val(caOpt.tempEntry.bright);		
					//
					$('#caBgmCol').spectrum({
						color:caOpt.tempEntry.backColor, showButtons:false, preferredFormat:"hex", showInput:true,
						change:function(_color){
							caOpt.tempEntry.backColor=String(_color); caOpt.saveInfoOn(true);
							caAR.setBackground(caOpt.tempEntry.backGround,0,caOpt.tempEntry.imageURL, caOpt.tempEntry.backColor);
						},
						move:function(_color){
							caOpt.tempEntry.backColor=String(_color); caOpt.saveInfoOn(true);
							caAR.setBackground(caOpt.tempEntry.backGround,0,caOpt.tempEntry.imageURL, caOpt.tempEntry.backColor);
						}
					});
					//
					if(caOpt.tempEntry.backGround=='col'){
						$('#backSwitch').prop('checked', false);
					}else{
						$('#backSwitch').prop('checked', true);
					}
					//
					$('#caCamPan').prop('checked', caOpt.tempEntry.caCamPan);
					$('#caCamLock').prop('checked', caOpt.tempEntry.caCamLock);
					//
					$('#caWindowWidth').val(caOpt.tempEntry.windowWidth);
					$('#caWindowHeight').val(caOpt.tempEntry.windowHeight);					
					$('#modelSizeTxt').val(caOpt.tempEntry.modelScale);
					$('#modelPosYTxt').val(caOpt.tempEntry.modelPosY);
					$('#modelSizeSlide').val(caOpt.tempEntry.modelScale);
					$('#modelPosYSlide').val(caOpt.tempEntry.modelPosY);
					//
					$('#btnSwitchFull').prop('checked', caOpt.tempEntry.buttonOBJ.fullscreen);
					$('#btnSwitchRotation').prop('checked', caOpt.tempEntry.buttonOBJ.rotate);
					$('#btnSwitchWireframe').prop('checked', caOpt.tempEntry.buttonOBJ.wireframe);
					$('#autoRotaionSwitch').prop('checked', caOpt.tempEntry.autoRotate);
					if(caOpt.tempEntry.damping==undefined)caOpt.tempEntry.damping=false;
					$('#dampingSwitch').prop('checked',caOpt.tempEntry.damping); 					
					//
					caAR.setBackground(caOpt.tempEntry.backGround,0,caOpt.tempEntry.imageURL, caOpt.tempEntry.backColor);
					caAR.setBtnFullscreen(0,caOpt.tempEntry.buttonOBJ.fullscreen);
					caAR.setBtnWireframe(0,caOpt.tempEntry.buttonOBJ.wireframe);
					caAR.setBtnRotate(0,caOpt.tempEntry.buttonOBJ.rotate);
					//
					if(caOpt.tempEntry.imageURL.length>3){
						caOpt.tempEntry.imageURL=caOpt.tempEntry.imageURL.split('plugins/Canvasio3D').join('plugins/canvasio3d-light');
						$('#caBgmImg').prop("src", caOpt.tempEntry.imageURL);
					}else{
						$('#caBgmImg').attr("src",undefined);
					}
					//
					if(!caOpt.newEntryFlag){
						caOpt.newEntryFlag=true;
						caOpt.tempEntry.name=caOpt.tempEntry.name+'#'+caOpt.selectEntryID
						$('#dataListVal').val(caOpt.tempEntry.name);
						$('#caShortCode').html('');
					}else{
						$('#dataListVal').val(caOpt.tempEntry.name);
						$('#caShortCode').html('[Canvasio3D Scene='+caOpt.selectEntryID+']');
					}
					//
					caOpt.menuToggle();
					caAR.entryData[0].threeOK=true; caAR.modelLoad(0);
				}
				//
				caOpt.showList=function(_back){
					var temp='',tempName='',entry=_back.split('#|#'),count=entry.length-1; $('#dataListVal').css('display','none');
					//
					if(count>0){
						$('#dataList').empty();
						tempName="<?php arClass::msg(10);?>";
						$('#dataList').append(`<option value="-1" name="${tempName}">${tempName}</option>`);
						//
						for(var i=0;i<count;i++){
							temp=JSON.parse(entry[i]); if(i==0)$('#dataListVal').val(temp.name);
							$('#dataList').append(`<option value="${temp.id}" name="${temp.name}">${temp.name}</option>`);
						}
					}else{
						caAR.debug('No entry found!');
					}
				}						
				//
				if(!caOpt.initFlag){
					caOpt.initFlag=true; caOpt.menuToggle();
				}
				//
				caOpt.menuSelect=function(_this){
					switch(_this.id){
						case 'caDatSet':
							$('#caDatSetDiv').css('display','block'); $('#caDatSet').css('border-top','2px solid #000');
							$('#caModSetDiv').css('display','none'); $('#caModSet').css('border-top','2px solid #f6f6f6');
							$('#caWinSetDiv').css('display','none'); $('#caWinSet').css('border-top','2px solid #f6f6f6');
							$('#caButSetDiv').css('display','none'); $('#caButSet').css('border-top','2px solid #f6f6f6');
							$('#caModMatDiv').css('display','none');
							$('#caModIntDiv').css('display','none');
							$('#caModEnvDiv').css('display','none');														
						break;						
						case 'caWinSet':
							$('#caDatSetDiv').css('display','none'); $('#caDatSet').css('border-top','2px solid #f6f6f6');
							$('#caModSetDiv').css('display','none'); $('#caModSet').css('border-top','2px solid #f6f6f6');
							$('#caWinSetDiv').css('display','block'); $('#caWinSet').css('border-top','2px solid #000');
							$('#caButSetDiv').css('display','none'); $('#caButSet').css('border-top','2px solid #f6f6f6');
							$('#caModMatDiv').css('display','none');
							$('#caModIntDiv').css('display','none');
							$('#caModEnvDiv').css('display','none');						
						break;
						case 'caModSet':
							$('#caDatSetDiv').css('display','none'); $('#caDatSet').css('border-top','2px solid #f6f6f6');
							$('#caModSetDiv').css('display','block'); $('#caModSet').css('border-top','2px solid #000');
							$('#caWinSetDiv').css('display','none'); $('#caWinSet').css('border-top','2px solid #f6f6f6');
							$('#caButSetDiv').css('display','none'); $('#caButSet').css('border-top','2px solid #f6f6f6');
							$('#caModMatDiv').css('display','none');
							$('#caModIntDiv').css('display','none');
							$('#caModEnvDiv').css('display','none');											
						break;
						case 'caButSet':
							$('#caDatSetDiv').css('display','none'); $('#caDatSet').css('border-top','2px solid #f6f6f6');
							$('#caModSetDiv').css('display','none'); $('#caModSet').css('border-top','2px solid #f6f6f6');
							$('#caWinSetDiv').css('display','none'); $('#caWinSet').css('border-top','2px solid #f6f6f6');
							$('#caWinSetDiv').css('display','none'); $('#caDatSet').css('border-top','2px solid #f6f6f6');
							$('#caButSetDiv').css('display','block'); $('#caButSet').css('border-top','2px solid #000');
							$('#caModMatDiv').css('display','none');
							$('#caModIntDiv').css('display','none');
							$('#caModEnvDiv').css('display','none');													
						break;
						case 'caShcSet':
							$('#caDatSetDiv').css('display','none');
							$('#caModSetDiv').css('display','none');
							$('#caWinSetDiv').css('display','none');
							$('#caButSetDiv').css('display','none');
							$('#caShcSetDiv').css('display','block');
							$('#caModMatDiv').css('display','none');
							$('#caModIntDiv').css('display','none');
							$('#caModEnvDiv').css('display','none');												
						break;																				
					}
				}
			});
			//
			if(!caOpt.checkItFlag){
				caOpt.checkItFlag=true; caOpt.caID='<?php print_r(get_option('canvasio3D_ID'));?>';
				caAR.phpConnect('checkUpdate',caOpt.caID);
			}			
		</script>
		<?php
	}
	//
	public static function load_plugin_textdomain($plugin_name, $domain){
		$locale=apply_filters('plugin_locale', determine_locale(), $domain); $mofile=$domain.'-'.$locale.'.mo';
		if(load_textdomain($domain, WP_PLUGIN_DIR.'/'.$plugin_name.'/inc/languages/'.$mofile)){return true;}
		return false;
	}
	//
	public function caARConnect(){
		global $wpdb, $woocommerce, $product, $current_user; $_X=$_REQUEST['setTo'];$_cmd=$_REQUEST['cmd']; $_val=$_REQUEST['val']; $_id=$_REQUEST['id']; $temp=''; $i=0; $out=null; if($_X!='77-pZxT')return;
		//
		switch ($_cmd){
			case 'checkUpdate':
				$out=arClass::checkUpdate($_val);
			break;
			case 'requestKey':
				$out=arClass::checkIt($_val);
			break;
			case 'setWindow':
				$out=arClass::DB_Get($_val, $_id);
			break;			
			case 'getList':
				$out=arClass::DB_Get_List();
			break;
			case 'getListEntry':
				$out=arClass::DB_Get($_val, $_id);
			break;
			case 'getEntry':
				$out=arClass::DB_Get($_val, $_id);
			break;
			case 'getNewEntry':
				$newID=arClass::DB_Get_ID(); $out=arClass::DB_New().'||'.$newID;
			break;
			case 'saveEntry':
				$out=arClass::DB_Save($_id, $_val);
			break;			
			case 'deleteEntry':
				$out=arClass::DB_Delete($_id);
			break;
		}
		//
		print_r($out.'#');
	}
	//
	function checkUpdate($_val){
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' ); if(!is_user_logged_in())return;
		//
		if(arClass::$pluginName=='Canvasio3D Light'){
			$request=curl_init('https://www.canvasio3d.com/caLine/?caID='.md5($_val).'&caV=0.0.1&caURL='.arClass::$caURL);$light=true;
		}else{
			$request=curl_init('https://www.canvasio3d.com/caLine/?caID='.md5($_val).'&caV='.arClass::$version.'&caURL='.arClass::$caURL);$light=false;
		}
		//
		curl_setopt($request,CURLOPT_POST, true);
		curl_setopt($request,CURLOPT_POSTFIELDS,array('file' => '@'.realpath('Canvasio3D.zip')));
		curl_setopt($request,CURLOPT_RETURNTRANSFER, true);
		$curlBack=curl_exec($request); curl_close($request);
		//
		if($curlBack){
			print_r('New Update!');
		}
	}
	//
	function checkIt($_val){
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' ); if(!is_user_logged_in())return;
		//
		if(arClass::$pluginName=='Canvasio3D Light'){
			$request=curl_init('https://www.canvasio3d.com/caLine/?caID='.md5($_val).'&caV=0.0.1&caURL='.arClass::$caURL);$light=true;
		}else{
			$request=curl_init('https://www.canvasio3d.com/caLine/?caID='.md5($_val).'&caV='.arClass::$version.'&caURL='.arClass::$caURL);$light=false;
		}
		//
		curl_setopt($request,CURLOPT_POST, true);
		curl_setopt($request,CURLOPT_POSTFIELDS,array('file' => '@'.realpath('Canvasio3D.zip')));
		curl_setopt($request,CURLOPT_RETURNTRANSFER, true);
		$curlBack=curl_exec($request); curl_close($request);
		//
		if($curlBack){
			//
			arClass::msg(38);
			//
			$zipFile=arClass::$pluginsDir.'/Canvasio3D.zip';
			$fo=fopen($zipFile, "a");
			$write=fputs($fo, $curlBack);
			fclose($fo);
			//
			$unZip=arClass::$pluginsDir.'/Canvasio3D';
			$zip=new ZipArchive;
			$res=$zip->open($zipFile);
			//
			if ($res===true) {
				$zip->extractTo($unZip);
				$zip->close();
				unlink($zipFile);
				//
				if (file_exists(arClass::$pluginsDir.'/canvasio3d-light')) {
					deactivate_plugins('canvasio3d-light/canvasio3D.php');
					$dir=arClass::$pluginsDir.'/canvasio3d-light';
					//
					WP_Filesystem();
					global $wp_filesystem;
					$wp_filesystem->rmdir($dir, true);
				}
				//
				if (file_exists(arClass::$pluginsDir.'/canvasio3d-light-1')) {
					deactivate_plugins('canvasio3d-light/canvasio3D.php');
					$dir=arClass::$pluginsDir.'/canvasio3d-light-1';
					//
					WP_Filesystem();
					global $wp_filesystem;
					$wp_filesystem->rmdir($dir, true);
				}				
				//
				update_option('canvasio3D_ID',$_val);
				//
				print_r('updateOK');
			} else {
				print_r('zip file error');
			}		
			//
		}else{
			print_r('false key');
		}
	}	
	//
	function DB_Get($_name, $_id){
		global $wpdb; $out=null; $temp=null; $table_name=$wpdb->prefix."ca3D_Model";
		//
		if($_id=='' || $_id==null){
			if($_name && $_name!=''){
				$temp=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE name='".$_name."'", ARRAY_A);
			}
		}else{
			$temp=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE ID='".$_id."'", ARRAY_A);
		}
		//
		if (sizeof($temp) > 0){
			foreach($temp as $r){$out = $r['data'];}
		}else{
			$out=arClass::DB_Defaults();
		} 
		//
		//$out=str_replace("canvasio3d-light","Canvasio3D",$out);
		return arClass::crypt($out).'||'.$_id;
	}
	//
	function crypt($str){
		$str_out=$str;
		//$str_out=str_replace("w","x",$str);
		//$str_out=str_replace("e","w",$str);
		//$str_out=str_replace("a","t",$str);
		//$str_out=str_replace("http://","uppa~",$str);
		//$str_out=str_replace("https://","ups~",$str);
		return ($str_out);
	}
	//
	function DB_Get_List(){
		global $wpdb; $table_name=$wpdb->prefix."ca3D_Model"; $temp='';
		$result=$wpdb->get_results("SELECT * FROM ".$table_name, ARRAY_A); $i=sizeof($result); sort($result);
		//
		if($i>0){
			for($t=$i-1;$t>-1;$t--){
				$id=json_decode($result[$t]['id'],true);
				$data=json_decode($result[$t]['data'],true);
				$entry='{"id":"'.$id.'","name":"'.$data['name'].'"}#|#';
				$out=$out.$entry;
			}			
		}else{
			$out=null;
		}
		//
		return $out;
	}
	//
	function DB_Get_ID(){
		global $wpdb; $table_name=$wpdb->prefix."ca3D_Model";$id=0;
		$result=$wpdb->get_results("SELECT `id` FROM ".$table_name, ARRAY_A);
		foreach($result as $r){if((int)$r['id']>$id){$id=(int)$r['id'];}}
		$id++;return $id;
	}
	//
	function DB_Insert($_name, $_id){
		global $wpdb; $date=new DateTime(); $table_name=$wpdb->prefix."ca3D_Model"; if(!is_user_logged_in())return;
		if(!current_user_can('edit_posts')){$info='{"info":"access denied","id":"'.$_id.'"}';return;};
		$result=$wpdb->get_results("SELECT * FROM ".$table_name, ARRAY_A); $i=sizeof($result); $new=arClass::DB_New();
		//
		if($_name=='' || $_name==null){
			//
			$row=$wpdb->insert($table_name, array(
				'ID' => 'PRIMARY KEY',
				'name' => 'New Model#'.$i,
				'data' => $new,
				'time' => $date->getTimestamp()
				)
			);
			//
			return 'New Model#'.$i.'#';
		}else{
			//
			$row=$wpdb->insert($table_name, array(
				'ID'=>$i,
				'name' => $_name,
				'data' => $new,
				'time' => $date->getTimestamp()
				)
			);			
			//
			return $_name.'#';
		}
	}
	//
	function DB_Save($_id, $data){
		global $wpdb; $date=date("Y-m-d"); $table_name=$wpdb->prefix."ca3D_Model"; if(!is_user_logged_in())return;
		if(!current_user_can('edit_posts')){$info='{"info":"access denied","id":"'.$_id.'"}';return;};
		//
		$result=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE id="."'".$_id."'" , ARRAY_A); $i=sizeof($result);
		//
		$d=str_replace('\"','"', $data); $info=null;
		//
		if($i==0){
			$wpdb->insert($table_name, array(
				'data' => $d,
				'time' => $date)
			);
			$info='{"info":"insert","id":"'.$wpdb->insert_id.'"}';
		}else{
			$wpdb->update($table_name, array(
				'data' => $d,
				'time' => $date
				),
				array('id'=>$_id)
			);
			$info='{"info":"update","id":"'.$_id.'"}';
		}
		//
		return $info;
	}	
	//
	function DB_Delete($_id){
		global $wpdb; $table_name=$wpdb->prefix."ca3D_Model"; if(!is_user_logged_in())return; 
		if(!current_user_can('edit_posts')){$info='{"info":"access denied","id":"'.$_id.'"}';return;};
		$result=$wpdb->delete($table_name, array('id'=>$_id));
		return $result;
	}
	//
	private static function DB_Defaults(){
		$default='{"name":"Canvasio3D","threeOK":false,"windowWidth":"100%","windowHeight":"320px","active":false,"loaded":false,"backGround":"col","imageURL":"'.arClass::$path.'/assets/img/caPlaceholder.png","mapURL":"'.arClass::$path.'/assets/map/","backColor":"#ffffff","modelScale":"2","modelPosY":"0","modelURL":"'.arClass::$path.'/assets/model/canvasio3d.glb","animOn":true,"damping":true,"animType":2201,"animAuto":true,"waterOn":true,"waterHeight":-1,"caCamPan":false,"caCamLock":false,"shadowToggle":true,"autoRotate":true,"lightSet":"0","bright":3,"distance":0,"gamma":0,"cubeMap":"","cubeMapOn":false,"wooProdID":"0000","wooEnabled":false,"crystalOn":false,"crystal":"none","modelFunctionOBJ":{},"video":{"url":"","size":"1","posZ":"0","posY":"0","on":"false"},"textOBJ":{},"matOBJ":{},"effectOBJ":{},"soundOBJ":{},"buttonOBJ":{"upload":false,"fullscreen":true,"rotate":false,"play":false,"pause":false,"glasses":false,"back":false,"wireframe":false}}';
		return $default;
	}
	//
	private static function DB_New(){
		$default='{"name":"Canvasio3D","threeOK":false,"windowWidth":"1100px","windowHeight":"320px","active":false,"loaded":false,"backGround":"col","imageURL":"'.arClass::$path.'/assets/img/caPlaceholder.png","mapURL":"'.arClass::$path.'/assets/map/","backColor":"#d7d7d7","modelScale":"2","modelPosY":"0","modelURL":"'.arClass::$path.'/assets/model/canvasio3d.glb","animOn":false,"animType":2200,"damping":false,"animAuto":false,"waterOn":false,"waterHeight":-1,"caCamPan":false,"caCamLock":false,"shadowToggle":false,"autoRotate":false,"lightSet":"0","bright":"3","distance":0,"gamma":0,"cubeMap":"","cubeMapOn":false,"wooProdID":"0000","wooEnabled":false,"crystalOn":false,"crystal":"none","modelFunctionOBJ":{},"video":{"url":"","size":"1","posZ":"0","posY":"0","on":"false"},"textOBJ":{},"matOBJ":{},"effectOBJ":{},"soundOBJ":{},"buttonOBJ":{"upload":false,"fullscreen":true,"rotate":false,"play":false,"pause":false,"glasses":false,"back":false,"wireframe":false}}';
		return $default;
	}
	//
	function DB_SetUp($_flag){
		global $wpdb; $date=new DateTime(); $table_name=$wpdb->prefix."ca3D_Model"; if(!is_user_logged_in())return;
		//
		if($_flag){
			$sql="DROP TABLE IF EXISTS ".$table_name;
			$e=$wpdb->query($sql);
			//
			unset($existing_mimes['gltf']);
			unset($existing_mimes['glb']);
			unset($existing_mimes['mtl']);
			unset($existing_mimes['obj']);
			unset($existing_mimes['stl']);
		};
		//
		$sql="CREATE TABLE IF NOT EXISTS ".$table_name."( 
			`id` MEDIUMINT NOT NULL AUTO_INCREMENT,
			`name` TINYTEXT DEFAULT '',
			`data` TEXT DEFAULT '',
			`time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY `id` (`id`)
		);"; $checkDB=$wpdb->get_var($sql);
		//
		$result=$wpdb->get_results("SELECT * FROM ".$table_name, ARRAY_A);
		//
		if (sizeof($result) == 0){
			add_option('canvasio3D_ID','0000-0000-0000-0000');
		}
		//
	}
	//
	function initScript($p){
		?>
		<header>
		<link rel="stylesheet" type="text/css" href="<?php print_r($p.'/css/style.css?ver='.arClass::$ver);?>">
			<script type="text/javascript" src="<?php print_r($p.'/js/three.min.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/OrbitControls.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/Reflector.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/Refractor.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/Water2.js?ver='.arClass::$ver);?>"></script>			
			<script type="text/javascript" src="<?php print_r($p.'/js/fflate.min.js?ver='.arClass::$ver);?>"></script>	
			<script type="text/javascript" src="<?php print_r($p.'/js/GLTFLoader.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/FBXLoader.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/MTLLoader.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/OBJLoader.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/STLLoader.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/sp_min.js?ver='.arClass::$ver);?>"></script>
			<script type="text/javascript" src="<?php print_r($p.'/js/caAR.js?ver='.arClass::$ver);?>"></script>
		</header>
		<?php
	}
	//
	function initShortCode($atts){
		if(arClass::$arID==0){
			if(!is_admin()){wp_head();};arClass::initScript(arClass::$path);print_r('<script>caAR.init("'.arClass::$path.'","'.arClass::$upPath.'","'.admin_url('admin-ajax.php').'","'.arClass::$version.'","'.arClass::$gst.'")</script>');
		}
		//
		$defaultAtts=array(
			'name'=>'Canvasio3D',
			'width'=>'320px',
			'height'=>'320px',
			'image'=>'',
			'backcolor'=>'',
			'scene'=>'0',
			'id'=>null
		);		
		$a=shortcode_atts($defaultAtts, $atts);if($a['id']!=null)$a['scene']=$a['id'];
		//
		ob_start();$output='
		<div class="arWrap" id="arWrap_'.arClass::$arID.'">
			<div id="caAR_'.arClass::$arID.'">
				<script>caAR.switchModus("'.arClass::$modus.'");caAR.phpConnect("setWindow","'.$a['name'].'","'.$a['scene'].'","'.arClass::$arID.'");</script>
				<div class="caProgress" id="caProgress_'.arClass::$arID.'"></div>
				<div class="caHandDiv"><div id="caHpIcon_'.arClass::$arID.'" class="caHpIcon"></div></div>
				<div class="caOverlayDiv" id="caOverlayDiv_'.arClass::$arID.'"><div class="caOverlay" id="caOverlay_'.arClass::$arID.'"></div></div>
				<div id="menuHolder" class="menuHolder"></div>
			</div>
		</div>
		';
		arClass::$arID++;ob_end_clean();return $output;
	}
}
arClass::run();
?>