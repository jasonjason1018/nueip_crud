<button><a href="/">返回主頁</a></button>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
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
<style>
	.wrap {
  text-align: center;
  padding-top: 20%;
}
/*.btn {
  background-color: #FFB80C;
  text-decoration: none;
  color: #1e1e1e;
  padding: 16px;
  border-radius: 5px;
}*/

.popup-wrap {
  width: 100%;
  height: 100%;
  display: none;
  position: fixed;
  top: 0px;
  left: 0px;
  content: '';
  background: rgba(0, 0, 0, 0.85);
}

.popup-box {
  width: 50%;
  padding: 50px 75px;
  transform: translate(-50%, -50%) scale(0.5);
  position: absolute;
  top: 50%;
  left: 50%;
  box-shadow: 0px 2px 16px rgba(0, 0, 0, 0.5);
  border-radius: 3px;
  background: #fff;
  text-align: center;
}
h2 {
  font-size: 32px;
  color: #1a1a1a;
}

h3 {
  font-size: 24px;
  color: #888;
}

.close-btn {
  width: 50px;
  height: 50px;
  display: inline-block;
  position: absolute;
  top: 10px;
  right: 10px;
  border-radius: 100%;
  background: #d75f70;
  font-weight: bold;
  text-decoration: none;
  color: #fff;
  line-height: 40px;
  font-size: 32px;
}

.transform-in, .transform-out {
  display: block;
  -webkit-transition: all ease 0.5s;
  transition: all ease 0.5s;
}

.transform-in {
  -webkit-transform: translate(-50%, -50%) scale(1);
  transform: translate(-50%, -50%) scale(1);
}

.transform-out {
  -webkit-transform: translate(-50%, -50%) scale(0.5);
  transform: translate(-50%, -50%) scale(0.5);
}
</style>
<table border="10" data-ajax="false">
	<tr>
		<td>帳號</td>
		<td>姓名</td>
		<td>性別</td>
		<td>生日</td>
		<td>信箱</td>
		<td>備註</td>
		<td></td>
	</tr>
	@foreach($data as $k=>$v)
		<tr>
			<td id="account">{{$v->account}}</td>
			<td id="name">{{$v->name}}</td>
			@if($v->sex == 1)
				<td id="sex">男</td>
			@else
				<td id="sex">女</td>
			@endif
			<td id="birthday">{{$v->birthday}}</td>
			<td id="mail">{{$v->mail}}</td>
			<td id="remark">{{$v->remark}}</td>
			<td><button><a class="btn popup-btn" href="#letmeopen">編輯</a></button></td>
		</tr>
	@endforeach
</table>
			<div class="popup-wrap" id="letmeopen">
			  <div class="popup-box transform-out">
			  	<h2>帳號<input style="width:600px;height:60px;font-size:36px" type="text" id="account" value=""></h2>
			  	<h2>姓名<input style="width:600px;height:60px;font-size:36px" type="text" id="name" value=""></h2>
			  	<h2>性別
			  		<select name="sex" id="sex" style="width:600px;height:60px;font-size:36px">
			  				<option value="1">男</option><!--selected="selected" -->
			  				<option value="0">女</option>
			  		</select>
			  	</h2>
			  	
			  	<h2>生日<select class="sel_year" rel="2000" name="b_y" style="width:150px;height:60px;font-size:20px"> </select> 年
				<select class="sel_month" rel="2" name="b_m" style="width:150px;height:60px;font-size:20px"> </select> 月
				<select class="sel_day" rel="14" name="b_d" style="width:150px;height:60px;font-size:20px"> </select> 日</h2>

			    <a class="close-btn popup-close" href="#">x</a>
			  </div>
			</div>
<script>
$(".popup-btn").click(function() {
  var href = $(this).attr("href")
  $(href).fadeIn(250);
  $(href).children$("popup-box").removeClass("transform-out").addClass("transform-in");
  e.preventDefault();
});
/*function openwindow(){
  var href = $(this).attr("href")
  $(href).fadeIn(250);
  $(href).children$("popup-box").removeClass("transform-out").addClass("transform-in");
  e.preventDefault();
}*/

$(".popup-close").click(function() {
  closeWindow();
});
// $(".popup-wrap").click(function(){
//   closeWindow();
// })
function closeWindow(){
  $(".popup-wrap").fadeOut(200);
  $(".popup-box").removeClass("transform-in").addClass("transform-out");
  event.preventDefault();
}
</script>
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

</html>