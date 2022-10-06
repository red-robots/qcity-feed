<?php
/*
Plugin Name: Qcity Feed
Plugin URI: https://bellaworksweb.com
Description: News Posts shortcode from Qcity.
Author: Austin Crane
Version: 1.0
Author URI: https://bellaworksweb.com
*/

function qcityfeed_shortcode( $atts ) {
	
	$a = shortcode_atts( array(
			'title' => '',
			'description' => '',
			'layout' => '',
	), $atts );

	ob_start(); 
	
	
	// echo '<pre>';
	// print_r($ourTerm);
	// echo '</pre>';
	
	$title = $a['title'];
	$desc = $a['description'];
	$layout = $a['layout'];

	//$per_page = 3;

	$response = wp_remote_get( 'https://qcitymetro.com/wp-json/wp/v2/posts?per_page=5&_embed' );

	if( is_array($response) ) :
        $code = wp_remote_retrieve_response_code( $response );
        if(!empty($code) && intval(substr($code,0,1))===2): 
            $body = json_decode(wp_remote_retrieve_body( $response),true); 

  //       echo '<pre>';
		// print_r($body);
		// echo '</pre>';
        ?>
        <?php if( $title || $desc ) { ?>
	        <div class="wp-block-columns">
	        	<div class="wp-block-column">
	        		<?php if($title){ ?>
		        		<h2 class="black-section-title">
		        			<?php echo $title; ?>
		        		</h2>
		        	<?php } ?>
		        	<?php if($desc){ ?>
		        		<p><?php echo $desc; ?></p>
		        	<?php } ?>
	        	</div>
	        </div>
	    <?php } ?>

	    <?php if( $layout == 'thirds' ) { ?>
	    	<div class="wp-block-columns">
	    		<?php $i=0; $c = 0; foreach ($body as $post) : $i++; 
	    			$post_title = $post['title']['rendered']; 
					$excerpt = $post['excerpt']['rendered']; 
					$excerpt = substr($excerpt, 0, -24);
					$permalink = $post['link'];
					$img = $post["_embedded"]["wp:featuredmedia"][0]["source_url"];
					// echo '<pre>';
					// print_r($post);
					// echo '</pre>';
					// $img = $post["_embedded"]["wp:featuredmedia"][0]["media_details"]["sizes"]["medium"]["source_url"];
					$author = $post["_embedded"]["author"][0]["name"];
					$cat = $post["_embedded"]["wp:term"][0][0]["name"];
					$date = $post['date'];
					$time = strtotime($date);

					$newformat = date('F j, Y',$time);
	    		?>
	    		<div class="wp-block-column">
	    			<div class="wp-block-newspack-blocks-homepage-articles  wpnbha is-grid columns-3 show-image image-aligntop ts-2 is-3 is-uncropped show-category  has-text-align-left">
	    				
	    					<article class="category-entertainment type-post post-has-image">
	    						<?php if($img) { ?>
		    						<figure class="post-thumbnail">
		    							<a href="<?php echo $permalink; ?>" target="_blank">
		       								<img 
		       								src="<?php echo $img; ?>" 
		       								style="width: 400px; height: 200px; background-size: contain; background-image: url(<?php echo $img; ?>);"
		       								class="attachment-newspack-article-block-uncropped size-newspack-article-block-uncropped wp-post-image jetpack-lazy-image jetpack-lazy-image--handled">
		       							</a>
		    						</figure>
		    					<?php } ?>
	    						<div class="entry-wrapper">
	       							<div class="cat-links">
	       								<a><?php echo $cat; ?></a>
	       							</div>
	       							<h2 class="entry-title">
	       								<a href="<?php echo $permalink; ?>" target="_blank">
	       									<?php echo $post_title; ?>
	       								</a>
	       							</h2>
	       							<!-- <p>
	       								<?php //echo $excerpt; ?>
	       							</p> -->
	       							<div class="entry-meta">
	       								<span class="byline">
	       									by <b><?php echo $author; ?></b>
	       								</span>
	       								<time class="entry-date">
	       									<?php echo $newformat; ?>
	       								</time>
	       							</div>
	       						</div>
	    					</article>
	    				
	    			</div>
	    		</div>
	    		
	    		<?php endforeach; ?>
	    	</div>
	    <?php } else { ?>

        <div class="wp-block-columns">
		<?php $i=0; $c = 0; foreach ($body as $post) : $i++;

			$post_title = $post['title']['rendered']; 
			$excerpt = $post['excerpt']['rendered']; 
			$excerpt = substr($excerpt, 0, -24);
			$permalink = $post['link'];
			$img = $post["_embedded"]["wp:featuredmedia"][0]["source_url"];
			$author = $post["_embedded"]["author"][0]["name"];
			$cat = $post["_embedded"]["wp:term"][0][0]["name"];
			$date = $post['date'];
			$time = strtotime($date);

			$newformat = date('F j, Y',$time);
			

			?>
				<?php if( $i == 1 ) { ?>
					<div class="wp-block-column" style="flex-basis:66.66%;">
		       			<div class="wp-block-newspack-blocks-homepage-articles  wpnbha show-image image-aligntop ts-4 is-3 is-uncropped show-category ">
		       				<div>
		       					<article class="tag-cms tag-editors-choice category-news type-post post-has-image">
		       						<figure class="post-thumbnail">
		       							<a href="<?php echo $permalink; ?>" target="_blank">
		       								<img src="<?php echo $img; ?>" class="attachment-newspack-article-block-uncropped size-newspack-article-block-uncropped wp-post-image jetpack-lazy-image jetpack-lazy-image--handled">
		       							</a>
		       						</figure>
		       						<div class="entry-wrapper">
		       							<div class="cat-links">
		       								<a><?php echo $cat; ?></a>
		       							</div>
		       							<h2 class="entry-title">
		       								<a href="<?php echo $permalink; ?>" target="_blank">
		       									<?php echo $post_title; ?>
		       								</a>
		       							</h2>
		       							<p>
		       								<?php echo $excerpt; ?>
		       							</p>
		       							<div class="entry-meta">
		       								<span class="byline">
		       									by <b><?php echo $author; ?></b>
		       								</span>
		       								<time class="entry-date">
		       									<?php echo $newformat; ?>
		       								</time>
		       							</div>
		       						</div>
		       					</article>
		       				</div>
		       			</div>
		       		</div>
		       	<?php } else { $c++; ?>
		       		<?php if($c==1) { ?><div class="wp-block-column" style="flex-basis:33.33%;"><?php } ?>
		       			<div class="wp-block-newspack-blocks-homepage-articles  wpnbha show-image image-aligntop ts-2 is-3 is-uncropped show-category ">
		       				<div>
		       					<article class="tag-cms tag-editors-choice category-news type-post post-has-image">
		       						<figure class="post-thumbnail">
		       							<a href="<?php echo $permalink; ?>" target="_blank">
		       								<img src="<?php echo $img; ?>" class="attachment-newspack-article-block-uncropped size-newspack-article-block-uncropped wp-post-image jetpack-lazy-image jetpack-lazy-image--handled">
		       							</a>
		       						</figure>
		       						<div class="entry-wrapper">
		       							<div class="cat-links">
		       								<a><?php echo $cat; ?></a>
		       							</div>
		       							<h2 class="entry-title">
		       								<a href="<?php echo $permalink; ?>" target="_blank">
		       									<?php echo $post_title; ?>
		       								</a>
		       							</h2>
		       							<div class="entry-meta">
		       								<span class="byline">
		       									by <b><?php echo $author; ?></b>
		       								</span>
		       								<time class="entry-date">
		       									<?php echo $newformat; ?>
		       								</time>
		       							</div>
		       						</div>
		       					</article>
		       				</div>
		       			</div>
		       		<?php if($c==2) { ?></div><?php } ?>
		       	<?php } ?>
       	
			
		<?php endforeach; ?>
        </div>
    	<?php } ?>


        <?php 

    endif;
endif;
	
	// $content = wpautop(trim($content));
	// return $content;
	
	// Spit everythng out
	return ob_get_clean();
}

add_shortcode( 'qcity_feed', 'qcityfeed_shortcode' );