<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ecjia 前端页面控制器父类
 */
class ecjia_user_front_controller extends ecjia_theme_controller
{

    public function __construct()
    {
        parent::__construct();

        $this->makePublicRoute();

        if (!$this->check_login()) {
            /*未登录处理*/
            $url       = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
            $login_str = user_function::return_login_str();
            if (isset($_GET['referer_url'])) {
                $url = $_GET['referer_url'];
            }

            ecjia_front::$controller->redirectWithExited(RC_Uri::url($login_str, array('referer_url' => urlencode($url))));
        }

        if ($this->check_status()) {
            $url         = RC_Uri::url('user/profile/cancel_account');
            $current_url = RC_Uri::current_url();

            if ($url != $current_url) {
                return ecjia_front::$controller->redirectWithExited($url);
            }
        }
    }

    protected function makePublicRoute()
    {
        $this->public_route = array(
            'user/privilege/login',
            'user/privilege/mobile_login',
            'user/privilege/pass_login',
            'user/privilege/signin',
            'user/privilege/signup',
            'user/privilege/register',
            'user/privilege/captcha_validate',
            'user/privilege/captcha_refresh',
            'user/privilege/captcha_check',
            'user/privilege/enter_code',
            'user/privilege/mobile_signin',
            'user/privilege/wechat_login',

            'user/privilege/bind_signin',
            'user/privilege/bind_signin_do',
            'user/privilege/bind_signup',
            'user/privilege/bind_signup_do',
            'user/privilege/bind_login',
            'user/privilege/validate_code',
            'user/privilege/set_password',

            'user/get_password/get_password_phone',
            'user/get_password/pwd_question_name',
            'user/get_password/send_pwd_email',
            'user/get_password/update_password',
            'user/get_password/forget_pwd',
            'user/get_password/reset_pwd_mail',
            'user/get_password/reset_pwd_form',
            'user/get_password/reset_pwd',
            'user/get_password/mobile_register_account',
            'user/get_password/init',
            'user/get_password/mobile_check',
            'user/get_password/captcha_validate',
            'user/get_password/enter_code',
            'user/get_password/captcha_check',
            'user/get_password/validate_forget_password',

            'user/get_password/reset_password',
            'market/mobile_reward/init',
            'market/mobile_reward/recieve',

            'user/index/wxconfig',
        );
    }

    /**
     * 未登录验证
     */
    private function check_login()
    {
        /*不需要登录的操作或自己验证是否登录（如ajax处理）的方法*/
        //验证公开路由
        $route_controller = ROUTE_M . '/' . ROUTE_C . '/' . ROUTE_A;
        if (in_array($route_controller, $this->public_route)) {
            return true;
        }

        //验证登录身份
        if (ecjia_touch_user::singleton()->isSignin()) {
            return true;
        }

        return false;
    }

    private function check_status()
    {
        $token = ecjia_touch_user::singleton()->getToken();
        $user  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        $user  = is_ecjia_error($user) ? array() : $user;

        if ($user['account_status'] == 'wait_delete') {
            return true;
        }

        return false;
    }
}

// end