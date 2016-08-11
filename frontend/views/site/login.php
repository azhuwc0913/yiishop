<?php
	use yii\captcha\Captcha;
	use yii\widgets\ActiveForm;
	?>
	
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10">
		<div class="login_hd">
			<h2>用户登录</h2>
			<b></b>
		</div>
		<div class="row">
			<div class="col-lg-5">
				<?php $form = ActiveForm::begin(['id' => 'login-form','method'=>'post']); ?>
					<ul>
						<li>
							<?= $form->field($model, 'username')->textInput(['style'=>'width:150px'])->label('用户名') ?>

						</li>
						<li>
							<?= $form->field($model, 'password')->passwordInput(['style'=>'width:150px'])->label('密码') ?>

							<a href="">忘记密码?</a>
						</li>
						<li class="checkcode">
							<?= $form->field($model, 'verifyCode')->textInput(['autofocus' => true, 'style'=>'width:150px']) ?>

							<?php echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'site/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;margin-left:0px;'],'template'=>'{image}']);?>

						</li>
						<li>
							<?= $form->field($model, 'rememberMe')->checkbox()->label('记住我') ?>
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="submit" value="" class="login_btn" />
						</li>
					</ul>
				<?php ActiveForm::end(); ?>

				<div class="coagent mt15">
					<dl>
						<dt>使用合作网站登录商城：</dt>
						<dd class="qq"><a href=""><span></span>QQ</a></dd>
						<dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
						<dd class="yi"><a href=""><span></span>网易</a></dd>
						<dd class="renren"><a href=""><span></span>人人</a></dd>
						<dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
						<dd class=""><a href=""><span></span>百度</a></dd>
						<dd class="douban"><a href=""><span></span>豆瓣</a></dd>
					</dl>
				</div>
			</div>
			
			<div class="guide fl">
				<h3>还不是商城用户</h3>
				<p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

				<a href="regist.html" class="reg_btn">免费注册 >></a>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

