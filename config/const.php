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
        0 => '',
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
];