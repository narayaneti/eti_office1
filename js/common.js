// JavaScript Document
$("#login_option").click(function(){
	$( "#login_op_border" ).toggleClass( "login_op_border" );
});
 if ($(window).width() <= 339){
       	$( "#accordionSidebar" ).toggleClass( "toggled" );
  }
 $(function () {

            $(".field-wrapper .field-placeholder").on("click", function () {
                $(this).closest(".field-wrapper").find("input").focus();
            });
            $(".field-wrapper input").on("keyup", function () {
                var value = $.trim($(this).val());
                if (value) {
                    $(this).closest(".field-wrapper").addClass("hasValue");
                } else {
                    $(this).closest(".field-wrapper").removeClass("hasValue");
                }
            });

        });
function imagevalid(file){
	var exts=['jpg','jpeg','png'];
	var result='fail';
	//first check if file has any value
	if(file){
			
			//spilt file name at dot
			var get_ext = file.split('.');
			//reverse name to check extension
			get_ext = get_ext.reverse();
			//check file type is valid as given in 'exts' array
			if($.inArray(get_ext[0].toLowerCase(), exts) > -1){
				result='pass';
				return result;
			}
			else{
				result='fail';
				return result;
			}
			}
			else{
				result='fail';
				return result;
			}
}
