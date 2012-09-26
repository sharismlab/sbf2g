<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<a href="index.php"><center>返回输入</center></a>
<?php
include('inc.php');

//格式化公司与产品,如果首字母是 + 则不对字符做首位大写的操作。

if (!empty($_POST['gsmc']))
	{
		$gs_chushi=trim($_POST['gsmc']);						//去头去尾
		$gs_name=substr($gs_chushi,1,strlen($gs_chushi));		//取第一个字符  ucfirst
		if ($gs_chushi{0}=='+') {$gs_name=$gs_name;} else {$gs_name=ucwords(strtolower(trim($_POST['gsmc'])));	}	
	}	

if (!empty($_POST['cpmc']))
	{
		$cp_chushi=trim($_POST['cpmc']);						//去头去尾
		$cp_name=substr($cp_chushi,1,strlen($cp_chushi));		//取第一个字符
		if ($cp_chushi{0}=='+') {$cp_name=$cp_name;} else {$cp_name=ucwords(strtolower(trim($_POST['cpmc'])));	}	
	}

//判断定义产品的流程是否具备
if (empty($gs_name) or empty($cp_name)){

	if(!empty($gs_name) and empty($cp_name)) echo '请同时输入一个产品的名称。<br>';
	if(empty($gs_name) and !empty($cp_name)) echo '请同时输入一个公司的名称。<br>';
	if(empty($gs_name) and empty($cp_name)) echo '老大，你总要输点什么吧 :)<br>';

	}else{

$cp_id=0;
$gs_id=0;

//读取节点文件
$sbsbfile=fread(fopen($NodesFile,"r"),filesize($NodesFile));

//把文件变成一行行的数组
$lines=explode("\n",$sbsbfile);

$txt='';

//遍历数组，取公司/产品的id，如果不存在就取最大id值
foreach($lines as $nodes)
{
	$info = explode(",",$nodes,10);	
	
	//让 $zuida_id 是最大id值
	if($zuida_id<intval($info[0])) $zuida_id=intval($info[0]);

	if ($info[4]==$cp_name) {$info[4]=$gs_name;}
	if ($info[7]==$cp_name) {$info[7]=$gs_name;}
	
	if ($info[0]=="Id") 
	{
		$txt.= 'Id,Label,Name,JiBei,LiShu,TongDao,IO,Group,Weight,Date';
	}else{
		$txt.= "\n$info[0],$info[1],$info[2],$info[3],$info[4],$info[5],$info[6],$info[7],$info[8],$info[9]";
	}
	
	//检查公司ID是否存在
	if($info[1] == $gs_name) {$gs_id=$info[0];echo '有一个叫 '.$gs_name.' 的公司已经存在于这个世界上了。<br>'; }
	
	//检查产品ID是否存在
	if($info[1] == $cp_name) {$cp_id=$info[0];echo '属于 '.$gs_name.' 公司的 '.$cp_name.' 产品也已经存在。<br>';}
}

	$txt2=fopen("nodes.csv","w+");
	fwrite($txt2,$txt);

//建立新公司
if ($gs_id==0)
	{
		//定义最大节点id
		$gs_id=$zuida_id=++$zuida_id;
		
		$sb = fopen($NodesFile,'a');

		$sbtxt= "\n";
		$sbtxt.=$gs_id.","; 			//1.id
		$sbtxt.=$gs_name.",";			//2.标签
		$sbtxt.=$gs_name.",";			//3.名称
		$sbtxt.='gs,';					//4.级别
		$sbtxt.=$gs_name.",";			//5.隶属
		$sbtxt.=",";					//6.通道
		$sbtxt.=",";					//7.io
		$sbtxt.=$gs_name.",";			//8.组
		$sbtxt.=$w_gs.",";				//9.权值
		$sbtxt.=$date;					//10.时间

		fwrite($sb,$sbtxt);
		
		echo $FH_gs."一个名叫 ".$gs_name." 的公司刚刚建立。<br>".$FH_gs2;		
		
		//往输入补充文本填写字符
		$gs_quanwen = file_get_contents($gsmcFile);
		$gs_add = fopen($gsmcFile,'w');
		
		//用新的包含公司的字符串 替换 之前全文的末尾
		$gs_add_name=',"'.$gs_name.'"];';
		$tihuan = '];';		
		$gs_add_xiin = str_replace($tihuan,$gs_add_name,$gs_quanwen);		

		fwrite($gs_add,$gs_add_xiin);				
		}

//建立新产品
if ($cp_id==0)
	{
		//定义最大产品id
		$cp_id=$zuida_id=++$zuida_id;
		
		$sb = fopen($NodesFile,'a');
		
		$sbtxt= "\n";
		$sbtxt.=$cp_id.","; 			//1.id
		$sbtxt.=$cp_name.",";			//2.标签
		$sbtxt.=$cp_name.",";			//3.名称
		$sbtxt.="cp,";					//4.级别
		$sbtxt.=$gs_name.",";			//5.隶属
		$sbtxt.=",";					//6.通道
		$sbtxt.=",";					//7.io
		$sbtxt.=$gs_name.",";			//8.组
		$sbtxt.=$w_cp.",";				//9.权值
		$sbtxt.=$date;					//10.时间

		fwrite($sb,$sbtxt);
		
		echo $FH_cp."一个名叫 ".$cp_name." 的产品研发完毕。<br>".$FH_cp2;		
		
		//输入补充   -   产品名称
		$cp_quanwen = file_get_contents($cpmcFile);
		$cp_add = fopen($cpmcFile,'w');
		
		//用新的包含公司的字符串 替换 之前全文的末尾
		$cp_add_name=',"'.$cp_name.'"];';
		$tihuan = '];';		
		$cp_add_xiin = str_replace($tihuan,$cp_add_name,$cp_quanwen);		

		fwrite($cp_add,$cp_add_xiin);				
	}

////////////////////
//开始处理边的数据//
////////////////////

//边存在的标记
$EdgeBiaoji=0;  

//读边文件
$EdgesFileText=fread(fopen($EdgesFile,"r"),filesize($EdgesFile));

//边文件转换为数组
$EdgesLines=explode("\n",$EdgesFileText);

//遍历数组，检查节点是否已经存在
$txt='';
foreach($EdgesLines as $Edge)
{
	$info = explode(",",$Edge,8);	
		if($gs_id==intval($info[0]) AND $cp_id==intval($info[1]))
		{
			$EdgeBiaoji=1;
			echo  $gs_name." 与 ".$cp_name ." 已经存在隶属关系了。<br>";
		}	
		
	//下面的代码检查，是否为一个产品安排了一个公司，并把新的数据整理为文本		
	if ($info[0]==$cp_id or $info[1]==$cp_id) {$info[4]=$gs_name;}
	if ($info[0]=="Source") 
		{
			$txt.= 'Source,Target,Source-Name,Target-Name,LiShu,Category,Weight,Date';
		}else{
			$txt.="\n$info[0],$info[1],$info[2],$info[3],$info[4],$info[5],$info[6],$info[7]";
		}
}
	$edges_txt=fopen($EdgesFile,"w+");
	fwrite($edges_txt,$txt);
	
//建立公司到产品的关系
if ( $EdgeBiaoji==0 )
	{
		$sb = fopen($EdgesFile,'a');
		
		$sbtxt= "\n";
		$sbtxt.= $gs_id.","; 		//1.源id
		$sbtxt.= $cp_id.",";  		//2.目标id
		$sbtxt.= $gs_name.",";    	//3.源 name
		$sbtxt.= $cp_name.",";  	//4.目标 name
		$sbtxt.= $gs_name.",";   	//5.隶属
		$sbtxt.= "CP,";   			//6.类别
		$sbtxt.= $g_c.",";   		//7.权重
		$sbtxt.= $date;        		//8.日期
		
		fwrite($sb,$sbtxt);
		echo $FH_hj.$gs_name . " 到 " . $cp_name." 的关系连接完毕。<br>".$FH_hj2;
	}

		if(copy("nodes.csv","nodes.txt")) {} else {echo '文件复制失败';}
		if(copy("edges.csv","edges.txt")) {} else {echo '文件复制失败';}
		
} //最高大的围墙
?>