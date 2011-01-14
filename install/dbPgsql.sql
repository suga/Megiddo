-- Sequence: log_id_seq

-- DROP SEQUENCE log_id_seq;

CREATE SEQUENCE log_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE log_id_seq OWNER TO postgres;

-- Table: "log"

-- DROP TABLE "log";

CREATE TABLE "log"
(
  id serial NOT NULL,
  file character varying(255),
  message text,
  is_error boolean DEFAULT true,
  date timestamp without time zone DEFAULT now(),
  CONSTRAINT id PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "log" OWNER TO postgres;


-- Sequence: tag_id_tag_seq

-- DROP SEQUENCE tag_id_tag_seq;

CREATE SEQUENCE tag_id_tag_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE tag_id_tag_seq OWNER TO postgres;


-- Table: tag

-- DROP TABLE tag;

CREATE TABLE tag
(
  id_tag serial NOT NULL,
  tag character varying(255),
  CONSTRAINT id_tag PRIMARY KEY (id_tag),
  CONSTRAINT tag_tag_key UNIQUE (tag)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE tag OWNER TO postgres;

-- Sequence: tag_i18n_id_tag_i18n_seq

-- DROP SEQUENCE tag_i18n_id_tag_i18n_seq;

CREATE SEQUENCE tag_i18n_id_tag_i18n_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE tag_i18n_id_tag_i18n_seq OWNER TO postgres;


-- Table: tag_i18n

-- DROP TABLE tag_i18n;

CREATE TABLE tag_i18n
(
  id_tag_i18n serial NOT NULL,
  id_tag integer NOT NULL,
  isolang character varying(10) NOT NULL,
  translate text,
  CONSTRAINT id_tag_i18n PRIMARY KEY (id_tag_i18n),
  CONSTRAINT id_tag FOREIGN KEY (id_tag)
      REFERENCES tag (id_tag) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE tag_i18n OWNER TO postgres;

-- Table: culture

-- DROP TABLE culture;

CREATE TABLE culture
(
  isolang character varying(255) NOT NULL,
  "default" boolean NOT NULL DEFAULT false,
  CONSTRAINT isolang PRIMARY KEY (isolang)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE culture OWNER TO postgres;

INSERT INTO culture (isolang,"default") VALUES ('en_US',false);  
INSERT INTO culture (isolang,"default") VALUES ('pt_BR',true);  