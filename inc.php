<?php

//初始变量
$date = date('Y-m-j');
$zuida_id=0;   	//定义节点最大id的初始值

//节点 Weight
$w_gs=1.3;		//公司节点
$w_cp=1.1;		//产品节点
$w_gd=1;		//管道节点


//边 Weight，
$g_c = 1.2;		//公司 到 产品
$c_g = 1.1;		//产品 到 管道
$g_g = 1.0;		//管道 到 管道

//边的声明
//产品声明：CP
//管道声明：GD
//连接声明：LJ

//HTML 页面样式
$FH_gs = '<font color=red><b>';
$FH_gs2 = '</b></font>';

$FH_cp = '<font color=red><b>';
$FH_cp2 = '</b></font>';

$FH_gd = '<font color=teal>';
$FH_gd2 = '</font>';

$FH_lj = '<font color=blue>';
$FH_lj2 = '</font>';

$FH_hj = '<font color=green>';
$FH_hj2 = '</font>';

//获得节点/边文件
$NodesFile="nodes.csv";
$EdgesFile="edges.csv";

//补充输入的文本
$gsmcFile="gsmc_txt.js";
$cpmcFile="cpmc_txt.js";
?>