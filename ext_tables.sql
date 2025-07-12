#
# Table structure for table 'tx_dt3pace_domain_model_session'
#
CREATE TABLE tx_dt3pace_domain_model_session (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    slug varchar(255) DEFAULT '' NOT NULL,
    status varchar(50) DEFAULT 'PROPOSED' NOT NULL,
    votes int(11) DEFAULT '0' NOT NULL,
    is_published tinyint(1) DEFAULT '0' NOT NULL,
    proposer int(11) DEFAULT '0' NOT NULL,
    speakers int(11) DEFAULT '0' NOT NULL,
    room int(11) DEFAULT '0' NOT NULL,
    track int(11) DEFAULT '0' NOT NULL,
    time_slot int(11) DEFAULT '0' NOT NULL,
    slides int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY idx_session_status (status),
    KEY idx_session_time_slot (time_slot),
    KEY idx_session_room (room),
    UNIQUE KEY uniq_session_slug (slug)
);

#
# Table structure for table 'tx_dt3pace_domain_model_speaker'
#
CREATE TABLE tx_dt3pace_domain_model_speaker (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    bio text,
    company varchar(255) DEFAULT '' NOT NULL,
    image int(11) DEFAULT '0' NOT NULL,
    slug varchar(255) DEFAULT '' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_dt3pace_domain_model_room'
#
CREATE TABLE tx_dt3pace_domain_model_room (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    capacity int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_dt3pace_domain_model_timeslot'
#
CREATE TABLE tx_dt3pace_domain_model_timeslot (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    start int(11) DEFAULT '0' NOT NULL,
    end int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_dt3pace_domain_model_track'
#
CREATE TABLE tx_dt3pace_domain_model_track (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_dt3pace_domain_model_vote'
#
CREATE TABLE tx_dt3pace_domain_model_vote (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    session int(11) DEFAULT '0' NOT NULL,
    voter int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY idx_vote_voter (voter),
    KEY idx_vote_session (session),
    UNIQUE KEY uniq_session_voter (session, voter)
);

#
# Table structure for table 'tx_dt3pace_domain_model_note'
#
CREATE TABLE tx_dt3pace_domain_model_note (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    note_text text,
    session int(11) DEFAULT '0' NOT NULL,
    user int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

#
# Table structure for table 'tx_dt3pace_session_speaker_mm'
#
CREATE TABLE tx_dt3pace_session_speaker_mm (
    uid_local int(11) DEFAULT '0' NOT NULL,
    uid_foreign int(11) DEFAULT '0' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,
    sorting_foreign int(11) DEFAULT '0' NOT NULL,

    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)
);