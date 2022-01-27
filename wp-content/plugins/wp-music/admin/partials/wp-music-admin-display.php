<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.techwithnavi.com/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

   <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form method="post" id="wp_music_form_options" name="wp_music_form_options_form_options" action="options.php">
        <?php
            // Get all options
            $options = get_option($this->plugin_name);
           
            // Add in WordPress hidden fields
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
        ?>

        <fieldset>

            <h4><?php _e( 'Currency', $this->plugin_name ); ?></h4>

            <select name="<?php echo $this->plugin_name; ?>[music_currency]">
                     <option value="usd" <?php selected($options['music_currency'], 'usd'); ?>>
                         <?php _e( 'USD', $this->plugin_name ); ?>
                     </option>
                     <option value="inr" <?php selected($options['music_currency'], 'inr'); ?>>
                         <?php _e( 'INR', $this->plugin_name ); ?>
                     </option>
                     <option value="cad" <?php selected($options['music_currency'], 'cad'); ?>>
                         <?php _e( 'CAD', $this->plugin_name ); ?>
                     </option>
            </select>


        </fieldset>

        <hr />

        <fieldset>

            <h4><?php _e( 'Post per page', $this->plugin_name ); ?></h4>
            
            <?php 
                 $perPage = ( $options['music_post_per_page']) ? $options['music_post_per_page'] : '';
            ?>
            <input type="number" name="<?php echo $this->plugin_name . '[music_post_per_page]'; ?>" value="<?php echo $perPage;?>" />

            
        </fieldset>

        <hr />

        <fieldset>

            <h4><?php _e( 'Shortcode', $this->plugin_name ); ?></h4>
            <p>
            You can use this shortcode [music] to music listing 
            </p>
        </fieldset>

        <hr />

        <?php submit_button( __('Save all changes', $this->plugin_name), 'primary','submit', TRUE ); ?>

    </form>

</div>