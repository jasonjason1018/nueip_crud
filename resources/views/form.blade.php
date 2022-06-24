<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script type="text/javascript">
	$(function () {
	$.ms_DatePicker({
            YearSelector: ".sel_year",
            MonthSelector: ".sel_month",
            DaySelector: ".sel_day"
    });
});
	(function($){
$.extend({
ms_DatePicker: function (options) {
   var defaults = {
         YearSelector: "#sel_year",
         MonthSelector: "#sel_month",
         DaySelector: "#sel_day",
         FirstText: "--",
         FirstValue: 0
   };
   var opts = $.extend({}, defaults, options);
   var $YearSelector = $(opts.YearSelector);
   var $MonthSelector = $(opts.MonthSelector);
   var $DaySelector = $(opts.DaySelector);
   var FirstText = opts.FirstText;
   var FirstValue = opts.FirstValue;

   // 初始化
   var str = "<option value=\"" + FirstValue + "\">"+FirstText+"</option>";
   $YearSelector.html(str);
   $MonthSelector.html(str);
   $DaySelector.html(str);

   // 年份列表
   var yearNow = new Date().getFullYear();
   var yearSel = $YearSelector.attr("rel");
   for (var i = yearNow; i >= 1900; i--) {
		var sed = yearSel==i?"selected":"";
		var yearStr = "<option value=\"" + i + "\" " + sed+">"+i+"</option>";
        $YearSelector.append(yearStr);
   }

    // 月份列表
	var monthSel = $MonthSelector.attr("rel");
    for (var i = 1; i <= 12; i++) {
		var sed = monthSel==i?"selected":"";
        var monthStr = "<option value=\"" + i + "\" "+sed+">"+i+"</option>";
        $MonthSelector.append(monthStr);
    }

    // 日列表(仅当选择了年月)
    function BuildDay() {
        if ($YearSelector.val() == 0 || $MonthSelector.val() == 0) {
            // 未选择年份或者月份
            $DaySelector.html(str);
        } else {
            $DaySelector.html(str);
            var year = parseInt($YearSelector.val());
            var month = parseInt($MonthSelector.val());
            var dayCount = 0;
            switch (month) {
                 case 1:
                 case 3:
                 case 5:
                 case 7:
                 case 8:
                 case 10:
                 case 12:
                      dayCount = 31;
                      break;
                 case 4:
                 case 6:
                 case 9:
                 case 11:
                      dayCount = 30;
                      break;
                 case 2:
                      dayCount = 28;
                      if ((year % 4 == 0) && (year % 100 != 0) || (year % 400 == 0)) {
                          dayCount = 29;
                      }
                      break;
                 default:
                      break;
            }
					
			var daySel = $DaySelector.attr("rel");
            for (var i = 1; i <= dayCount; i++) {
				var sed = daySel==i?"selected":"";
				var dayStr = "<option value=\"" + i + "\" "+sed+">" + i + "</option>";
                $DaySelector.append(dayStr);
             }
         }
      }
      $MonthSelector.change(function () {
         BuildDay();
      });
      $YearSelector.change(function () {
         BuildDay();
      });
	  if($DaySelector.attr("rel")!=""){
		 BuildDay();
	  }
   } // End ms_DatePicker
});
})(jQuery);
</script>
<button><a href="/">返回主頁</a></button>
<table border="10">
	<form method="post" action="/insert_data" id="data-form">
		@csrf
		<tr>
			<td>帳號</td>
			<td><input type="text" name="account" id="account" autocomplete="off"></td>
		</tr>
		<tr>
			<td>姓名</td>
			<td><input type="text" name="name" id="name" autocomplete="off"></td>
		</tr>
		<tr>
			<td>性別</td>
			<td>
				<select name="sex" id="sex">
					<option value="1">男</option>
					<option value="0">女</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>生日</td>
			<!--<td><input type="text" name="birthday" id="datepicker2" autocomplete="off"></td>-->
			<td><select class="sel_year" rel="2000" name="b_y"> </select> 年
			<select class="sel_month" rel="2" name="b_m"> </select> 月
			<select class="sel_day" rel="14" name="b_d"> </select> 日</td>
		</tr>
		<tr>
			<td>信箱</td>
			<td><input type="text" name="mail" id="mail" autocomplete="off"></td>
		</tr>
		<tr>
			<td>備註</td>
			<td><textarea name="remark"></textarea></td>
		</tr>
	</form>
		<tr>
			<td><button id="send_data">送出</button></td>
		</tr>
</table>

<script>
	$("#account").change(function(){
		var regNumber = /\d+/;
		var regString = /[a-zA-Z]+/;
		var check2 = /[^@$!%*?&\s]$/;
		account = $("#account").val();
		if(!regNumber.test(account) && regString.test(account)){
			if(account!=""){
				alert('請輸入英文+數字的帳號');
				$("#account").val("");
			}else{
				alert('請填寫帳號');
			}
		}else{
			if(!check2.test(account)){
				if(account!=""){
					alert('帳號不能包含特殊符號');
					$("#account").val("");
				}else{
					alert('請填寫帳號');
				}
			}
		}
	});
	$("#mail").change(function(){
		mail = $("#mail").val();
		var checkmail = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(!checkmail.test(mail)){
			if(mail!=""){
				alert('email格式錯誤');
				$('#mail').val("");
			}else{
				alert('請填寫email');
			}
		}
	});
	$("#send_data").click(function(){
		sex = $("#sex").val();
		mail = $("#mail").val();
		account = $("#account").val();
		name = $("#name").val();
		if(sex == ""){
			alert('請選擇性別');
		}else if(mail == ''){
			alert('請填寫email');
		}else if(account == ''){
			alert('請填寫帳號');
		}else if(name == ''){
			alert('請填寫姓名');
		}else{
			$("#data-form").submit();	
		}
	});
</script>
<script>
	$(function() {
    $("#datepicker2").datepicker({
          altField : "#datepicker2",
          altFormat : "yy/mm/dd",
          dateFormat : "yy/mm/dd",
          //星期 此用於dateFormat的顯示，以及日曆框中滑鼠移到星期標題的顯示
          dayNames : [ "星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六" ],
          //星期 此用於dateFormat的顯示
          dayNamesShort : [ "日", "一", "二", "三", "四", "五", "六" ],
          //星期  日曆框中的標題
          dayNamesMin : [ "日", "一", "二", "三", "四", "五", "六" ],
          //設定月份名稱
          monthNames : [ "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月","10月", "11月", "12月" ],
          //設定月份縮寫
          monthNamesShort : [ "1", "2", "3", "4", "5", "6", "7", "8", "9","10", "11", "12" ],
          //設定 Next 鏈結文字
          nextText : "下個月",
          //設定 Prev 鏈結文字
          prevText : "上個月",
        });
  });
</script>