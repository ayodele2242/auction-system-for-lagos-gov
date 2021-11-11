<?php include('header.php'); 

if(isset($_COOKIE['redirect_to']))
{
   $url = $_COOKIE['redirect_to'];
   unset($_COOKIE['redirect_to']);
   echo 'window.location.href = "main"';
   //header('location:' . $url);
}

?>
<?php include('top-nav.php'); ?>
   
<div class="container-fluid mt-5 pt-5">
       
            <div class="block-header">
			<h2><i class="fa fa-wrench"></i> Contact</h2>
            </div>

<!-- Widgets -->
<div class="row clearfix">
<div class="col-lg-2"></div>
<div class="col-lg-8">           
			   <?php if ($msgBox) { echo $msgBox;} 
			// echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
			   ?>
			<div id="message" class="mymsg"></div>
			<form  class="" id="editSetting" >
				<div class="panel-body">
					<div class="form-group row header bgcolor-default">
						<div class="col-md-12">
							 <h4><?php echo $globalSettingsTitle; ?></h4>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label"><?php echo $installURLField; ?></label>
						<div class="col-sm-8">
							<input class="form-control" type="text"  name="installUrl" id="installUrl" value="<?php echo clean($set['installUrl']); ?>" />
							<span class="help-block"><?php echo $installURLHelp; ?></span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Site Name</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="siteName" id="siteName" value="<?php echo clean($set['siteName']); ?>" />
							<span class="help-block"><?php echo $siteNameHelp; ?></span>
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-sm-3 control-label">Company Name</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="schName" id="schName" value="<?php echo clean($set['company_name']); ?>" />
							<span class="help-block">This is what the people at the front end will see when visiting your company website.</span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label"><?php echo $siteEmailField; ?></label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="siteEmail" id="siteEmail" value="<?php echo clean($set['siteEmail']); ?>" />
							<span class="help-block"><?php echo $siteEmailHelp; ?></span>
						</div>
					</div>

				<div class="form-group row">
				<label class="col-sm-3 control-label">Company Logo</label>
				<div class="col-sm-8">
				<div class="media">
										<div class="media-left showit myimg">
										<?php
										if(empty($set['companyLogo'])){
										?>
										<img src="<?php echo $set['installUrl']; ?>logo/avatar.png" class="img">
										<?php
										}else{
										?>
										<img id="profile_pics"  data-holder-rendered="true" src="<?php echo $set['installUrl']; ?>logo/<?php echo $set['companyLogo']; ?>" class="img">
										<?php
										}
										?>
												</div>
												<div class="media-body">
												<a class="btn alert-info mobile-link btn-round waves-effect" data-toggle="modal" data-target="#profile_pic_modal">
							<span class="glyphicon glyphicon-camera"></span> &nbsp; Update Company Logo
							</a> 
												</div>
											</div>
											</div>

				</div>

                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label">Phone Number</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="phone" value="<?php echo clean($set['phone']); ?>" />
							<span class="help-block">For multiple phone numbers use comma e.g. 070-xxxx-xxx, 080-xxx-xxxxx</span>
						</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label">Company Location</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="location" value="<?php echo clean($set['location']); ?>" />
							<span class="help-block">State where company is located</span>
						</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label">Company Address</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="address" value="<?php echo clean($set['address']); ?>" />
							<span class="help-block"></span>
						</div>
					</div>

					
					<div class="form-group row header bgcolor-default">
						<div class="col-md-12">
							 <h4><?php echo $localTitle; ?></h4>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label"><?php echo $selectLangField; ?></label>
						<div class="col-sm-8">
							<select class="form-control" name="localization">
								<option value="ar" <?php echo $ar; ?>><?php echo $optionArabic; ?> &mdash; ar.php</option>
								<option value="bg" <?php echo $bg; ?>><?php echo $optionBulgarian; ?> &mdash; bg.php</option>
								<option value="ce" <?php echo $ce; ?>><?php echo $optionChechen; ?> &mdash; ce.php</option>
								<option value="cs" <?php echo $cs; ?>><?php echo $optionCzech; ?> &mdash; cs.php</option>
								<option value="da" <?php echo $da; ?>><?php echo $optionDanish; ?> &mdash; da.php</option>
								<option value="en" <?php echo $en; ?>><?php echo $optionEnglish; ?> &mdash; en.php</option>
								<option value="en-ca" <?php echo $en_ca; ?>><?php echo $optionCanadianEnglish; ?> &mdash; en-ca.php</option>
								<option value="en-gb" <?php echo $en_gb; ?>><?php echo $optionBritishEnglish; ?> &mdash; en-gb.php</option>
								<option value="es" <?php echo $es; ?>><?php echo $optionEspanol; ?> &mdash; es.php</option>
								<option value="fr" <?php echo $fr; ?>><?php echo $optionFrench; ?> &mdash; fr.php</option>
								<option value="ge" <?php echo $ge; ?>><?php echo $optionGerman; ?> &mdash; ge.php</option>
								<option value="hr" <?php echo $hr; ?>><?php echo $optionCroatian; ?> &mdash; hr.php</option>
								<option value="hu" <?php echo $hu; ?>><?php echo $optionHungarian; ?> &mdash; hu.php</option>
								<option value="hy" <?php echo $hy; ?>><?php echo $optionArmenian; ?> &mdash; hy.php</option>
								<option value="id" <?php echo $id; ?>><?php echo $optionIndonesian; ?> &mdash; id.php</option>
								<option value="it" <?php echo $it; ?>><?php echo $optionItalian; ?> &mdash; it.php</option>
								<option value="ja" <?php echo $ja; ?>><?php echo $optionJapanese; ?> &mdash; ja.php</option>
								<option value="ko" <?php echo $ko; ?>><?php echo $optionKorean; ?> &mdash; ko.php</option>
								<option value="nl" <?php echo $nl; ?>><?php echo $optionDutch; ?> &mdash; nl.php</option>
								<option value="pt" <?php echo $pt; ?>><?php echo $optionPortuguese; ?> &mdash; pt.php</option>
								<option value="ro" <?php echo $ro; ?>><?php echo $optionRomanian; ?> &mdash; ro.php</option>
								<option value="sv" <?php echo $sv; ?>><?php echo $optionSwedish; ?> &mdash; sv.php</option>
								<option value="th" <?php echo $th; ?>><?php echo $optionThai; ?> &mdash; th.php</option>
								<option value="vi" <?php echo $vi; ?>><?php echo $optionVietnamese; ?> &mdash; vi.php</option>
								<option value="yue" <?php echo $yue; ?>><?php echo $optionCantonese; ?> &mdash; yue.php</option>
							</select>
						</div>
					</div>
					
					<div class="form-group row header bgcolor-default mt-10">
						<div class="col-md-12">
							 <h4><?php echo $globalOptionsTitle; ?></h4>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label"><?php echo $enableRegField; ?></label>
						<div class="col-sm-8">
							<select class="form-control" name="allowRegistrations">
								<option value="0"><?php echo $noBtn; ?></option>
								<option value="1" <?php echo $allowRegistrations; ?>><?php echo $yesBtn; ?></option>
							</select>
							<span class="help-block"><?php echo $enableRegHelp; ?></span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label"><?php echo $enableWeatherField; ?></label>
						<div class="col-sm-8">
							<select class="form-control" name="enableWeather">
								<option value="0"><?php echo $noBtn; ?></option>
								<option value="1" <?php echo $enableWeather; ?>><?php echo $yesBtn; ?></option>
							</select>
							<span class="help-block"><?php echo $enableWeatherHelp; ?></span>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label"><?php echo $enableCalField; ?></label>
						<div class="col-sm-8">
							<select class="form-control" name="enableCalendar">
								<option value="0"><?php echo $noBtn; ?></option>
								<option value="1" <?php echo $enableCalendar; ?>><?php echo $yesBtn; ?></option>
							</select>
							<span class="help-block"><?php echo $enableCalHelp; ?></span>
						</div>
					</div>
                    
                    <div class="form-group row header bgcolor-default mt-10">
						<div class="col-md-12">
							 <h4>Search Engine Optimization Details</h4>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Description</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="description" value="<?php echo clean($set['description']); ?>" />
							<span class="help-block">Website description for SEO. e.g. company name, motto, vission etc. </span>
						</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label">Keywords</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="keywords" value="<?php echo clean($set['keywords']); ?>" />
							<span class="help-block">Words that can easily be used by SEO to find your site. e.g. company name, words related to you company activities etc. </span>
						</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label">Author</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" required name="author" value="<?php echo clean($set['author']); ?>" />
							
						</div>
					</div>
                    
                    <div class="form-group row header bgcolor-default mt-10">
						<div class="col-md-12">
							 <h4>Social Networks</h4>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label" style="color: #06C;"><span  class="fa fa-facebook"></span> Facebook</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="facebook" value="<?php echo clean($set['facebook']); ?>" />
					</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label" style="color: #39F;"><span class="fa fa-twitter"></span> Twitter</label>
						<div class="col-sm-8">
							<input class="form-control" type="text"  name="twitter" value="<?php echo clean($set['twitter']); ?>" />
					</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label" style="color:#066"><span class="fa fa-instagram"></span> Instagram</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="instagram" value="<?php echo clean($set['instagram']); ?>" />					</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 control-label" style="color:#900;"><span class="fa fa-youtube"></span> Youtube</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="youtube" value="<?php echo clean($set['youtube']); ?>" />
					</div>
					</div>

				</div>
				<div class="form-group">
				<div id="message" class="mymsg"></div>
				<hr />
				<div align="center">
				<button type="input" name="submit" value="editSettings" class="btn btn-success btn-md btn-icon mt-10 " id="btn-submit"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
				</div>
			</div>
			</form>
            
            </div>

			</div>
            <!-- #END# Widgets -->

       
	</div>
	


	<!-- Site logo modal -->
<div class="modal fade" id="profile_pic_modal" tabindex="-1" role="dialog" aria-labelledby="profile_pic_modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"
>
<div class="modal-dialog" role="document">

						    <div class="modal-content">
							
							
							<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-camera"></span> Update Logo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

				  <div class="modal-body" style="overflow:hidden;">
							  <div class="media">
								
                                <div class="media-body">
                                    Click on the icon <a href="javascript:void(0);">
                                        <img class="media-object" src="../logo/photo.png" width="34" height="34">
                                    </a>   on the image to select the image you wish to upload.
                                </div>
                            </div>


							<div id="error"></div>	  
                             <div id="body-overlay"><div><img src="../img/processing.gif"/></div></div>
		<div align="center"> <div id="body-overlay"><div><img src="../img/processing.gif"/></div></div>
		<div class="bgColor">
			<form id="uploadForm" action="upload.php" method="post">
				 <div id="targetOuter">
					<div id="targetLayer"><?php if(!empty($set['companyLogo'])){ ?> <img src="../logo/<?php echo $set['companyLogo'];  ?>" style="min-width:100%; height:200px;"> <?php }else{ ?><img src="../logo/avatar.png" width="150px" height="150px" class="upload-preview" /><?php }?></div>
					<img src="../logo/photo.png"  class="icon-choose-image"/>
					<div class="icon-choose-image" onClick="showUploadOption()"></div>
					<div id="profile-upload-option">
						<div class="profile-upload-option-list"><input name="userImage" id="userImage" type="file" class="inputFile" onChange="showPreview(this);"></input><span>Upload</span></div>
						<div class="profile-upload-option-list" onClick="removeProfilePhoto();">Remove</div>
						<div class="profile-upload-option-list" onClick="hideUploadOption();">Cancel</div>
					</div>
				</div>	
				<div>
				<input type="submit" value="Upload Photo" class="btn btn-success btn-sm wave-effect" id="btn-submit" onClick="hideUploadOption();"/>
				</div>
			</form>
		</div>	
		</div>	

                              </div>
						      <div class="modal-footer">
						        
						      </div>
                              
						    </div>
						  </div>
						</div>   

<?php include('footer.php'); ?>    

   