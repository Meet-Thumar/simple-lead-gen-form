<?php 
if(!class_exists('SIMPLE_LEAD_GEN_FORM')) {
    class SIMPLE_LEAD_GEN_FORM
    {
        function __construct(){
            global $wpdb;           
            register_activation_hook(SIMPLE_LEAD_GEN_FORM_DIR . '/simple-lead-gen-form.php',array('SIMPLE_LEAD_GEN_FORM','install'));           
            register_uninstall_hook(SIMPLE_LEAD_GEN_FORM_DIR . '/simple-lead-gen-form.php',array('SIMPLE_LEAD_GEN_FORM','uninstall'));    
            add_action('wp_enqueue_scripts',array($this,'slgf_set_css'));
            add_action('wp_enqueue_scripts',array($this,'slgf_set_js'));
            add_shortcode('simple_lead_gen_form',array($this,'simple_lead_gen_form_func'));            
            add_action('wp_ajax_slgf_submit_customer_data',array($this,'slgf_submit_customer_data_func'));
            add_action('wp_ajax_nopriv_slgf_submit_customer_data',array($this,'slgf_submit_customer_data_func'));            
            add_action( 'init', array($this,'slgf_create_custom_post_type' ));            
        }

        /* register customer custom post type */
        function slgf_create_custom_post_type() {
            register_post_type( 'Customer',            
                array(
                'labels' => array(
                    'name' => __( 'Customer','my-custom-domain'  ),
                    'singular_name' => __( 'Customer','my-custom-domain'  ),
                    'view_item'           => __( 'Show Book', 'my-custom-domain' )
                ),
                'public' => true,
                'has_archive' => false,
                'rewrite' => array('slug' => 'Customer'),
                'show_in_rest' => true,
                'supports' => array( 'title', 'editor', 'custom-fields','thumbnail','excerpt' ),
                )
            );
        }

        /* insert customer post data */
        function slgf_submit_customer_data_func(){

            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '' ;
            $user_phone = isset($_POST['user_phone']) ? $_POST['user_phone'] : '';
            $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
            $user_budget = isset($_POST['user_budget']) ? $_POST['user_budget'] : '';
            $user_msg = isset($_POST['user_msg']) ? $_POST['user_msg'] : '';

            $post_content = '<div class="main-container"> 
            <p>Customer name : '.$user_name.' </p> 
            <p>Customer phone number : '.$user_phone.' </p> 
            <p>Customer email  : '.$user_email.' </p> 
            <p>Customer desired budget : '.$user_budget.' </p> 
            <p>Customer msg : '.$user_msg.' </p> 
            </div>';

            $customer_new_post = array(
                'post_title' => $user_name,
                'post_content'=> $post_content,
                'post_status' => 'private',
                'post_type' => 'customer'
            );
                
            echo wp_insert_post($customer_new_post);
            exit;
            die();
        }

        // install plugin
        public static function install(){           
            $simple_lead_gen_from_ver = get_option('simple_lead_gen_from_version');            
            if($simple_lead_gen_from_ver == '') {  
                global $simple_lead_gen_form_version;                     
                update_option('simple_lead_gen_from_version',$simple_lead_gen_form_version);
            }
        }

        // uninstall plugin
        public static function uninstall(){ 
            delete_option('simple_lead_gen_from_version');
        }
        
        // set front js
        function slgf_set_js(){ 
            global $simple_lead_gen_form_version;
            wp_register_script('simple-lead-gen-form-js',SIMPLE_LEAD_GEN_JS.'/simple-lead-gen-form.js',array('jquery'),$simple_lead_gen_form_version);

            wp_localize_script('simple-lead-gen-form-js', 'slgf_ajax_obj', array( 'ajax_url' => admin_url('admin-ajax.php') ));

            wp_enqueue_script('simple-lead-gen-form-js');
        }
        // set front css
        function slgf_set_css(){
            global $simple_lead_gen_form_version;
            wp_register_style('simple-lead-gen-form-css',SIMPLE_LEAD_GEN_CSS.'/simple-lead-gen-form.css',array(),$simple_lead_gen_form_version);
            wp_enqueue_style('simple-lead-gen-form-css');
        }

        // simple lead gen form        
        function simple_lead_gen_form_func($atts, $content, $tag ) {
            
            $defaults = array(
                'name_label'  => __('Name','simple-lead-gen-form'),
                'phone_no_label' =>  __('Phone Number','simple-lead-gen-form'),
                'email_label' => __('Email','simple-lead-gen-form'),
                'desired_budget_label' => __('Desired Budget','simple-lead-gen-form'),
                'message_label' => __('Message','simple-lead-gen-form'),
                'name_max_length'  => 10,
                'phone_no_max_length' => 0,
                'email_max_length' => 0,
                'desired_budget_max_length' => 0,
                'message_max_length' => 0,
                'message_row' => 2,
                'message_col' => 2,
            );
            
            $args     = shortcode_atts($defaults, $atts, $tag);
            extract($args);

            $content = '
            <div class="slgf-main-container">
                <form method="POST" id="slgf-main-form" onsubmit="return sglf_submit_customer_data_func();">
                        <h3>'. esc_html__('Customer Form','simple-lead-gen-form').'</h3>                 
                        <span id="form_success_msg" class="form_success_msg">Form submit successfully</span><br>
                        <label for="user_name"><b>'.$name_label.'</b></label>
                        <input type="text" placeholder="Enter Name"  name="user_name" id="user_name" data-attr="'.$name_max_length.'">
                        <span id="usercheck">
                            '. esc_html__('Please Enter Name','simple-lead-gen-form').'
                        </span>

                        <label for="user_phone"><b>'.$phone_no_label.'</b></label>
                        <input type="number" placeholder="Enter Phone Number" name="user_phone" id="user_phone" data-attr="'.$phone_no_max_length.'">
                        <span id="phonecheck" >
                            '. esc_html__('Please Enter Phone Number','simple-lead-gen-form').'
                        </span>

                        <label for="user_email"><b>'.$email_label.'</b></label>
                        <input type="email" placeholder="Enter Email" name="user_email" id="user_email" data-attr="'.$email_max_length.'">
                        <span id="emailcheck" >
                            '. esc_html__('Please Enter Email','simple-lead-gen-form').'
                        </span>

                        <label for="user_budget"><b>'.$desired_budget_label.'</b></label>
                        <input type="text" placeholder="Enter Desired Budget" name="user_budget" id="user_budget" data-attr="'.$desired_budget_max_length.'">
                        <span id="budgetcheck" >
                            '. esc_html__('Please Enter Desired Budget','simple-lead-gen-form').'
                        </span>

                        <label for="user_msg"><b>'.$message_label.'</b></label>
                        <textarea id="user_msg" name="user_msg" placeholder="Enter message here...." rows="'.$message_row.'" cols="'.$message_row.'" data-attr="'.$message_max_length.'"></textarea>
                        <span id="msgcheck" >
                            '. esc_html__('Please Enter Message','simple-lead-gen-form').'
                        </span>

                        <button type="submit" class="slgf_submit_btn" id="slgf_submit_btn">Submit Data</button>
                    </form>
            </div>';

            return $content;

        }
    }
    global $simple_lead_gen_form;
    $simple_lead_gen_form  = new SIMPLE_LEAD_GEN_FORM();
}