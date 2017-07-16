<?php
 /**
  * WordPress settings API class
  *
  * @link       https://wpruby.com
  * @since      1.0.0
  *
  * @package    TCP_Settings
  * @subpackage TCP_Settings/admin
  */

if ( !class_exists('TCP_Settings' ) ):
class TCP_Settings {

    private $settings_api;

    public function __construct() {
        $this->settings_api = new TCP_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu() {
        add_submenu_page('edit-comments.php',	__( 'Toxic Comments Protection', 'toxic-comments-protection' ),	__( 'Toxic Comments Protection', 'toxic-comments-protection' ),	'manage_options',	'tcp-settings',	array($this, 'plugin_page'));
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'tcp_general',
                'title' => __( 'General', 'toxic-comments-protection' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_settings_fields() {
        $settings_fields = array(
            'tcp_general' => array(
              array(
                  'name'    => 'perspective_api_key',
                  'label'   => __( 'Prevent API from storing data', 'toxic-comments-protection' ),
                  'desc'    => __( 'You can get an API key from going to the <a href="https://console.developers.google.com/">Google Developer Console</a> and ensuring the API is activated against your account.', 'toxic-comments-protection' ),
                  'type'    => 'text',
                  'default' => ''
              ),
              array(
                  'name'    => 'hold_comments_score_ceil',
                  'label'   => __( 'Comments Holding Ceil', 'toxic-comments-protection' ),
                  'desc'    => __( 'Hold the comment for administration approval if it had a toxic score more than this value.', 'toxic-comments-protection' ),
                  'type'    => 'select',
                  'options' => array(
                    '10' => 10,
                    '20' => 20,
                    '30' => 30,
                    '40' => 40,
                    '50' => 50,
                    '60' => 60,
                    '70' => 70,
                    '80' => 80,
                    '90' => 90,
                    '100' => 100,
                  )
              ),
              array(
                  'name'    => 'do_not_store_comments',
                  'label'   => __( 'Prevent API from storing data', 'toxic-comments-protection' ),
                  'desc'    => __( 'This should be checked if comments being submitted is private (i.e. not publicly accessible), or if the comments submitted contains content written by someone under 13 years old.', 'toxic-comments-protection' ),
                  'type'    => 'checkbox',
                  'default' => 'on'
              ),
            )

        );

        return $settings_fields;
    }

    public function plugin_page() {
        echo '<div id="tcp_settings_page" class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    public function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }


    public function get_option($option = '', $section = ''){
      return $this->settings_api->get_option($option, $section );
    }

}
endif;
