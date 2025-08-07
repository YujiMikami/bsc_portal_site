<?php
/*
configヘルパー関数を使って参照する。
config(const.task.'キー名')
配列全体を取得
config('const.task.status')
特定のステータスを取得
config('const.task.status.1')
*/
return [
    //権限
    'portal_role' => [
        1 => 'システム管理者',
        2 => '管理者',
        99 => '一般ユーザ',
    ],
    //性別
    'gender' => [
        1 => '男性',
        2 => '女性',
        99 => '未回答',
    ],
    //有給区分
    'paid_distinction' => [
        1 => '有給休暇',
        2 => '生理休暇',
        3 => '慶弔休暇',
        4 => '産前産後休暇',
        5 => '特別休暇',
        99 => 'その他',
    ],
];