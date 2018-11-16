<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:73:"/data/home/bxu2359070239/htdocs/application/index/view/content/index.html";i:1522376095;s:73:"/data/home/bxu2359070239/htdocs/application/index/view/layout/layout.html";i:1522374328;s:73:"/data/home/bxu2359070239/htdocs/application/index/view/public/header.html";i:1522401813;s:72:"/data/home/bxu2359070239/htdocs/application/index/view/public/aside.html";i:1522374328;s:73:"/data/home/bxu2359070239/htdocs/application/index/view/public/footer.html";i:1522407094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<meta name="keywords" content="<?php echo $description; ?>" />
	<meta name="description" content="<?php echo $description; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $websetData['domain']; ?>/public__STATIC__/index/css/common.css">
	<?php if(is_array($css) || $css instanceof \think\Collection || $css instanceof \think\Paginator): if( count($css)==0 ) : echo "" ;else: foreach($css as $key=>$v): ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $websetData['domain']; ?>/public__STATIC__/index/css/<?php echo $v; ?>.css">
	<?php endforeach; endif; else: echo "" ;endif; ?>
	<script type="text/javascript" src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/js/jquery.lazyload.min.js"></script>
	<script type="text/javascript" src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/js/index.js"></script>
</head>
<body>
	<script>
	/*头部导航特效*/
	$(function(){
		//懒加载 lazy-load
		$(".lazy").lazyload({
			effect:'fadeIn',
			placeholder:'<?php echo $websetData['domain']; ?>/public__STATIC__/index/images/lazyload.gif'
		});
		(function(){
			var $cate_id = "<?php echo $cate_id;?>";
			if($cate_id!=='false'){
				var index=0;
				if($cate_id==41){
					index=1;	
				}else if($cate_id==42){
					index = 2;
				}else if($cate_id==43){
					index = 3;
				}else if($cate_id==44){
					index = 4;
				}else if($cate_id==45){
					index = 5;
				}else if($cate_id==46){
					index = 6;
				}
				$('header .left nav').append("<div class='hk' style='top:0;left:"+index*100+"px;position:absolute;width:100px;height:60px;background:#f00;z-index:-1;'></div>");
				$("header .left nav .hk").css("left",index*100+"px");
				$('header .left nav ul li').hover(function(){
					var i = $(this).index();
					$("header .left nav .hk").stop(true,true).animate({ 
						left:i*100+"px",    
				    },{ 
					    easing: 'easeOutBack',
					    duration: 350,  
					});
				})
				$('header .left nav').mouseleave(function(){
					$("header .left nav .hk").stop(true,true).animate({ 
						left:index*100+"px",    
				    },{ 
					    easing: 'easeOutBack',
					    duration: 200,  
					});	
				})			
			}	
		})();
	})
	function logout(othis){
		var $this = $(othis);
		$.ajax({
			type:'get',
			url:"<?php echo url('index/member/logout'); ?>",
			success:function(data){
				sessionStorage.clear();
				window.location.href=data.url;
			}
		});		
	};	
	/*头部导航结束特效*/
	</script>
	<!-- header start -->
	<header class="_width min-width">
		<div class="_content">
			<div class="left fl">
				<p class="logo"><a href="__ROOT__/index.html"><?php echo $websetData['logo']; ?></a></p>
				<nav>
					<ul>
						<li class="active"><a href="__ROOT__/index.html">主页</a></li>
						<?php if(is_array($_categoryData) || $_categoryData instanceof \think\Collection || $_categoryData instanceof \think\Paginator): if( count($_categoryData)==0 ) : echo "" ;else: foreach($_categoryData as $key=>$v): ?>
						<li <?php if($cate_id==$v['id']):?>class="active"<?php endif;?> ><a href="<?php echo url('index/lst/index',['cate_id'=>$v['id']]); ?>"><?php echo $v['name']; ?></a></li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					
				</nav>
			</div>
			<?php if(\think\Session::get('member.name')): ?><div class="right fr" style="cursor:auto;"><div class="face"><img src="<?php echo $websetData['domain']; ?>/public/<?php echo \think\Session::get('member.face'); ?>"></div>欢迎您，<?php echo \think\Session::get('member.name'); ?>&nbsp;<a onclick="logout(this);" class="logout" href="javascript:void(0);" style="color:#e2e2e2;cursor:pointer;" >退出</a></div><?php else: ?><div class="right fr">登录|注册</div><?php endif; ?>
		</div>
	</header>
	<!-- header end -->

<script>
	$(function(){
		var article_id = "<?php echo input('ar_id'); ?>";
		var member_id = "<?php echo session('member.id'); ?>";
		/* 发表评论 */
		$('.comment-send .btn input').click(function(){
			var $this = $(this);
			member_id = sessionStorage.getItem("member_id");
			console.log(member_id);
			if(member_id){
				var data = $("#comment-send").serialize();
				$this.attr("disabled",true);
				$.ajax({
					type:'post',
					data:data,
					dataType:'json',
					url:'<?php echo url("index/Content/ajaxSendComment"); ?>?article_id='+article_id,
					success:function(data){
						if(data.ok){
							var html='<li class="top"><div class="info"><div class="left fl"><img class="fl" src="<?php echo $websetData['domain']; ?>/public/'+data.face+'" width="36" height="36" style="border-radius:50%;margin-right:10px;"><p class="name">'+data.name+'</p><p class="time">'+data.time+'</p></div><div class="right fr"></div></div><div class="comment_content">'+data.content+'</div></li>';
							$('.main .wrap .detail .comment .comment_list>ul').prepend(html);
							$('#comment-send')[0].reset();
							$('.comment-send .btn span').html('');
						}else{
							$('.comment-send .btn span').html(data.error_msg);
						}
						$this.attr("disabled",false);
					},
				});
			}else{
				$('header .right').trigger('click');
			}
			return false;
		});
		$('.comment-send textarea').focus(function(){
			$('.comment-send .btn span').html('');
		});
		//加载更多
		var page = 1;
		$('.more').click(function(){
			var $this = $(this);
			page++;
			$.ajax({
				type:'get',
				dataType:'json',
				url:'<?php echo url("index/content/ajaxAddMore",'',''); ?>/article_id/'+article_id+"/page/"+page,
				success:function(data){
					var html = '';
					var text = '';
					var timer;
					$(data).each(function(k,v){
						if(data.ok == 0){
							$this.children().html('没有啦，已经到底啦');
							$this.children().css('cursor','not-allowed');
							$this.unbind('click');
							return;
						}
						var isreply='';
						$(v.reply).each(function(k1,v1){
							var istoname = '';
							if(member_id!=v1.member_id){
								isreply='回复';
							}else{
								isreply='';
							}
							if(v1.pid!=0){
								istoname="回复"+v1.toname;
							}
							timer = changeTime(v1.time*1000);
							text+='<li class="sub"><div class="info"><div class="left fl"><img class="fl" src="<?php echo $websetData['domain']; ?>/'+ v1.face+'" width="36" height="36" style="border-radius:50%;margin-right:10px;"><p class="name">'+v1.name+istoname+'：</p><p class="time">'+timer+'</p></div><div class="right fr" onclick="reply(this);">'+isreply+'</div></div><div class="comment_content">'+v1.content+'<form method="post" action="" class="send_reply" style="display: none;"><input type="hidden" name="pid" value="'+v1.id+'"><input type="hidden" name="to_member_id" value="'+v1.member_id+'"><input type="hidden" name="comment_id" value="'+v1.comment_id+'"><textarea class="reply" name="content"></textarea><div class="btn"><span style="color:#f00;"></span><input style="margin-left:100px;" onclick="addreply(this);return false;" type="submit" value="提交"></div></form>	</div></li>';
						});
						if(member_id!=v.member_id){
							isreply='回复';
						}
						timer = changeTime(v.time*1000);
						html+='<li class="top"><div class="info"><div class="left fl"><img class="fl" src="<?php echo $websetData['domain']; ?>/public/'+ v.face+'" width="36" height="36" style="border-radius:50%;margin-right:10px;"><p class="name">'+v.name+':</p><p class="time">'+timer+'</p></div><div class="right fr answer" onclick="reply(this);">'+isreply+'</div></div><div class="comment_content">'+v.content+'<form method="post" action="" class="send_reply"><input type="hidden" name="pid" value="0"><input type="hidden" name="to_member_id" value="'+v.member_id+'"><input type="hidden" name="comment_id" value="'+v.comment_id+'"><textarea class="reply" name="content"></textarea><div class="btn"><span style="color:#f00;"></span><input style="margin-left:100px;" type="submit" value="提交" onclick="addreply(this);return false;"></div></form></div><ul>'+text+'</ul></li>';
					});
					$('.comment_list>ul').append(html);

				},
			});
		})
	});
	//点击回复textarea展现出来
	function reply(othis){
		var member_id = sessionStorage.getItem("member_id");
		if(!member_id){
			$('header .right').trigger('click');
			return;
		}
		var $this = $(othis);
		$('.comment_content form').hide();
		$('.comment_content form').find('textarea').val('');
		var $form = $this.parents('.info').siblings('.comment_content').find('form');
		$form.slideDown();
		$form.find("textarea").focus();
	}
	//添加回复评论
	function addreply(othis){
		//var member_id = "<?php echo session('member.id'); ?>";
		var member_id = sessionStorage.getItem("member_id");
		if(member_id){
			var $this = $(othis);
			$this.attr("disabled",true);
			var data = $this.parents('.send_reply').serialize();
			$.ajax({
				type:'post',
				data:data,
				dataType:'json',
				url:'<?php echo url("index/content/ajaxAddReply"); ?>',
				success:function(data){
					if(data.ok==1){
						var html = '';
						if(data.pid==0){
							html='<li class="sub"><div class="info"><div class="left fl"><img class="fl" src="<?php echo $websetData['domain']; ?>/public/'+data.face+'" width="36" height="36" style="border-radius:50%;margin-right:10px;"><p class="name">'+data.name+'</p><p class="time">'+data.time+'</p></div><div class="right fr"></div></div><div class="comment_content">'+data.content+'</div></li>';
						}else{
							html='<li class="sub"><div class="info"><div class="left fl"><img class="fl" src="<?php echo $websetData['domain']; ?>/public/'+data.face+'" width="36" height="36" style="border-radius:50%;margin-right:10px;"><p class="name">'+data.name+'回复'+data.to_name+'：</p><p class="time">'+data.time+'</p></div><div class="right fr"></div></div><div class="comment_content">'+data.content+'</div></li>';
						}
						if(data.pid==0){
							$this.parents('.comment_content').siblings('ul').prepend(html);	
							
						}else{
							$this.parents('.sub').after(html);	
						}
						$this.parents('form')[0].reset();
						$this.siblings('span').html('');
						$this.parents('form').hide();
					}else if(data.ok==0){
						$this.siblings('span').html(data.error_msg);		
					}
					$this.attr("disabled",false);
				}
			});
		}else{
			$('header .right').trigger('click');
		}
	}
	function changeTime(time){
		var date = new Date(time);
		Y = date.getFullYear() + '-';
		M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
		D = date.getDate() + ' ';
		h = date.getHours() + ':';
		m = date.getMinutes() + ':';
		s = date.getSeconds(); 
		return Y+M+D+h+m+s;
	}
</script>
<!-- main start -->
	<div class="_width main min-width" style="padding:86px 0">
		<div class="_content wrap">
			<div class="detail fl">
				<div class="breadcrumbs">当前位置：<a href="__ROOT__/index.html">首页</a> > <a href="<?php echo url('index/lst/index',['cate_id'=>$info['cate_id']]); ?>"><?php echo $info['cate_name']; ?></a> > 正文</div>
				<div class="title">
					<h2><?php echo $info['name']; ?></h2>
					<p><span><?php echo $info['author']; ?></span> 发布于 <span><?php echo date('Y-m-d',$info['time']); ?></span> 分类  <span><a href="<?php echo url('index/lst/index',['cate_id'=>$info['cate_id']]); ?>"><span><?php echo $info['cate_name']; ?></span></a></span></p>
				</div>	
				<div class="content" id="content">
					<?php echo $info['content']; ?>
				</div>
				<div class="tag">
					<img src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/images/tag.png">
					<?php $count=count($info['tag']);if(is_array($info['tag']) || $info['tag'] instanceof \think\Collection || $info['tag'] instanceof \think\Paginator): if( count($info['tag'])==0 ) : echo "" ;else: foreach($info['tag'] as $k=>$v): ?>
					<a href="<?php echo url('index/lst/index',['tag_id'=>$v['id']]); ?>"><?php echo $v['name']; ?></a><?php if($k+1!=$count):?>、<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="comment">
					<h3>评论<span></span></h3>
					<div class="comment-send">
						<div class="fl head">
							<?php if(\think\Session::get('member.name')): ?><img style="width:40px;height:40px;border-radius:50%" src="<?php echo $websetData['domain']; ?>/public/<?php echo \think\Session::get('member.face'); ?>"><?php endif; ?>
							<p><?php if(\think\Session::get('member.name')): ?><?php echo \think\Session::get('member.name'); endif; ?></p>

						</div>
						<div class="fl">
							<form action="" id="comment-send" method="post">
								<textarea name="content">发表评论....</textarea>
								<div class="btn"><span style="color:#f00;"></span><input style="margin-left:100px;" type="submit" value="提交"></div>
							</form>
						</div>
						</div>	
					<div class="comment_list">
						<ul>
							<?php $sessionId=session('member.id');if(is_array($commentData) || $commentData instanceof \think\Collection || $commentData instanceof \think\Paginator): if( count($commentData)==0 ) : echo "" ;else: foreach($commentData as $key=>$v): ?>
							<li class="top">
								<div class="info">
									<div class="left fl">
									<img class="fl" src="<?php echo $websetData['domain']; ?>/public/<?php echo $v['face']; ?>" width="36" height="36" style="border-radius:50%;margin-right:10px;">
									<p class="name"><?php echo $v['name']; ?></p>
									<p class="time"><?php echo date('Y-m-d H:i:s',$v['time']); ?></p>
									</div>
									<div class="right fr answer" onclick="reply(this);"><?php if($sessionId!=$v['member_id']):?>回复<?php endif;?></div>	
								</div>
								<div class="comment_content">
									<?php echo $v['content']; ?>	
									<form method='post' action='' class="send_reply">
										<input type="hidden" name="pid" value="0">
										<input type="hidden" name="to_member_id" value="<?php echo $v['member_id']; ?>">
										<input type="hidden" name="comment_id" value="<?php echo $v['comment_id']; ?>">
										<textarea class="reply" name="content"></textarea>
										<div class="btn"><span style="color:#f00;"></span><input onclick="addreply(this); return false;" style="margin-left:100px;" type="submit" value="提交"></div>
									</form>
								</div>
								<ul>
									
									<?php if(is_array($v['reply']) || $v['reply'] instanceof \think\Collection || $v['reply'] instanceof \think\Paginator): if( count($v['reply'])==0 ) : echo "" ;else: foreach($v['reply'] as $key=>$vo): ?>
									<li class="sub">
										<div class="info">
											<div class="left fl">
											<img class="fl" src="<?php echo $websetData['domain']; ?>/public/<?php echo $vo['face']; ?>" width="36" height="36" style="border-radius:50%;margin-right:10px;">
											<p class="name"><?php echo $vo['name']; if($vo['pid'] != 0): ?>回复<?php echo $vo['toname']; endif; ?>：</p>
											<p class="time"><?php echo date('Y-m-d H:i:s',$vo['time']); ?></p>
											</div>
											<div class="right fr" onclick="reply(this);"><?php if($sessionId!=$vo['member_id']):?>回复<?php endif;?></div>	
										</div>
										<div class="comment_content">
											<?php echo $vo['content']; ?>
											<form action='' method='post' class="send_reply">
												<input type="hidden" name="pid" value="<?php echo $vo['id']; ?>">
												<input type="hidden" name="to_member_id" value="<?php echo $vo['member_id']; ?>">
												<input type="hidden" name="comment_id" value="<?php echo $v['comment_id']; ?>">
												<textarea class="reply" name="content"></textarea>
												<div class="btn"><span style="color:#f00;"></span><input style="margin-left:100px;" onclick="addreply(this);return false;" type="submit" value="提交"></div>
											</form>	
										</div>	
									</li>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>	
					</div>
					<div class="more"><a href="javascript:void(0);">查看更多</a></div>
					<div class="tab-article">
						<p>上一篇:<?php if($previnfo['name']):?><a href="<?php echo url('index/content/index',['ar_id'=>$previnfo['id']]); ?>"><?php echo $previnfo['name']; ?></a><?php else: ?>没有啦！！！<?php endif; ?></p>
						<p>下一篇:<?php if($nextinfo['name']):?><a href="<?php echo url('index/content/index',['ar_id'=>$nextinfo['id']]); ?>"><?php echo $nextinfo['name']; ?></a><?php else: ?>没有啦！！！<?php endif; ?></p>
					</div>
				</div>			
			</div>
			<div class="left <?php if(input('param.ar_id')): ?>fr<?php else: ?>fl<?php endif; ?>">
			<div class="top">
				<h3>最新文章</h3>
				<div class="list">
					<ul>
						<?php if(is_array($_articleData) || $_articleData instanceof \think\Collection || $_articleData instanceof \think\Paginator): if( count($_articleData)==0 ) : echo "" ;else: foreach($_articleData as $key=>$v): ?>
						<li>
						<a href="<?php echo url('index/content/index',['ar_id'=>$v['id']]); ?>">
							<span><?php echo $v['name']; ?></span>	
						</a>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
			<div class="middle">
				<h3>最新评论</h3>
				<div class="list">
					<ul>
						<?php if(is_array($_commentData) || $_commentData instanceof \think\Collection || $_commentData instanceof \think\Paginator): if( count($_commentData)==0 ) : echo "" ;else: foreach($_commentData as $key=>$v): ?>
						<li>
						<a href="<?php echo url('index/content/index',['ar_id'=>$v['article_id']]); ?>">
							<img style="float:left;width:36px;height:36px;" src="<?php echo $websetData['domain']; ?>/public/<?php echo $v['face']; ?>">
							<p><?php echo $v['name']; ?>:</p>
							<p><?php echo $v['content']; ?></p>
						</a>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>	
			</div>	
			<div class="bottom">
				<h3>标签云</h3>
				<div class="list">
					<ul>
						<?php if(is_array($tagData) || $tagData instanceof \think\Collection || $tagData instanceof \think\Paginator): if( count($tagData)==0 ) : echo "" ;else: foreach($tagData as $key=>$v): ?>
						<li><a href="<?php echo url('index/lst/index',['tag_id'=>$v['id']]); ?>"><?php echo $v['name']; ?></a></li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>	
			</div>					
		</div>
		</div>
	</div>		
	<!-- main end -->

<!-- footer start -->
	<footer>
		<div class="_width footer min-width">
			<div class="_content">
				<div class="top">
					<div class="left">
						<h2><?php echo $websetData['logo']; ?></h2>
						<p><?php echo $websetData['footer_1']; ?><br />
						<?php echo $websetData['footer_3']; ?>
						</p>
					</div>	
					<div class="right">
						<ul>
							<?php if(is_array($flinkData) || $flinkData instanceof \think\Collection || $flinkData instanceof \think\Paginator): if( count($flinkData)==0 ) : echo "" ;else: foreach($flinkData as $key=>$v): ?>
							<li>
								<a href="<?php echo $v['url']; ?>" target="_blank">
									<img width="50" src="<?php echo $websetData['domain']; ?>/public/<?php echo $v['image']; ?>">
									<p><?php echo $v['name']; ?></p>	
								</a>
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
				<div class="bottom">
					<p class="fl"><?php echo $websetData['copyright']; ?> <?php echo $websetData['record']; ?></p>
					<p class="fr"><?php echo $websetData['footer_right']; ?></p>
				</div>
			</div>
		</div>
	</footer>
	<div class="mask"></div>
	<div class="login_register">
		<i class="close"></i>
		<ul class="tab">
			<li class="active">登入</li>
			<li>注册</li>
		</ul>
		<div class="login">
			<p class="error" style="display:none;">
				<img src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/images/error.png">
				<span style="vertical-align:middle;"></span>
			</p>
			<form method="post" action="" id="login">
				<div class="email">
					<label for="telnum"></label>
					<input id="telnum" type="text" class="item" placeholder="请输入手机号码" name="telnum">
				</div>
				<div class="pass">
					<label for="lpass"></label>
					<input type="password" id="lpass" class="item" placeholder="密码" name="password">
				</div>
				<div class="captcha">
					<input type="text" class="code" name="captcha" >
					<img src="<?php echo captcha_src(); ?>" onclick="this.src=this.src+'?'+Math.random()">
				</div>
				<div class="btn">
					<button>登录</button>
				</div>
			</form>
		</div>
		<div class="register">
			<p class="error" style="display:none;">
				<img src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/images/error.png">
				<span style="vertical-align:middle;"></span>
			</p>
			<form action="" method="post" enctype="multipart/form-data" id="register">
				<div class="email">
					<label for="telnum"></label>
					<input type="text" id="telnum" class="item" placeholder="手机号码" name="telnum"  maxlength="30">
					<p class="error-msg"></p>
				</div>
				<div class="pass">
					<label for="pwd"></label>
					<input type="password" id="pwd" class="item" placeholder="密码" name="password" maxlength="16">
					<p class="error-msg"></p>
				</div>
				<div class="telcode">
					<label for="code"></label>
					<input id="code" type="text" class="item" placeholder="请输入验证码" name="code" maxlength="16">
					<p class="error-msg"></p>
					<input type="button" class="getcode" value="获取短信验证码">
				</div>

				<div class="name">
					<label for="name"></label>
					<input id="name" type="text" class="item" placeholder="名称" name="name" maxlength="10">
					<p class="error-msg"></p>
				</div>
				<div class="head" style="position:relative;">
					<label for="head"></label>
					<div class="upload">
						<img src="<?php echo $websetData['domain']; ?>/public__STATIC__/index/images/touxiang.png" alt="">
						<span>添加图片</span>
					</div>
					<div class="previmg"></div>
					<input type="file" style="display:none;" id="head" style="" class="item change" placeholder="图片" name="face">
					<p class="error-msg"></p>
				</div>
				<div class="btn">
					<button>注册</button>
				</div>
			</form>
		</div>
	</div>
	<script>
		var domain = "<?php echo $websetData['domain']; ?>/";
		$(function(){
			/* 注册*/
			$(".upload").click(function(){
				$(":file").trigger("click");
			})
			$(":file").change(function(){
				$(".previmg").html('');
				$(".upload").siblings(".error-msg").html('');
				if(this.files[0]['type'].split("/")[0]!='image'){
					$(":file").next().html("文件格式不正确");
					return;
				}
				var url=window.URL.createObjectURL(this.files[0]);
				var img = document.createElement("img");
				img.style = "width:40px;";
				img.src=url;
				$(".previmg").get(0).appendChild(img);
			})
			$(".getcode").click(function(){
				var $this = $(this);
				var $tel = $(".login_register .register form input.item").eq(0);
				var telnum = $tel.val();
				var reg = /^1[3|a|4|5|6|8]\d{9}$/;
				if(!reg.test(telnum)){
					$tel.next().html("手机号码格式不正确");
					return false;
				}else{
					$tel.next().html("");
				}
				$.ajax({
					type:"get",
					url:"<?php echo url('index/member/ajaxCheckTelnum'); ?>",
					data:{
						telnum:telnum
					},
					success:function(data){
						if(data==200){
							//号码没有注册
							var i = 60;
							$this.attr("disabled",true);
							dijian();
							function dijian(){
								$this.val(i+"秒后重新获取");
								i--;
								if(i<0){
									clearInterval(timer);
									$this.attr("disabled",false);
									$this.val("获取短信验证码");
								}
							}
							timer = setInterval(dijian,1000);
							$.ajax({
								type:'get',
								dtaType:'json',
								data:{
									telnum:telnum
								},
								url:"<?php echo url('index/member/ajaxGetCode'); ?>",
								success:function(data){
									console.log(data);
								}
							})
						}else{
							$tel.next().html("该号码已注册");
							//号码已经注册
						}
					}
				})
			})
			//注册正则验证
			var register = 0;
			function regexcheck(){
				var val = $(this).val();
				if(val!=''||register){
					var reg;
					var nameval = $(this).attr("name");
					if(nameval=='telnum'){
						reg = /^1[3|a|4|5|6|8]\d{9}$/;
						if(!reg.test(val)){
							$(this).next().html("手机号码格式不正确");
							return false;
						}
					}else if(nameval=="password"){
						reg = /^\w{6,14}$/;
						if(!reg.test(val)){
							$(this).next().html("长度必须为6~14位,不能有空格");
							return false;
						}
					}else if(nameval=='name'){
						reg = /^.{2,6}$/;
						if(!reg.test(val)){
							$(this).next().html("长度为2到6个字符");
							return false;
						}
					}else if(nameval=='code'){
						reg = /^\d{4}$/;
						if(!reg.test(val)){
							$(this).next().html("验证码格式不正确");
							return false;
						}
					}
					register = 0;
				}
			};
			//失去焦点
			$(".login_register .register form input.item").blur(function(){
				regexcheck.call($(this));
			})
			//获取焦点
			$(".login_register .register form input.item").focus(function(){
				$(this).next().html("");
			})
			var $registerbtn = $('#register button');
			$registerbtn.click(function(){
				var $this = $(this);
				$this.attr("disabled",true);
				$(".login_register .register form input.item").each(function(k,v){
					register = 1;
					$(v).trigger("blur");
				})
				var flag = 1;
				$(".login_register .register form .error-msg").each(function(k,v){
					console.log(k);
					if($(v).html()!=''){
						flag = 0;
					}
				})
				$(".login_register .register form input.item").trigger("blur");
				if($(".previmg img").length<=0){
					$(":file").next().html("图片不能为空");
					$this.attr("disabled",false);
					return false;
				}else{
					$(":file").next().html("");
				}
				if(!flag){
					$this.attr("disabled",false);
					return false;
				}
				var fd = new FormData($(".register form").get(0));
				$.ajax({
					type:'post',
					data:fd,
					processData: false,  // 不处理数据
					contentType: false,   // 不设置内容类型
					url:"<?php echo url('index/member/ajaxRegistCheck'); ?>",
					success:function(data){
						$this.attr("disabled",false);
						if(data.split("_")[0]==200){
							$(".mask,.login_register").hide();
							$(".login form").get(0).reset();
							$(".register form").get(0).reset();
							$(".login_register form .error-msg").empty();
							$(".login_register .error").hide();
							$(".login_register .error span").empty();
							$("body").css("overflow","visible");
						}else{
							$(".login_register .register form .error-msg").eq(data.split("_")[0]).html(data.split("_")[1]);
						}
					}
				});
				return false;
			});	
			/* 登录 */
			var $loginbtn = $('#login button');
			$loginbtn.click(function(){
				var $this = $(this);
				$(this).attr("disabled",true);
				var data = $('#login').serialize();
				$.ajax({
					type:'post',
					data:data,
					url:"<?php echo url('index/member/ajaxLoginCheck'); ?>",
					success:function(data){
						$this.attr("disabled",false);
						if(data.split("_")[0]==200){
							sessionStorage.setItem('member_id',data.split("_")[3]);
							$(".main .wrap .detail .comment .comment-send .fl p").html(data.split("_")[1]);
							var img = "<img src='"+domain+"public/"+data.split("_")[2]+"'>"
							$(".main .wrap .detail .comment .comment-send .head").prepend(img)
							$(".mask,.login_register").hide();
							$('.login_register .login form').get(0).reset();
							var str = '<div class="right fr" style="cursor:auto;"><div class="face"><img  src="<?php echo $websetData['domain']; ?>/public/'+data.split("_")[2]+'"></div>欢迎您，'+data.split("_")[1]+'&nbsp;<a onclick="logout(this);" class="logout" href="javascript:void(0);" style="color:#e2e2e2;cursor:pointer;" >退出</a></div>';
							$("header ._content .right").remove();
							$("header ._content .left").after(str);
							$("body").css("overflow","visible");
							$(".login form").get(0).reset();
							$(".register form").get(0).reset();
							$(".login_register form .error-msg").empty();
							$(".login_register .error").hide();
							$(".login_register .error span").empty();
							var to_member_id = $(".send_reply").children().eq(1).val();
							if(sessionStorage.getItem('member_id')==to_member_id){
								$(".main .wrap .detail .comment .comment_list ul li.top .right").remove();
							}
						}else{
							var errorindex = data.split("_")[0];
							$('.login p.error span').html(data.split("_")[1]);
							$('.login p.error').show();
							console.log(errorindex);
							$(".login_register .login form input").eq(errorindex).focus(function(){
								console.log(this);
								$('.login p.error').hide()
								$(".login_register .login form input").eq(errorindex).off("focus");
							})

						}
					}
				});
				return false;
			});
		})
	</script>
	<!-- footer end -->
</body>
</html>