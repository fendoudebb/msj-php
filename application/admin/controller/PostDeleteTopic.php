<?php

namespace app\admin\controller;


use app\common\config\ResCode;
use think\Db;
use think\Exception;
use think\Log;

class PostDeleteTopic extends BaseRoleAdmin {

    public function deletePostTopic() {
        $postId = input('post.postId');
        $topicId = input('post.topicId');
        if (!isset($postId)) {
            Log::log(__FUNCTION__ . "-operator[$this->username]: " . ResCode::MISSING_PARAMS_POST_ID);
            return $this->fail(ResCode::MISSING_PARAMS_POST_ID);
        }
        if (!is_numeric($postId)) {
            Log::log(__FUNCTION__ . "-operator[$this->username]: " . ResCode::ILLEGAL_ARGUMENT_POST_ID);
            return $this->fail(ResCode::ILLEGAL_ARGUMENT_POST_ID);
        }
        if (!isset($topicId)) {
            Log::log(__FUNCTION__ . "-operator[$this->username]: " . ResCode::MISSING_PARAMS_TOPIC_ID);
            return $this->fail(ResCode::MISSING_PARAMS_TOPIC_ID);
        }
        if (!is_numeric($topicId)) {
            Log::log(__FUNCTION__ . "-operator[$this->username]: " . ResCode::ILLEGAL_ARGUMENT_TOPIC_ID);
            return $this->fail(ResCode::ILLEGAL_ARGUMENT_TOPIC_ID);
        }

        try {
            Db::startTrans();
            $postTopic = Db::table('post_topic')
                ->field('id, is_delete')
                ->where('post_id', $postId)
                ->where('topic_id', $topicId)
                ->find();
            if (!isset($postTopic)) {
                Db::rollback();
                Log::log(__FUNCTION__ . "-operator[$this->username]: " . ResCode::POST_TOPIC_DOES_NOT_EXIST);
                return $this->fail(ResCode::POST_TOPIC_DOES_NOT_EXIST);
            }

            $id = $postTopic['id'];
            $isDelete = $postTopic['is_delete'];
            if ($isDelete) {
                Db::rollback();
                Log::log(__FUNCTION__ . "-operator[$this->username]: " . ResCode::POST_TOPIC_HAS_BEEN_DELETED);
                return $this->fail(ResCode::POST_TOPIC_HAS_BEEN_DELETED);
            }
            $updateResult = Db::table('post_topic')
                ->where('id', $id)
                ->update([
                    'is_delete' => 1
                ]);
            if (!$updateResult) {
                Db::rollback();
                Log::log(__FUNCTION__ . "-operator[$this->username]: " . ResCode::TABLE_UPDATE_FAIL);
                return $this->fail(ResCode::TABLE_UPDATE_FAIL);
            }
            Db::commit();
            return $this->res();
        } catch (Exception $e) {
            Db::rollback();
            Log::log(__FUNCTION__ . "-operator[$this->username]: exception-> " . $e->getMessage());
            return $this->exception();
        }

    }

}