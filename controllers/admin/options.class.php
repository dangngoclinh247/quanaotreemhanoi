<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/13/2015
 * Time: 11:53 PM
 */

namespace controllers\admin;


use library\Alert;

class options extends Admin_Controllers
{
    public function __construct()
    {
        parent::__construct();

        $this->views->form = array(
            array(
                "name" => "Tên Website",
                "option_name" => "website_title",
                "type" => "input"
            ),
            array(
                "name" => "SEO Title Trang Chủ",
                "option_name" => "website_seo_title",
                "type" => "input"
            ),
            array(
                "name" => "SEO Description Trang Chủ",
                "option_name" => "website_seo_description",
                "type" => "textarea",
                "size" => "4"
            ),
            array(
                "name" => "Thông tin dưới chân website",
                "option_name" => "website_footer",
                "type" => "textarea",
                "size" => "3"
            ),
            array(
                "name" => "Tên Công Ty",
                "option_name" => "company_name",
                "type" => "input"
            ),
            array(
                "name" => "Tên Công Ty (Viết tắt)",
                "option_name" => "company_name_short",
                "type" => "input"
            ),
            array(
                "name" => "Địa chỉ",
                "option_name" => "company_address",
                "type" => "input"
            ),
            array(
                "name" => "Điện thoại di động",
                "option_name" => "company_phone1",
                "type" => "input"
            ),
            array(
                "name" => "Điện thoại cố định",
                "option_name" => "company_phone2",
                "type" => "input"
            ),
            array(
                "name" => "Địa Chỉ Email",
                "option_name" => "company_email",
                "type" => "input"
            ),
            array(
                "name" => "Website Name",
                "option_name" => "company_website_name",
                "type" => "input"
            ),
            array(
                "name" => "Website Url",
                "option_name" => "company_website",
                "type" => "input"
            ),
            array(
                "name" => "Footer Thanh  Toán h4",
                "option_name" => "footer_payment_name",
                "type" => "input"
            ),
            array(
                "name" => "Footer Thanh Toán",
                "option_name" => "footer_payment",
                "type" => "textarea",
                "size" => 7
            ),
            array(
                "name" => "Footer mở cửa (text)",
                "option_name" => "footer_open",
                "type" => "input"
            ),
            array(
                "name" => "Footer Widget 1 h4",
                "option_name" => "footer_widget1_h4",
                "type" => "input"
            ),
            array(
                "name" => "Footer Widget 1",
                "option_name" => "footer_widget1",
                "type" => "textarea",
                "size" => 7
            ),
            array(
                "name" => "Footer Widget 2 h4",
                "option_name" => "footer_widget2_h4",
                "type" => "input"
            ),
            array(
                "name" => "Footer Widget 2",
                "option_name" => "footer_widget2",
                "type" => "textarea",
                "size" => 7
            ),
            array(
                "name" => "Footer Widget 3 h4",
                "option_name" => "footer_widget3_h4",
                "type" => "input"
            ),
            array(
                "name" => "Footer Widget 3",
                "option_name" => "footer_widget3",
                "type" => "textarea",
                "size" => 7
            ),
            array(
                "name" => "Footer Widget 4 h4",
                "option_name" => "footer_widget4_h4",
                "type" => "input"
            ),
            array(
                "name" => "Footer Widget 4",
                "option_name" => "footer_widget4",
                "type" => "textarea",
                "size" => 7
            ),
            array(
                "name" => "Số sản phẩm trên 1 trang",
                "option_name" => "products_per_page",
                "type" => "input"
            ),
            array(
                "name" => "Hình người dùng mặt định",
                "option_name" => "img_user",
                "type" => "input"
            ),
            array(
                "name" => "Hình sản phẩm mặt định",
                "option_name" => "img_product",
                "type" => "input"
            )
        );
    }

    public function index()
    {
        $options_model = new \models\Options();
        if(isset($_POST['save']))
        {
            unset($_POST['save']);
            foreach($_POST as $option_name => $option_value)
            {
                if($options_model->hasOptionName($option_name))
                {
                    $options_model->setOptionName($option_name);
                    $options_model->setOptionValue($option_value);
                    $options_model->update();
                }
                else
                {
                    $options_model->setOptionName($option_name);
                    $options_model->setOptionValue($option_value);
                    $options_model->insert();
                }
            }
            $message = new Alert();
            $message->setMessage("<strong>Lưu!</strong> Thành công");
            $this->views->message = $message;
        }
        $options_model = new \models\Options();
        $options = $options_model->select_all(\models\Options::AUTOLOAD_YES);
        $this->views->options = $options;

        $this->views->setPageTitle("Thông tin WebSite");
        $this->views->render("admin/options/index");
    }
}