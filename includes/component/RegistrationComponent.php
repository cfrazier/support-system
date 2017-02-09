<?php

namespace SmartcatSupport\component;

use smartcat\core\AbstractComponent;
use smartcat\mail\Mailer;
use SmartcatSupport\descriptor\Option;

class RegistrationComponent extends AbstractComponent {

    public function register_user() {
        $form = include $this->plugin->config_dir . '/register_user_form.php';

        if( $form->is_valid() ) {
            $data = $form->data;
            $data['password'] = wp_generate_password();

            $user_id = wp_insert_user(
                array(
                    'user_login'    => $data['email'],
                    'user_email'    => $data['email'],
                    'first_name'    => $data['first_name'],
                    'last_name'     => $data['last_name'],
                    'role'          => 'support_user',
                    'user_pass'     => $data['password']
                )
            );

            add_filter( 'parse_email_template', function( $content, $recipient ) use ( $data ) {
                if( $recipient == $data['email'] ) {
                    $content = str_replace( '{%password%}', $data['password'], $content );
                }

                return $content;
            }, 10, 3 );

            Mailer::send_template( get_option( Option::WELCOME_EMAIL_TEMPLATE ), $data['email'] );

            wp_set_auth_cookie( $user_id );
            wp_send_json_success();
        } else {
            wp_send_json_error( $form->errors );
        }
    }

    public function subscribed_hooks() {
        return array(
            'wp_ajax_nopriv_support_register_user' => array( 'register_user' )
        );
    }
}