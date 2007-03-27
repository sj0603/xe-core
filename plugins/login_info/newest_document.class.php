<?php

    /**
     * @class newest_document
     * @author zero (zero@nzeo.com)
     * @brief 최근 게시물을 출력하는 플러그인
     * @version 0.1
     **/

    class newest_document extends PluginHandler {

        /**
         * @brief 플러그인의 실행 부분
         * ./plugins/플러그인/conf/info.xml에 선언한 extra_vars를 args로 받는다
         * 결과를 만든후 return 해주어야 한다
         **/
        function proc($args) {
            // 플러그인 자체적으로 설정한 변수들을 체크
            $title = $args->title;
            $order_target = $args->order_target;
            $order_type = $args->order_type;
            $list_count = (int)$args->list_order;
            if(!$list_count) $list_count = 5;
            $mid_list = explode(",",$args->mid_list);

            // DocumentModel::getDocumentList()를 이용하기 위한 변수 정리
            $obj->mid = $mid_list;
            $obj->sort_index = $order_target;
            $obj->list_count = $list_count;

            $oDocumentModel = &getModel('document');
            $output = $oDocumentModel->getDocumentList($obj);

            // 템플릿 파일에서 사용할 변수들을 세팅
            if(count($mid_list)==1) Context::set('module_name', $mid_list[0]);
            Context::set('title', $title);
            Context::set('style', $args->style);
            Context::set('document_list', $output->data);

            // 템플릿의 스킨 경로를 지정 (skin, colorset에 따른 값을 설정)
            $tpl_path = sprintf('%sskins/%s', $this->plugin_path, $args->skin);
            Context::set('colorset', $args->colorset);

            // 템플릿 파일을 지정
            $tpl_file = 'list';

            // 템플릿 컴파일
            $oTemplate = new TemplateHandler();
            return $oTemplate->compile($tpl_path, $tpl_file);
        }


    }
?>
