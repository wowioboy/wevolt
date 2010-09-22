<table border='0' cellspacing='0' cellpadding='0' width='<? echo ($_SESSION['contentwidth']-130);?>'>
       <tr>
           <td width="9" id="updateBox_TL"></td>
           <td width="<? echo( $_SESSION['contentwidth']-146);?>" id="updateBox_T"></td>
           <td width="21" id="updateBox_TR"></td>
       </tr>
       <tr>
           <td valign='top' class="updateboxcontent" colspan="3">
               <div style="padding:5px;">
               
               <? 
			   		
					if ($_GET['cat'] != '')
						$CatID = $_GET['cat'];
					if (($_GET['item'] == '') && ($_GET['a'] == '')) {?>
                    
                     <img src="http://www.wevolt.com/images/portfolio_header.png" />
                    <?
						if ($_SESSION['contentwidth'] >800)
							$PerLine = 5;
						else
							$PerLine = 3;
						$Gallery->getGallery($UserID,$_GET['tags'],$CatID,$_GET['keywords'],$_GET['sort'],$PortfolioID,trim($FeedOfTitle),$PerLine);
					} else if ($_GET['a'] == 'edit') {
						$ThumbArray = $Gallery->getGalleryThumbs($UserID, $PortfolioID);
						
						?>
                         <img src="http://www.wevolt.com/images/portfolio_header.png" />
                         <div class="spacer"></div>
                        Upload an image to your portfolio.<br />
  <div class="spacer"></div>
                      <table width="100%"><tr>
                      <td valign="top">
                      <input type="file" name="txtFilename" id="txtFilename" />
                
                       <div class="spacer"></div>
                       Privacy: <select name="txtPrivacy" id="txtPrivacy">
                       			<option value="public">Public</option>
                                <option value="private">Private</option>
                                <option value="friends">Friends</option>
                                <option value="fans">Fans</option>
                                </select>
                        <div class="spacer"></div>
                        Description:<br />

                        <textarea name="txtDescription" id="txtDescription" style="width:100%"></textarea>
                        </td>
                        <td width="300">
                        <img src="" style="display:none;" />
                        </td>
                        </tr>
                        </table>
                         <div class="spacer"></div>
                         Current Gallery<br />
						<? foreach($ThumbArray as $item) {
										echo '<a href="/'.$FeedOfTitle.'/?tab=profile&s=portfolio&view='.$item['ID'].'"><img src="http://www.wevolt.com/'.$item['Thumb'].'" style="border:1px #000 solid;" hspace="3" width="50" height="50"></a>';	
									
									
								}
								?>
                        

                    <? } else {?>
                   
                    <? 
						$GalleryItem = $Gallery->getGalleryItem($UserID,$_GET['item']);
						//print_r($GalleryItem);
						?>
                        <table width="100%" cellspacing="10">
                            <tr>
                                <td align="center" class="gallery_item"><img src="http://www.wevolt.com/<? echo $GalleryItem->ThumbLg;?>" /></td>
                            </tr>
                            <tr>
                            	<td style="overflow:hidden">
                                <? $ThumbArray = $Gallery->getGalleryThumbs($UserID, $PortfolioID);
								foreach($ThumbArray as $item) {
										echo '<a href="/'.$FeedOfTitle.'/?tab=profile&s=portfolio&view='.$item['ID'].'"><img src="http://www.wevolt.com/'.$item['Thumb'].'" style="border:1px #000 solid;" hspace="3" width="50" height="50"></a>';	
									
									
								}
								?>
                                </td>
                            </tr>
                            <tr>
                                <td><? echo $GalleryItem->Title;?><div class="spacer"></div><? echo $GalleryItem->Description;?></td>
                            </tr>
                            <tr>
                            	<td>Comments<? $Gallery->getContentComments($_GET['item']);?></td>
                            </tr>
                       </table>
                        <?
					}
					
			   
			   ?>
                              
               </div>
    		</td>
       </tr>
       <tr>
           <td id="updateBox_BL"></td>
           <td id="updateBox_B"></td>
           <td id="updateBox_BR"></td>
      </tr>
</table>
                   
                 