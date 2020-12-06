Set database name, username and password in ./connect-to-db.php
Run the following mysql commands to create the tables:

create table users (
    id int(10) unsigned not null,
    username varchar(30) not null,
    fname varchar(255),
    password varchar(255) not null,
    reg_time timestamp not null default current_timestamp,
    enabled tinyint(1) unsigned not null default '1');

alter table users
    add primary key (id),
    add unique key username (username);

alter table users
    modify id int(10) unsigned not null auto_increment;

create table posts (
    id int(10) unsigned not null,
    body varchar(500) not null,
    timestamp timestamp not null,
    user_id int(10) unsigned not null);

alter table posts
    add primary key (id);

alter table posts
    modify id int(10) unsigned not null auto_increment;