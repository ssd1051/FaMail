<?php 
namespace Home\Controller; 
use Think\Controller; 
class BbsController extends Controller {
public function index(){
if(session('?user.user_id')){
$this->display('home');
}
else{
$this->error('你还没有登陆！','/index.php/Home/Home/login',3);
}
}
public function center(){
if(session('?user.user_id')){
$value=session('user.user_name');
$data=$value;
$this->assign('data',$data);
$this->display('center');
}
else{
$this->error('你还没有登陆！','/index.php/Home/Home/login',3);
}
}
public function admin(){
if(session('?user.user_id')){
$value=session('user.user_name');
$data=$value;
$this->assign('name',$data);
$this->display('admin');
}
else{
$this->error('你还没有登陆！','/index.php/Home/Home/login',3);
}
}
public function op(){
//论坛权限方法控制器
}
public function newpage(){
if(session('?user.user_id')){
$error['errors']='请填写所有信息并提交！';
$error['error']='alert-info';
$this->assign('error',$error);
if(IS_POST){
$id=session('user.user_id');
$title=I('post.title','');
$content=I('post.content','');
$date=I('post.time','');
$point=I('post.point','');
if(!empty($title)&!empty($content)&!empty($date)){
if(empty($point)){
$points=0;
}
elseif($point<"20"&$point>"0"){
$points=$point;
}
else{
$error['errors']='积分数量范围为0-20！';
$error['error']='alert-danger';
$this->assign('error',$error);
}
$User=M('Page');
$page['title']=$title;
$page['content']=$content;
$page['fromid']=$id;
$page['point']=$points;
$page['date']=$date;
$User->add($page);
$value=$User->table('think_page')->where("content='$content' and title='$title'")->find();
foreach($value as $values){
$pid=$value['id'];
}
$error['errors']='新增帖子操作成功！';
$error['error']='alert-success';
$error['message']='点击此处查看您添加的帖子！';
$this->assign('error',$error);
S('pid',$pid,300);
}
else{
$error['errors']='标题和内容不可为空！';
$error['error']='alert-danger';
$this->assign('error',$error);
}
}
$this->display('newpage');
return $pid;
}
else{
$this->error('你还没有登陆！','/index.php/Home/Home/login',3);
}
}
public function showpage(){
if(session('?user.user_name')){
$pid=S('pid');
if(!empty($pid)){
$Model=M('Page');
$data=$Model->where("id='$pid'")->find();
foreach($data as $datas){
$title=$data['title'];
$content=$data['content'];
$uid=$data['fromid'];
$date=$data['date'];
}
$show['title']=$title;
$show['content']=$content;
$show['fromid']=$uid;
$show['date']=$date;
$this->assign('show',$show);
$this->display('showpage');
S('pid',null);
}
else{
$this->error('非法操作！','/index.php/Home/Bbs/index',5);
}
}
else{
$this->error('你还没有登陆！','/index.php/Home/Home/login',3);
}
}
public function editpage(){
//修改帖子内容方法控制器
}
public function delectpage(){
//删除帖子方法控制器
}
public function pages(){
//论坛帖子列表页方法控制器
}
public function setpage(){
//帖子管理页方法控制器
}
//以下方法可能不在本控制器内编写
public function ucenter(){
if(session('?user.user_id')){
$value['id']=session('user.user_id');
$value['name']=session('user.user_name');
$value['email']=session('user.user_email');
$this->assign('data',$value);
$this->display('ucenter');
}
else{
$this->success('你还没有登陆！','/index.php/Home/Home/login',3);
}
}
//其余方法根据实际情况添加
}
?>