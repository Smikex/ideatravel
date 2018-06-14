<form action="" method="get" class="search-form">

    <input type="hidden" value="" name="s">

    <span class="label selector-container"><span class="field-title"><?php _e('Where we go ?','theme-text-idea') ?></span>

                <select name="search[city]" class="search-select">

                    <option value=""><?php _e('All','theme-text-idea') ?></option>

                    <?php

                    $tags = get_tags();

                    if( $tags ){

                        foreach( $tags as $tag ){

                            $selected = ( $tag->term_id == $filter['city']) ? 'selected' : '';

                            echo '<option '.$selected.' value="'.$tag->term_id.'">'.$tag->name.'</option>';

                        }

                    }

                    ?>

                </select></span><span class="label selector-container"><span class="field-title"><?php _e('Tour type','theme-text-idea') ?></span>

                <select name="search[cat]" class="search-select">

                    <option value=""><?php _e('All','theme-text-idea') ?></option>

                      <?php

                      $categories = get_categories();

                      if( $categories ){

                          foreach( $categories as $cat ){

                              $selected = ( $cat->cat_ID == $filter['cat']) ? 'selected' : '';

                              echo '<option '.$selected.' value="'.$cat->cat_ID .'">'.$cat->name.' ('.$cat->count.')</option>';

                          }

                      }

                      ?>

                </select></span><span class="label dates-container"><span class="field-title"><?php _e('Dates','theme-text-idea') ?></span>

                <div>

                  <input placeholder="<?php _e('from','theme-text-idea') ?>" type="text" value="<?= !empty($filter['date_start']) ? $filter['date_start'] : '' ?>" name="search[date_start]" id="start-date-search" class="datepicker">

                </div>

                <div>

                  <input placeholder="<?php _e('till','theme-text-idea') ?>" type="text" value="<?= !empty($filter['date_end']) ? $filter['date_end'] : '' ?>" name="search[date_end]" id="end-date-search" class="datepicker">

                </div></span>

    <button type="submit">Search</button>

</form>