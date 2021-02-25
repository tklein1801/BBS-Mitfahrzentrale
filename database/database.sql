create database if not exists `bbs-mitfahrzentrale`;

create table if not exists cshare_apiLogs
(
    logId         int auto_increment
        primary key,
    requestedPath varchar(40)                         not null,
    requestedIp   varchar(15)                         not null,
    requestKey    varchar(16)                         null,
    requestedAt   timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP
);

create table if not exists cshare_plz
(
    plzId int auto_increment
        primary key,
    plz   int         not null,
    name  varchar(40) not null
);

create table if not exists cshare_user
(
    userId    int auto_increment
        primary key,
    name      varchar(30) not null,
    surname   varchar(30) not null,
    email     varchar(40) not null,
    password  varchar(50) not null,
    plz       int(5)      not null,
    city      varchar(40) not null,
    adress    varchar(40) not null,
    telNumber varchar(18) not null,
    apiKey    varchar(16) not null
);

create table if not exists cshare_rides
(
    rideId            int auto_increment
        primary key,
    creatorId         int          not null,
    driver            int(1)       not null,
    title             varchar(50)  not null,
    information       varchar(250) not null,
    price             int(4)       not null,
    seats             int(2)       not null,
    startAt           int          not null,
    startPlz          int(5)       not null,
    startCity         varchar(40)  not null,
    startAdress       varchar(40)  not null,
    destinationPlz    int(5)       not null,
    destinationCity   varchar(40)  not null,
    destinationAdress varchar(40)  not null,
    createdAt         int          not null,
    constraint `cshare_user-cshare_rides`
        foreign key (creatorId) references cshare_user (userId)
);

create table if not exists cshare_favorites
(
    favoriteId int auto_increment
        primary key,
    userId     int not null,
    rideId     int not null,
    constraint `cshare_rides-cshare_favorites`
        foreign key (rideId) references cshare_rides (rideId)
            on update cascade on delete cascade,
    constraint `cshare_user-cshare_favorites`
        foreign key (userId) references cshare_user (userId)
            on update cascade on delete cascade
);