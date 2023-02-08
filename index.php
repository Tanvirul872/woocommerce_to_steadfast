<?php
/*
 * Plugin Name: Woocommerce Order Data Table
 * Description: Displays all the order data for Woocommerce orders in the form of a table
 * Version: 1.0
 * Author: OpenAI
 * Author URI: https://openai.com
 */



/* Include CSS and Script */
add_action('wp_enqueue_scripts','plugin_css_jsscripts');
function plugin_css_jsscripts() {
    // CSS
    wp_enqueue_style( 'style-css', plugins_url( '/style.css', __FILE__ ));

    // JavaScript
    wp_enqueue_script( 'script-js', plugins_url( '/script.js', __FILE__ ),array('jquery'));

    // Pass ajax_url to script.js
    wp_localize_script( 'script-js', 'plugin_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}



function wc_order_data_table_page() {
  add_menu_page(
    'Order Data Table',
    'Order Data Table',
    'manage_options',
    'wc-order-data-table',
    'wc_order_data_table_content',
    'dashicons-admin-generic',
    60
  );
}
add_action( 'admin_menu', 'wc_order_data_table_page' );

function wc_order_data_table_content() {
  if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }
  
// Arguments for get_posts to retrieve all orders
$args = array(
    'post_type' => 'shop_order',
    'post_status' => array_keys( wc_get_order_statuses() ),
    'posts_per_page' => -1,
);



// function post_data_to_api($api_key, $secret_key, $content_type, $data) {
//   $headers = array(
//       'Content-Type: '.$content_type,
//       'Authorization: '.base64_encode($api_key.':'.$secret_key)
//   );

//   $url = 'https://portal.steadfast.com.bd/api/v1/create_order';
//   $args = array(
//       'headers' => $headers,
//       'body' => $data
//   );
//   $response = wp_remote_post($url, $args);

//   if (is_wp_error($response)) {
//       return $response->get_error_message();
//   } else {
//       return $response['body'];
//   }
// }



// $api_key = '8itkm2wuwftjvpmwdggps7bspg5zrife';
// $secret_key = 'dpgvyrbhgjr8uks8f3lraxp6';
// $content_type = 'application/json';
// $data = array(
//   'invoice' => '12345',
//   'recipient_name' => 'tanvir test',
//   'recipient_phone' => '01966927688',
//   'recipient_address' => 'address 1, city 1',
//   'cod_amount' => '123',
//   'note' => 'test order from api',
// );
// $data = json_encode($data);
// $result = post_data_to_api($api_key, $secret_key, $content_type, $data);

// echo '<pre>'; 
// print_r($result);
// echo '</pre>';




// // Prepare the API request to retrieve shipping rates
// $api_url = 'https://portal.steadfast.com.bd/api/v1/create_order';


//   $api_key = '8itkm2wuwftjvpmwdggps7bspg5zrife' ; 
//   $secret_key = 'dpgvyrbhgjr8uks8f3lraxp6' ; 
// 		$headers = array(
		
// 		'Api-Key:'.$api_key,
// 		'Secret-Key:'.$secret_key,
// 		'Content-Type:application/json, charset=UTF-8',
		
// 	);
// $data = array(

// 'invoice' => '12345',
// 'recipient_name' => 'tanvir test',
// 'recipient_phone' => '01966927688',
// 'recipient_address' => 'address 1, city 1',
// 'cod_amount' => '123',
// 'note' => 'test order from api',
  
// );

// // Send the API request and get the response
// $response = wp_remote_post( $api_url, array(
//     'method' => 'POST',
//     'headers' => $headers,
//     'body' => json_encode( $data ),
// ) );

// // Check if the API request was successful
// if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
//     echo '<pre>'; 
// 	print_r($response);
//     echo '</pre>';
	
// } else {
// 	print_r($response);
//     // Parse the shipping rates from the API response
//     $shipping_rates = json_decode( wp_remote_retrieve_body( $response ) );
// }




// $api_url = 'https://portal.steadfast.com.bd/api/v1/create_order';


  $api_key = '8itkm2wuwftjvpmwdggps7bspg5zrife' ; 
  $secret_key = 'dpgvyrbhgjr8uks8f3lraxp6' ; 

  

$headers = array(
    "Content-Type" => "application/json",
    // "Authorization" => "Bearer.$api_key.$secret_key",
    "Api-Key" => $api_key,
    "Secret-Key" => $secret_key,
);

// $username = "Choruighor";
// $password = "choruighor@872";

// $headers = array(
//     "Content-Type" => "application/json",
//     "Authorization" => "Basic " . base64_encode("$username:$password")
// );


$data = array(
  'invoice' => '1234522222',
  'recipient_name' => 'tanvir test',
  'recipient_phone' => '01966927688',
  'recipient_address' => 'address 1, city 1',
  'cod_amount' => '123',
  'note' => 'test order from api',
);

$url = "https://portal.steadfast.com.bd/api/v1/create_order";

$response = wp_remote_post( $url, array(
    'method' => 'POST',
    'timeout' => 45,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => $headers,
    'body' => json_encode($data),
    'cookies' => array()
) );

if ( is_wp_error( $response ) ) {
    // Handle error response
} else {
    $status_code = wp_remote_retrieve_response_code( $response );
    if ($status_code == 200) {
      echo '<pre>'; 
      	print_r($response);
          echo '</pre>';
    } else {
        // Handle error response

        echo '<pre>'; 
      	print_r($response);
          echo '</pre>';
    }
}




// Get all the orders
$orders = get_posts( $args );

  echo '<div class="wrap">';
  echo '<h1>Order Data Table</h1>';
  echo '<table class="wp-list-table widefat fixed striped posts">';
  echo '<thead>';
  echo '<tr>';
  echo '<th scope="col">Order ID</th>';
  echo '<th scope="col">Customer name</th>';
  echo '<th scope="col">Customer Address</th>';
  echo '<th scope="col">Customer Phone</th>';
  echo '<th scope="col">Customer Email</th>';
  echo '<th scope="col">Customer Cod </th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

// Loop through each order and get the order ID
foreach ( $orders as $order_get_id ) {
    $order_id = $order_get_id->ID;

    // Do something with the order ID, such as retrieve order data
    // ...
	
	
	// Get the order object for a given order ID
$order = wc_get_order( $order_id );

// Get the email address associated with the order
$email = $order->get_billing_email();

// Get the total order amount
$order_total = $order->get_total();





// Get the billing address
$billing_first_name = $order->get_billing_first_name();
$billing_last_name = $order->get_billing_last_name();
$billing_address_1 = $order->get_billing_address_1();
$billing_address_2 = $order->get_billing_address_2();
$billing_city = $order->get_billing_city();
$billing_state = $order->get_billing_state();
$billing_postcode = $order->get_billing_postcode();
$billing_country = $order->get_billing_country();

// Get the shipping address
$shipping_first_name = $order->get_shipping_first_name();
$shipping_last_name = $order->get_shipping_last_name();
$shipping_address_1 = $order->get_shipping_address_1();
$shipping_address_2 = $order->get_shipping_address_2();
$shipping_city = $order->get_shipping_city();
$shipping_state = $order->get_shipping_state();
$shipping_postcode = $order->get_shipping_postcode();
$shipping_country = $order->get_shipping_country();

// Get the customer phone number
$billing_phone = $order->get_billing_phone();

// Get the customer email address
$billing_email = $order->get_billing_email();

    echo '<tr>';
    echo '<td>' . $order_id. '</td>';
    echo '<td>' . $billing_first_name.' '.$billing_last_name . '</td>';
    echo '<td>' . $billing_address_1.$billing_address_2. '</td>';
    echo '<td>' . $billing_phone.  '</td>';
    echo '<td>' . $billing_email . '</td>';
	echo '<td>' . $order_total . '</td>';
	echo '</tr>';

}


echo '</tbody>';
echo '</table>';
echo '</div>';

}
 ?> 





