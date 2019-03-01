CREATE table users (
  user_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  first_name varchar(25) NOT NULL,
  last_name varchar(25) NOT NULL,
  password CHAR(128) NOT NULL,
  user_type VARCHAR(25) NOT NULL,
  bio TEXT,
  last_logon DATETIME
);

ALTER TABLE users
  ADD weekly_msg BOOLEAN DEFAULT 0;


CREATE TABLE teachers (
  user_id INTEGER PRIMARY KEY NOT NULL,
  school VARCHAR(80),
  district VARCHAR(40),
  grade INTEGER,
  subject VARCHAR(20),
  weekly_msg BOOLEAN,

  FOREIGN KEY(user_id) REFERENCES users(user_id)
);

ALTER TABLE teachers
DROP COLUMN weekly_msg;

CREATE TABLE pros (
  user_id INTEGER PRIMARY KEY NOT NULL,
  company VARCHAR(80),
  job_title VARCHAR(40),
  expertise TEXT,
  qa_interview BOOLEAN DEFAULT 0,
  lecture BOOLEAN DEFAULT 0,
  panel BOOLEAN DEFAULT 0,
  workshop BOOLEAN DEFAULT 0,

  FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE opportunity (
  opp_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  requested_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(40),
  requested_by INTEGER NOT NULL,
  description TEXT NOT NULL,
  accepted_speaker INTEGER NOT NULL DEFAULT 0,
  qa_interview BOOLEAN DEFAULT 0,
  lecture BOOLEAN DEFAULT 0,
  panel BOOLEAN DEFAULT 0,
  workshop BOOLEAN DEFAULT 0,
  # location VARCHAR(80)    I left this out, since I think district and/or school info

  FOREIGN KEY(requested_by) REFERENCES users(user_id),
  FOREIGN KEY(accepted_speaker) REFERENCES users(user_id)
);

ALTER TABLE opportunity
ADD address VARCHAR(120), ADD city VARCHAR(40), ADD zip VARCHAR(10);


## Ken's tables referenced for column names
CREATE TABLE user(
  user_id INTEGER NOT NULL AUTO_INCREMENT,
  user_type VARCHAR(25) NOT NULL,
  email VARCHAR(254) NOT NULL,
  password VARCHAR(128) NOT NULL,
  PRIMARY KEY(user_id)
);

CREATE TABLE teacher(
  user_id INTEGER,
  PRIMARY KEY(user_id),
  FOREIGN KEY(user_id) REFERENCES user(user_id)
);

CREATE TABLE speaker(user_id INTEGER,
  PRIMARY KEY(user_id),
  FOREIGN KEY(user_id) REFERENCES user(user_id)
);

CREATE TABLE opportunity(
  opp_id INTEGER NOT NULL AUTO_INCREMENT,
  requested_by INTEGER NOT NULL,
  requested_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  accepted_speaker INTEGER NOT NULL DEFAULT 0,
  PRIMARY KEY(opp_id),
  FOREIGN KEY(requested_by) REFERENCES user(user_id),
  FOREIGN KEY(accepted_speaker) REFERENCES user(user_id)
)