#!/usr/bin/env bash

MYSQL_IP=10.13.0.101
MYSQL_PORT=3306

MYSQL_USERNAME=root
MYSQL_PASSWORD=platQA#123


dbDatabaseName="mail_group"

connectMysql="mysql -h${MYSQL_IP} -P${MYSQL_PORT} -u${MYSQL_USERNAME} -p${MYSQL_PASSWORD} --default-character-set=utf8"

${connectMysql} -e "create database if not exists ${dbDatabaseName}";

${connectMysql} -e "use ${dbDatabaseName} ;

CREATE TABLE IF NOT EXISTS group_info (
    create_time timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '分组的创建时间',
    group_name varchar(64) NOT NULL COMMENT '分组名',
    group_owner varchar(64) NOT NULL COMMENT '邮件分组持有人',
    PRIMARY KEY (group_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
"

${connectMysql} -e "use ${dbDatabaseName} ;

CREATE TABLE IF NOT EXISTS group_member (
    group_name varchar(64) NOT NULL COMMENT '分组名',
    group_member varchar(64) NOT NULL COMMENT '分组成员',
    PRIMARY KEY (group_name,group_member)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
"
