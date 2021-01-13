<?php get_header(); ?>
    <section class="search-form-section">
        <div class="container">
            <form class="search-form">
                <div class="input-wrap">
                    <label for="where-field">WHERE</label>
                    <input id="where-field" class="search-form-input" type="text" placeholder="Anywhere">
                </div>
                <div class="input-wrap date-wrap">
                    <label for="check-in-field">CHECK-IN</label>
                    <input id="check-in-field" class="search-form-input" type="date" placeholder="dd-mm-yyyy">
                </div>
                <div class="input-wrap date-wrap">
                    <label for="check-out-field">CHECK-OUT</label>
                    <input id="check-out-field" class="search-form-input" type="date" placeholder="dd-mm-yyyy" value=""
                           min="2020-01-01" max="2030-12-31">
                </div>
                <div class="input-wrap guests-wrap">
                    <label for="guests-field">GUESTS</label>
                    <select id="guests-field" class="search-form-input">
                        <option value="" disabled selected>GUESTS</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="input-wrap btn-wrap">
                    <button id="search-btn" type="submit">Search</button>
                </div>
            </form>
        </div>
    </section>


    <section class="hotels">
        <div class="container">
            <div class="hotels-head">
                <h2>300+ Places to Stay</h2>

                <?php
                $args = array(
                    'post_type' => 'property',
                    'posts_per_page' => 2

                );
                $loop = new WP_Query($args);

                $count_posts = $loop->found_posts; ?>

                <div class="sort-wrap">
                    <div class="sort-count">
                        <select id="sort-count-select">
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="302">30</option>
                        </select>
                        <div class="sort-count-text">Showing <span id="current-count">1-<?php echo $count_posts>2 ? 2 : $count_posts;?> </span> of <span id="add-count"><?=$count_posts?></span></div>
                    </div>
                    <div class="sort-view-wrap">
                        <select id="sort-filter-select">
                            <option value="recent" selected>Most recent</option>
                            <option value="new">New</option>
                            <option value="old">Old</option>
                        </select>
                        <button id="grid-view" class="sort-view-btn active"><i class="fa fa-th-large" aria-hidden="true"></i></button>
                        <button id="list-view" class="sort-view-btn"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <div class="hotels-content">
                <div class="hotel-list-wrap">
                    <div class="hotel-list ">

                                <?php if ($loop->have_posts()) {
                                    while ($loop->have_posts()) {
                                        $loop->the_post();
                                         ?>

                                        <div class="hotel-item">
                                            <a href="<?php the_permalink(); ?>" class="img-wrap">
                                                <img src="<?=get_the_post_thumbnail_url( get_the_ID() ,'full' )?>" />
                                                <div class="price">$<?=get_field( "price" );?> / Night</div>
                                            </a>
                                            <div class="info-wrap">
                                                <a href="<?=get_field( 'location_link' );?>" class="location"><i class="fa fa-map-marker" aria-hidden="true"></i><?=get_field( "location_name" );?></a>
                                                <div class="hotel-attributes">
                                                    <div class="attribute"><i class="fa fa-bed" aria-hidden="true"></i><span><?=get_field( "rooms" );?></span></div>
                                                    <div class="attribute"><i class="fa fa-bath" aria-hidden="true"></i><span><?=get_field( "вedrooms" );?></span></div>
                                                    <div class="attribute"><i class="fa fa-television" aria-hidden="true"></i><span><?=get_field( "bathrooms" );?></span></div>
                                                    <div class="attribute"><i class="fa fa-square-o" aria-hidden="true"></i><span><?=get_field( "square" );?></span></div>
                                                </div>
                                                <div class="author-wrap">
                                                    <?php
                                                     $author_id = get_the_author_meta( 'ID' );
                                                     $author_name = get_the_author_meta('user_firstname').' '.get_the_author_meta('user_lastname');;
                                                     $author_image_url = get_field('profile_avatar', 'user_'. $author_id );
                                                     ?>
                                                    <img class="author-img" src="<?=$author_image_url?>" />
                                                    <div class="author-info-wrap">
                                                        <div class="name"><?=$author_name?></div>
                                                        <div class="date">Listed on <?php the_time('M d, Y'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <a href="" class="save-btn"><i class="fa fa-star" aria-hidden="true"></i> Save</a>
                                                    <a href="<?php the_permalink(); ?>" class="details-btn">Details</a>
                                                </div>
                                                <div class="description"><?=get_field( "description" );?></div>
                                            </div>
                                        </div>

                                    <?php }
                                } ?>

                    </div>
                    <?php
                        if ($count_posts > 2) {
                         $number_of_page = ceil($count_posts / 2); ?>
                         <div class="pagination-wrap">
                                <ul class="pagination">
                                <?php
                                for ($i = 1; $i <= $number_of_page; $i++) {
                                    if ($i == 1){ ?>
                                        <li class="active"><a href="#" data-page="<?=$i?>"><?=$i?></a></li>
                                    <?php } else {  ?>
                                     <li><a href="" data-page="<?=$i?>"><?=$i?></a></li>
                                 <?php }
                                } ?>
                                </ul>
                            </div>
                       <?php  }
                      ?>

                </div>

                <?php  wp_reset_query(); ?>
                <div class="hotel-filter">

                    <div class="filter-group">
                        <h3>Amenities</h3>
                        <div class="filter-items two-colunm">
                            <?php
                             $amenities = get_terms([
                                 'taxonomy' => 'amenities',
                                 'hide_empty' => false,
                                 'orderby' => 'id',
                                 'order' => 'ASC'
                             ]);
                             foreach( $amenities as $amenitie ){
                            ?>
                                    <label class="container-checkbox"><?=$amenitie->name?>
                                        <input class="filter-checkbox" data-tax="<?=$amenitie->taxonomy?>" data-tax-slug="<?=$amenitie->slug?>"  type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                             <?php } ?>
                        </div>
                    </div>
                    <div class="filter-group">
                        <h3>Extras</h3>
                        <div class="filter-items two-colunm">

                            <?php
                             $extras = get_terms([
                                 'taxonomy' => 'extras',
                                 'hide_empty' => false,
                                 'orderby' => 'id',
                                 'order' => 'ASC'
                             ]);
                             foreach( $extras as $extra ){
                            ?>
                                    <label class="container-checkbox"><?=$extra->name?>
                                        <input class="filter-checkbox" type="checkbox" data-tax="<?=$extra->taxonomy?>" data-tax-slug="<?=$extra->slug?>">
                                        <span class="checkmark"></span>
                                    </label>
                             <?php } ?>

                        </div>
                    </div>
                    <div class="filter-group">
                        <h3>Accessibility</h3>
                        <div class="filter-items">

                            <?php
                             $accessibility = get_terms([
                                 'taxonomy' => 'accessibility',
                                 'hide_empty' => false,
                                 'orderby' => 'id',
                                 'order' => 'ASC'
                             ]);
                             foreach( $accessibility as $accessibility_item ){
                            ?>
                                    <label class="container-checkbox"><?=$accessibility_item->name?>
                                        <input class="filter-checkbox" type="checkbox" data-tax="<?=$accessibility_item->taxonomy?>" data-tax-slug="<?=$accessibility_item->slug?>">
                                        <span class="checkmark"></span>
                                    </label>
                             <?php } ?>

                        </div>
                    </div>
                    <div class="filter-group">
                        <h3>Bedroom</h3>
                        <div class="filter-items">

                            <?php
                             $bedroom_features = get_terms([
                                 'taxonomy' => 'bedroom-features',
                                 'hide_empty' => false,
                                 'orderby' => 'id',
                                 'order' => 'ASC'
                             ]);
                             foreach( $bedroom_features as $bedroom_feature ){
                            ?>
                                    <label class="container-checkbox"><?=$bedroom_feature->name?>
                                        <input class="filter-checkbox" type="checkbox" data-tax="<?=$bedroom_feature->taxonomy?>" data-tax-slug="<?=$bedroom_feature->slug?>">
                                        <span class="checkmark"></span>
                                    </label>
                             <?php } ?>

                        </div>
                    </div>
                    <div class="filter-group">
                        <h3>Property Type</h3>
                        <div class="filter-items two-colunm">

                            <?php
                             $property_types = get_terms([
                                 'taxonomy' => 'property-type',
                                 'hide_empty' => false,
                                 'orderby' => 'id',
                                 'order' => 'ASC'
                             ]);
                             foreach( $property_types as $property_type ){
                            ?>
                                    <label class="container-checkbox"><?=$property_type->name?>
                                        <input class="filter-checkbox" type="checkbox" data-tax="<?=$property_type->taxonomy?>" data-tax-slug="<?=$property_type->slug?>">
                                        <span class="checkmark"></span>
                                    </label>
                             <?php } ?>

                        </div>
                    </div>

                </div>
                <a class="open-filter" href="javascript:void(0);">Show Filter <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>

    <section class="download-app">
        <div class="container">
            <h3>Download App</h3>
            <p>Fusce placerat pretium mauris, vel sollicitudin elit lacinia vitae. Quisque sit amet nisi erat.</p>
            <div class="app-btn-wrap">
                <a class="app-btn" href="/">
                    <i class="fa fa-apple" aria-hidden="true"></i>
                    <span class="app-btn-text-wra">
                        <span>Download on the</span>
                        <span>App Store</span>
                    </span>
                </a>
                <a class="app-btn" href="/">
                    <i class="fa fa-google" aria-hidden="true"></i>
                    <span class="app-btn-text-wra">
                        <span>Get it on</span>
                        <span>Google Play</span>
                    </span>
                </a>

            </div>
        </div>
    </section>

<?php get_footer(); ?>