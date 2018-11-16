$(function(){
	/*主页淡出效果*/
	(function(){
		var $li = $('.main .wrap .article-list ul li');
		var sTop;
		$(window).scroll(function(){
			var sTop = $(document).scrollTop();
			var bw;
			$li.each(function(){
				offsetTop = $(this).offset().top;
				bw = offsetTop+($(this).height())/4-sTop;
				if(bw<$(window).height()){
					$(this).addClass('on');
				}
			})
			if(sTop>300){
				$('header').addClass('on');	
			}else{
				$('header').removeClass('on');	
			}
		})		
	})();
	/*内容页评论*/
	/*(function(){
		var $reply = $('.main .wrap .detail .comment .comment_list ul li.top .right');
		var $textarea = $reply.parents('.info').siblings('.comment_content').find('textarea');
		$reply.click(function(){
			$('.comment_content form').hide();
			$('.comment_content form').find('textarea').val('');
			var $form = $(this).parents('.info').siblings('.comment_content').find('form');
			$form.slideDown();
			$form.find("textarea").focus();
		})
	})();*/
	(function(){
		var $comment_send = $('.main .wrap .detail .comment .comment-send .fl form textarea')
		$comment_send.css('color','rgb(169, 169, 169)');
		$comment_send.focus(function(){
			$(this).html('');
			$(this).css('color','#333');
		})
	})();
	(function(){
		/*注册和登入 start*/

		$('header .right').click(function(){
			if($(this).html()=="登录|注册"){
				$('body').css('overflow','hidden');
				$('.login_register').fadeIn();
				$('.mask').fadeIn();
			}
		})
		$('.login_register .tab li').click(function(){
			var index = $(this).index();
			$(this).addClass('active').siblings().removeClass('active');
			$('.login_register>div').eq(index).show().siblings('div').hide();			
		})
		$('.login_register .close,.mask').click(function(){
			$('body').css('overflow','visible');
			$(".login form").get(0).reset();
			$(".register form").get(0).reset();
			$(".login_register form .error-msg").empty();
			$(".login_register .error").hide();
			$(".login_register .error span").empty();
			$('.login_register').fadeOut();
			$('.mask').fadeOut();
		})
		/*注册和登入 end*/
	})()
})	


		