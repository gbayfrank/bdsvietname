<li>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('realty-thumbnail'); ?>
        </a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>">
                <img src="http://placehold.it/160x120">
            </a>
        <?php endif; ?>
        <div class="info-realty">
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <p class="date">
                <i class="fa fa-clock-o"></i>
                <?php echo get_the_date('d/m/Y') ?>
            </p>
            <div class="des">
                <?php
                $content = apply_filters('the_content', get_the_content());
                $content = str_replace(']]>', ']]&gt;', $content);
                ?>
                <?php echo wp_trim_words( $content,30,'...' ); ?>
            </div>
            
            <div class="details">
            <div class="price">
                <label><?php _e( 'Giá','hrm' ); ?><span>:</span></label>
                <?php
                $prince_realty = rwmb_meta('price-realty', 'type=number');
                $par_value = rwmb_meta('par_value');
                $key = '';
                if (($par_value == 'Triệu/m2') && $prince_realty) {
								$key = __('Triệu/m<sup>2</sup>', 'hrm');
								echo number_format($prince_realty, 0, ",", ".") . ' ' . $key;
							} elseif ($prince_realty) {
								echo number_format($prince_realty, 0, ",", ".") . ' ' . $par_value;
							} elseif (!$prince_realty) {
                    echo 'Thỏa thuận';
                }
                ?>
            </div>
            <div class="area">
                <label><?php _e( 'Diện tích','hrm' ); ?><span>:</span></label>
                <?php echo rwmb_meta('area-realty', 'type=number'); ?> m<sup>2</sup>
            </div>
            
            <div class="location">
                <label><?php _e( 'Vị trí','hrm' ); ?><span>:</span></label>
                <?php 
                $post_terms = wp_get_post_terms( get_the_ID(), 'city-realty', array("fields" => "all") );
                foreach ($post_terms as $post_term) {
                    if ($post_term->parent == 0) {
                        $term_city = $post_term->name;
                        $term_city_id = $post_term->term_id;
                    } else {
                        $term_cha_city = $post_term->parent;
                        $term_cha_city1s = get_term($term_cha_city,'city-realty');
                        if ($post_term->parent != 0 && $term_cha_city1s->parent == 0) {
                            $term_district = $post_term->name;
                            $term_district_id = $post_term->term_id;
                        }
                    }
                    
                }
                ?>
                <a href="<?php echo home_url().'/tim-bat-dong-san/?s=&cate-realty=&quick-city='.$term_city_id.'&quick-district='.$term_district_id.'&quick-ward=&area=&price=&quarter=&bedroom=&project_cat='; ?>"><?php echo $term_district; ?></a> - <a href="<?php echo home_url().'/tim-bat-dong-san/?s=&cate-realty=&quick-city='.$term_city_id.'&quick-district=&quick-ward=&area=&price=&quarter=&bedroom=&project_cat='; ?>"><?php echo $term_city; ?></a>
            </div>
           
        </div>
        </div>
        
    </li>