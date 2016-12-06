<?php
/**
 * Created by PhpStorm.
 * User: sudeeptalati
 * Date: 29/12/2015
 * Time: 16:02
 */

class Workcarriedout extends CFormModel
{

    public $product_serial_number_available;
    public $product_serial_number;
    public $product_serial_number_unavailable_reason;
    public $product_plating_image;
    public $product_plating_image_url;


    public $work_done;
    public $first_visit_date;
    public $job_completion_date;
    public $chat_message;

    public $spares_used;
    public $spare_part_number_or_name;
    public $spare_qty;
    public $spares_array;



    public function rules()
    {
        return array(
            array('first_visit_date, job_completion_date, spares_used,work_done, product_serial_number_available, product_serial_number_unavailable_reason, product_serial_number', 'required'),
            array('product_serial_number', 'length', 'max' => 14, 'min' => 14, 'message' =>'Please enter exact 14 digits serial number'),
            array('product_serial_number_available, product_serial_number, spares_used, spare_qty', 'numerical'),
            array('product_plating_image', 'file', 'types'=>'jpeg, jpg, gif, png', 'minSize'=>100, 'maxSize'=>1024*1024*10 , 'allowEmpty'=>true),

            array('product_plating_image_url, product_serial_number_unavailable_reason, work_done, first_visit_date, job_completion_date, chat_message, spare_part_number_or_name, spares_array', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'product_serial_number_available' => 'Is Product Serial Number Available',
            'product_serial_number_unavailable_reason' => 'Please provide reasons',
            'product_serial_number' => 'Product Serial Number',
            'product_plating_image' => 'Product Plating Image',
            'product_plating_image_url' => 'Product Plating Image URL',


            'work_done' => 'Please state nature of fault and work carried out',

            'first_visit_date' => 'First Visit Date',
            'job_completion_date' => 'Job Completion date',
            'chat_message' => 'Reply to this Message',

            'spares_used' => 'Did you use any spares',
            'spare_part_number_or_name' => 'Part Number or Name',
            'spare_qty' => 'Quantity',
            'spares_array' => 'Spares',

        );
    }

}///end of class