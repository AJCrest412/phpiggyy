create table if not exists users(
  id bigint(20) unsigned not null AUTO_INCREMENT,
  email varchar(255) not null,
  password varchar(255) not null,
  age tinyint(3) unsigned not null,
  country varchar(255) not null,
  social_media_url varchar(255) not null,
  created_at datetime not null DEFAULT CURRENT_TIMESTAMP(),
  updated_at datetime not null DEFAULT CURRENT_TIMESTAMP(),
  primary key(id),
  unique key(email)
);

create table if not exists transaction(
  id bigint(20) not null AUTO_INCREMENT,
  description varchar(255) not null,
  amount decimal(10, 2) not null,
  date datetime not null,
  created_at datetime not null DEFAULT CURRENT_TIMESTAMP(),
  updated_at datetime not null DEFAULT CURRENT_TIMESTAMP(),
  user_id bigint(20) unsigned not null,
  primary key(id),
  foreign key(user_id) references users(id)
);

create table if not exists receipts(
  id bigint(20) unsigned not null AUTO_INCREMENT,
  original_filename varchar(255) not null,
  storage_filename varchar(255) not null,
  media_type varchar(255) not null,
  transaction_id bigint(20) not null,
  primary key (id),
  foreign key(transaction_id) references transaction(id) on delete cascade
);