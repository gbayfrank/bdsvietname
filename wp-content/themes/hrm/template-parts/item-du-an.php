<div class-="project-box-post">
    <div class="project-img-item">
        <a  href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <div class="thumbnail-project-detail lazyload-news-list-item" >
                <?php the_post_thumbnail( 'post-news'); ?>
            </div>
        </a>
    </div>
    <div class="project-title-item">
        <div class="project-background-item">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </div>
    </div>
    <div class="project-description-item" style="word-wrap: break-word;">
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php echo wp_trim_words( get_the_content(), 30, '...' ); ?>
        </a>
    </div>
</div>