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
    //部署
    'department' => [
        0 => '',
        1 => 'ITビジネス事業部',
        2 => '総務部',
    ],

    //役職
    'post' => [
        0 => '',
        1 => '代表取締役',
        2 => '部長',
        3 => '課長',
        99 => '社員',
    ],

    //権限
    'portal_role' => [
        0 => '',
        1 => 'システム管理者',
        2 => '管理者',
        99 => '一般ユーザ',
    ],
];