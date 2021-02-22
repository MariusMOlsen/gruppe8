create table admin
(
    id      int unsigned auto_increment
        primary key,
    navn    varchar(45) null,
    epost   varchar(45) null,
    passord varchar(45) null,
    token   varchar(45) null
);

create table fag
(
    navn      varchar(45) not null,
    pin       int(4)      null,
    emnekode  varchar(45) not null,
    foreleser varchar(45) not null,
    primary key (foreleser, navn)
);

create table foreleser
(
    id           int(10)     null,
    navn         varchar(45) not null
        primary key,
    epost        varchar(45) null,
    bildeadresse varchar(45) null,
    passord      varchar(45) null,
    token        varchar(45) null
);

create table student
(
    id             int unsigned auto_increment,
    navn           varchar(45) null,
    epost          varchar(45) not null
        primary key,
    passord        varchar(45) null,
    studierettning varchar(45) null,
    kull           year        null,
    token          varchar(45) null,
    constraint id_UNIQUE
        unique (id)
);

create table svar
(
    tekst   blob        not null,
    fag     varchar(45) not null
        primary key,
    student varchar(45) not null
);

create table tilbakemelding
(
    kommentar blob        not null,
    fag       varchar(45) not null,
    student   varchar(45) not null,
    anonym    bit         not null,
    primary key (fag, student)
);

