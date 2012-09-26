<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>

    <!-- 自动补充表单试验-->
    <title>sbf</title>
    <script type="text/javascript" src="lib/jquery.js"></script>
    <script type='text/javascript' src="lib/jquery.autocomplete.js"></script>
    <link rel="stylesheet" type="text/css" href="lib/css/jquery.autocomplete.css" />

    <script type='text/javascript' src="js/gsmc_txt.js"></script>
    <script type='text/javascript' src="js/cpmc_txt.js"></script>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  	
    <script type="text/javascript">
      $().ready(function() {	
      	$("#gsmc").focus().autocomplete(gsmc);
      });


      $().ready(function() {	
      	$("#cpmc").focus().autocomplete(cpmc);
      });

      $().ready(function() {	
      	$("#cpmc0").focus().autocomplete(cpmc);
      });

      $().ready(function() {	
      	$("#cpmc1").focus().autocomplete(cpmc);
      });

      $().ready(function() {	
      	$("#cpmc2").focus().autocomplete(cpmc);
      });
    </script>
    <!-- 自动补充表单试验 ---  结束  -->

  </head>
  <body>
    <div class="container">
      
      <form autocomplete="off" id="form2" name="smcp" method="post" action="re.php">
          <legend>Title</legend>
          <label>公司名称 / Name of the company</label>
          <input name="gsmc" type="text" id="gsmc" size="20" placeholder="Type here..."/>
          <label>-&gt; 产品名称 / Name of the product</label>
          <input name="cpmc" type="text" id="cpmc" size="20" placeholder="Type here..."/>
          <input type="submit" name="Submit2" value="产品声明" class="btn"/>
      </form>

      <form autocomplete="off" id="form1" name="form1" method="post" action="gx.php">
        <legend>Title 2</legend>
        <table class="table table-bordered table-hover">
          <tr>
            <td rowspan="5" align="center" valign="middle">
              <label>产品名称 / Name of the company</label>
              <input name="cpmc" type="text" id="cpmc0" size="20" />
            </td>

            <td width="102" rowspan="2">
              <p>开放接口</p>
            </td>
            <td width="58">
              <p align="center">输入</p>
            </td>
            <td width="397" height="60">
              <div align="center">
                <label class="inline checkbox">
                  <input name="in_rss" type="checkbox" id="in_rss" value="rss_in" />
                  RSS
                </label>
                <label class="inline checkbox">
                  <input name="in_email" type="checkbox" id="in_email" value="email_in" />
                  Email
                </label> 
                <span class="STYLE3"> □ IM </span>
                <!--input name="in_im" type="checkbox" id="in_im" value="im_in" /-->
                <span class="STYLE3"> □ SMS</span>      
                <!--input name="in_sms" type="checkbox" id="in_sms" value="sms_in" /-->
                <span class="STYLE3">  □ SOUnd</span>
                <!--input name="in_sound" type="checkbox" id="in_sound" value="sound_in" /-->
              </div>
            </td>
          </tr>
          <tr>
            <td><div align="center">输出</div></td>
             <td width="397" height="60">
              <div align="center">
                <label class="inline checkbox">
                  <input name="out_rss" type="checkbox" id="out_rss" value="rss_out" />
                  RSS
                </label>
                <label class="inline checkbox">
                  <input name="out_email" type="checkbox" id="out_email" value="email_out" />
                  Email
                </label> 
                <span class="STYLE3"> □ IM </span>
                <!--input name="in_im" type="checkbox" id="in_im" value="im_in" /-->
                <span class="STYLE3"> □ SMS</span>      
                <!--input name="in_sms" type="checkbox" id="in_sms" value="sms_in" /-->
                <span class="STYLE3">  □ SOUnd</span>
                <!--input name="in_sound" type="checkbox" id="in_sound" value="sound_in" /-->
              </div>
            </td>
          </tr>
          <tr>
            <td height="10" colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2"><div align="center">有限接口</div></td>
            <td><div align="center">输入</div>        
            <div align="center"></div></td>
            <td height="60"><label>
              <div align="center">
                <input name="cp1" type="text" id="cpmc1" size="20" />
                -&gt; 
                <select name="gxi1" id="gxi1">
                  <option value="api" selected="selected">API</option>
                  <option value="im">IM</option>
                  <option value="sms">SMS</option>
                  <option value="sound">Sound</option>
                </select>
                -&gt; 本产品</div>
            </label></td>
          </tr>
          <tr>
            <td height="60"><div align="center">输出</div></td>
            <td><div align="center">本产品 -&gt; 
                <select name="gxi2" id="gxi2">
                  <option value="api" selected="selected">API</option>
                  <option value="im">IM</option>
                  <option value="sms">SMS</option>
                  <option value="sound">Sound</option>
                </select> 
              -&gt;  
              <input name="cp2" type="text" id="cpmc2" size="20" />
            </div></td>
          </tr>
        </table>
        <p align="center">
          <label>
          <input type="submit" name="Submit3" value="关系声明" />
        </label></p>
      </form>

      <p align="center">&nbsp;</p>
      <p align="center"><a href="README.txt">readme.txt</a></p>
      <p align="center"><a href="nodes.csv">nodes.csv</a> <a href="nodes.txt">nodes.txt</a> | <a href="edges.csv">edges.csv</a> <a href="edges.txt">edges.txt</a></p>
      <p align="center">&nbsp;</p>
      <p align="center">Sharism Lab 2012</p>

    </div>
  </body>

</html>
