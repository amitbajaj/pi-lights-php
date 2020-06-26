delimiter $$
drop table if exists devices
$$
create table devices(id int not null auto_increment, uuid varchar(255), name varchar(255), num_ports int, last_comm datetime, primary key (id), unique key(uuid)) engine=innodb
$$

delimiter $$
drop table if exists users
$$
create table users(id int not null auto_increment, user_id varchar(255) not null, password varchar(255) not null, login_status int not null, login_ip varchar(255), last_login_time timestamp, primary key(id), unique key(user_id)) engine=innodb
$$

delimiter $$
drop table if exists messages
$$
create table messages(device_id int not null, message varchar(10) not null, value varchar(10)) engine=innodb
$$

delimiter $$
drop table if exists message_archive
$$
create table message_archive(device_id int not null,message varchar(10) not null, value varchar(10), message_time datetime not null) engine=innodb
$$

delimiter $$
drop procedure if exists doLogin
$$
create procedure doLogin(user varchar(255), pass varchar(255), ip varchar(255))
begin
    if exists(select user_id from users where user_id = user and password = sha2(pass,224) and (login_status=0 or login_ip=ip or timestampdiff(MINUTE,now(),ifnull(last_login_time,now()))<5)) then
        update users set login_status = 1, login_ip = ip, last_login_time = now() where user_id = user;
        select 1 as 'status';
    else
        select 0 as 'status';
    end if;
end
$$

drop procedure if exists doLogout
$$
create procedure doLogout(user varchar(255))
begin
    update users set login_status = 0 where user_id = user;
end
$$

delimiter $$
drop procedure if exists addDevice
$$
create procedure addDevice(device varchar(255), dname varchar(255), nports int)
begin
    if exists(select 1 from devices where uuid = device) then
        select 0 as 'status';
    else
        insert into devices(uuid, name, num_ports) values(device, dname, nports);
        select 1 as 'status';
    end if;
end
$$

delimiter $$
drop procedure if exists getMessage
$$
create procedure getMessage(device varchar(255), devname varchar(255), nports int)
begin
    declare deviceid int;
    select id into deviceid from devices where uuid=device;
    if deviceid is null then
        insert into devices(uuid,name,num_ports,last_comm) values(device,devname,nports,now());
        select message, value from messages where device_id = deviceid;
    else
        update devices set last_comm = now() where id = deviceid;
        select message, value from messages where device_id = deviceid;
        insert into message_archive(device_id,message,value,message_time) select deviceid,message,value,now() from messages where device_id=deviceid;
        delete from messages where device_id = deviceid;
    end if;
end
$$

delimiter $$
drop procedure if exists getDevices
$$
create procedure getDevices()
begin
    select id, uuid, name, num_ports, date_format(last_comm,'%Y-%m-%d %H:%i:%s') as last_comm from devices;
end
$$

delimiter $$
drop procedure if exists sendMessage
$$
create procedure sendMessage(devid int, devaction varchar(10), actvalue varchar(10))
begin
    insert into messages(device_id,message,value) values(devid,devaction,actvalue);
end
$$