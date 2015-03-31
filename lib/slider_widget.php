<?php

  class SliderWidget extends WP_Widget {
    function __construct() {
      parent::__construct('wsm_front_slider_widget',
        __('Front slider (WSM custom slider)', 'wsm_front_slider_widget'),
        array(
          'description' => __('WSM custom slider special for FYN. Get slides from the featured image posts.', 'wsm_front_slider_widget_desc')
        )
      );
    }

    function output_cell($posts, $counter) {
      if(isset($posts[$counter])) {
        $thumbnail = get_the_post_thumbnail( $posts[$counter]->ID, 'thumbnail' ); 
      } else {
        $thumbnail = null;
      }
      ?>
        <div class='slider_post_thumbnail <?= ($thumbnail) ? '' : ' no-image'; ?>'><?= $thumbnail; ?></div>
      <?php
    }

    function widget($args, $instance) {
      if (!array_key_exists('front_slider_tag', $instance) || !$instance['front_slider_tag']) { return false; }
      $tag_id = intval($instance['front_slider_tag']);
      $posts = get_posts(
        array(
          'posts_per_page' => 8,
          'tax_query' => array(
            'taxonomy' => 'tag',
            'field' => 'id',
            'terms' => $tag_id
          )
        )
      );

      // var_dump($posts[0]);
      echo $args['before_widget'];
      
      echo "<div class=\"html-slider coda-slider\">";
        for($i = 0; $i < 2; $i++) {
          $counter = $i * 4;
          ?>
            <div>
              <table>
                <tr>
                  <td>
                    <?php $this->output_cell($posts, $counter++); ?>
                  </td>
                  <td>
                    <?php $this->output_cell($posts, $counter++); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <?php $this->output_cell($posts, $counter++); ?>
                  </td>
                  <td>
                    <?php $this->output_cell($posts, $counter++); ?>
                  </td>
                </tr>
              </table>
            </div>
          <?php
        }
      echo "</div>";

      echo $args['after_widget'];
    }

    function form($instance) {
      $tags = get_tags();

      
      echo "<p>";
        echo "<label>Slides tag for front slider</label>";
        echo "<select class='widefat' name=" . $this->get_field_name('front_slider_tag') . ">";
          echo "<option></option>";
          foreach ( $tags as $tag ) {
            $selected_attr = ((array_key_exists('front_slider_tag', $instance) && $instance['front_slider_tag'] == $tag->term_id) ? ' selected ' : '');
            echo "<option value='" . $tag->term_id . "' " . $selected_attr . ">" . $tag->name . "</option>";
          }
        echo "</select>";
      echo "</p>";
    }

    function update($new_instance, $old_instance) {
      $instance = array();
      $instance['front_slider_tag'] = array_key_exists('front_slider_tag', $new_instance) ? intval($new_instance['front_slider_tag']) : 0;

      return $instance;
    }
  }