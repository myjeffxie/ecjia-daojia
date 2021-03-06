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
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/23
 * Time: 11:56 AM
 */

namespace Ecjia\App\Goods\SettingComponents;

use Ecjia\App\Setting\ComponentAbstract;

class GoodsPriceSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'goods_price';

    public function __construct()
    {
        $this->name = __('商品价格设置', 'goods');
    }


    public function handle()
    {
        $data = [
            ['code' => 'currency_format', 'value' => '￥%s', 'options' => ['type' => 'text']],
            ['code' => 'market_price_rate', 'value' => '1.2', 'options' => ['type' => 'text']],
            ['code' => 'price_format', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4,5']],
            ['code' => 'sku_price_mode', 'value' => 'goods_sku', 'options' => ['type' => 'select', 'store_range' => 'sku,goods_sku']],
        ];

        return $data;
    }


    public function getConfigs()
    {
        $config = [
            [
                'cfg_code'  => 'currency_format',
                'cfg_name'  => __('货币格式', 'goods'),
                'cfg_desc'  => __('显示商品价格的格式，%s将被替换为相应的价格数字。', 'goods'),
                'cfg_range' => '',
            ],

            [
                'cfg_code'  => 'market_price_rate',
                'cfg_name'  => __('市场价格比例', 'goods'),
                'cfg_desc'  => __('输入商品售价时将自动根据该比例计算市场价格', 'goods'),
                'cfg_range' => '',
            ],

            [
                'cfg_code'  => 'price_format',
                'cfg_name'  => __('商品价格显示规则', 'goods'),
                'cfg_desc'  => __('如果设置先四舍五入不保留小数的话，商品价格是 59.9元，前台显示的就会是 60元', 'goods'),
                'cfg_range' => array(
                    '0' => __('不处理', 'goods'),
                    '1' => __('保留不为 0 的尾数', 'goods'),
                    '2' => __('不四舍五入，保留一位小数', 'goods'),
                    '3' => __('不四舍五入，不保留小数', 'goods'),
                    '4' => __('先四舍五入，保留一位小数', 'goods'),
                    '5' => __('先四舍五入，不保留小数 ', 'goods'),
                ),
            ],

            [
                'cfg_code'  => 'sku_price_mode',
                'cfg_name'  => __('商品SKU价格模式', 'goods'),
                'cfg_desc'  => __('选择第一种方式的时候，设置促销活动会无效，比如促销价格等；会默认按商品价格来计算促销活动', 'goods'),
                'cfg_range' => array(
                    'sku'       => __('货品SKU价格', 'goods'),
                    'goods_sku' => __('商品价格 + 属性价格', 'goods'),
                ),
            ],


        ];

        return $config;
    }


}