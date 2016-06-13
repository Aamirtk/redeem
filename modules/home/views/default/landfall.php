<!DOCTYPE html>
<?php
use frontend\modules\talent\models\User;
$site = \backend\modules\content\models\Site::find()->limit(1)->one();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>创意空间-蓝海创意云官方创客空间</title>
    <meta name="keywords" content="创客，创客空间，原创"/>
    <meta name="description" content="蓝海创意云创客空间(maker.vscochina.com)孵化优秀文创项目。专业审批，严格要求，展示最优质、最具潜力的原创项目。创意云诚邀创意人才入驻创意空间，玩转创意活动，打造文创行业最火爆创客平台。"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://account.vsochina.com/static/css/login/common.css?v1.4" />
    <link type="text/css" rel="stylesheet" href="/css/dreamSpace.css" />
    <link type="text/css" rel="stylesheet" href="/css/dreamSpace-ad.css" />
    <script type="text/javascript" charset="utf-8" src="http://www.vsochina.com/resource/newjs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="http://account.vsochina.com/static/js/cookie.js"></script>
    <script src="http://static.vsochina.com/libs/angular.js/1.2.9/angular.js"></script>
</head>
<body  ng-app="formApp" ng-controller="formController">
    <!--header-->
    <div class="ad-header">
        <div class="warp-1200">
            <div class="ad-top clearfix">
                <a href="http://maker.vsochina.com"><img src="/images/landfall/logo.png" alt="" class="ad-top-logo"></a>
                <b class="font16">免费咨询电话：400-164-7979</b>
                <span class="ad-top-other" ><i class="icon-16 icon-16-block"></i> 其它服务
                    <ul>
                        <li><a href="http://www.vsochina.com/task.html" target="_blank">任务大厅</a></li>
                        <li><a href="http://maker.vsochina.com/" target="_blank">创意空间</a></li>
                        <li><a href="http://render.vsochina.com/" target="_blank">渲染农场</a></li>
                        <li><a href="http://www.vsochina.com/shop_list.html" target="_blank">创意商城</a></li>
                        <li><a href="http://bbs.vsochina.com/" target="_blank">创意社区</a></li>
                    </ul>
                </span>

            </div>
            <div class="ad-bottom">
                <p class="font48"><span class="font60">百万</span>创客的不变选择</p>
                <p class="font14"><span class="font18">创意空间</span>专注孵化优秀文化创意项目。有好项目、好创意、但是缺资金、缺设备、缺团队怎么办？入驻创意空间，一站式为您解决文创项目创业中的资金、资源、人员、推广等难题！</p>

                <a href="https://cz.vsochina.com/project/project?t=mp" class="ad-top-btn top-btn-dark">免费项目入驻</a>
                <span class="ad-top-btn-middle">or</span>
                <a href="http://maker.vsochina.com" class="ad-top-btn">了解更多</a>
            </div>
        </div>
    </div>
    <!--/header-->
    <!--优秀项目-->
    <div class="ad-project grey-bg">
        <p class="font24">优秀项目</p>
        <p class="font14">面向文化创意产业全领域，征集最具创新的项目；只为真正热爱文创项目的你服务！</p>
        <div class="warp-1200">
        <ul class="ad-project-ul clearfix">
            <li>
                <img src="/images/landfall/1.png" alt="">
                <p class="ad-project-style">动漫</p>
                <p class="ad-project-enstyle">Animate & Comic</p>
                <p class="ad-project-name">《异狩志》</p>
                <a href="https://cz.vsochina.com/project/project?t=mp" class="ad-project-btn">动漫项目入驻</a>
            </li>
            <li>
                <img src="/images/landfall/2.jpg" alt="">
                <p class="ad-project-style">影视</p>
                <p class="ad-project-enstyle">Movie & Drama</p>
                <p class="ad-project-name">《神变法则》</p>
                <a href="https://cz.vsochina.com/project/project?t=mp" class="ad-project-btn">影视项目入驻</a>
            </li>
            <li>
                <img src="/images/landfall/3.jpg" alt="">
                <p class="ad-project-style">音乐</p>
                <p class="ad-project-enstyle">Music</p>
                <p class="ad-project-name">《奋斗》</p>
                <a href="https://cz.vsochina.com/project/project?t=mp" class="ad-project-btn">音乐项目入驻</a>
            </li>
            <li>
                <img src="/images/landfall/4.jpg" alt="">
                <p class="ad-project-style">游戏</p>
                <p class="ad-project-enstyle">Game</p>
                <p class="ad-project-name">《黑潮》</p>
                <a href="https://cz.vsochina.com/project/project?t=mp" class="ad-project-btn">游戏项目入驻</a>
            </li>
            <li>
                <img src="/images/landfall/5.jpg" alt="">
                <p class="ad-project-style">小说</p>
                <p class="ad-project-enstyle">Novel</p>
                <p class="ad-project-name">《千碑塔》</p>
                <a href="https://cz.vsochina.com/project/project?t=mp" class="ad-project-btn">小说项目入驻</a>
            </li>
        </ul>
        </div>
    </div>
    <!--/优秀项目-->
    <!--优秀项目-->
    <div class="ad-project">
        <p class="font24">我们的优势</p>
        <p class="font14">懂艺术、懂技术、懂运营、也懂商业模式；资金、资源、人员、渠道因有尽有！</p>
        <p><a href="https://cz.vsochina.com/project/project?t=mp" class="ad-project-btn">立即加入我们</a></p>
        <div class="warp-1200">
            <ul class="ad-project-ul clearfix pt70">
                <li>
                    <div class="ad-project-item">
                        <p class="font24">艺术</p>
                        <p class="font24">Art</p>
                        <img src="/images/landfall/6.png" alt="">
                        <p class="font12">众多业界大师入驻指导</p>
                        <p class="font12">路盛章-北京奥运会动画片总导演</p>
                    </div>
                </li>
                <li>
                    <div class="ad-project-item dark-bg">
                        <p class="font24">技术</p>
                        <p class="font24">Technology</p>
                        <img src="/images/landfall/7.jpg" alt="">
                        <p class="font12">云技术全程支持</p>
                        <p class="font12">存储渲染、云端接入天河超级计算机</p>
                    </div>
                </li>
                <li>
                    <div class="ad-project-item">
                        <p class="font24">运营</p>
                        <p class="font24">Operation</p>
                        <img src="/images/landfall/8.jpg" alt="">
                        <p class="font12">整合产业上下游资源</p>
                        <p class="font12">覆盖主流宣发渠道，全方位创业支持</p>
                    </div>
                </li>
                <li>
                    <div class="ad-project-item dark-bg">
                        <p class="font24">资金</p>
                        <p class="font24">Investment</p>
                        <img src="/images/landfall/demo9.jpg" alt="">
                        <p class="font12">有机会与投资人面对面</p>
                        <p class="font12">多支基金从天使到VC投资，全程孵化</p>
                    </div>
                </li>
                <li>
                    <div class="ad-project-item">
                        <p class="font24">管理</p>
                        <p class="font24">Management</p>
                        <img src="/images/landfall/10.jpg" alt="">
                        <p class="font12">人员、进度、成本一目了然</p>
                        <p class="font12">自助云端项目协同与管理工具</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!--/优秀项目-->
    <!--业界评论-->
    <div class="ad-project grey-bg">
        <p class="font24">业界评论</p>
        <p class="font14">用创新的理念重新定义行业标准，给每一个加入我们的创作者提供更好更快、更全面的服务！</p>
        <div class="warp-1200">
            <div class="rslides-box">
                <ul class="rslides">
                    <li>
                        <div class="rslides-left">
                            <img src="http://create.vsochina.com/static/images/create/index/user-portrait-2.png" alt="路盛章">
                        </div>
                        <div class="rslides-right">
                            <p class="rslides-right-name">路盛章</p>
                            <p class="rslides-right-txt">奥运福娃宣传片总导演</p>
                            非常新颖的协作工具，很不错，也很适合学生使用，希望以后变得越来越好。
                        </div>
                    </li>
                    <li>
                        <div class="rslides-left">
                            <img src="http://create.vsochina.com/static/images/create/index/user-portrait-5.png" alt="Tamas Waliczky">
                        </div>
                        <div class="rslides-right">
                            <p class="rslides-right-name">Tamas Waliczky</p>
                            <p class="rslides-right-txt">新媒体艺术家，香港城市大学创意媒体系教授</p>
                            使用起来非常有趣，我也很乐意能够通过这样的协作方式进行创作。
                        </div>
                    </li>
                    <li>
                        <div class="rslides-left">
                            <img src="http://create.vsochina.com/static/images/create/index/user-portrait-1.png" alt="香港梦马工作室">
                        </div>
                        <div class="rslides-right">
                            <p class="rslides-right-name">香港梦马工作室</p>
                            <p class="rslides-right-txt">久负盛名的文化创意企业</p>
                            无论是个人还是团队都经常使用协同工具，创意空间的虚拟工作室工具已经融入我们的工作方式，朋友们也很喜欢这种高效简化的合作方式。
                        </div>
                    </li>
                    <li>
                        <div class="rslides-left">
                            <img src="http://create.vsochina.com/static/images/create/index/user-portrait-3.png" alt="梁兴">
                        </div>
                        <div class="rslides-right">
                            <p class="rslides-right-name">梁兴</p>
                            <p class="rslides-right-txt">“嘻多猴”之父，华冠文化科技有限公司董事长</p>
                            作为一个协作平台，非常棒，把我们行业里面专业圈里的供方和需方非常有效地整合在一起，无缝链接。
                        </div>
                    </li>
                    <li>
                        <div class="rslides-left">
                            <img src="http://create.vsochina.com/static/images/create/index/user-portrait-4.png" alt="喻明">
                        </div>
                        <div class="rslides-right">
                            <p class="rslides-right-name">喻明</p>
                            <p class="rslides-right-txt">中国传媒大学苏州研究院常务副院长</p>
                            突破了传统的团队合作创模式的局限性，更加高效，更加便捷，为文创行业的协同创作提供了不可或缺的帮助。
                        </div>
                    </li>
                </ul>
                <ul class="rslides-pager clearfix">
                    <li class="active">
                        <img src="http://create.vsochina.com/static/images/create/index/user-portrait-2.png" alt="路盛章">
                    </li>
                    <li>
                        <img src="http://create.vsochina.com/static/images/create/index/user-portrait-5.png" alt="Tamas Waliczky">
                    </li>
                    <li>
                        <img src="http://create.vsochina.com/static/images/create/index/user-portrait-1.png" alt="香港梦马工作室"></li>
                    <li>
                        <img src="http://create.vsochina.com/static/images/create/index/user-portrait-3.png" alt="梁兴">
                    </li>
                    <li>
                        <img src="http://create.vsochina.com/static/images/create/index/user-portrait-4.png" alt="喻明">
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/业界评论-->
    <!--合作伙伴-->
    <div class="ad-project">
        <p class="font24 pt150">合作伙伴</p>
        <p class="font14">立即加入，让我们带您去连接那些创意产生的地方；伙伴力量，助力文创梦想！</p>
        <div class="warp-1200">
            <ul class="ad-project-ul clearfix lipb25">
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_1.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_2.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_3.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_4.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_5.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_6.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_7.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_8.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_9.png"></li>
                <li><img src="http://create.vsochina.com/static/images/create/index/logo_10.jpg"></li>
            </ul>
        </div>
    </div>

    <div class="ad-project dark-bg">
        <p class="font24">超过百万创作者的不变选择，成就自己的文化创意梦想！</p>

        <div class="ad-project-form">
            <form action="" method="post" ng-submit="processForm()" novalidate name="projectForm">
                <div class="ad-project-form-input">
                    <i class="icon-24 icon-24-username"></i>
                    <input type="text" placeholder="输入您的姓名" name="nickname" required autocomplete="off" ng-model="formData.nickname"   ng-maxlength="20" />
                    <span class="span-error" ng-show="projectForm.nickname.$dirty && projectForm.nickname.$invalid" >
                        <span  ng-show="projectForm.nickname.$error.required">请输入您的姓名！</span>
                        <span  ng-show="projectForm.nickname.$error.maxlength">用户名过长！</span>
                    </span>
                </div>
                <div class="ad-project-form-input">
                    <i class="icon-24 icon-24-email"></i>
                    <input type="email" placeholder="电子邮箱" name="email"  required autocomplete="off" ng-model="formData.email" />
                    <span class="span-error" ng-show="projectForm.email.$dirty && projectForm.email.$invalid" >
                        <span ng-show="projectForm.email.$error.required">请输入邮箱！</span>
                        <span ng-show="projectForm.email.$error.email">邮箱格式不正确！</span>
                    </span>

                </div>
                <div class="ad-project-form-input">
                    <i class="icon-24 icon-24-password"></i>
                    <input type="password" placeholder="设置您的密码" name="password" autocomplete="off" required ng-model="formData.password" ng-minlength="6"/>
                    <span class="span-error" ng-show="projectForm.password.$dirty && projectForm.password.$invalid" >
                        <span ng-show="projectForm.password.$error.required">请输入密码！</span>
                        <span  ng-show="projectForm.password.$error.minlength">密码过短！</span>
                    </span>
                </div>
                <div class="ad-project-form-btn" >
                    <input type="submit" value="永久免费入驻" ng-disabled="projectForm.nickname.$invalid || projectForm.email.$invalid || projectForm.password.$invalid" />
                </div>

            </form>
        </div>

        <p class="font12">当您点击“永久免费入驻”按钮时，将视您已经同意了蓝海创意云创意空间的<a href="http://www.vsochina.com/protocol/pro_id/219.html" target="_blank">《用户条款》</a></p>
    </div>
    <!--/合作伙伴-->
    <script type="text/javascript" src="http://static.vsochina.com/libs/jquery.lazyload/1.9.5/jquery.lazyload.js"></script>
    <script type="text/javascript" src="/js/dreamSpace.js"></script>
    <script>
        // define angular module/app
        var formApp = angular.module('formApp', []);
        // create angular controller and pass in $scope and $http
        function formController($scope, $http) {
            $scope.formData = {};
            $scope.processForm = function() {
                var _btn = $(".ad-project-form-btn input");
                _btn.val("正在提交…");
                $http({
                    method  : 'POST',
                    url     : "<?=yii::$app->urlManager->createUrl(['/home/default/in'])?>",
                    data    : $.param($scope.formData),  // pass in data as strings
                    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }).success(function(json) {
                    if (json.ret==13760) {
                        // if successful, bind errors to error variables  send email
                        window.location.href = "https://account.vsochina.com/user/resendActivateEmail?email="+$scope.formData.email;
                    } else {
                        // if not successful, bind success message to message
                        alert(json.message);
                        _btn.val("永久免费入驻");
                    }
                }).error(function() {
                    _btn.val("永久免费入驻");
                });
            };
        };
    </script>
    <script src="http://static.vsochina.com/libs/responsiveslides/responsiveslides.min.js"></script>
    <script>
        ;(function($){
            var Placeholder,
                inputHolder = 'placeholder' in document.createElement('input'),
                textareaHolder = 'placeholder' in document.createElement('textarea');
                Placeholder = {
                    ini:function () {
                        if (inputHolder && textareaHolder) {
                            return false;
                        }
                        this.el = $(':text[placeholder],:password[placeholder],textarea[placeholder]');
                        this.setHolders();
                    },
                    setHolders: function(obj){
                        var el = obj ? $(obj) : this.el;
                        if (el) {
                            var self = this;
                            el.each(function() {
                                var span = $('<label />');
                                span.text( $(this).attr('placeholder') );
                                span.css({
                                    color: '#999',
                                    fontSize: $(this).css('fontSize'),
                                    fontFamily: $(this).css('fontFamily'),
                                    fontWeight: $(this).css('fontWeight'),
                                    position: 'absolute',
                                    top: "0px",
                                    left: "58px",
                                    width: $(this).width()+100,
                                    height: $(this).outerHeight(),
                                    lineHeight: $(this).css('line-height'),
                                    textIndent: $(this).css('textIndent'),
                                    paddingLeft: $(this).css('borderLeftWidth'),
                                    paddingTop: $(this).css('borderTopWidth'),
                                    paddingRight: $(this).css('borderRightWidth'),
                                    paddingBottom: $(this).css('borderBottomWidth'),
                                    display: 'inline',
                                    overflow: 'hidden',
                                    textAlign:'left'
                                })
                                if (!$(this).attr('id')) {
                                    $(this).attr('id', self.guid());
                                }
                                span.attr('for', $(this).attr('id'));
                                $(this).after(span);
                                self.setListen(this, span);
                                //span.each(function(){
                                    var label = $(span);
                                    $(span).on("click",function(){
                                        label.prev("input[type='text']").focus();
                                //    });
                                });
                                /*
                                span.on("click",function(){
                                    _this.parent().first().focus();
                                });
                                */

                            })
                        }
                    },
                    setListen : function(el, holder) {
                        if (!inputHolder || !textareaHolder) {
                            el = $(el);
                            el.bind('keydown', function(e){
                                    if (el.val() != '') {
                                        holder.hide(0);
                                    } else if ( /[a-zA-Z0-9`~!@#\$%\^&\*\(\)_+-=\[\]\{\};:'"\|\\,.\/\?<>]/.test(String.fromCharCode(e.keyCode)) ) {
                                        holder.hide(0);
                                    } else {
                                        holder.show(0);
                                    }
                            });
                            el.bind('keyup', function(e){
                                    if (el.val() != '') {
                                        holder.hide(0);
                                    } else {
                                        holder.show(0);
                                    }

                            })
                        }
                    },
                    guid: function() {
                        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                            var r = Math.random()*16| 0,
                                v = c == 'x' ? r : (r&0x3|0x8);
                            return v.toString(16);
                        }).toUpperCase();
                    }
                }

            $.fn.placeholder = function () {
                if (inputHolder && textareaHolder) {
                    return this;
                }
                Placeholder.setListen(this);
                return this;
            }

            $.placeholder = Placeholder;

        })(jQuery);
        jQuery(function($){$.placeholder.ini();});
        $(".rslides").responsiveSlides({
            auto: false,
            speed: 20,
            nav: false,
            prevText: "",
            nextText: "",
            namespace: "rslides",
            pager:true
        });

        $(".rslides-pager li").on("click",function () {
            var index = $(this).index();
            $(".rslides_tabs li").eq(index).find("a").click();
            $(this).addClass("active").siblings().removeClass("active");
        });
        $(".ad-top-other").hover(function(){
            $(this).addClass("active");
        },function(){
            $(this).removeClass("active");
        });
        $("[name='nickname']").keyup(function(){
            var str = $("[name='nickname']").val();
            if(getRealLen( str )>20){
                $("[ng-show='projectForm.nickname.$error.maxlength']").removeClass("ng-hide");
                $("[ng-show='projectForm.nickname.$dirty && projectForm.nickname.$invalid']").removeClass("ng-hide");
            }else{
                $("[ng-show='projectForm.nickname.$error.maxlength']").addClass("ng-hide");
            }
        });
        function getRealLen( str ) {
            return str.replace(/[^\x00-\xff]/g, '___').length;
        }
    </script>

    <?php require_once(Yii::getAlias('@frontend') . '/web/layout/home_footer.php')?>
</body>
</html>