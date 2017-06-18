<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Toxic_Comments_Protection
 * @subpackage Toxic_Comments_Protection/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Toxic_Comments_Protection
 * @subpackage Toxic_Comments_Protection/admin
 * @author     WPRuby <info@wpruby.com>
 */
class Toxic_Comments_Protection_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Toxic_Comments_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Toxic_Comments_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/toxic-comments-protection-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Toxic_Comments_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Toxic_Comments_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/toxic-comments-protection-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * The function process the comment when posted
	 *
	 * @since    1.0.0
	 */
	public function process_comment() {
		$comment_id = intval($_POST['comment_id']);
		$commentdata = get_comment($comment_id);
		$comment = array(
			'comment' => array(
				'text' => $commentdata->comment_content,
				'type' => 'PLAIN_TEXT',
			),
			'requestedAttributes' => array(
				'TOXICITY' => array(
					'scoreType'=>'PROBABILITY',
				)
			),
				'languages' => 'en',
				'doNotStore' => false,
		 );

		// The data to send to the API
		$postData = ($comment);

		// Setup cURL
		$ch = curl_init('https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=' . PERSPECTIVE_API_KEY);
		curl_setopt_array($ch, array(
		    CURLOPT_POST => TRUE,
		    CURLOPT_RETURNTRANSFER => TRUE,
		    CURLOPT_HTTPHEADER => array(
		        'Content-Type: application/json'
		    ),
		    CURLOPT_POSTFIELDS => json_encode($postData)
		));

		// Send the request
		$response = curl_exec($ch);

		//@TODO Handling errors, and checking success or error
		// Decode the response
		$responseData = json_decode($response, TRUE);
		$score = $responseData['attributeScores']['TOXICITY']['summaryScore']['value'];
		add_comment_meta( $comment_id, 'tcp_score', $score );
		$rounded_score = round($score * 100, 2);
		$number = $rounded_score / 10;
		$css_class_value = ceil($number) * 10;
		if($number != 0)
			echo sprintf('<span class="tcp-score score-%s">%s%%</span>', strval($css_class_value),strval($rounded_score));
		else
			echo sprintf('<a href="#" class="tcp_calculate_score" data-id="%s">%s</a>', strval($comment_id), __('Calculate Score', 'toxic-comments-protection'));

		wp_die();


}
}
