<?php
/**
 * @author caelyn
 * Date 16/08/11  AM 00:05
 * @desc 我想问业务
 */
namespace App\Http\Controllers\QuestionAnswer;

use App\Http\Controllers\Controller;
use App\Http\Logics\QuestionAnswer\QuestionLogic;


class QuestionController extends Controller{
    /**
     * @desc 我想问页面
     */
    public function index(){
        $userId = $this->getUserId();
        $from           = RequestSourceLogic::getSource();
        //九随心数据
        $currentLogic  = new CurrentLogic();
        $current       = $currentLogic->projectDetail($userId,$from);
        $current['data']['formatFreeAmount'] = round($current['data']['freeAmount']/IncomeModel::TEN_THOUSANDS, 2); //格式化剩余可投金额
        $wapBannerList = AdLogic::getUseAbleListByPositionId(2);
        $data = [
            'current'       => $current['data'],
            'indexActive'   => 'active',
            'wapBannerList' => $wapBannerList
        ];
        return view('wap.home.index', $data);
    }
}