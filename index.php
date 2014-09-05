<?php
/**
 * 微信接口控制器
 * @author mango
 * @version 2014.07.26
 */

$setting = array(
    'title' => '微信接口处理',
    'header' => '微信接口处理',
    'header_small' => 'ColdMaker',
    'default_url' => 'home.html',
);
$menu = array(
    array(
        'title' => '设置信息',
        'icon' => 'fa-cogs',
        'sub_menu' => array(
            array('title' => '设置信息','icon' => 'fa-cog','url' => 'home.html'),
        )
    ),
    array(
        'title' => '回复信息',
        'icon' => 'fa-wechat',
        'sub_menu' => array(
            array(
                'title' => '关注回复',
                'icon' => 'fa-user',
                'url' => 'home.html'
            ),
            array(
                'title' => '图文回复',
                'icon' => 'fa-paw',
                'url' => 'home.html'
            ),
            array(
                'title' => '文本回复',
                'icon' => 'fa-font',
                'url' => 'http://zealand.d-bluesoft.com',
            )
        )
    ),
    array(
        'title' => '自定义菜单',
        'icon' => 'fa-sitemap',
        'sub_menu' => array(
            array(
                'title' => '菜单设置',
                'icon' => 'fa-user',
                'url' => 'list.html'
            )
        )
    ),
    array(
        'title' => '帮助',
        'icon' => 'fa-user',
        'sub_menu' => array(
            array(
                'title' => 'FontAwesome图标',
                'icon' => 'fa-book',
                'url' => 'http://fortawesome.github.io/Font-Awesome/icons/',
            )
        )
    )
);
$setting['menu'] = $menu;
echo json_encode($setting);exit;
class WxAction extends Action
{
    /**
     * 接口地址
     */
	public function api()
	{
		//实例化一个Wx模型
		$wxObj = D('Wx');
		$wxObj->responseMsg();
	}

    /*******************Setting*****************************/
    /**
     * set
     */
    public function set()
    {
        $setObj = D('Setting');
        $setList = $setObj->select();
        foreach($setList as $k=>$v){
            $list[$v['skey']] = $v['svalue'];
        }
        $this->assign($list);
        $this->display();
    }

    /**
     * doSet
     */
    public function doSet()
    {
        $data = $_POST;
        foreach($data as $k=>$v){
            $map['skey'] = array('eq', $k);
            $result = D('Setting')->where($map)->find();
            if(empty($result)){
                $data = array('skey'=>$k,'svalue'=>$v);
                D('Setting')->add($data);
            }else{
                D('Setting')->where($map)->setField('svalue',$v);
            }
        }
        $this->success('更新成功');
    }
    /*******************微信自定义菜单***********************/
    /**
     * 微信菜单列表
     */
    public function menuList()
    {
        $list = D('Menu')->where('pid=0')->order('sort')->select();
        $newList = array();
        foreach($list as $k=>$v){
            $newList[] = $v;
            $clist = D('Menu')->where('pid='.$v['id'])->order('sort')->select();
            $newList = array_merge($newList, $clist);
        }
        $this->assign('list', $newList);
        $this->display();
    }

    /**
     * 微信菜单添加界面
     */
    public function menuAdd()
    {
        $menuList = D('Menu')->where('pid=0')->order('sort desc')->select();
        $this->assign('menuList',$menuList);
        $this->display();
    }

    /**
     * 微信菜单添加操作
     */
    public function menuDoAdd()
    {
        $data = $_POST;
        $result = D('Menu')->add($data);
        if(!empty($result)){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 编辑菜单界面
     */
    public function menuEdit()
    {
        $id = intval($_GET['id']);
        $info = D('Menu')->where('id='.$id)->find();
        $menuList = D('Menu')->where('pid=0')->order('sort desc')->select();
        $this->assign('info',$info);
        $this->assign('menuList',$menuList);
        $this->display();
    }

    /**
     * 编辑菜单操作
     */
    public function menuDoEdit()
    {
        $data = $_POST;
        $result = D('Menu')->save($data);
        if(!empty($result)){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    /**
     * 菜单删除操作
     */
    
    public function menuDel()
    {
        $delIds = array();
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }

        if (empty($delIds)) {
            $this->error('请选择您要删除的菜单');
        }
        $map['id'] = $pmap['pid'] = array('in', $delIds);
        if(D('Menu')->where($map)->delete()){
            D('Menu')->where($pmap)->delete();
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    /*********************文本回复*******************************/
    /**
     * 文本回复列表
     */
    public function textList()
    {
        //分页
        $count = D('Text')->count();
        $page = page($count, 20);
        $list = D('Text')->limit($page->firstRow, $page->listRows)->select();
        foreach($list as $k=>$v){
            $map['obj_type'] = array('eq', 'text');
            $map['obj_id'] = array('eq', $v['id']);
            $list[$k]['keyword'] = D('Route')->where($map)->getField('keyword');
        }
        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->display();
    }

    /**
     * 添加文本操作
     */
    public function textDoAdd()
    {
        $keyword = trim($_POST['keyword']);
        $content = trim($_POST['content']);
        $id = D('Text')->add(array('content'=>$content));
        $data['keyword'] = $keyword;
        $data['obj_type'] = 'text';
        $data['obj_id'] = $id;
        $result = D('Route')->add($data);
        $this->success('添加成功');
    }

    /**
     * 编辑文本界面
     */
    public function textEdit()
    {
        $id = intval($_GET['id']);
        $info = D('Text')->where('id='.$id)->find();
        $map['obj_type'] = array('eq', 'text');
        $map['obj_id'] = array('eq', $id);
        $routeInfo = D('Route')->where($map)->find();
        $this->assign('info', $info);
        $this->assign('routeInfo', $routeInfo);
        $this->display();
    }

    /**
     * 编辑文本操作
     */
    public function textDoEdit()
    {
        $id = intval($_POST['id']);
        $route_id = intval($_POST['route_id']);
        $keyword = trim($_POST['keyword']);
        $content = trim($_POST['content']);
        D('Text')->where('id='.$id)->setField('content', $content);
        D('Route')->where('id='.$route_id)->setField('keyword', $keyword);
        $this->success('更新成功');
    }

    /**
     * 文本删除
     */
    public function textDel(){
        $delIds = array();
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }
        if (empty($delIds)) {
            $this->error('请选择您要删除的关键字');
        }
        $map['id'] = $routeMap['obj_id'] = array('in', $delIds);
        $routeMap['obj_type'] = array('eq', 'text');
        if(D('Text')->where($map)->delete()){
            D('Route')->where($routeMap)->delete();
            $this->success('删除成功',U('Text/ls'));
        }else{
            $this->error('删除失败');
        }
    }

    /****************************关注图文回复**************************/
    /**
     * 关注回复界面
     */
    public function subscribe()
    {
        $id = D('Route')->where("obj_type='event' AND keyword='subscribe'")->getField('obj_id');
        if(!empty($id)){
            $info = D('Txp')->where('id='.$id)->find();
            $this->assign('info', $info);
        }
        $this->display();
    }

    /**
     * 关注回复操作
     */
    public function doSub()
    {
        $data = $_POST;
        if(!empty($data['id'])){
            D('Txp')->save($data);
        }else{
            $id = D('Txp')->add($data);
            $route['obj_type'] = 'event';
            $route['obj_id'] = $id;
            $route['keyword'] = 'subscribe';
            D('Route')->add($route);
        }
        $this->success('更新成功');
    }
    
    /***********************图文回复*************************/
    /**
     * 图文列表
     */
    public function newsList()
    {
        $fid = intval($_GET['fid']);
        $map['fid'] = array('eq', $fid);
        $count = D('Txp')->where($map)->count();
        $page = page($count, 20);
        $list = D('Txp')->where($map)->limit($page->firstRow, $page->listRows)->select();
        foreach($list as $k=>$v){
            $routeMap['obj_type'] = array('eq', 'txp');
            $routeMap['obj_id'] = array('eq', $v['id']);
            $list[$k]['keyword'] = D('Route')->where($routeMap)->getField('keyword');
        }
        $this->assign('fid', $fid);
        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->display();
    }

    /**
     * 图文添加界面
     */
    public function newsAdd()
    {
        $fid = intval($_GET['fid']);
        $this->assign('fid', $fid);
        $this->display();
    }
    /**
     * 图文添加操作
     */
    public function newsDoAdd()
    {
        $keyword = trim($_POST['keyword']);
        $data = $_POST;
        $id = D('Txp')->add($data);
        $route['keyword'] = $keyword;
        $route['obj_type'] = 'txp';
        $route['obj_id'] = $id;
        D('Route')->add($route);
        $this->success('添加成功');
    }

    /**
     * 图文编辑界面
     */
    public function newsEdit()
    {
        $id = intval($_GET['id']);
        $info = D('Txp')->where('id='.$id)->find();
        $map['obj_type'] = array('eq', 'txp');
        $map['obj_id'] = array('eq', $id);
        $routeInfo = D('Route')->where($map)->find();
        $this->assign('info', $info);
        $this->assign('routeInfo', $routeInfo);
        $this->display();
    }

    /**
     * 图文编辑操作
     */
    public function newsDoEdit()
    {
        $id = intval($_POST['id']);
        $route_id = intval($_POST['route_id']);
        $keyword = trim($_POST['keyword']);
        $data = $_POST;
        D('Txp')->where('id='.$id)->save($data);
        D('Route')->where('id='.$route_id)->setField('keyword', $keyword);
        $this->success('更新成功');
    }
    
    public function newsDel(){
        $delIds = array();
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }
        if (empty($delIds)) {
            $this->error('请选择您要删除的关键字');
        }
        $map['id'] = $fmap['fid'] = array('in', $delIds);
        if(D('Txp')->where($map)->delete()){
            $ids = D('Txp')->where($fmap)->getField('id', true);
            $ids = array_merge($ids, $delIds);

            $routeMap['obj_id'] = array('in', $ids);
            D('Txp')->where($fmap)->delete();
            $routeMap['obj_type'] = array('eq', 'txp');
            D('Route')->where($routeMap)->delete();
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
?>