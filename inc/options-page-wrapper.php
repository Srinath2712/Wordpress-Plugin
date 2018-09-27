<!--*
*   Plugin Name: NY Times Plugin(SMNYT)
*   Version: 1.0 
*   Author: Srinath Mupparsi
*   License: GPL2
*   Description:  Provides both widgets and shortcodes to help     display NY times articles on the web page. 

*/
-->


<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1>NY Times Articles</h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

         <?php if(!isset($smnyt_search)  || $smnyt_search == ''): ?>
                    
					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->
						<h2 class="hndle"><span>Lets Get Started</span>
						</h2>
						<div class="inside">
                            <form method="post" action="">
                               
                        <input type="hidden" name="smnyt_form_submitted" value="Y">
                                
							<table class="form-table">
                                    <tr>
		                          <th class="row-title"></th>
	                               </tr>
	                                   <tr valign="top">
                                            <td scope="row"><label for="tablecell">Search Strings</label></td>
                                            <td><input name="smnyt_search" id="smnyt_search" type="text" value="" class="regular-text" /><br></td>
	                                   </tr>
	                                   <tr valign="top" class="alternate">
                                        <td scope="row"><label for="tablecell">API Keys</label></td>
                                            <td><input name="smnyt_apikey" id="smnyt_apikey" type="text" value="" class="regular-text" /><br></td>
	                                   </tr>

                                </table>
                            <p><input class="button-primary" type="submit" name="smnyt_form_submit" value="save" /></p>
                            </form>
						</div>
					

					</div>
				<?php else: ?>
	<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h2 class="hndle"><span>Lets Get Started</span>
						</h2>

						<div class="inside">
                            <p>Below are 10 articles</p>
                            <ul class="smnyt-articles">
                            <?php for($i=0; $i <10; $i++): ?>
                            <li>
                                <ul>
<?php if( count($smnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}) > 0): ?>
                                    <li>
                                        <img width="120px" src="<?php echo 'http://www.nytimes.com/' . $smnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}[1]->{'url'}?>">
                                    </li>
                                    <?php endif; ?>
                                   	<li class="smnyt-articles-name">
											<a href="<?php echo $smnyt_results->{'response'}->{'docs'}[$i]->{'web_url'}; ?>">
												<?php echo $smnyt_results->{'response'}->{'docs'}[$i]->{'headline'}->{'main'}; ?>
											</a>
										</li>

										<li class="smnyt-articles-paragraph">
											<p><?php echo $smnyt_results->{'response'}->{'docs'}[$i]->{'lead_paragraph'}; ?></p>
										</li>
                                </ul>
                                
                                </li>
                            <?php endfor; ?>
                            
                            </ul>
						</div>
					

					</div>
                    <?php endif; ?>
                    	<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h2 class="hndle"><span>JSON Feed</span>
						</h2>

						<div class="inside">
                            
                            <p>
								<?php echo $smnyt_results->{'response'}->{'docs'}[0]->{'web_url'}; ?>
							</p>
							<p>
								<?php echo $smnyt_results->{'response'}->{'docs'}[0]->{'headline'}->{'main'}; ?>
							</p>
							<p>
								<?php echo $smnyt_results->{'response'}->{'docs'}[0]->{'multimedia'}[1]->{'url'}; ?>
							</p>
							<p>
								<?php echo $smnyt_results->{'response'}->{'docs'}[0]->{'lead_paragraph'}; ?>
							</p>

                            <pre><code><?php var_dump($smnyt_results); ?></code></pre>
						</div>
					

					</div>
				</div>
			

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">
<?php if (isset($smnyt_search) && $smnyt_search != ''): ?>
					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h2 class="hndle"><span>Settings</span></h2>

						<div class="inside">
							 <form method="post" action="">
                                 <input type="hidden" name="smnyt_form_submitted" value="Y">
					
                            <p><input name="smnyt_search" id="smnyt_search" type="text" value="<?php echo $smnyt_search; ?>" class="all-options" />
                                 
                                 <input name="smnyt_apikey" id="smnyt_apikey" type="text" value="<?php echo $smnyt_apikey; ?>" class="all-options" />
                                 
                                 </p>
	                                   

                 
                            <p><input class="button-primary" type="submit" name="smnyt_form_submit" value="Update" /></p>
                            </form>
						</div>
						<!-- .inside -->

					</div>
                    <?php endif; ?>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->
                                            