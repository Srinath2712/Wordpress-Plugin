<!--
*   Plugin Name: NY Times Plugin(SMNYT)
*   Version: 1.0 
*   Author: Srinath Mupparsi
*   License: GPL2
*   Description:  Provides both widgets and shortcodes to help     display NY times articles on the web page. 
-->

<?php 

	echo $before_widget;
	echo $before_title . $title . $after_title;


?>
<ul class="smnyt-articles frontend">

	<?php 

		$total_articles = count( $smnyt_results->{'response'}->{'docs'} );

		for( $i = $total_articles - 1; $i >= $total_articles - $num_articles; $i-- ):		

	;?>

	<li class="smnyt-articles">

			<div class="smnyt-articles-info">
				<?php if( $display_image == '1' ): ?>

					<?php if( count($smnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}) > 0): ?>
				
					<img width="120px" src="<?php echo "http://www.nytimes.com/" . $smnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}[1]->{'url'}; ?>">	

					<?php endif; ?>	
				
				<?php endif; ?>														
				
				<p class="smnyt-articles-name">			
					<a href="<?php echo $smnyt_results->{'response'}->{'docs'}[$i]->{'web_url'}; ?>">
						<?php echo $smnyt_results->{'response'}->{'docs'}[$i]->{'headline'}->{'main'}; ?>
					</a>								
				</p>							
				
				<p>
					<?php echo $smnyt_results->{'response'}->{'docs'}[$i]->{'lead_paragraph'}; ?>
				</p>							

			</div>

	</li>


	<?php endfor; ?>

</ul>

<?php 
	echo $after_widget;
?>