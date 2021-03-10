<?php
// add_action('wp_ajax_contact_us', 'handle_contact_us_form');
// add_action('wp_ajax_nopriv_contact_us', 'handle_contact_us_form');

function handle_contact_us_form()
{
    if (empty($_POST) || !wp_verify_nonce($_POST['contact_us_nonce'], 'contact_us')) {
        echo json_encode([
            'error' => 'Извините, проверочные данные не соответствуют'
        ]);
        exit;
    }

    // $username = sanitize_text_field($_POST['username']);
    // $email = sanitize_text_field($_POST['email']);
    // $message = sanitize_text_field($_POST['msg']);

    $response = array();


    // $data = get_field('form_contacts', 'options');
    // $recipients = [];

    // foreach ($data['recipients'] as $row) :
    //     $recipients[] = $row['email'];
    // endforeach;

    // $is_send_ok = wp_mail(
    //     $recipients,
    //     'Обратная связь',
    //     str_replace(
    //         array('[username]', '[email]', '[message]'),
    //         array($username, $email, apply_filters('the_content', $message)),
    //         $data['email_body']
    //     ),
    //     array('content-type: text/html')
    // );

    // if ($is_send_ok == false) {
    //     $response['error'] = 'Ошибка! Письмо не отправлено!';
    // }

    // Debug data
    // if (!empty($response['error'])) {
    //     $response['admin_fields'] = $data;
    //     $response['post_fields'] = [
    //         $username,
    //         $email,
    //         $message
    //     ];
    // }

    // Send response in json format
    echo json_encode($response);

    // Exit script and close wp functionallity
    wp_die();
}