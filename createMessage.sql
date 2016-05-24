create table message (
	msgId int auto_increment not null,
    msgAuthor int not null default 0,
    msgMail varchar(100) not null,
    msgSubject varchar(80) not null,
    msgContenu text not null,
    msgRecipient int not null default 6,
    msgCreateTime datetime default null,
    msgParentId int default null,
    constraint pk_msg primary key (msgId),
    constraint fk_msgParentId foreign key (msgParentId) references message(msgId),
    constraint fk_msgAuthor foreign key (msgAuthor) references user(userId),
    constraint fk_msgRecipient foreign key (msgRecipient) references user(userId)
)