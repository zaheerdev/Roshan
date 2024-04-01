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

if (!function_exists('implode_data')) {

    /**
     * implode_data
     *
     * @param  mixed $data
     * @return void
     */
    function implode_data($data)
    {

        if ($data) {
            $result = implode(',', $data);
        } else {
            $result = "";
        }

        return $result;
    }
} //function ends

if (!function_exists('explode_data')) {

    /**
     * implode_data
     *
     * @param  mixed $data
     * @return void
     */
    function explode_data($data)
    {

        if ($data) {
            $result = explode(',', $data);
        } else {
            $result = "";
        }

        return $result;
    }
} //function ends

if (!function_exists('redirect_session')) {
    function redirect_session()
    {
        $_SESSION['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
        redirect(BASE_URL . 'auth/login');
    }
} //function ends

if (!function_exists('beautify_implode')) {
    function beautify_implode($data)
    {
        $data = explode(',', $data);
        return implode(', ', $data);
    }
} //function ends
