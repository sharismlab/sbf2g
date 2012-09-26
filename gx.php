<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<a href="index.php"><center>返回输入</center></a>
<?php
include('inc.php');
/* 全部变量名称

产品：			$cp_name			$cp_id

开放接口

	输入：
		rss：	in_rss_name			in_rss_id
		email：	in_email_name		in_email_id
		im		in_im_name			in_im_id
		sms：	in_sms_name			in_sms_id
		sound：	in_sound_name		in_sound_id

	输出
		rss：	out_rss_name		out_rss_id
		email：	out_email_name		out_email_id
		im		out_im_name			out_im_id
		sms：	out_sms_name		out_sms_id
		sound：	out_sound_name		out_sound_id

有限接口

	传递变量：	gxi1				gxi2

	产品1：
				cp_in_name			cp_in.id  	//产品 对应 产品1 的管道
				
				cp1_name			cp1_id		//产品1的名称
				cp1_out_name		cp1_out_id	//产品1输出管道的名称
	产品2：
				cp_out_name			cp_out.id	//产品 对应 产品2 的管道
				
				cp2_name			cp2_id		//产品2的名称
				cp2_in_name			cp2_in_id	//产品2输入管道的名称	
*/

	//------------------------------
	//一、检查与规范来自表单的数据 
	//------------------------------

//格式化表单过来的字符：删除字符首位空白；首字符大写; 管道设置为规范名称
//if (!empty($_POST['cpmc'])) $cp_name=ucfirst(strtolower(trim($_POST['cpmc'])));
if (!empty($_POST['cpmc']))
	{
		$cp_chushi=trim($_POST['cpmc']);						//去头去尾
		$cp_name=substr($cp_chushi,1,strlen($cp_chushi));		//取第一个字符
		if ($cp_chushi{0}=='+') {$cp_name=$cp_name;} else {$cp_name=ucwords(strtolower(trim($_POST['cpmc'])));	}	
	}


if (!empty($_POST['in_rss']) AND !empty($_POST['cpmc'])) 	$in_rss_name=$cp_name.'_'.'RSS_In';			$in_rss_name_2=$cp_name.'_'.'RSS_Out';
if (!empty($_POST['in_email']) AND !empty($_POST['cpmc'])) 	$in_email_name=$cp_name.'_'.'Email_In';		$in_email_name_2=$cp_name.'_'.'Email_Out';
if (!empty($_POST['in_im']) AND !empty($_POST['cpmc'])) 	$in_im_name=$cp_name.'_'.'IM_In';
if (!empty($_POST['in_sms']) AND !empty($_POST['cpmc'])) 	$in_sms_name=$cp_name.'_'.'SMS_In';
if (!empty($_POST['in_sound']) AND !empty($_POST['cpmc'])) 	$in_sound_name=$cp_name.'_'.'Sound_In';

if (!empty($_POST['out_rss']) AND !empty($_POST['cpmc'])) 	$out_rss_name=$cp_name.'_'.'RSS_Out';		$out_rss_name_2=$cp_name.'_'.'RSS_In';
if (!empty($_POST['out_email']) AND !empty($_POST['cpmc'])) $out_email_name=$cp_name.'_'.'Email_Out';	$out_email_name_2=$cp_name.'_'.'Email_In';
if (!empty($_POST['out_im']) AND !empty($_POST['cpmc'])) 	$out_im_name=$cp_name.'_'.'IM_Out';
if (!empty($_POST['out_sms']) AND !empty($_POST['cpmc'])) 	$out_sms_name=$cp_name.'_'.'SMS_Out';
if (!empty($_POST['out_sound']) AND !empty($_POST['cpmc'])) $out_sound_name=$cp_name.'_'.'Sound_Out';

//检查来自下拉框的数据
if (!empty($_POST['gxi1'])) $gxi1=$_POST['gxi1'];	//echo $_POST['gxi1'].'<br>';
if (!empty($_POST['gxi2'])) $gxi2=$_POST['gxi2'];	//echo $_POST['gxi2'].'<br>';

//产品1的数据
//if (!empty($_POST['cp1'])) $cp1_name=ucfirst(strtolower(trim($_POST['cp1'])));
if (!empty($_POST['cp1']))
	{
		$cp1_chushi=trim($_POST['cp1']);						//去头去尾
		$cp1_name=substr($cp1_chushi,1,strlen($cp1_chushi));		//取第一个字符
		if ($cp1_chushi{0}=='+') {$cp1_name=$cp1_name;} else {$cp1_name=ucwords(strtolower(trim($_POST['cp1'])));	}	
	}


if (!empty($cp1_name) and !empty($_POST['cpmc']))
	{		
		if ($gxi1=='sound') {$cp1_out_name=$cp1_name.'_Sound_Out';	$cp_in_name = $cp_name.'_Sound_In';	$tdao_i='Sound_O';}
		if ($gxi1=='api') 	{$cp1_out_name=$cp1_name.'_API_Out';	$cp_in_name = $cp_name.'_API_In';	$tdao_i='API_O';}
		if ($gxi1=='im') 	{$cp1_out_name=$cp1_name.'_IM_Out';		$cp_in_name = $cp_name.'_IM_In';	$tdao_i='IM_O';}
		if ($gxi1=='sms') 	{$cp1_out_name=$cp1_name.'_SMS_Out';	$cp_in_name = $cp_name.'_SMS_In';	$tdao_i='SMS_O';}
	}
	
	
//产品2的数据
//if (!empty($_POST['cp2'])) $cp2_name=ucfirst(strtolower(trim($_POST['cp2'])));
if (!empty($_POST['cp2']))
	{
		$cp2_chushi=trim($_POST['cp2']);						//去头去尾
		$cp2_name=substr($cp2_chushi,1,strlen($cp2_chushi));		//取第一个字符
		if ($cp2_chushi{0}=='+') {$cp2_name=$cp2_name;} else {$cp2_name=ucwords(strtolower(trim($_POST['cp2'])));	}	
	}
	
if (!empty($cp_name) and !empty($cp2_name))
	{		
		if ($gxi2=='sound') {$cp2_in_name=$cp2_name.'_Sound_In';	$cp_out_name = $cp_name.'_Sound_Out';	$tdao_o='Sound_I';}
		if ($gxi2=='api') 	{$cp2_in_name=$cp2_name.'_API_In';		$cp_out_name = $cp_name.'_API_Out';		$tdao_o='API_I';}
		if ($gxi2=='im') 	{$cp2_in_name=$cp2_name.'_IM_In';		$cp_out_name = $cp_name.'_IM_Out';		$tdao_o='IM_I';}
		if ($gxi2=='sms') 	{$cp2_in_name=$cp2_name.'_SMS_In';		$cp_out_name = $cp_name.'_SMS_Out';		$tdao_o='SMS_I';}
	}
	
//判断表单是否具备基本的数据
if(!empty($in_rss_name))$js=1;
if(!empty($in_email_name))$js=1;
if(!empty($in_im_name))$js=1;
if(!empty($in_sms_name))$js=1;
if(!empty($in_sound_name))$js=1;

if(!empty($out_rss_name))$js=1;
if(!empty($out_email_name))$js=1;
if(!empty($out_im_name))$js=1;
if(!empty($out_sms_name))$js=1;
if(!empty($out_sound_name))$js=1;

if(!empty($cp1_name))$js=1;
if(!empty($cp2_name))$js=1;

if (empty($cp_name) or empty($js))
{
	echo "必须有一个产品名称，必须至少有一个产品的接口，否则一切无从开始！";
	}else{  //全部正式代码的开始

	
	//---------------------------------------------
	//二、检查节点文件是否存在，记录或新建节点文件
	//---------------------------------------------
	

//读取节点文件
$sbsbfile=fread(fopen($NodesFile,"r"),filesize($NodesFile));

//把文件变成一行行的数组
$lines=explode("\n",$sbsbfile);

//遍历数组，读产品和管道的id ，//记录最大id ，用于创建新的节点
foreach($lines as $nodes)
{
	$info = explode(",",$nodes,9);
	
	//让 $zuida_id 是最大id值
	if($zuida_id<intval($info[0]))	$zuida_id=intval($info[0]);

	//记录已经存在节点的id  // 和产品的组名称
	if ($info[1] == $cp_name) 									{$cp_id=$info[0];		$cp_group=$info[7];		echo '产品节点 '.$cp_name.' 已经存在。<br>';}
	
	//产品1 
	if (!empty($cp1_name) AND $info[1] == $cp1_name)	 		{$cp1_id=$info[0];		$cp1_group=$info[7];	echo '产品节点 '.$cp1_name.' 已经存在。<br>';}
	if (!empty($cp1_name) AND $info[1] == $cp1_out_name)		{$cp1_out_id=$info[0];	$cp1_group=$info[7];	echo '管道节点 '.$cp1_out_name.' 已经存在。<br>';}
			
	//产品2
	if (!empty($cp2_name) AND $info[1] == $cp2_name) 			{$cp2_id=$info[0];		$cp2_group=$info[7];	echo '产品节点 '.$cp2_name.' 已经存在。<br>';}
	if (!empty($cp2_name) AND $info[1] == $cp2_in_name)			{$cp2_in_id=$info[0];	$cp2_group=$info[7];	echo '管道节点 '.$cp2_in_name.' 已经存在。<br>';}

	if (!empty($cp1_name) AND $info[1] == $cp_in_name) 			{$cp_in_id=$info[0];	echo '管道节点 '.$cp_in_name.' 已经存在。<br>';}
	if (!empty($cp2_name) AND $info[1] == $cp_out_name) 		{$cp_out_id=$info[0];	echo '管道节点 '.$cp_out_name.' 已经存在。<br>';}
		
	if (!empty($in_rss_name) AND $info[1] == $in_rss_name) 		{$in_rss_id=$info[0];	echo '管道节点 '.$in_rss_name.' 已经存在。<br>';}
	if (!empty($in_email_name) AND $info[1] == $in_email_name) 	{$in_email_id=$info[0];	echo '管道节点 '.$in_email_name.' 已经存在。<br>';}
	if (!empty($in_im_name) AND $info[1] == $in_im_name) 		{$in_im_id=$info[0];	echo '管道节点 '.$in_im_name.' 已经存在。<br>';}
	if (!empty($in_sms_name) AND $info[1] == $in_sms_name) 		{$in_sms_id=$info[0];	echo '管道节点 '.$in_sms_name.' 已经存在。<br>';}
	if (!empty($in_sound_name) AND $info[1] == $in_sound_name) 	{$in_sound_id=$info[0];	echo '管道节点 '.$in_sound_name.' 已经存在。<br>';}

	if (!empty($out_rss_name) AND $info[1] == $out_rss_name) 	{$out_rss_id=$info[0];	echo '管道节点 '.$out_rss_name.' 已经存在。<br>';}
	if (!empty($out_email_name) AND $info[1]==$out_email_name) 	{$out_email_id=$info[0];echo '管道节点 '.$out_email_name.' 已经存在。<br>';}
	if (!empty($out_im_name) AND $info[1] == $out_im_name) 		{$out_im_id=$info[0];	echo '管道节点 '.$out_im_name.' 已经存在。<br>';}
	if (!empty($out_sms_name) AND $info[1] == $out_sms_name)	{$out_sms_id=$info[0];	echo '管道节点 '.$out_sms_name.' 已经存在。<br>';}
	if (!empty($out_sound_name) AND $info[1]==$out_sound_name) 	{$out_sound_id=$info[0];echo '管道节点 '.$out_sound_name.' 已经存在。<br>';}
}

	//设置写入节点的文本，并写入节点文件
	$Add_Nodes_Text='';	
	$add_cp='';
	//echo $cp1_group;
	if (empty($cp_group)) {$cp_group=$cp_name;}  //检查，组标识，是否由产品的换为公司的。
	if (!empty($cp1_name) and empty($cp1_group)) {$cp1_group=$cp1_name;}
	if (!empty($cp2_name) and empty($cp2_group)) {$cp2_group=$cp2_name;}
	
	if (!empty($cp_name) AND empty($cp_id)) 				{$cp_id	=++$zuida_id;		$Add_Nodes_Text.="\n$cp_id,$cp_name,$cp_name,cp,$cp_name,,,$cp_group,$w_cp,$date";			$add_cp=',"'.$cp_name.'"';	echo $FH_cp.'新产品 '.$cp_name.' 研发完毕。<br>'.$FH_cp2;}
	if (!empty($cp1_name) AND empty($cp1_id)) 				{$cp1_id=++$zuida_id;		$Add_Nodes_Text.="\n$cp1_id,$cp1_name,$cp1_name,cp,$cp1_name,,,$cp1_group,$w_cp,$date";		$add_cp.=',"'.$cp1_name.'"';	echo $FH_cp.'又一个新产品 '.$cp1_name.' 研发完毕。<br>'.$FH_cp2;}
	if (!empty($cp2_name) AND empty($cp2_id)) 				{$cp2_id=++$zuida_id;		$Add_Nodes_Text.="\n$cp2_id,$cp2_name,$cp2_name,cp,$cp2_name,,,$cp2_group,$w_cp,$date";		$add_cp.=',"'.$cp2_name.'"';	echo $FH_cp.'又一个新产品 '.$cp2_name.' 也研发完毕。<br>'.$FH_cp2;}
	
	//下面文本 建立 “产品” 输入和输出  两个管道
	if (!empty($cp_in_name) AND empty($cp_in_id)) 			{$cp_in_id=++$zuida_id;		$Add_Nodes_Text.="\n$cp_in_id,$cp_in_name,,gd,,$tdao_i,I,$cp_group,$w_gd,$date";			echo $FH_gd.$cp_name.' 的接收装置 '.$cp_in_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($cp_out_name) AND empty($cp_out_id))			{$cp_out_id=++$zuida_id;	$Add_Nodes_Text.="\n$cp_out_id,$cp_out_name,,gd,,$tdao_o,O,$cp_group,$w_gd,$date";			echo $FH_gd.$cp_name.' 的发射器 '.$cp_out_name.' 制造完毕。<br>'.$FH_gd2;}

	if (!empty($in_rss_name) AND empty($in_rss_id))			{$in_rss_id=++$zuida_id;	$Add_Nodes_Text.="\n$in_rss_id,$in_rss_name,,gd,,RSS_I,I,$cp_group,$w_gd,$date";			echo $FH_gd.$cp_name.' 的接收装置 '.$in_rss_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($in_email_name) AND empty($in_email_id))		{$in_email_id=++$zuida_id;	$Add_Nodes_Text.="\n$in_email_id,$in_email_name,,gd,,Email_I,I,$cp_group,$w_gd,$date";		echo $FH_gd.$cp_name.' 的接收装置 '.$in_email_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($in_im_name) AND empty($in_im_id)) 			{$in_im_id=++$zuida_id; 	$Add_Nodes_Text.="\n$in_im_id,$in_im_name,,gd,,IM_I,I,$cp_group,$w_gd,$date";				echo $FH_gd.$cp_name.' 的接收装置 '.$in_im_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($in_sms_name) AND empty($in_sms_id)) 		{$in_sms_id=++$zuida_id;	$Add_Nodes_Text.="\n$in_sms_id,$in_sms_name,,gd,,SMS_I,I,$cp_group,$w_gd,$date";			echo $FH_gd.$cp_name.' 的接收装置 '.$in_sms_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($in_sound_name) AND empty($in_sound_id)) 	{$in_sound_id=++$zuida_id;	$Add_Nodes_Text.="\n$in_sound_id,$in_sound_name,,gd,,Sound_I,I,$cp_group,$w_gd,$date";		echo $FH_gd.$cp_name.' 的接收装置 '.$in_sound_name.' 制造完毕。<br>'.$FH_gd2;}

	if (!empty($out_rss_name) AND empty($out_rss_id)) 		{$out_rss_id=++$zuida_id;	$Add_Nodes_Text.="\n$out_rss_id,$out_rss_name,,gd,,RSS_O,O,$cp_group,$w_gd,$date";			echo $FH_gd.$cp_name.' 的发射器 '.$out_rss_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($out_email_name) AND empty($out_email_id)) 	{$out_email_id=++$zuida_id;	$Add_Nodes_Text.="\n$out_email_id,$out_email_name,,gd,,Email_O,O,$cp_group,$w_gd,$date";	echo $FH_gd.$cp_name.' 的发射器 '.$out_email_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($out_im_name) AND empty($out_im_id)) 		{$out_im_id=++$zuida_id;	$Add_Nodes_Text.="\n$out_im_id,$out_im_name,,gd,,IM_O,O,$cp_group,$w_gd,$date";			echo $FH_gd.$cp_name.' 的发射器 '.$out_im_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($out_sms_name) AND empty($out_sms_id)) 		{$out_sms_id=++$zuida_id;	$Add_Nodes_Text.="\n$out_sms_id,$out_sms_name,,gd,,SMS_O,O,$cp_group,$w_gd,$date";			echo $FH_gd.$cp_name.' 的发射器 '.$out_sms_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($out_sound_name) AND empty($out_sound_id)) 	{$out_sound_id=++$zuida_id;	$Add_Nodes_Text.="\n$out_sound_id,$out_sound_name,,gd,,Sound_O,O,$cp_group,$w_gd,$date";	echo $FH_gd.$cp_name.' 的发射器 '.$out_sound_name.' 制造完毕。<br>'.$FH_gd2;}
	
	//下面文本 - 建立              “产品1”（前面的空格）的输出Out     和      “产品2”（后面的空格）的输入    管道
	if (!empty($cp1_out_name) AND empty($cp1_out_id)) 		{$cp1_out_id=++$zuida_id;	$Add_Nodes_Text.="\n$cp1_out_id,$cp1_out_name,,gd,,$tdao_i,O,$cp1_group,$w_gd,$date";		echo $FH_gd.$cp1_name.' 的发射器 '.$cp1_out_name.' 制造完毕。<br>'.$FH_gd2;}
	if (!empty($cp2_in_name) AND empty($cp2_in_id)) 		{$cp2_in_id=++$zuida_id;	$Add_Nodes_Text.="\n$cp2_in_id,$cp2_in_name,,gd,,$tdao_o,I,$cp2_group,$w_gd,$date";		echo $FH_gd.$cp2_name.' 的接收装置 '.$cp2_in_name.' 制造完毕。<br>'.$FH_gd2;}
		
	$sb = fopen($NodesFile,'a');	
	fwrite($sb,$Add_Nodes_Text);	
	fclose($sb);	
	
	
		//输入补充   -   产品名称
		$cp_quanwen = file_get_contents($cpmcFile);
		$cp_add = fopen($cpmcFile,'w');
		
		//用新的包含公司的字符串 替换 之前全文的末尾		
		if (!empty($cp_name))		
		$add_cp.='];';		
		$tihuan = '];';		
		$cp_add_xiin = str_replace($tihuan,$add_cp,$cp_quanwen);		

		fwrite($cp_add,$cp_add_xiin);		
	
	//---------------------------------------------
	//三、处理产品到管道的数据
	//---------------------------------------------


	//读边文件
	$EdgesFileText=fread(fopen($EdgesFile,"r"),filesize($EdgesFile));

	//边文件转换为数组
	$EdgesLines=explode("\n",$EdgesFileText);

	//遍历数组，检查边是否已经存在
	$e1=$e2=$e3=$e4=$e5=$e6=$e7=$e8=$e9=$e10=$e11=$e12=$e13=$e14=$e15=$e16=0;
	
	foreach($EdgesLines as $Edge)
	{
		$info = explode(",",$Edge,3);	

		if(!empty($in_rss_id) 		AND intval($info[0])==$in_rss_id	AND intval($info[1])==$cp_id) 			{$e1=1;	echo $in_rss_name.' 到 '.$cp_name.' 的边已经存在'.'<br>' ;}
		if(!empty($in_email_id) 	AND intval($info[0])==$in_email_id	AND intval($info[1])==$cp_id)			{$e2=1;	echo $in_email_name.' 到 '.$cp_name.' 的边已经存在'.'<br>';}
		if(!empty($in_im_id) 		AND intval($info[0])==$in_im_id 	AND intval($info[1])==$cp_id) 			{$e3=1;	echo $in_im_name.' 到 '.$cp_name.' 的边已经存在'.'<br>';}
		if(!empty($in_sms_id) 		AND intval($info[0])==$in_sms_id 	AND intval($info[1])==$cp_id) 			{$e4=1;	echo $in_sms_name.' 到 '.$cp_name.' 的边已经存在'.'<br>';}
		if(!empty($in_sound_id) 	AND intval($info[0])==$in_sound_id 	AND intval($info[1])==$cp_id)			{$e5=1;	echo $in_sound_name.' 到 '.$cp_name.' 的边已经存在'.'<br>';}		
		
		if(!empty($out_rss_id) 		AND intval($info[0])==$cp_id 		AND intval($info[1])==$out_rss_id) 		{$e6=1;	echo $cp_name.' 到 '.$out_rss_name.' 的边已经存在'.'<br>';}
		if(!empty($out_email_id)	AND intval($info[0])==$cp_id 		AND intval($info[1])==$out_email_id) 	{$e7=1;	echo $cp_name.' 到 '.$out_email_name.' 的边已经存在'.'<br>';}
		if(!empty($out_im_id) 		AND intval($info[0])==$cp_id 		AND intval($info[1])==$out_im_id) 		{$e8=1;	echo $cp_name.' 到 '.$out_im_name.' 的边已经存在'.'<br>';}
		if(!empty($out_sms_id) 		AND intval($info[0])==$cp_id		AND intval($info[1])==$out_sms_id) 		{$e9=1;	echo $cp_name.' 到 '.$out_sms_name.' 的边已经存在'.'<br>';}	
		if(!empty($out_sound_id)	AND intval($info[0])==$cp_id		AND intval($info[1])==$out_sound_id) 	{$e10=1;echo $cp_name.' 到 '.$out_sound_name.' 的边已经存在'.'<br>';}	

		if(!empty($cp_in_id) 		AND intval($info[0])==$cp_in_id 	AND intval($info[1])==$cp_id) 			{$e11=1; echo $cp_in_name.' 到 '.$cp_name.' 的输入管道已经存在'.'<br>';} //本产品  输入管道  存在
		if(!empty($cp_out_id) 		AND intval($info[0])==$cp_id 		AND intval($info[1])==$cp_out_id) 		{$e12=1; echo $cp_name.' 到 '.$cp_out_name.' 的输出管道已经存在'.'<br>';}//本产品  输出管道  存在		

		if(!empty($cp1_out_id) 		AND intval($info[0])==$cp1_id 		AND intval($info[1])==$cp1_out_id) 		{$e13=1; echo $cp1_name.' 到 '.$cp1_out_name.' 的输出管道已经存在'.'<br>';}//产品1 与 产品1的输出管道 存在
		if(!empty($cp1_out_id) 		AND intval($info[0])==$cp1_out_id 	AND intval($info[1])==$cp_in_id) 		{$e15=1; echo $cp1_out_name.' 到 '.$cp_in_name.' 的连接关系已经存在'.'<br>';} //产品1 与 产品2 连接关系 存在


		if(!empty($cp2_in_id) 		AND intval($info[0])==$cp2_in_id	AND intval($info[1])==$cp2_id) 			{$e14=1; echo $cp2_in_name.' 到 '.$cp2_name.' 的输入管道已经存在'.'<br>';}//产品2 与 产品2的输入管道 存在
		if(!empty($cp2_in_id) 		AND intval($info[0])==$cp_out_id 	AND intval($info[1])==$cp2_in_id) 		{$e16=1; echo $cp_out_name.' 到 '.$cp2_in_name.' 的连接关系已经存在'.'<br>';}  //产品2 与 产品2 连接关系 存在
	}
		
	//写入边文本
		$Add_Edges_Text='';   	

		if(!empty($cp_in_id) 	AND $e11==0) 	{$Add_Edges_Text.="\n".$cp_in_id.','.$cp_id.','.$cp_in_name.','.$cp_name.','.$cp_group.',GD,'.$c_g.','.$date;			echo $FH_hj.'接收装置 '.$cp_in_name.' 成功焊接到 '.$cp_name.'。<br>'.$FH_hj2;}
		if(!empty($cp_out_id) 	AND $e12==0) 	{$Add_Edges_Text.="\n".$cp_id.','.$cp_out_id.','.$cp_name.','.$cp_out_name.','.$cp_group.',GD,'.$c_g.','.$date;			echo $FH_hj.$cp_name.' 的发射器 '.$cp_out_name.' 成功焊接。<br>'.$FH_hj2;}
		if(!empty($cp1_out_id) 	AND $e13==0) 	{$Add_Edges_Text.="\n".$cp1_id.','.$cp1_out_id.','.$cp1_name.','.$cp1_out_name.','.$cp1_group.',GD,'.$c_g.','.$date;		echo $FH_hj.$cp1_name.' 的发射器 '.$cp1_out_name.' 成功焊接。<br>'.$FH_hj2;}
		if(!empty($cp2_in_id) 	AND $e14==0) 	{$Add_Edges_Text.="\n".$cp2_in_id.','.$cp2_id.','.$cp2_in_name.','.$cp2_name.','.$cp2_group.',GD,'.$c_g.','.$date;		echo $FH_hj.'接收装置 '.$cp2_in_name.' 成功焊接到 '.$cp2_name.' 。<br>'.$FH_hj2;}
		if(!empty($cp1_out_id) 	AND $e15==0) 	{$Add_Edges_Text.="\n".$cp1_out_id.','.$cp_in_id.','.$cp1_out_name.','.$cp_in_name.','.$gxi1.',LJ,'.$g_g.','.$date;	echo $FH_lj.$cp1_name .' 的 '.$cp1_out_name.' 成功与 '.$cp_name.' 的 '.$cp_in_name.' 建立连接通道。<br>'.$FH_lj2;}
		if(!empty($cp2_in_id) 	AND $e16==0) 	{$Add_Edges_Text.="\n".$cp_out_id.','.$cp2_in_id.','.$cp_out_name.','.$cp2_in_name.','.$gxi2.',LJ,'.$g_g.','.$date;	echo $FH_lj.$cp_name .' 的 '.$cp_out_name.' 成功与 '.$cp2_name .' 的 '.$cp2_in_name.' 建立连接通道。<br>'.$FH_lj2;}
		
		if(!empty($in_rss_id) 	AND $e1==0) 	{$Add_Edges_Text.="\n".$in_rss_id.','.$cp_id.','.$in_rss_name.','.$cp_name.','.$cp_group.',GD,'.$c_g.','.$date;			echo $FH_hj.'接收装置 '.$in_rss_name.' 成功焊接到 '.$cp_name.' 。<br>'.$FH_hj2;}
		if(!empty($in_email_id) AND $e2==0) 	{$Add_Edges_Text.="\n".$in_email_id.','.$cp_id.','.$in_email_name.','.$cp_name.','.$cp_group.',GD,'.$c_g.','.$date;		echo $FH_hj.'接收装置 '.$in_email_name.' 成功焊接到 '.$cp_name.' 。<br>'.$FH_hj2;}
		if(!empty($in_im_id) 	AND $e3==0) 	{$Add_Edges_Text.="\n".$in_im_id.','.$cp_id.','.$in_im_name.','.$cp_name.','.$cp_group.',GD,'.$c_g.','.$date;			echo $FH_hj.'接收装置 '.$in_im_name.' 成功焊接到 '.$cp_name.' 。<br>'.$FH_hj2;}
		if(!empty($in_sms_id) 	AND $e4==0) 	{$Add_Edges_Text.="\n".$in_sms_id.','.$cp_id.','.$in_sms_name.','.$cp_name.','.$cp_group.',GD,'.$c_g.','.$date;			echo $FH_hj.'接收装置 '.$in_sms_name.' 成功焊接到 '.$cp_name.' 。<br>'.$FH_hj2;}
		if(!empty($in_sound_id) AND $e5==0)		{$Add_Edges_Text.="\n".$in_sound_id.','.$cp_id.','.$in_sound_name.','.$cp_name.','.$cp_group.',GD,'.$c_g.','.$date;		echo $FH_hj.'接收装置 '.$in_sound_name.' 成功焊接到 '.$cp_name.' 。<br>'.$FH_hj2;}
		
		if(!empty($out_rss_id) 	AND $e6==0) 	{$Add_Edges_Text.="\n".$cp_id.','.$out_rss_id.','.$cp_name.','.$out_rss_name.','.$cp_group.',GD,'.$c_g.','.$date;		echo $FH_hj.'发射器 '.$out_rss_name.' 成功焊接到 '.$cp_name.'<br>'.$FH_hj2;}
		if(!empty($out_email_id) AND $e7==0) 	{$Add_Edges_Text.="\n".$cp_id.','.$out_email_id.','.$cp_name.','.$out_email_name.','.$cp_group.',GD,'.$c_g.','.$date;	echo $FH_hj.'发射器 '.$out_email_name.' 成功焊接到 '.$cp_name.'<br>'.$FH_hj2;}
		if(!empty($out_im_id) 	AND $e8==0) 	{$Add_Edges_Text.="\n".$cp_id.','.$out_im_id.','.$cp_name.','.$out_im_name.','.$cp_group.',GD,'.$c_g.','.$date;			echo $FH_hj.'发射器 '.$out_im_name.' 成功焊接到 '.$cp_name.'<br>'.$FH_hj2;}
		if(!empty($out_sms_id) 	AND $e9==0) 	{$Add_Edges_Text.="\n".$cp_id.','.$out_sms_id.','.$cp_name.','.$out_sms_name.','.$cp_group.',GD,'.$c_g.','.$date;		echo $FH_hj.'发射器 '.$out_sms_name.' 成功焊接到 '.$cp_name.'<br>'.$FH_hj2;}
		if(!empty($out_sound_id) AND $e10==0) 	{$Add_Edges_Text.="\n".$cp_id.','.$out_sound_id.','.$cp_name.','.$out_sound_name.','.$cp_group.',GD,'.$c_g.','.$date;	echo $FH_hj.'发射器 '.$out_sound_name.' 成功焊接到 '.$cp_name.'<br>'.$FH_hj2;}

		$sbedges = fopen($EdgesFile,'a');	
		fwrite($sbedges,$Add_Edges_Text);
		fclose($sbedges);
		
		
		//--------------------------------------------
		//四、创建对应同管道之间的边
		//--------------------------------------------
		

	//读取节点文件;把文件变成一行行的数组
	$sbsbfile=fread(fopen($NodesFile,"r"),filesize($NodesFile));
	$lines=explode("\n",$sbsbfile);
	
	//读边文件,边文件转换为数组
	$EdgesFileText=fread(fopen($EdgesFile,"r"),filesize($EdgesFile));
	$EdgesLines=explode("\n",$EdgesFileText);

//遍历数组，读产品和管道标识。  如果管道存在，就读节点中管道的值，如果匹配就设置写入边的文本
$Add_Edges_Text_2='';   
$YouBian_Bj=0;

foreach($lines as $nodes)
{
	$info = explode(",",$nodes,10);
				//如果需要检测一个节点的输出与输入有关系，在这里写代码吧。
	if (!empty($in_rss_name) AND $info[1]!=$in_rss_name_2 AND $info[5]=='RSS_O')   //检测rss输入
		{
			foreach($EdgesLines as $Edge)
				{
					$edge_info = explode(",",$Edge,3);

					if ($edge_info[0]==$info[0] and $edge_info[1]==$in_rss_id) $YouBian_Bj=1;					
				}
		if ($YouBian_Bj==1) {
			echo $info[1].' 到 '.$in_rss_name.'的连接关系已经存在<br>';
		}else{
			echo $FH_lj.$info[1].' 到 '.$in_rss_name.'的连接关系完成建立<br>'.$FH_lj2;
			$Add_Edges_Text_2.="\n".$info[0].','.$in_rss_id.','.$info[1].','.$in_rss_name.',RSS,LJ,'.$g_g.','.$date;
			$YouBian_Bj=0;
		}
		}
		
	if (!empty($in_email_name) AND $info[1]!=$in_email_name_2 AND $info[5]=='Email_O')   //检测email输入
		{
			foreach($EdgesLines as $Edge)
				{
					$edge_info = explode(",",$Edge,3);
					if ($edge_info[0]==$info[0] and $edge_info[1]==$in_email_id) $YouBian_Bj=1;					
				}
		if ($YouBian_Bj==1) {
			echo $info[1].' 到 '.$in_email_name.'的连接关系已经存在<br>';
		}else{
			echo $FH_lj.$info[1].' 到 '.$in_email_name.'的连接关系完成建立<br>'.$FH_lj2;
			$Add_Edges_Text_2.="\n".$info[0].','.$in_email_id.','.$info[1].','.$in_email_name.',Email,LJ,'.$g_g.','.$date;
			$YouBian_Bj=0;
		}
		}
		
	if (!empty($out_rss_name)  AND $info[1]!=$out_rss_name_2 AND $info[5]=='RSS_I')   //检测rss输出出出
		{
			foreach($EdgesLines as $Edge)
				{
					$edge_info = explode(",",$Edge,3);
					if ($edge_info[0]==$out_rss_id and $edge_info[1]==$info[0]) $YouBian_Bj=1;					
				}
		if ($YouBian_Bj==1) {
			echo $out_rss_name.' 到 '.$info[1].'的连接关系已经存在<br>';
		}else{
			echo $FH_lj.$out_rss_name.' 到 '.$info[1].'的连接关系完成建立<br>'.$FH_lj;
			$Add_Edges_Text_2.="\n".$out_rss_id.','.$info[0].','.$out_rss_name.','.$info[1].',RSS,LJ,'.$g_g.','.$date;
			$YouBian_Bj=0;
		}
		}
		
	if (!empty($out_email_name) AND $info[1]!=$out_email_name_2 AND $info[5]=='Email_I')   //检测email输出出出
		{
			foreach($EdgesLines as $Edge)
				{
					$edge_info = explode(",",$Edge,3);
					if ($edge_info[0]==$out_email_id and $edge_info[1]==$info[0]) $YouBian_Bj=1;					
				}
		if ($YouBian_Bj==1) {
			echo $out_email_name.' 到 '.$info[1].'的连接关系已经存在<br>';
		}else{
			echo $FH_lj.$out_email_name.' 到 '.$info[1].'的连接关系完成建立<br>'.$FH_lj;
			$Add_Edges_Text_2.="\n".$out_email_id.','.$info[0].','.$out_email_name.','.$info[1].',Email,LJ,'.$g_g.','.$date;
			$YouBian_Bj=0;
		}
		}				
}

		$add_edges = fopen($EdgesFile,'a');	
		fwrite($add_edges,$Add_Edges_Text_2);
		
		if(copy("nodes.csv","nodes.txt")) {} else {echo '文件复制失败';}
		if(copy("edges.csv","edges.txt")) {} else {echo '文件复制失败';}
	
}//全部代码的围墙
?>