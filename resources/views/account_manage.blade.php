<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://jqueryui.com/resources/demos/external/jquery.bgiframe-2.1.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<button id="newdataop">新增</button>
@foreach($data as $k=>$v)
<script type="text/javascript">
  $(function () {
  $.ms_DatePicker({
            YearSelector: ".sel_year{{$k}}",
            MonthSelector: ".sel_month{{$k}}",
            DaySelector: ".sel_day{{$k}}"
    });
});
  (function($){
$.extend({
ms_DatePicker: function (options) {
   var defaults = {
         YearSelector: "#sel_year{{$k}}",
         MonthSelector: "#sel_month{{$k}}",
         DaySelector: "#sel_day{{$k}}",
         FirstText: "--",
         FirstValue: 0
   };
   var opts = $.extend({}, defaults, options);
   var $YearSelector = $(opts.YearSelector);
   var $MonthSelector = $(opts.MonthSelector);
   var $DaySelector = $(opts.DaySelector);
   var FirstText = opts.FirstText;
   var FirstValue = opts.FirstValue;


   var str = "<option value=\"" + FirstValue + "\">"+FirstText+"</option>";
   $YearSelector.html(str);
   $MonthSelector.html(str);
   $DaySelector.html(str);


   var yearNow = new Date().getFullYear();
   var yearSel = $YearSelector.attr("rel");
   for (var i = yearNow; i >= 1900; i--) {
    var sed = yearSel==i?"selected":"";
    var yearStr = "<option value=\"" + i + "\" " + sed+">"+i+"</option>";
        $YearSelector.append(yearStr);
   }


  var monthSel = $MonthSelector.attr("rel");
    for (var i = 1; i <= 12; i++) {
    var sed = monthSel==i?"selected":"";
        var monthStr = "<option value=\"" + i + "\" "+sed+">"+i+"</option>";
        $MonthSelector.append(monthStr);
    }


    function BuildDay() {
        if ($YearSelector.val() == 0 || $MonthSelector.val() == 0) {

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

  <script>
  $(function() {
    $( "#dialog{{$k}}" ).dialog({
      autoOpen: false,
      height:350,
      width:400
    });
    $( "#opener{{$k}}" ).click(function() {
      $( "#dialog{{$k}}" ).dialog( "open" );
      return false;
    });
  });
  </script>
  <div id="dialog{{$k}}" title="編輯資料" style="display:none">
  <form method="post" action="/update_data" id="updatedata{{$k}}">
    @csrf
      帳號<input type="text" name="account" id="account{{$k}}" autocomplete="off" value="{{$v->account}}" onchange="check_account('{{$k}}')"><br>
      姓名<input type="text" name="name" id="name" autocomplete="off" value="{{$v->name}}"><br>
      性別<select name="sex" id="sex">
        @if($v->sex == '1')
          <option value="1" selected=selected>男</option>
        @else
          <option value="1">男</option>
        @endif
        @if($v->sex == '0')
          <option value="0" selected=selected>女</option>
        @else
          <option value="0">女</option>
        @endif
        </select><br>
        @php
          $ymd = explode('-', $v->birthday);
        @endphp
    生日<select class="sel_year{{$k}}" id="sel_year{{$k}}" rel="{{$ymd[0]}}" name="b_y"></select> 年
      <select class="sel_month{{$k}}" id="sel_month{{$k}}" rel="{{$ymd[1]}}" name="b_m"></select> 月
      <select class="sel_day{{$k}}" id="sel_day{{$k}}" rel="{{$ymd[2]}}" name="b_d"></select> 日<br>
    信箱<input type="text" name="mail" id="mail{{$k}}" autocomplete="off" value="{{$v->mail}}" onchange="check_mail('{{$k}}')"><br>
    備註<textarea name="remark"></textarea><br>
    <input type="hidden" name="sno" value="{{$v->sno}}">
  </form>
  <button onclick="update_data('{{$k}}')">送出</button>
</div>
@endforeach


<script type="text/javascript">
  function check_account(no){
    var regNumber = /\d+/;
    var regString = /[a-zA-Z]+/;
    var check2 = /[^@$!%*?&\s]$/;
    account = $("#account"+no).val();
    if(!regNumber.test(account) && regString.test(account)){
      if(account!=""){
        alert('請輸入英文+數字的帳號');
        $("#account"+no).val("");
      }else{
        alert('請填寫帳號');
      }
    }else{
      if(!check2.test(account)){
        if(account!=""){
          alert('帳號不能包含特殊符號');
          $("#account"+no).val("");
        }else{
          alert('請填寫帳號');
        }
      }
    }
  }
  function check_mail(no){
    mail = $("#mail"+no).val();
    var checkmail = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!checkmail.test(mail)){
      if(mail!=""){
        alert('email格式錯誤');
        $('#mail'+no).val("");
      }else{
        alert('請填寫email');
      }
    }
  };
  function update_data(no){
    var yes = confirm('確定要更新資料嗎');
    if(yes){
      sex = $("#sex"+no).val();
      mail = $("#mail"+no).val();
      account = $("#account"+no).val();
      name = $("#name"+no).val();
      if(sex == ""){
        alert('請選擇性別');
      }else if(mail == ''){
        alert('請填寫email');
      }else if(account == ''){
        alert('請填寫帳號');
      }else if(name == ''){
        alert('請填寫姓名');
      }else{
        $("#updatedata"+no).submit();
      }
    }
  }
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


   var str = "<option value=\"" + FirstValue + "\">"+FirstText+"</option>";
   $YearSelector.html(str);
   $MonthSelector.html(str);
   $DaySelector.html(str);


   var yearNow = new Date().getFullYear();
   var yearSel = $YearSelector.attr("rel");
   for (var i = yearNow; i >= 1900; i--) {
		var sed = yearSel==i?"selected":"";
		var yearStr = "<option value=\"" + i + "\" " + sed+">"+i+"</option>";
        $YearSelector.append(yearStr);
   }


	var monthSel = $MonthSelector.attr("rel");
    for (var i = 1; i <= 12; i++) {
		var sed = monthSel==i?"selected":"";
        var monthStr = "<option value=\"" + i + "\" "+sed+">"+i+"</option>";
        $MonthSelector.append(monthStr);
    }


    function BuildDay() {
        if ($YearSelector.val() == 0 || $MonthSelector.val() == 0) {

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
			<td><button id="opener{{$k}}">編輯</button></td>
      <td><button onclick="deletedata('{{$v->sno}}')"><a class="btn popup-btn" href="javascript:void(0)">刪除</a></button>
      </td>
		</tr>
	@endforeach
</table>
<script>
$(function() {
    $( "#newdata" ).dialog({
      autoOpen: false,
      height:350,
      width:400
    });
    $( "#newdataop" ).click(function() {
      $( "#newdata" ).dialog( "open" );
      return false;
    });
  });
  </script>
  <div id="newdata" title="新增資料" style="display:none">
  <form method="post" action="/insert_data" id="newdata-form">
    @csrf
      帳號<input type="text" name="account" id="newaccount" autocomplete="off"><br>
      姓名<input type="text" name="name" id="newname" autocomplete="off"><br>
      性別<select name="sex" id="newsex">
          <option value="1">男</option>
          <option value="0">女</option>
        </select><br>
    生日<select class="sel_year" rel="2000" name="b_y"> </select> 年
      <select class="sel_month" rel="2" name="b_m"> </select> 月
      <select class="sel_day" rel="14" name="b_d"> </select> 日<br>
    信箱<input type="text" name="mail" id="newmail" autocomplete="off"><br>
    備註<textarea name="remark"></textarea><br>
  </form>
  <button id="send_data">送出</button>
</div>
<script>
function deletedata(sno){
  var yes = confirm('確定要刪除資料嗎');
  if(yes){
    window.location='/delete_data/'+sno;
  }
}
</script>
<script>
	$("#newaccount").change(function(){
		var regNumber = /\d+/;
		var regString = /[a-zA-Z]+/;
		var check2 = /[^@$!%*?&\s]$/;
		account = $("#newaccount").val();
		if(!regNumber.test(account) && regString.test(account)){
			if(account!=""){
				alert('請輸入英文+數字的帳號');
				$("#newaccount").val("");
			}else{
				alert('請填寫帳號');
			}
		}else{
			if(!check2.test(account)){
				if(account!=""){
					alert('帳號不能包含特殊符號');
					$("#newaccount").val("");
				}else{
					alert('請填寫帳號');
				}
			}
		}
	});
	$("#newmail").change(function(){
		mail = $("#newmail").val();
		var checkmail = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(!checkmail.test(mail)){
			if(mail!=""){
				alert('email格式錯誤');
				$('#newmail').val("");
			}else{
				alert('請填寫email');
			}
		}
	});
	$("#send_data").click(function(){
		sex = $("#newsex").val();
		mail = $("#newmail").val();
		account = $("#newaccount").val();
		name = $("#newname").val();
		if(sex == ""){
			alert('請選擇性別');
		}else if(mail == ''){
			alert('請填寫email');
		}else if(account == ''){
			alert('請填寫帳號');
		}else if(name == ''){
			alert('請填寫姓名');
		}else{
			$("#newdata-form").submit();	
		}
	});
</script>

</html>