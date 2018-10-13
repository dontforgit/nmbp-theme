# No More Bad Presents

## Introduction

This website was made so that families could quickly and easily share their Christmas lists with one another. 

## Foundation

### Technical Requirements

The foundation of this website are:

* Hestia Christmas theme
* Correctly configured MYSQL database
* Appropriate pages made in the WP back-end. 
* Appropriate configurations made in the Hestia customizer.

The foundation of the Hestia theme is _bootstrap_. As such, all of the additions to the hestia theme will be written with this framework in mind. 

### Usage

I am selling usage of this site to friends and family. I do not expect royalties or liability from any member of the public using this theme for themselves.

## Setup

### Database Setup

```mysql

/** Gift Table **/
CREATE TABLE wp_gift
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT(20) NOT NULL,
  quantity BIGINT(20) NOT NULL,
  link BLOB,
  price VARCHAR(20),
  title VARCHAR(64),
  notes BLOB,
  remaining BIGINT(20),
  active BOOLEAN NOT NULL DEFAULT 1,
);
 
/** Claimed Table **/
CREATE TABLE wp_claimed
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT(20) NOT NULL,
  gift_id BIGINT(20) NOT NULL,
  quantity INT(20) NOT NULL,
  active BOOLEAN NOT NULL DEFAULT 1
);
 
/**  Famiily Table **/
CREATE TABLE wp_families
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(20) NOT NULL, 
  active BOOLEAN NOT NULL DEFAULT 1
);
 
/** Family Relationships **/
CREATE TABLE wp_family_relationships
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  user_id BIGINT(20) NOT NULL, 
  family_id BIGINT(20) NOT NULL, 
  active BOOLEAN NOT NULL DEFAULT 1
);
--

```

## Conclusion

_...and the rest will follow._