<?php

if (!function_exists('dd')) {

    /**
     * dd
     *
     * @param  mixed $data
     * @param  mixed $array
     * @return void
     */

    function dd($data, $array = true)
    {
        echo "<pre>";
        if ($array) {
            print_r($data);
        } else {
            echo $data;
        }
        exit;
    }
} //end function

if (!function_exists('get_order_product_details')) {

    /**
     * get_order_product_details
     *
     * @param  mixed $product_id
     * @return void
     */
    function get_order_product_details($product_id)
    {

        $ci = &get_instance();

        $response = $ci->utility_model->get_order_product_details($product_id);

        if ($response) {
            return $response;
        } else {

            return false;
        }
    }
} //function ends

if (!function_exists('get_order_vendor_details')) {

    /**
     * get_order_vendor_details
     *
     * @param  mixed $vendor_id
     * @return void
     */
    function get_order_vendor_details($vendor_id)
    {

        $ci = &get_instance();

        $response = $ci->utility_model->get_order_vendor_details($vendor_id);

        if ($response) {
            return $response;
        } else {

            return false;
        }
    }
} //function ends

if (!function_exists('generate_random_string')) {

    /**
     * generate_random_string
     *
     * @param  mixed $length
     * @param  mixed $numeric
     * @return void
     */
    function generate_random_string($length, $numeric = false)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($numeric) {
            $characters = '0123456789';
        }
        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
} //function end

if (!function_exists('is_order_delivered')) {
    function is_order_delivered($order_id) {

        $CI =& get_instance();
        
        $is_delivered = $CI->utility_model->is_order_delivered($order_id);

        return $is_delivered;
    }
}