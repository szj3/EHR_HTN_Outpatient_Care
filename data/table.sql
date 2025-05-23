CREATE TABLE IF NOT EXISTS `form_hypertension_risk_assessment` (
id bigint(20) NOT NULL auto_increment,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
custom varchar(255) default NULL,
doctor varchar(255),
date_of_signature datetime default NULL,
was_diastolic_over_85_this_past_week tinyint(1) default NULL, -- diastolic
was_systolic_over_130_this_past_week tinyint(1) default NULL, -- systolic
are_you_smoker tinyint(1) default NULL, --  smoker status
family_history_of_htn_chf_diabetes  tinyint(1) default NULL, -- family history
exercise_this_week tinyint(1) default NULL, -- did you exercise this week
total_score int default NULL,
fld2 varchar(255) default NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB;
