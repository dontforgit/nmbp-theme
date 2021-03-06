# No More Bad Presents

## Disclaimer

Yes, I know that this is not the correct way to build upon a parent theme. This code should not be taken as a representation of the quality of code that I am accustomed to writing. My family is literally begging me to rebuild this site and I simply don't have the time to do it any other way. 

Maybe next year. :)

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

### Page Setup

- Create `/my-list-submit/`
- Create `/christmas-list/`
- Create `/add-to-my-family/`

### Database Setup

```mysql

/** Gift Table **/
CREATE TABLE wp_gift
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT(20) NOT NULL,
  quantity BIGINT(20) NOT NULL,
  desire INT,
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
  hoh_id VARCHAR(20) NOT NULL DEFAULT 0,
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
 
/** Licencing available **/
CREATE TABLE wp_family_license
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  family_id BIGINT(20) NOT NULL,
  available BOOLEAN NOT NULL DEFAULT 1
);

```

## Conclusion

_...and the rest will follow._
