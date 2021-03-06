$(document).ready(function() {
   $(".checkbox-featured").click(function() {
       var pro_id = $(this).attr("data-id");
       var status = $(this).prop("checked");
       var featured = 0;
       if(status == true)
       {
           featured = 1;
       }
       $.ajax({
           url: "/admin.php?c=products&m=featured&p=" + pro_id,
           type: "post",
           data: {
               featured: featured
           },
           success: function(result){
               if(result != "1")
               {
                   alert("Lỗi: " + result);
               }
           },
           error: function(e) {
               alert(e);
           }
       });
   })
});
/**
 * Created by Liam Dang on 9/25/2015.
 */
function to_slug(str)
{
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, '-');

    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, '');

    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, '');

    // return
    return str;
}

/**
 * Get bootstrap components alerts width message and type alert
 * @param message
 * @param type
 * @returns {string}
 */
function getAlert(message, type)
{
    if(typeof type == 'undefined') type = "success";

    var str = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">';
    str += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    str += message;
    str += '</div>';
    return str;
}
